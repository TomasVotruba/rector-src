<?php

declare(strict_types=1);

namespace Rector\BetterPhpDocParser\PhpDoc;

use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDoc\DoctrineAnnotation\AbstractValuesAwareNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey;
use Stringable;

final class DoctrineAnnotationTagValueNode extends AbstractValuesAwareNode implements Stringable
{
    /**
     * @param array<mixed, mixed> $values
     */
    public function __construct(
        public IdentifierTypeNode $identifierTypeNode,
        ?string $originalContent = null,
        array $values = [],
        ?string $silentKey = null
    ) {
        $this->hasChanged = true;

        parent::__construct($values, $originalContent, $silentKey);
    }

    public function __toString(): string
    {
        if (! $this->hasChanged) {
            if ($this->originalContent === null) {
                return '';
            }

            return $this->originalContent;
        }

        if ($this->values === []) {
            if ($this->originalContent === '()') {
                // empty brackets
                return $this->originalContent;
            }

            return '';
        }

        $itemContents = $this->printValuesContent($this->values);
        return sprintf('(%s)', $itemContents);
    }

    public function hasClassName(string $className): bool
    {
        if ($this->identifierTypeNode->name === $className) {
            return true;
        }

        // the name is not fully qualified in the original name, look for resolvd class attirubte
        $resolvedClass = $this->identifierTypeNode->getAttribute(PhpDocAttributeKey::RESOLVED_CLASS);
        return $resolvedClass === $className;
    }
}
