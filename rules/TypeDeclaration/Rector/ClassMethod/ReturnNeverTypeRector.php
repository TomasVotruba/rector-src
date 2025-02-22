<?php

declare(strict_types=1);

namespace Rector\TypeDeclaration\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Expr\Yield_;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Return_;
use PhpParser\Node\Stmt\Throw_;
use PHPStan\Type\NeverType;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\Defluent\ConflictGuard\ParentClassMethodTypeOverrideGuard;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @changelog https://wiki.php.net/rfc/noreturn_type
 *
 * @see \Rector\Tests\TypeDeclaration\Rector\ClassMethod\ReturnNeverTypeRector\ReturnNeverTypeRectorTest
 */
final class ReturnNeverTypeRector extends AbstractRector
{
    public function __construct(
        private ParentClassMethodTypeOverrideGuard $parentClassMethodTypeOverrideGuard
    ) {
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Add "never" type for methods that never return anything', [
            new CodeSample(
                <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        throw new InvalidException();
    }
}
CODE_SAMPLE

                ,
                <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(): never
    {
        throw new InvalidException();
    }
}
CODE_SAMPLE
            ),
        ]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [ClassMethod::class, Function_::class];
    }

    /**
     * @param ClassMethod|Function_ $node
     */
    public function refactor(Node $node): ?Node
    {
        if (! $this->phpVersionProvider->isAtLeastPhpVersion(PhpVersionFeature::NEVER_TYPE)) {
            return null;
        }

        $returns = $this->betterNodeFinder->findInstanceOf($node, Return_::class);
        if ($returns !== []) {
            return null;
        }

        $notNeverNodes = $this->betterNodeFinder->findInstancesOf($node, [Yield_::class]);
        if ($notNeverNodes !== []) {
            return null;
        }

        $neverNodes = $this->betterNodeFinder->findInstancesOf($node, [Node\Expr\Throw_::class, Throw_::class]);
        $hasNeverFuncCall = $this->resolveHasNeverFuncCall($node);
        if ($neverNodes === [] && ! $hasNeverFuncCall) {
            return null;
        }

        if ($node instanceof ClassMethod && ! $this->parentClassMethodTypeOverrideGuard->isReturnTypeChangeAllowed(
            $node
        )) {
            return null;
        }

        $node->returnType = new Name('never');

        return $node;
    }

    /**
     * @param ClassMethod|Function_ $functionLike
     */
    private function resolveHasNeverFuncCall(FunctionLike $functionLike): bool
    {
        $hasNeverType = false;

        foreach ((array) $functionLike->stmts as $stmt) {
            if ($stmt instanceof Expression) {
                $stmt = $stmt->expr;
            }

            if ($stmt instanceof Stmt) {
                continue;
            }

            $stmtType = $this->getStaticType($stmt);
            if ($stmtType instanceof NeverType) {
                $hasNeverType = true;
            }
        }

        return $hasNeverType;
    }
}
