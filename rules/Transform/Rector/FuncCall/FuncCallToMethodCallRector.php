<?php

declare(strict_types=1);

namespace Rector\Transform\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Transform\NodeAnalyzer\FuncCallStaticCallToMethodCallAnalyzer;
use Rector\Transform\ValueObject\FuncCallToMethodCall;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Webmozart\Assert\Assert;

/**
 * @see \Rector\Tests\Transform\Rector\FuncCall\FuncCallToMethodCallRector\FuncCallToMethodCallRectorTest
 */
final class FuncCallToMethodCallRector extends AbstractRector implements ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const FUNC_CALL_TO_CLASS_METHOD_CALL = 'function_to_class_to_method_call';

    /**
     * @var FuncCallToMethodCall[]
     */
    private array $funcNameToMethodCallNames = [];

    public function __construct(
        private FuncCallStaticCallToMethodCallAnalyzer $funcCallStaticCallToMethodCallAnalyzer
    ) {
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Turns defined function calls to local method calls.', [
            new ConfiguredCodeSample(
                <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        view('...');
    }
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var \Namespaced\SomeRenderer
     */
    private $someRenderer;

    public function __construct(\Namespaced\SomeRenderer $someRenderer)
    {
        $this->someRenderer = $someRenderer;
    }

    public function run()
    {
        $this->someRenderer->view('...');
    }
}
CODE_SAMPLE
                ,
                [
                    self::FUNC_CALL_TO_CLASS_METHOD_CALL => [
                        new FuncCallToMethodCall('view', 'Namespaced\SomeRenderer', 'render'),
                    ],
                ]
            ),
        ]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [FuncCall::class];
    }

    /**
     * @param FuncCall $node
     */
    public function refactor(Node $node): ?Node
    {
        $classLike = $node->getAttribute(AttributeKey::CLASS_NODE);
        if (! $classLike instanceof Class_) {
            return null;
        }

        $classMethod = $node->getAttribute(AttributeKey::METHOD_NODE);
        if (! $classMethod instanceof ClassMethod) {
            return null;
        }

        if ($classMethod->isStatic()) {
            return null;
        }

        foreach ($this->funcNameToMethodCallNames as $funcNameToMethodCallName) {
            if (! $this->isName($node->name, $funcNameToMethodCallName->getOldFuncName())) {
                continue;
            }

            $expr = $this->funcCallStaticCallToMethodCallAnalyzer->matchTypeProvidingExpr(
                $classLike,
                $classMethod,
                $funcNameToMethodCallName->getNewObjectType()
            );

            return $this->nodeFactory->createMethodCall(
                $expr,
                $funcNameToMethodCallName->getNewMethodName(),
                $node->args
            );
        }

        return null;
    }

    /**
     * @param array<string, mixed> $configuration
     */
    public function configure(array $configuration): void
    {
        $funcCallsToClassMethodCalls = $configuration[self::FUNC_CALL_TO_CLASS_METHOD_CALL] ?? [];
        Assert::allIsInstanceOf($funcCallsToClassMethodCalls, FuncCallToMethodCall::class);

        $this->funcNameToMethodCallNames = $funcCallsToClassMethodCalls;
    }
}
