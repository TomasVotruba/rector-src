# 494 Rules Overview

<br>

## Categories

- [Arguments](#arguments) (5)

- [Autodiscovery](#autodiscovery) (4)

- [Carbon](#carbon) (2)

- [CodeQuality](#codequality) (68)

- [CodeQualityStrict](#codequalitystrict) (4)

- [CodingStyle](#codingstyle) (38)

- [Composer](#composer) (6)

- [DeadCode](#deadcode) (48)

- [Defluent](#defluent) (9)

- [DependencyInjection](#dependencyinjection) (4)

- [DowngradePhp53](#downgradephp53) (1)

- [DowngradePhp70](#downgradephp70) (9)

- [DowngradePhp71](#downgradephp71) (9)

- [DowngradePhp72](#downgradephp72) (4)

- [DowngradePhp73](#downgradephp73) (6)

- [DowngradePhp74](#downgradephp74) (11)

- [DowngradePhp80](#downgradephp80) (15)

- [EarlyReturn](#earlyreturn) (11)

- [Generics](#generics) (1)

- [LeagueEvent](#leagueevent) (1)

- [MockeryToProphecy](#mockerytoprophecy) (2)

- [MysqlToMysqli](#mysqltomysqli) (4)

- [Naming](#naming) (7)

- [Order](#order) (1)

- [PHPOffice](#phpoffice) (14)

- [PSR4](#psr4) (2)

- [Php52](#php52) (2)

- [Php53](#php53) (4)

- [Php54](#php54) (2)

- [Php55](#php55) (3)

- [Php56](#php56) (2)

- [Php70](#php70) (19)

- [Php71](#php71) (9)

- [Php72](#php72) (10)

- [Php73](#php73) (9)

- [Php74](#php74) (14)

- [Php80](#php80) (17)

- [Php81](#php81) (2)

- [PhpSpecToPHPUnit](#phpspectophpunit) (7)

- [PostRector](#postrector) (7)

- [Privatization](#privatization) (11)

- [Removing](#removing) (6)

- [RemovingStatic](#removingstatic) (9)

- [Renaming](#renaming) (11)

- [Restoration](#restoration) (7)

- [Transform](#transform) (36)

- [TypeDeclaration](#typedeclaration) (18)

- [Visibility](#visibility) (3)

<br>

## Arguments

### ArgumentAdderRector

This Rector adds new default arguments in calls of defined methods and class types.

:wrench: **configure it!**

- class: [`Rector\Arguments\Rector\ClassMethod\ArgumentAdderRector`](../rules/Arguments/Rector/ClassMethod/ArgumentAdderRector.php)

```php
use Rector\Arguments\Rector\ClassMethod\ArgumentAdderRector;
use Rector\Arguments\ValueObject\ArgumentAdder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ArgumentAdderRector::class)
        ->call('configure', [[
            ArgumentAdderRector::ADDED_ARGUMENTS => ValueObjectInliner::inline([
                new ArgumentAdder('SomeExampleClass', 'someMethod', 0, 'someArgument', true, 'SomeType', null),
            ]),
        ]]);
};
```

↓

```diff
 $someObject = new SomeExampleClass;
-$someObject->someMethod();
+$someObject->someMethod(true);
```

<br>

```php
use Rector\Arguments\Rector\ClassMethod\ArgumentAdderRector;
use Rector\Arguments\ValueObject\ArgumentAdder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ArgumentAdderRector::class)
        ->call('configure', [[
            ArgumentAdderRector::ADDED_ARGUMENTS => ValueObjectInliner::inline([
                new ArgumentAdder('SomeExampleClass', 'someMethod', 0, 'someArgument', true, 'SomeType', null),
            ]),
        ]]);
};
```

↓

```diff
 class MyCustomClass extends SomeExampleClass
 {
-    public function someMethod()
+    public function someMethod($value = true)
     {
     }
 }
```

<br>

### FunctionArgumentDefaultValueReplacerRector

Streamline the operator arguments of version_compare function

:wrench: **configure it!**

- class: [`Rector\Arguments\Rector\FuncCall\FunctionArgumentDefaultValueReplacerRector`](../rules/Arguments/Rector/FuncCall/FunctionArgumentDefaultValueReplacerRector.php)

```php
use Rector\Arguments\Rector\FuncCall\FunctionArgumentDefaultValueReplacerRector;
use Rector\Arguments\ValueObject\ReplaceFuncCallArgumentDefaultValue;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(FunctionArgumentDefaultValueReplacerRector::class)
        ->call('configure', [[
            FunctionArgumentDefaultValueReplacerRector::REPLACED_ARGUMENTS => ValueObjectInliner::inline([
                new ReplaceFuncCallArgumentDefaultValue('version_compare', 2, 'gte', 'ge'),
            ]),
        ]]);
};
```

↓

```diff
-version_compare(PHP_VERSION, '5.6', 'gte');
+version_compare(PHP_VERSION, '5.6', 'ge');
```

<br>

### ReplaceArgumentDefaultValueRector

Replaces defined map of arguments in defined methods and their calls.

:wrench: **configure it!**

- class: [`Rector\Arguments\Rector\ClassMethod\ReplaceArgumentDefaultValueRector`](../rules/Arguments/Rector/ClassMethod/ReplaceArgumentDefaultValueRector.php)

```php
use Rector\Arguments\Rector\ClassMethod\ReplaceArgumentDefaultValueRector;
use Rector\Arguments\ValueObject\ReplaceArgumentDefaultValue;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ReplaceArgumentDefaultValueRector::class)
        ->call('configure', [[
            ReplaceArgumentDefaultValueRector::REPLACED_ARGUMENTS => ValueObjectInliner::inline([
                new ReplaceArgumentDefaultValue('SomeExampleClass', 'someMethod', 0, 'SomeClass::OLD_CONSTANT', false),
            ]),
        ]]);
};
```

↓

```diff
 $someObject = new SomeClass;
-$someObject->someMethod(SomeClass::OLD_CONSTANT);
+$someObject->someMethod(false);'
```

<br>

### SwapFuncCallArgumentsRector

Swap arguments in function calls

:wrench: **configure it!**

- class: [`Rector\Arguments\Rector\FuncCall\SwapFuncCallArgumentsRector`](../rules/Arguments/Rector/FuncCall/SwapFuncCallArgumentsRector.php)

```php
use Rector\Arguments\Rector\FuncCall\SwapFuncCallArgumentsRector;
use Rector\Arguments\ValueObject\SwapFuncCallArguments;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(SwapFuncCallArgumentsRector::class)
        ->call('configure', [[
            SwapFuncCallArgumentsRector::FUNCTION_ARGUMENT_SWAPS => ValueObjectInliner::inline([
                new SwapFuncCallArguments('some_function', [1, 0]), ]
            ),
        ]]);
};
```

↓

```diff
 final class SomeClass
 {
     public function run($one, $two)
     {
-        return some_function($one, $two);
+        return some_function($two, $one);
     }
 }
```

<br>

### ValueObjectWrapArgRector

Wrap argument with value object, if not yet the type

:wrench: **configure it!**

- class: [`Rector\Arguments\Rector\MethodCall\ValueObjectWrapArgRector`](../rules/Arguments/Rector/MethodCall/ValueObjectWrapArgRector.php)

```php
use Rector\Arguments\Rector\MethodCall\ValueObjectWrapArgRector;
use Rector\Arguments\ValueObject\ValueObjectWrapArg;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ValueObjectWrapArgRector::class)
        ->call('configure', [[
            ValueObjectWrapArgRector::VALUE_OBJECT_WRAP_ARGS => ValueObjectInliner::inline([
                new ValueObjectWrapArg('SomeClass', 'someMethod', 0, 'Number'),
            ]),
        ]]);
};
```

↓

```diff
 class SomeClass
 {
     public function run()
     {
-        $this->someMethod(1000);
+        $this->someMethod(new Number(1000));
     }
 }
```

<br>

## Autodiscovery

### MoveEntitiesToEntityDirectoryRector

Move entities to Entity namespace

- class: [`Rector\Autodiscovery\Rector\Class_\MoveEntitiesToEntityDirectoryRector`](../rules/Autodiscovery/Rector/Class_/MoveEntitiesToEntityDirectoryRector.php)

```diff
-// file: app/Controller/Product.php
+// file: app/Entity/Product.php

-namespace App\Controller;
+namespace App\Entity;

 use Doctrine\ORM\Mapping as ORM;

 /**
  * @ORM\Entity
  */
 class Product
 {
 }
```

<br>

### MoveInterfacesToContractNamespaceDirectoryRector

Move interface to "Contract" namespace

- class: [`Rector\Autodiscovery\Rector\Interface_\MoveInterfacesToContractNamespaceDirectoryRector`](../rules/Autodiscovery/Rector/Interface_/MoveInterfacesToContractNamespaceDirectoryRector.php)

```diff
-// file: app/Exception/Rule.php
+// file: app/Contract/Rule.php

-namespace App\Exception;
+namespace App\Contract;

 interface Rule
 {
 }
```

<br>

### MoveServicesBySuffixToDirectoryRector

Move classes by their suffix to their own group/directory

:wrench: **configure it!**

- class: [`Rector\Autodiscovery\Rector\Class_\MoveServicesBySuffixToDirectoryRector`](../rules/Autodiscovery/Rector/Class_/MoveServicesBySuffixToDirectoryRector.php)

```php
use Rector\Autodiscovery\Rector\Class_\MoveServicesBySuffixToDirectoryRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(MoveServicesBySuffixToDirectoryRector::class)
        ->call('configure', [[
            MoveServicesBySuffixToDirectoryRector::GROUP_NAMES_BY_SUFFIX => ['Repository'],
        ]]);
};
```

↓

```diff
-// file: app/Entity/ProductRepository.php
+// file: app/Repository/ProductRepository.php

-namespace App/Entity;
+namespace App/Repository;

 class ProductRepository
 {
 }
```

<br>

### MoveValueObjectsToValueObjectDirectoryRector

Move value object to ValueObject namespace/directory

:wrench: **configure it!**

- class: [`Rector\Autodiscovery\Rector\Class_\MoveValueObjectsToValueObjectDirectoryRector`](../rules/Autodiscovery/Rector/Class_/MoveValueObjectsToValueObjectDirectoryRector.php)

```php
use Rector\Autodiscovery\Rector\Class_\MoveValueObjectsToValueObjectDirectoryRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(MoveValueObjectsToValueObjectDirectoryRector::class)
        ->call('configure', [[
            MoveValueObjectsToValueObjectDirectoryRector::TYPES => ['ValueObjectInterfaceClassName'],
            MoveValueObjectsToValueObjectDirectoryRector::SUFFIXES => ['Search'],
            MoveValueObjectsToValueObjectDirectoryRector::ENABLE_VALUE_OBJECT_GUESSING => true,
        ]]);
};
```

↓

```diff
-// app/Exception/Name.php
+// app/ValueObject/Name.php
 class Name
 {
     private $name;

     public function __construct(string $name)
     {
         $this->name = $name;
     }

     public function getName()
     {
         return $this->name;
     }
 }
```

<br>

## Carbon

### ChangeCarbonSingularMethodCallToPluralRector

Change setter methods with args to their plural names on `Carbon\Carbon`

- class: [`Rector\Carbon\Rector\MethodCall\ChangeCarbonSingularMethodCallToPluralRector`](../rules/Carbon/Rector/MethodCall/ChangeCarbonSingularMethodCallToPluralRector.php)

```diff
 use Carbon\Carbon;

 final class SomeClass
 {
     public function run(Carbon $carbon, $value): void
     {
-        $carbon->addMinute($value);
+        $carbon->addMinutes($value);
     }
 }
```

<br>

### ChangeDiffForHumansArgsRector

Change methods arguments of `diffForHumans()` on `Carbon\Carbon`

- class: [`Rector\Carbon\Rector\MethodCall\ChangeDiffForHumansArgsRector`](../rules/Carbon/Rector/MethodCall/ChangeDiffForHumansArgsRector.php)

```diff
 use Carbon\Carbon;

 final class SomeClass
 {
     public function run(Carbon $carbon): void
     {
-        $carbon->diffForHumans(null, true);
+        $carbon->diffForHumans(null, \Carbon\CarbonInterface::DIFF_ABSOLUTE);

-        $carbon->diffForHumans(null, false);
+        $carbon->diffForHumans(null, \Carbon\CarbonInterface::DIFF_RELATIVE_AUTO);
     }
 }
```

<br>

## CodeQuality

### AbsolutizeRequireAndIncludePathRector

include/require to absolute path. This Rector might introduce backwards incompatible code, when the include/require beeing changed depends on the current working directory.

- class: [`Rector\CodeQuality\Rector\Include_\AbsolutizeRequireAndIncludePathRector`](../rules/CodeQuality/Rector/Include_/AbsolutizeRequireAndIncludePathRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        require 'autoload.php';
+        require __DIR__ . '/autoload.php';

         require $variable;
     }
 }
```

<br>

### AddPregQuoteDelimiterRector

Add preg_quote delimiter when missing

- class: [`Rector\CodeQuality\Rector\FuncCall\AddPregQuoteDelimiterRector`](../rules/CodeQuality/Rector/FuncCall/AddPregQuoteDelimiterRector.php)

```diff
-'#' . preg_quote('name') . '#';
+'#' . preg_quote('name', '#') . '#';
```

<br>

### AndAssignsToSeparateLinesRector

Split 2 assigns ands to separate line

- class: [`Rector\CodeQuality\Rector\LogicalAnd\AndAssignsToSeparateLinesRector`](../rules/CodeQuality/Rector/LogicalAnd/AndAssignsToSeparateLinesRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $tokens = [];
-        $token = 4 and $tokens[] = $token;
+        $token = 4;
+        $tokens[] = $token;
     }
 }
```

<br>

### ArrayKeyExistsTernaryThenValueToCoalescingRector

Change `array_key_exists()` ternary to coalesing

- class: [`Rector\CodeQuality\Rector\Ternary\ArrayKeyExistsTernaryThenValueToCoalescingRector`](../rules/CodeQuality/Rector/Ternary/ArrayKeyExistsTernaryThenValueToCoalescingRector.php)

```diff
 class SomeClass
 {
     public function run($values, $keyToMatch)
     {
-        $result = array_key_exists($keyToMatch, $values) ? $values[$keyToMatch] : null;
+        $result = $values[$keyToMatch] ?? null;
     }
 }
```

<br>

### ArrayKeysAndInArrayToArrayKeyExistsRector

Replace `array_keys()` and `in_array()` to `array_key_exists()`

- class: [`Rector\CodeQuality\Rector\FuncCall\ArrayKeysAndInArrayToArrayKeyExistsRector`](../rules/CodeQuality/Rector/FuncCall/ArrayKeysAndInArrayToArrayKeyExistsRector.php)

```diff
 class SomeClass
 {
     public function run($packageName, $values)
     {
-        $keys = array_keys($values);
-        return in_array($packageName, $keys, true);
+        return array_key_exists($packageName, $values);
     }
 }
```

<br>

### ArrayMergeOfNonArraysToSimpleArrayRector

Change array_merge of non arrays to array directly

- class: [`Rector\CodeQuality\Rector\FuncCall\ArrayMergeOfNonArraysToSimpleArrayRector`](../rules/CodeQuality/Rector/FuncCall/ArrayMergeOfNonArraysToSimpleArrayRector.php)

```diff
 class SomeClass
 {
     public function go()
     {
         $value = 5;
         $value2 = 10;

-        return array_merge([$value], [$value2]);
+        return [$value, $value2];
     }
 }
```

<br>

### ArrayThisCallToThisMethodCallRector

Change `[$this, someMethod]` without any args to `$this->someMethod()`

- class: [`Rector\CodeQuality\Rector\Array_\ArrayThisCallToThisMethodCallRector`](../rules/CodeQuality/Rector/Array_/ArrayThisCallToThisMethodCallRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $values = [$this, 'giveMeMore'];
+        $values = $this->giveMeMore();
     }

     public function giveMeMore()
     {
         return 'more';
     }
 }
```

<br>

### BooleanNotIdenticalToNotIdenticalRector

Negated identical boolean compare to not identical compare (does not apply to non-bool values)

- class: [`Rector\CodeQuality\Rector\Identical\BooleanNotIdenticalToNotIdenticalRector`](../rules/CodeQuality/Rector/Identical/BooleanNotIdenticalToNotIdenticalRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $a = true;
         $b = false;

-        var_dump(! $a === $b); // true
-        var_dump(! ($a === $b)); // true
+        var_dump($a !== $b); // true
+        var_dump($a !== $b); // true
         var_dump($a !== $b); // true
     }
 }
```

<br>

### CallUserFuncWithArrowFunctionToInlineRector

Refactor `call_user_func()` with arrow function to direct call

- class: [`Rector\CodeQuality\Rector\FuncCall\CallUserFuncWithArrowFunctionToInlineRector`](../rules/CodeQuality/Rector/FuncCall/CallUserFuncWithArrowFunctionToInlineRector.php)

```diff
 final class SomeClass
 {
     public function run()
     {
-        $result = \call_user_func(fn () => 100);
+        $result = 100;
     }
 }
```

<br>

### CallableThisArrayToAnonymousFunctionRector

Convert [$this, "method"] to proper anonymous function

- class: [`Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector`](../rules/CodeQuality/Rector/Array_/CallableThisArrayToAnonymousFunctionRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $values = [1, 5, 3];
-        usort($values, [$this, 'compareSize']);
+        usort($values, function ($first, $second) {
+            return $this->compareSize($first, $second);
+        });

         return $values;
     }

     private function compareSize($first, $second)
     {
         return $first <=> $second;
     }
 }
```

<br>

### ChangeArrayPushToArrayAssignRector

Change `array_push()` to direct variable assign

- class: [`Rector\CodeQuality\Rector\FuncCall\ChangeArrayPushToArrayAssignRector`](../rules/CodeQuality/Rector/FuncCall/ChangeArrayPushToArrayAssignRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $items = [];
-        array_push($items, $item);
+        $items[] = $item;
     }
 }
```

<br>

### CombineIfRector

Merges nested if statements

- class: [`Rector\CodeQuality\Rector\If_\CombineIfRector`](../rules/CodeQuality/Rector/If_/CombineIfRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        if ($cond1) {
-            if ($cond2) {
-                return 'foo';
-            }
+        if ($cond1 && $cond2) {
+            return 'foo';
         }
     }
 }
```

<br>

### CombinedAssignRector

Simplify `$value` = `$value` + 5; assignments to shorter ones

- class: [`Rector\CodeQuality\Rector\Assign\CombinedAssignRector`](../rules/CodeQuality/Rector/Assign/CombinedAssignRector.php)

```diff
-$value = $value + 5;
+$value += 5;
```

<br>

### CommonNotEqualRector

Use common != instead of less known <> with same meaning

- class: [`Rector\CodeQuality\Rector\NotEqual\CommonNotEqualRector`](../rules/CodeQuality/Rector/NotEqual/CommonNotEqualRector.php)

```diff
 final class SomeClass
 {
     public function run($one, $two)
     {
-        return $one <> $two;
+        return $one != $two;
     }
 }
```

<br>

### CompactToVariablesRector

Change `compact()` call to own array

- class: [`Rector\CodeQuality\Rector\FuncCall\CompactToVariablesRector`](../rules/CodeQuality/Rector/FuncCall/CompactToVariablesRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $checkout = 'one';
         $form = 'two';

-        return compact('checkout', 'form');
+        return ['checkout' => $checkout, 'form' => $form];
     }
 }
```

<br>

### CompleteDynamicPropertiesRector

Add missing dynamic properties

- class: [`Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector`](../rules/CodeQuality/Rector/Class_/CompleteDynamicPropertiesRector.php)

```diff
 class SomeClass
 {
+    /**
+     * @var int
+     */
+    public $value;
+
     public function set()
     {
         $this->value = 5;
     }
 }
```

<br>

### ConsecutiveNullCompareReturnsToNullCoalesceQueueRector

Change multiple null compares to ?? queue

- class: [`Rector\CodeQuality\Rector\If_\ConsecutiveNullCompareReturnsToNullCoalesceQueueRector`](../rules/CodeQuality/Rector/If_/ConsecutiveNullCompareReturnsToNullCoalesceQueueRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        if (null !== $this->orderItem) {
-            return $this->orderItem;
-        }
-
-        if (null !== $this->orderItemUnit) {
-            return $this->orderItemUnit;
-        }
-
-        return null;
+        return $this->orderItem ?? $this->orderItemUnit;
     }
 }
```

<br>

### DateTimeToDateTimeInterfaceRector

Changes DateTime type-hint to DateTimeInterface

- class: [`Rector\CodeQuality\Rector\ClassMethod\DateTimeToDateTimeInterfaceRector`](../rules/CodeQuality/Rector/ClassMethod/DateTimeToDateTimeInterfaceRector.php)

```diff
 class SomeClass {
-    public function methodWithDateTime(\DateTime $dateTime)
+    /**
+     * @param \DateTime|\DateTimeImmutable $dateTime
+     */
+    public function methodWithDateTime(\DateTimeInterface $dateTime)
     {
         return true;
     }
 }
```

<br>

### ExplicitBoolCompareRector

Make if conditions more explicit

- class: [`Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector`](../rules/CodeQuality/Rector/If_/ExplicitBoolCompareRector.php)

```diff
 final class SomeController
 {
     public function run($items)
     {
-        if (!count($items)) {
+        if (count($items) === 0) {
             return 'no items';
         }
     }
 }
```

<br>

### FixClassCaseSensitivityNameRector

Change miss-typed case sensitivity name to correct one

- class: [`Rector\CodeQuality\Rector\Name\FixClassCaseSensitivityNameRector`](../rules/CodeQuality/Rector/Name/FixClassCaseSensitivityNameRector.php)

```diff
 final class SomeClass
 {
     public function run()
     {
-        $anotherClass = new anotherclass;
+        $anotherClass = new AnotherClass;
     }
 }

 final class AnotherClass
 {
 }
```

<br>

### FlipTypeControlToUseExclusiveTypeRector

Flip type control to use exclusive type

- class: [`Rector\CodeQuality\Rector\Identical\FlipTypeControlToUseExclusiveTypeRector`](../rules/CodeQuality/Rector/Identical/FlipTypeControlToUseExclusiveTypeRector.php)

```diff
 class SomeClass
 {
     public function __construct(array $values)
     {
-        /** @var PhpDocInfo|null $phpDocInfo */
         $phpDocInfo = $functionLike->getAttribute(AttributeKey::PHP_DOC_INFO);
-        if ($phpDocInfo === null) {
+        if (! $phpDocInfo instanceof PhpDocInfo) {
             return;
         }
     }
 }
```

<br>

### ForRepeatedCountToOwnVariableRector

Change `count()` in for function to own variable

- class: [`Rector\CodeQuality\Rector\For_\ForRepeatedCountToOwnVariableRector`](../rules/CodeQuality/Rector/For_/ForRepeatedCountToOwnVariableRector.php)

```diff
 class SomeClass
 {
     public function run($items)
     {
-        for ($i = 5; $i <= count($items); $i++) {
+        $itemsCount = count($items);
+        for ($i = 5; $i <= $itemsCount; $i++) {
             echo $items[$i];
         }
     }
 }
```

<br>

### ForToForeachRector

Change `for()` to `foreach()` where useful

- class: [`Rector\CodeQuality\Rector\For_\ForToForeachRector`](../rules/CodeQuality/Rector/For_/ForToForeachRector.php)

```diff
 class SomeClass
 {
     public function run($tokens)
     {
-        for ($i = 0, $c = count($tokens); $i < $c; ++$i) {
-            if ($tokens[$i][0] === T_STRING && $tokens[$i][1] === 'fn') {
+        foreach ($tokens as $i => $token) {
+            if ($token[0] === T_STRING && $token[1] === 'fn') {
                 $tokens[$i][0] = self::T_FN;
             }
         }
     }
 }
```

<br>

### ForeachItemsAssignToEmptyArrayToAssignRector

Change `foreach()` items assign to empty array to direct assign

- class: [`Rector\CodeQuality\Rector\Foreach_\ForeachItemsAssignToEmptyArrayToAssignRector`](../rules/CodeQuality/Rector/Foreach_/ForeachItemsAssignToEmptyArrayToAssignRector.php)

```diff
 class SomeClass
 {
     public function run($items)
     {
         $collectedItems = [];

-        foreach ($items as $item) {
-             $collectedItems[] = $item;
-        }
+        $collectedItems = $items;
     }
 }
```

<br>

### ForeachToInArrayRector

Simplify `foreach` loops into `in_array` when possible

- class: [`Rector\CodeQuality\Rector\Foreach_\ForeachToInArrayRector`](../rules/CodeQuality/Rector/Foreach_/ForeachToInArrayRector.php)

```diff
-foreach ($items as $item) {
-    if ($item === 'something') {
-        return true;
-    }
-}
-
-return false;
+return in_array('something', $items, true);
```

<br>

### GetClassToInstanceOfRector

Changes comparison with get_class to instanceof

- class: [`Rector\CodeQuality\Rector\Identical\GetClassToInstanceOfRector`](../rules/CodeQuality/Rector/Identical/GetClassToInstanceOfRector.php)

```diff
-if (EventsListener::class === get_class($event->job)) { }
+if ($event->job instanceof EventsListener) { }
```

<br>

### InArrayAndArrayKeysToArrayKeyExistsRector

Simplify `in_array` and `array_keys` functions combination into `array_key_exists` when `array_keys` has one argument only

- class: [`Rector\CodeQuality\Rector\FuncCall\InArrayAndArrayKeysToArrayKeyExistsRector`](../rules/CodeQuality/Rector/FuncCall/InArrayAndArrayKeysToArrayKeyExistsRector.php)

```diff
-in_array("key", array_keys($array), true);
+array_key_exists("key", $array);
```

<br>

### InlineIfToExplicitIfRector

Change inline if to explicit if

- class: [`Rector\CodeQuality\Rector\Expression\InlineIfToExplicitIfRector`](../rules/CodeQuality/Rector/Expression/InlineIfToExplicitIfRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $userId = null;

-        is_null($userId) && $userId = 5;
+        if (is_null($userId)) {
+            $userId = 5;
+        }
     }
 }
```

<br>

### IntvalToTypeCastRector

Change `intval()` to faster and readable (int) `$value`

- class: [`Rector\CodeQuality\Rector\FuncCall\IntvalToTypeCastRector`](../rules/CodeQuality/Rector/FuncCall/IntvalToTypeCastRector.php)

```diff
 class SomeClass
 {
     public function run($value)
     {
-        return intval($value);
+        return (int) $value;
     }
 }
```

<br>

### IsAWithStringWithThirdArgumentRector

Complete missing 3rd argument in case `is_a()` function in case of strings

- class: [`Rector\CodeQuality\Rector\FuncCall\IsAWithStringWithThirdArgumentRector`](../rules/CodeQuality/Rector/FuncCall/IsAWithStringWithThirdArgumentRector.php)

```diff
 class SomeClass
 {
     public function __construct(string $value)
     {
-        return is_a($value, 'stdClass');
+        return is_a($value, 'stdClass', true);
     }
 }
```

<br>

### IssetOnPropertyObjectToPropertyExistsRector

Change isset on property object to `property_exists()` and not null check

- class: [`Rector\CodeQuality\Rector\Isset_\IssetOnPropertyObjectToPropertyExistsRector`](../rules/CodeQuality/Rector/Isset_/IssetOnPropertyObjectToPropertyExistsRector.php)

```diff
 class SomeClass
 {
     private $x;

     public function run(): void
     {
-        isset($this->x);
+        property_exists($this, 'x') && $this->x !== null;
     }
 }
```

<br>

### JoinStringConcatRector

Joins concat of 2 strings, unless the length is too long

- class: [`Rector\CodeQuality\Rector\Concat\JoinStringConcatRector`](../rules/CodeQuality/Rector/Concat/JoinStringConcatRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $name = 'Hi' . ' Tom';
+        $name = 'Hi Tom';
     }
 }
```

<br>

### LogicalToBooleanRector

Change OR, AND to ||, && with more common understanding

- class: [`Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector`](../rules/CodeQuality/Rector/LogicalAnd/LogicalToBooleanRector.php)

```diff
-if ($f = false or true) {
+if (($f = false) || true) {
     return $f;
 }
```

<br>

### NarrowUnionTypeDocRector

Changes docblock by narrowing type

- class: [`Rector\CodeQuality\Rector\ClassMethod\NarrowUnionTypeDocRector`](../rules/CodeQuality/Rector/ClassMethod/NarrowUnionTypeDocRector.php)

```diff
 class SomeClass {
     /**
-     * @param object|DateTime $message
+     * @param DateTime $message
      */
     public function getMessage(object $message)
     {
     }
 }
```

<br>

### NewStaticToNewSelfRector

Change unsafe new `static()` to new `self()`

- class: [`Rector\CodeQuality\Rector\New_\NewStaticToNewSelfRector`](../rules/CodeQuality/Rector/New_/NewStaticToNewSelfRector.php)

```diff
 class SomeClass
 {
     public function build()
     {
-        return new static();
+        return new self();
     }
 }
```

<br>

### RemoveAlwaysTrueConditionSetInConstructorRector

If conditions is always true, perform the content right away

- class: [`Rector\CodeQuality\Rector\FunctionLike\RemoveAlwaysTrueConditionSetInConstructorRector`](../rules/CodeQuality/Rector/FunctionLike/RemoveAlwaysTrueConditionSetInConstructorRector.php)

```diff
 final class SomeClass
 {
     private $value;

     public function __construct(stdClass $value)
     {
         $this->value = $value;
     }

     public function go()
     {
-        if ($this->value) {
-            return 'yes';
-        }
+        return 'yes';
     }
 }
```

<br>

### RemoveSoleValueSprintfRector

Remove `sprintf()` wrapper if not needed

- class: [`Rector\CodeQuality\Rector\FuncCall\RemoveSoleValueSprintfRector`](../rules/CodeQuality/Rector/FuncCall/RemoveSoleValueSprintfRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $value = sprintf('%s', 'hi');
+        $value = 'hi';

         $welcome = 'hello';
-        $value = sprintf('%s', $welcome);
+        $value = $welcome;
     }
 }
```

<br>

### SetTypeToCastRector

Changes `settype()` to (type) where possible

- class: [`Rector\CodeQuality\Rector\FuncCall\SetTypeToCastRector`](../rules/CodeQuality/Rector/FuncCall/SetTypeToCastRector.php)

```diff
 class SomeClass
 {
-    public function run($foo)
+    public function run(array $items)
     {
-        settype($foo, 'string');
+        $foo = (string) $foo;

-        return settype($foo, 'integer');
+        return (int) $foo;
     }
 }
```

<br>

### ShortenElseIfRector

Shortens else/if to elseif

- class: [`Rector\CodeQuality\Rector\If_\ShortenElseIfRector`](../rules/CodeQuality/Rector/If_/ShortenElseIfRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         if ($cond1) {
             return $action1;
-        } else {
-            if ($cond2) {
-                return $action2;
-            }
+        } elseif ($cond2) {
+            return $action2;
         }
     }
 }
```

<br>

### SimplifyArraySearchRector

Simplify array_search to in_array

- class: [`Rector\CodeQuality\Rector\Identical\SimplifyArraySearchRector`](../rules/CodeQuality/Rector/Identical/SimplifyArraySearchRector.php)

```diff
-array_search("searching", $array) !== false;
+in_array("searching", $array);
```

<br>

```diff
-array_search("searching", $array, true) !== false;
+in_array("searching", $array, true);
```

<br>

### SimplifyBoolIdenticalTrueRector

Symplify bool value compare to true or false

- class: [`Rector\CodeQuality\Rector\Identical\SimplifyBoolIdenticalTrueRector`](../rules/CodeQuality/Rector/Identical/SimplifyBoolIdenticalTrueRector.php)

```diff
 class SomeClass
 {
     public function run(bool $value, string $items)
     {
-         $match = in_array($value, $items, TRUE) === TRUE;
-         $match = in_array($value, $items, TRUE) !== FALSE;
+         $match = in_array($value, $items, TRUE);
+         $match = in_array($value, $items, TRUE);
     }
 }
```

<br>

### SimplifyConditionsRector

Simplify conditions

- class: [`Rector\CodeQuality\Rector\Identical\SimplifyConditionsRector`](../rules/CodeQuality/Rector/Identical/SimplifyConditionsRector.php)

```diff
-if (! ($foo !== 'bar')) {...
+if ($foo === 'bar') {...
```

<br>

### SimplifyDeMorganBinaryRector

Simplify negated conditions with de Morgan theorem

- class: [`Rector\CodeQuality\Rector\BooleanNot\SimplifyDeMorganBinaryRector`](../rules/CodeQuality/Rector/BooleanNot/SimplifyDeMorganBinaryRector.php)

```diff
 $a = 5;
 $b = 10;
-$result = !($a > 20 || $b <= 50);
+$result = $a <= 20 && $b > 50;
```

<br>

### SimplifyDuplicatedTernaryRector

Remove ternary that duplicated return value of true : false

- class: [`Rector\CodeQuality\Rector\Ternary\SimplifyDuplicatedTernaryRector`](../rules/CodeQuality/Rector/Ternary/SimplifyDuplicatedTernaryRector.php)

```diff
 class SomeClass
 {
     public function run(bool $value, string $name)
     {
-         $isTrue = $value ? true : false;
+         $isTrue = $value;
          $isName = $name ? true : false;
     }
 }
```

<br>

### SimplifyEmptyArrayCheckRector

Simplify `is_array` and `empty` functions combination into a simple identical check for an empty array

- class: [`Rector\CodeQuality\Rector\BooleanAnd\SimplifyEmptyArrayCheckRector`](../rules/CodeQuality/Rector/BooleanAnd/SimplifyEmptyArrayCheckRector.php)

```diff
-is_array($values) && empty($values)
+$values === []
```

<br>

### SimplifyForeachToArrayFilterRector

Simplify foreach with function filtering to array filter

- class: [`Rector\CodeQuality\Rector\Foreach_\SimplifyForeachToArrayFilterRector`](../rules/CodeQuality/Rector/Foreach_/SimplifyForeachToArrayFilterRector.php)

```diff
-$directories = [];
 $possibleDirectories = [];
-foreach ($possibleDirectories as $possibleDirectory) {
-    if (file_exists($possibleDirectory)) {
-        $directories[] = $possibleDirectory;
-    }
-}
+$directories = array_filter($possibleDirectories, 'file_exists');
```

<br>

### SimplifyForeachToCoalescingRector

Changes foreach that returns set value to ??

- class: [`Rector\CodeQuality\Rector\Foreach_\SimplifyForeachToCoalescingRector`](../rules/CodeQuality/Rector/Foreach_/SimplifyForeachToCoalescingRector.php)

```diff
-foreach ($this->oldToNewFunctions as $oldFunction => $newFunction) {
-    if ($currentFunction === $oldFunction) {
-        return $newFunction;
-    }
-}
-
-return null;
+return $this->oldToNewFunctions[$currentFunction] ?? null;
```

<br>

### SimplifyFuncGetArgsCountRector

Simplify count of `func_get_args()` to `func_num_args()`

- class: [`Rector\CodeQuality\Rector\FuncCall\SimplifyFuncGetArgsCountRector`](../rules/CodeQuality/Rector/FuncCall/SimplifyFuncGetArgsCountRector.php)

```diff
-count(func_get_args());
+func_num_args();
```

<br>

### SimplifyIfElseToTernaryRector

Changes if/else for same value as assign to ternary

- class: [`Rector\CodeQuality\Rector\If_\SimplifyIfElseToTernaryRector`](../rules/CodeQuality/Rector/If_/SimplifyIfElseToTernaryRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        if (empty($value)) {
-            $this->arrayBuilt[][$key] = true;
-        } else {
-            $this->arrayBuilt[][$key] = $value;
-        }
+        $this->arrayBuilt[][$key] = empty($value) ? true : $value;
     }
 }
```

<br>

### SimplifyIfIssetToNullCoalescingRector

Simplify binary if to null coalesce

- class: [`Rector\CodeQuality\Rector\If_\SimplifyIfIssetToNullCoalescingRector`](../rules/CodeQuality/Rector/If_/SimplifyIfIssetToNullCoalescingRector.php)

```diff
 final class SomeController
 {
     public function run($possibleStatieYamlFile)
     {
-        if (isset($possibleStatieYamlFile['import'])) {
-            $possibleStatieYamlFile['import'] = array_merge($possibleStatieYamlFile['import'], $filesToImport);
-        } else {
-            $possibleStatieYamlFile['import'] = $filesToImport;
-        }
+        $possibleStatieYamlFile['import'] = array_merge($possibleStatieYamlFile['import'] ?? [], $filesToImport);
     }
 }
```

<br>

### SimplifyIfNotNullReturnRector

Changes redundant null check to instant return

- class: [`Rector\CodeQuality\Rector\If_\SimplifyIfNotNullReturnRector`](../rules/CodeQuality/Rector/If_/SimplifyIfNotNullReturnRector.php)

```diff
 $newNode = 'something ;
-if ($newNode !== null) {
-    return $newNode;
-}
-
-return null;
+return $newNode;
```

<br>

### SimplifyIfNullableReturnRector

Direct return on if nullable check before return

- class: [`Rector\CodeQuality\Rector\If_\SimplifyIfNullableReturnRector`](../rules/CodeQuality/Rector/If_/SimplifyIfNullableReturnRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        /** @var \stdClass|null $value */
-        $value = $this->foo->bar();
-        if (! $value instanceof \stdClass) {
-            return null;
-        }
-
-        return $value;
+        return $this->foo->bar();
     }
 }
```

<br>

### SimplifyIfReturnBoolRector

Shortens if return false/true to direct return

- class: [`Rector\CodeQuality\Rector\If_\SimplifyIfReturnBoolRector`](../rules/CodeQuality/Rector/If_/SimplifyIfReturnBoolRector.php)

```diff
-if (strpos($docToken->getContent(), "\n") === false) {
-    return true;
-}
-
-return false;
+return strpos($docToken->getContent(), "\n") === false;
```

<br>

### SimplifyInArrayValuesRector

Removes unneeded `array_values()` in `in_array()` call

- class: [`Rector\CodeQuality\Rector\FuncCall\SimplifyInArrayValuesRector`](../rules/CodeQuality/Rector/FuncCall/SimplifyInArrayValuesRector.php)

```diff
-in_array("key", array_values($array), true);
+in_array("key", $array, true);
```

<br>

### SimplifyRegexPatternRector

Simplify regex pattern to known ranges

- class: [`Rector\CodeQuality\Rector\FuncCall\SimplifyRegexPatternRector`](../rules/CodeQuality/Rector/FuncCall/SimplifyRegexPatternRector.php)

```diff
 class SomeClass
 {
     public function run($value)
     {
-        preg_match('#[a-zA-Z0-9+]#', $value);
+        preg_match('#[\w\d+]#', $value);
     }
 }
```

<br>

### SimplifyStrposLowerRector

Simplify `strpos(strtolower()`, "...") calls

- class: [`Rector\CodeQuality\Rector\FuncCall\SimplifyStrposLowerRector`](../rules/CodeQuality/Rector/FuncCall/SimplifyStrposLowerRector.php)

```diff
-strpos(strtolower($var), "...")"
+stripos($var, "...")"
```

<br>

### SimplifyTautologyTernaryRector

Simplify tautology ternary to value

- class: [`Rector\CodeQuality\Rector\Ternary\SimplifyTautologyTernaryRector`](../rules/CodeQuality/Rector/Ternary/SimplifyTautologyTernaryRector.php)

```diff
-$value = ($fullyQualifiedTypeHint !== $typeHint) ? $fullyQualifiedTypeHint : $typeHint;
+$value = $fullyQualifiedTypeHint;
```

<br>

### SimplifyUselessVariableRector

Removes useless variable assigns

- class: [`Rector\CodeQuality\Rector\Return_\SimplifyUselessVariableRector`](../rules/CodeQuality/Rector/Return_/SimplifyUselessVariableRector.php)

```diff
 function () {
-    $a = true;
-    return $a;
+    return true;
 };
```

<br>

### SingleInArrayToCompareRector

Changes `in_array()` with single element to ===

- class: [`Rector\CodeQuality\Rector\FuncCall\SingleInArrayToCompareRector`](../rules/CodeQuality/Rector/FuncCall/SingleInArrayToCompareRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        if (in_array(strtolower($type), ['$this'], true)) {
+        if (strtolower($type) === '$this') {
             return strtolower($type);
         }
     }
 }
```

<br>

### SingularSwitchToIfRector

Change switch with only 1 check to if

- class: [`Rector\CodeQuality\Rector\Switch_\SingularSwitchToIfRector`](../rules/CodeQuality/Rector/Switch_/SingularSwitchToIfRector.php)

```diff
 class SomeObject
 {
     public function run($value)
     {
         $result = 1;
-        switch ($value) {
-            case 100:
+        if ($value === 100) {
             $result = 1000;
         }

         return $result;
     }
 }
```

<br>

### SplitListAssignToSeparateLineRector

Splits `[$a, $b] = [5, 10]` scalar assign to standalone lines

- class: [`Rector\CodeQuality\Rector\Assign\SplitListAssignToSeparateLineRector`](../rules/CodeQuality/Rector/Assign/SplitListAssignToSeparateLineRector.php)

```diff
 final class SomeClass
 {
     public function run(): void
     {
-        [$a, $b] = [1, 2];
+        $a = 1;
+        $b = 2;
     }
 }
```

<br>

### StrlenZeroToIdenticalEmptyStringRector

Changes strlen comparison to 0 to direct empty string compare

- class: [`Rector\CodeQuality\Rector\Identical\StrlenZeroToIdenticalEmptyStringRector`](../rules/CodeQuality/Rector/Identical/StrlenZeroToIdenticalEmptyStringRector.php)

```diff
 class SomeClass
 {
     public function run($value)
     {
-        $empty = strlen($value) === 0;
+        $empty = $value === '';
     }
 }
```

<br>

### SwitchNegatedTernaryRector

Switch negated ternary condition rector

- class: [`Rector\CodeQuality\Rector\Ternary\SwitchNegatedTernaryRector`](../rules/CodeQuality/Rector/Ternary/SwitchNegatedTernaryRector.php)

```diff
 class SomeClass
 {
     public function run(bool $upper, string $name)
     {
-        return ! $upper
-            ? $name
-            : strtoupper($name);
+        return $upper
+            ? strtoupper($name)
+            : $name;
     }
 }
```

<br>

### ThrowWithPreviousExceptionRector

When throwing into a catch block, checks that the previous exception is passed to the new throw clause

- class: [`Rector\CodeQuality\Rector\Catch_\ThrowWithPreviousExceptionRector`](../rules/CodeQuality/Rector/Catch_/ThrowWithPreviousExceptionRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         try {
             $someCode = 1;
         } catch (Throwable $throwable) {
-            throw new AnotherException('ups');
+            throw new AnotherException('ups', $throwable->getCode(), $throwable);
         }
     }
 }
```

<br>

### UnnecessaryTernaryExpressionRector

Remove unnecessary ternary expressions.

- class: [`Rector\CodeQuality\Rector\Ternary\UnnecessaryTernaryExpressionRector`](../rules/CodeQuality/Rector/Ternary/UnnecessaryTernaryExpressionRector.php)

```diff
-$foo === $bar ? true : false;
+$foo === $bar;
```

<br>

### UnusedForeachValueToArrayKeysRector

Change foreach with unused `$value` but only `$key,` to `array_keys()`

- class: [`Rector\CodeQuality\Rector\Foreach_\UnusedForeachValueToArrayKeysRector`](../rules/CodeQuality/Rector/Foreach_/UnusedForeachValueToArrayKeysRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $items = [];
-        foreach ($values as $key => $value) {
+        foreach (array_keys($values) as $key) {
             $items[$key] = null;
         }
     }
 }
```

<br>

### UnwrapSprintfOneArgumentRector

unwrap `sprintf()` with one argument

- class: [`Rector\CodeQuality\Rector\FuncCall\UnwrapSprintfOneArgumentRector`](../rules/CodeQuality/Rector/FuncCall/UnwrapSprintfOneArgumentRector.php)

```diff
-echo sprintf('value');
+echo 'value';
```

<br>

### UseIdenticalOverEqualWithSameTypeRector

Use ===/!== over ==/!=, it values have the same type

- class: [`Rector\CodeQuality\Rector\Equal\UseIdenticalOverEqualWithSameTypeRector`](../rules/CodeQuality/Rector/Equal/UseIdenticalOverEqualWithSameTypeRector.php)

```diff
 class SomeClass
 {
     public function run(int $firstValue, int $secondValue)
     {
-         $isSame = $firstValue == $secondValue;
-         $isDiffernt = $firstValue != $secondValue;
+         $isSame = $firstValue === $secondValue;
+         $isDiffernt = $firstValue !== $secondValue;
     }
 }
```

<br>

## CodeQualityStrict

### MoveOutMethodCallInsideIfConditionRector

Move out method call inside If condition

- class: [`Rector\CodeQualityStrict\Rector\If_\MoveOutMethodCallInsideIfConditionRector`](../rules/CodeQualityStrict/Rector/If_/MoveOutMethodCallInsideIfConditionRector.php)

```diff
-if ($obj->run($arg) === 1) {
+$objRun = $obj->run($arg);
+if ($objRun === 1) {

 }
```

<br>

### MoveVariableDeclarationNearReferenceRector

Move variable declaration near its reference

- class: [`Rector\CodeQualityStrict\Rector\Variable\MoveVariableDeclarationNearReferenceRector`](../rules/CodeQualityStrict/Rector/Variable/MoveVariableDeclarationNearReferenceRector.php)

```diff
-$var = 1;
 if ($condition === null) {
+    $var = 1;
     return $var;
 }
```

<br>

### ParamTypeToAssertTypeRector

Turn `@param` type to assert type

- class: [`Rector\CodeQualityStrict\Rector\ClassMethod\ParamTypeToAssertTypeRector`](../rules/CodeQualityStrict/Rector/ClassMethod/ParamTypeToAssertTypeRector.php)

```diff
 class SomeClass
 {
     /**
      * @param \A|\B $arg
      */
     public function run($arg)
     {
-
+        \Webmozart\Assert\Assert::isAnyOf($arg, [\A::class, \B::class]);
     }
 }
```

<br>

### VarInlineAnnotationToAssertRector

Turn `@var` inline checks above code to `assert()` of the type

- class: [`Rector\CodeQualityStrict\Rector\Stmt\VarInlineAnnotationToAssertRector`](../rules/CodeQualityStrict/Rector/Stmt/VarInlineAnnotationToAssertRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         /** @var SpecificClass $value */
+        assert($value instanceof SpecificClass);
         $value->call();
     }
 }
```

<br>

## CodingStyle

### AddArrayDefaultToArrayPropertyRector

Adds array default value to property to prevent foreach over null error

- class: [`Rector\CodingStyle\Rector\Class_\AddArrayDefaultToArrayPropertyRector`](../rules/CodingStyle/Rector/Class_/AddArrayDefaultToArrayPropertyRector.php)

```diff
 class SomeClass
 {
     /**
      * @var int[]
      */
-    private $values;
+    private $values = [];

     public function isEmpty()
     {
-        return $this->values === null;
+        return $this->values === [];
     }
 }
```

<br>

### AddFalseDefaultToBoolPropertyRector

Add false default to bool properties, to prevent null compare errors

- class: [`Rector\CodingStyle\Rector\Property\AddFalseDefaultToBoolPropertyRector`](../rules/CodingStyle/Rector/Property/AddFalseDefaultToBoolPropertyRector.php)

```diff
 class SomeClass
 {
     /**
      * @var bool
      */
-    private $isDisabled;
+    private $isDisabled = false;
 }
```

<br>

### BinarySwitchToIfElseRector

Changes switch with 2 options to if-else

- class: [`Rector\CodingStyle\Rector\Switch_\BinarySwitchToIfElseRector`](../rules/CodingStyle/Rector/Switch_/BinarySwitchToIfElseRector.php)

```diff
-switch ($foo) {
-    case 'my string':
-        $result = 'ok';
-    break;
-
-    default:
-        $result = 'not ok';
+if ($foo == 'my string') {
+    $result = 'ok;
+} else {
+    $result = 'not ok';
 }
```

<br>

### CallUserFuncArrayToVariadicRector

Replace `call_user_func_array()` with variadic

- class: [`Rector\CodingStyle\Rector\FuncCall\CallUserFuncArrayToVariadicRector`](../rules/CodingStyle/Rector/FuncCall/CallUserFuncArrayToVariadicRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        call_user_func_array('some_function', $items);
+        some_function(...$items);
     }
 }
```

<br>

### CallUserFuncToMethodCallRector

Refactor `call_user_func()` on known class method to a method call

- class: [`Rector\CodingStyle\Rector\FuncCall\CallUserFuncToMethodCallRector`](../rules/CodingStyle/Rector/FuncCall/CallUserFuncToMethodCallRector.php)

```diff
 final class SomeClass
 {
     public function run()
     {
-        $result = \call_user_func([$this->property, 'method'], $args);
+        $result = $this->property->method($args);
     }
 }
```

<br>

### CatchExceptionNameMatchingTypeRector

Type and name of catch exception should match

- class: [`Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector`](../rules/CodingStyle/Rector/Catch_/CatchExceptionNameMatchingTypeRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         try {
             // ...
-        } catch (SomeException $typoException) {
-            $typoException->getMessage();
+        } catch (SomeException $someException) {
+            $someException->getMessage();
         }
     }
 }
```

<br>

### ConsistentImplodeRector

Changes various implode forms to consistent one

- class: [`Rector\CodingStyle\Rector\FuncCall\ConsistentImplodeRector`](../rules/CodingStyle/Rector/FuncCall/ConsistentImplodeRector.php)

```diff
 class SomeClass
 {
     public function run(array $items)
     {
-        $itemsAsStrings = implode($items);
-        $itemsAsStrings = implode($items, '|');
+        $itemsAsStrings = implode('', $items);
+        $itemsAsStrings = implode('|', $items);

         $itemsAsStrings = implode('|', $items);
     }
 }
```

<br>

### ConsistentPregDelimiterRector

Replace PREG delimiter with configured one

:wrench: **configure it!**

- class: [`Rector\CodingStyle\Rector\FuncCall\ConsistentPregDelimiterRector`](../rules/CodingStyle/Rector/FuncCall/ConsistentPregDelimiterRector.php)

```php
use Rector\CodingStyle\Rector\FuncCall\ConsistentPregDelimiterRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ConsistentPregDelimiterRector::class)
        ->call('configure', [[
            ConsistentPregDelimiterRector::DELIMITER => '#',
        ]]);
};
```

↓

```diff
 class SomeClass
 {
     public function run()
     {
-        preg_match('~value~', $value);
-        preg_match_all('~value~im', $value);
+        preg_match('#value#', $value);
+        preg_match_all('#value#im', $value);
     }
 }
```

<br>

### CountArrayToEmptyArrayComparisonRector

Change count array comparison to empty array comparison to improve performance

- class: [`Rector\CodingStyle\Rector\FuncCall\CountArrayToEmptyArrayComparisonRector`](../rules/CodingStyle/Rector/FuncCall/CountArrayToEmptyArrayComparisonRector.php)

```diff
-count($array) === 0;
-count($array) > 0;
-! count($array);
+$array === [];
+$array !== [];
+$array === [];
```

<br>

### EncapsedStringsToSprintfRector

Convert enscaped {$string} to more readable sprintf

- class: [`Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector`](../rules/CodingStyle/Rector/Encapsed/EncapsedStringsToSprintfRector.php)

```diff
 final class SomeClass
 {
     public function run(string $format)
     {
-        return "Unsupported format {$format}";
+        return sprintf('Unsupported format %s', $format);
     }
 }
```

<br>

### FollowRequireByDirRector

include/require should be followed by absolute path

- class: [`Rector\CodingStyle\Rector\Include_\FollowRequireByDirRector`](../rules/CodingStyle/Rector/Include_/FollowRequireByDirRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        require 'autoload.php';
+        require __DIR__ . '/autoload.php';
     }
 }
```

<br>

### FuncGetArgsToVariadicParamRector

Refactor `func_get_args()` in to a variadic param

- class: [`Rector\CodingStyle\Rector\ClassMethod\FuncGetArgsToVariadicParamRector`](../rules/CodingStyle/Rector/ClassMethod/FuncGetArgsToVariadicParamRector.php)

```diff
-function run()
+function run(...$args)
 {
-    $args = \func_get_args();
 }
```

<br>

### MakeInheritedMethodVisibilitySameAsParentRector

Make method visibility same as parent one

- class: [`Rector\CodingStyle\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector`](../rules/CodingStyle/Rector/ClassMethod/MakeInheritedMethodVisibilitySameAsParentRector.php)

```diff
 class ChildClass extends ParentClass
 {
-    public function run()
+    protected function run()
     {
     }
 }

 class ParentClass
 {
     protected function run()
     {
     }
 }
```

<br>

### ManualJsonStringToJsonEncodeArrayRector

Convert manual JSON string to JSON::encode array

- class: [`Rector\CodingStyle\Rector\Assign\ManualJsonStringToJsonEncodeArrayRector`](../rules/CodingStyle/Rector/Assign/ManualJsonStringToJsonEncodeArrayRector.php)

```diff
+use Nette\Utils\Json;
+
 final class SomeClass
 {
     public function run()
     {
-        $someJsonAsString = '{"role_name":"admin","numberz":{"id":"10"}}';
+        $data = [
+            'role_name' => 'admin',
+            'numberz' => ['id' => 10]
+        ];
+        $someJsonAsString = Json::encode($data);
     }
 }
```

<br>

### NewlineBeforeNewAssignSetRector

Add extra space before new assign set

- class: [`Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector`](../rules/CodingStyle/Rector/ClassMethod/NewlineBeforeNewAssignSetRector.php)

```diff
 final class SomeClass
 {
     public function run()
     {
         $value = new Value;
         $value->setValue(5);
+
         $value2 = new Value;
         $value2->setValue(1);
     }
 }
```

<br>

### NullableCompareToNullRector

Changes negate of empty comparison of nullable value to explicit === or !== compare

- class: [`Rector\CodingStyle\Rector\If_\NullableCompareToNullRector`](../rules/CodingStyle/Rector/If_/NullableCompareToNullRector.php)

```diff
 /** @var stdClass|null $value */
-if ($value) {
+if ($value !== null) {
 }

-if (!$value) {
+if ($value === null) {
 }
```

<br>

### PHPStormVarAnnotationRector

Change various `@var` annotation formats to one PHPStorm understands

- class: [`Rector\CodingStyle\Rector\Assign\PHPStormVarAnnotationRector`](../rules/CodingStyle/Rector/Assign/PHPStormVarAnnotationRector.php)

```diff
-$config = 5;
-/** @var \Shopsys\FrameworkBundle\Model\Product\Filter\ProductFilterConfig $config */
+/** @var \Shopsys\FrameworkBundle\Model\Product\Filter\ProductFilterConfig $config */
+$config = 5;
```

<br>

### PostIncDecToPreIncDecRector

Use ++$value or --$value  instead of `$value++` or `$value--`

- class: [`Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector`](../rules/CodingStyle/Rector/PostInc/PostIncDecToPreIncDecRector.php)

```diff
 class SomeClass
 {
     public function run($value = 1)
     {
-        $value++; echo $value;
-        $value--; echo $value;
+        ++$value; echo $value;
+        --$value; echo $value;
     }
 }
```

<br>

### PreferThisOrSelfMethodCallRector

Changes `$this->...` and static:: to self:: or vise versa for given types

:wrench: **configure it!**

- class: [`Rector\CodingStyle\Rector\MethodCall\PreferThisOrSelfMethodCallRector`](../rules/CodingStyle/Rector/MethodCall/PreferThisOrSelfMethodCallRector.php)

```php
use PHPUnit\Framework\TestCase;
use Rector\CodingStyle\Rector\MethodCall\PreferThisOrSelfMethodCallRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(PreferThisOrSelfMethodCallRector::class)
        ->call('configure', [[
            PreferThisOrSelfMethodCallRector::TYPE_TO_PREFERENCE => [
                TestCase::class => 'prefer_self',

            ], ]]);
};
```

↓

```diff
 class SomeClass extends \PHPUnit\Framework\TestCase
 {
     public function run()
     {
-        $this->assertEquals('a', 'a');
+        self::assertEquals('a', 'a');
     }
 }
```

<br>

### PreslashSimpleFunctionRector

Add pre-slash to short named functions to improve performance

- class: [`Rector\CodingStyle\Rector\FuncCall\PreslashSimpleFunctionRector`](../rules/CodingStyle/Rector/FuncCall/PreslashSimpleFunctionRector.php)

```diff
 class SomeClass
 {
     public function shorten($value)
     {
-        return trim($value);
+        return \trim($value);
     }
 }
```

<br>

### RemoveDoubleUnderscoreInMethodNameRector

Non-magic PHP object methods cannot start with "__"

- class: [`Rector\CodingStyle\Rector\ClassMethod\RemoveDoubleUnderscoreInMethodNameRector`](../rules/CodingStyle/Rector/ClassMethod/RemoveDoubleUnderscoreInMethodNameRector.php)

```diff
 class SomeClass
 {
-    public function __getName($anotherObject)
+    public function getName($anotherObject)
     {
-        $anotherObject->__getSurname();
+        $anotherObject->getSurname();
     }
 }
```

<br>

### RemoveUnusedAliasRector

Removes unused use aliases. Keep annotation aliases like "Doctrine\ORM\Mapping as ORM" to keep convention format

- class: [`Rector\CodingStyle\Rector\Use_\RemoveUnusedAliasRector`](../rules/CodingStyle/Rector/Use_/RemoveUnusedAliasRector.php)

```diff
-use Symfony\Kernel as BaseKernel;
+use Symfony\Kernel;

-class SomeClass extends BaseKernel
+class SomeClass extends Kernel
 {
 }
```

<br>

### ReturnArrayClassMethodToYieldRector

Turns array return to yield return in specific type and method

:wrench: **configure it!**

- class: [`Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector`](../rules/CodingStyle/Rector/ClassMethod/ReturnArrayClassMethodToYieldRector.php)

```php
use Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector;
use Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ReturnArrayClassMethodToYieldRector::class)
        ->call('configure', [[
            ReturnArrayClassMethodToYieldRector::METHODS_TO_YIELDS => ValueObjectInliner::inline([
                new ReturnArrayClassMethodToYield('EventSubscriberInterface', 'getSubscribedEvents'),
            ]),
        ]]);
};
```

↓

```diff
 class SomeEventSubscriber implements EventSubscriberInterface
 {
     public static function getSubscribedEvents()
     {
-        return ['event' => 'callback'];
+        yield 'event' => 'callback';
     }
 }
```

<br>

### SeparateMultiUseImportsRector

Split multi use imports and trait statements to standalone lines

- class: [`Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector`](../rules/CodingStyle/Rector/Use_/SeparateMultiUseImportsRector.php)

```diff
-use A, B;
+use A;
+use B;

 class SomeClass
 {
-    use SomeTrait, AnotherTrait;
+    use SomeTrait;
+    use AnotherTrait;
 }
```

<br>

### SplitDoubleAssignRector

Split multiple inline assigns to each own lines default value, to prevent undefined array issues

- class: [`Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector`](../rules/CodingStyle/Rector/Assign/SplitDoubleAssignRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $one = $two = 1;
+        $one = 1;
+        $two = 1;
     }
 }
```

<br>

### SplitGroupedConstantsAndPropertiesRector

Separate constant and properties to own lines

- class: [`Rector\CodingStyle\Rector\ClassConst\SplitGroupedConstantsAndPropertiesRector`](../rules/CodingStyle/Rector/ClassConst/SplitGroupedConstantsAndPropertiesRector.php)

```diff
 class SomeClass
 {
-    const HI = true, AHOJ = 'true';
+    const HI = true;
+    const AHOJ = 'true';

     /**
      * @var string
      */
-    public $isIt, $isIsThough;
+    public $isIt;
+
+    /**
+     * @var string
+     */
+    public $isIsThough;
 }
```

<br>

### SplitStringClassConstantToClassConstFetchRector

Separate class constant in a string to class constant fetch and string

- class: [`Rector\CodingStyle\Rector\String_\SplitStringClassConstantToClassConstFetchRector`](../rules/CodingStyle/Rector/String_/SplitStringClassConstantToClassConstFetchRector.php)

```diff
 class SomeClass
 {
     const HI = true;
 }

 class AnotherClass
 {
     public function get()
     {
-        return 'SomeClass::HI';
+        return SomeClass::class . '::HI';
     }
 }
```

<br>

### StrictArraySearchRector

Makes array_search search for identical elements

- class: [`Rector\CodingStyle\Rector\FuncCall\StrictArraySearchRector`](../rules/CodingStyle/Rector/FuncCall/StrictArraySearchRector.php)

```diff
-array_search($value, $items);
+array_search($value, $items, true);
```

<br>

### SymplifyQuoteEscapeRector

Prefer quote that are not inside the string

- class: [`Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector`](../rules/CodingStyle/Rector/String_/SymplifyQuoteEscapeRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-         $name = "\" Tom";
-         $name = '\' Sara';
+         $name = '" Tom';
+         $name = "' Sara";
     }
 }
```

<br>

### TernaryConditionVariableAssignmentRector

Assign outcome of ternary condition to variable, where applicable

- class: [`Rector\CodingStyle\Rector\Ternary\TernaryConditionVariableAssignmentRector`](../rules/CodingStyle/Rector/Ternary/TernaryConditionVariableAssignmentRector.php)

```diff
 function ternary($value)
 {
-    $value ? $a = 1 : $a = 0;
+    $a = $value ? 1 : 0;
 }
```

<br>

### UnSpreadOperatorRector

Remove spread operator

- class: [`Rector\CodingStyle\Rector\ClassMethod\UnSpreadOperatorRector`](../rules/CodingStyle/Rector/ClassMethod/UnSpreadOperatorRector.php)

```diff
 class SomeClass
 {
-    public function run(...$array)
+    public function run(array $array)
     {
     }

     public function execute(array $data)
     {
-        $this->run(...$data);
+        $this->run($data);
     }
 }
```

<br>

### UseClassKeywordForClassNameResolutionRector

Use `class` keyword for class name resolution in string instead of hardcoded string reference

- class: [`Rector\CodingStyle\Rector\String_\UseClassKeywordForClassNameResolutionRector`](../rules/CodingStyle/Rector/String_/UseClassKeywordForClassNameResolutionRector.php)

```diff
-$value = 'App\SomeClass::someMethod()';
+$value = \App\SomeClass . '::someMethod()';
```

<br>

### UseIncrementAssignRector

Use ++ increment instead of `$var += 1`

- class: [`Rector\CodingStyle\Rector\Plus\UseIncrementAssignRector`](../rules/CodingStyle/Rector/Plus/UseIncrementAssignRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $style += 1;
+        ++$style;
     }
 }
```

<br>

### UseMessageVariableForSprintfInSymfonyStyleRector

Decouple `$message` property from `sprintf()` calls in `$this->symfonyStyle->method()`

- class: [`Rector\CodingStyle\Rector\MethodCall\UseMessageVariableForSprintfInSymfonyStyleRector`](../rules/CodingStyle/Rector/MethodCall/UseMessageVariableForSprintfInSymfonyStyleRector.php)

```diff
 use Symfony\Component\Console\Style\SymfonyStyle;

 final class SomeClass
 {
     public function run(SymfonyStyle $symfonyStyle)
     {
-        $symfonyStyle->info(sprintf('Hi %s', 'Tom'));
+        $message = sprintf('Hi %s', 'Tom');
+        $symfonyStyle->info($message);
     }
 }
```

<br>

### VarConstantCommentRector

Constant should have a `@var` comment with type

- class: [`Rector\CodingStyle\Rector\ClassConst\VarConstantCommentRector`](../rules/CodingStyle/Rector/ClassConst/VarConstantCommentRector.php)

```diff
 class SomeClass
 {
+    /**
+     * @var string
+     */
     const HI = 'hi';
 }
```

<br>

### VersionCompareFuncCallToConstantRector

Changes use of call to version compare function to use of PHP version constant

- class: [`Rector\CodingStyle\Rector\FuncCall\VersionCompareFuncCallToConstantRector`](../rules/CodingStyle/Rector/FuncCall/VersionCompareFuncCallToConstantRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        version_compare(PHP_VERSION, '5.3.0', '<');
+        PHP_VERSION_ID < 50300;
     }
 }
```

<br>

### WrapEncapsedVariableInCurlyBracesRector

Wrap encapsed variables in curly braces

- class: [`Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector`](../rules/CodingStyle/Rector/Encapsed/WrapEncapsedVariableInCurlyBracesRector.php)

```diff
 function run($world)
 {
-    echo "Hello $world!"
+    echo "Hello {$world}!"
 }
```

<br>

### YieldClassMethodToArrayClassMethodRector

Turns yield return to array return in specific type and method

:wrench: **configure it!**

- class: [`Rector\CodingStyle\Rector\ClassMethod\YieldClassMethodToArrayClassMethodRector`](../rules/CodingStyle/Rector/ClassMethod/YieldClassMethodToArrayClassMethodRector.php)

```php
use Rector\CodingStyle\Rector\ClassMethod\YieldClassMethodToArrayClassMethodRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(YieldClassMethodToArrayClassMethodRector::class)
        ->call('configure', [[
            YieldClassMethodToArrayClassMethodRector::METHODS_BY_TYPE => [
                'EventSubscriberInterface' => ['getSubscribedEvents'],

            ], ]]);
};
```

↓

```diff
 class SomeEventSubscriber implements EventSubscriberInterface
 {
     public static function getSubscribedEvents()
     {
-        yield 'event' => 'callback';
+        return ['event' => 'callback'];
     }
 }
```

<br>

## Composer

### AddPackageToRequireComposerRector

Add package to "require" in `composer.json`

:wrench: **configure it!**

- class: [`Rector\Composer\Rector\AddPackageToRequireComposerRector`](../rules/Composer/Rector/AddPackageToRequireComposerRector.php)

```php
use Rector\Composer\Rector\AddPackageToRequireComposerRector;
use Rector\Composer\ValueObject\PackageAndVersion;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(AddPackageToRequireComposerRector::class)
        ->call('configure', [[
            AddPackageToRequireComposerRector::PACKAGES_AND_VERSIONS => ValueObjectInliner::inline([
                new PackageAndVersion('symfony/console', '^3.4'),
            ]),
        ]]);
};
```

↓

```diff
 {
+    "require": {
+        "symfony/console": "^3.4"
+    }
 }
```

<br>

### AddPackageToRequireDevComposerRector

Add package to "require-dev" in `composer.json`

:wrench: **configure it!**

- class: [`Rector\Composer\Rector\AddPackageToRequireDevComposerRector`](../rules/Composer/Rector/AddPackageToRequireDevComposerRector.php)

```php
use Rector\Composer\Rector\AddPackageToRequireDevComposerRector;
use Rector\Composer\ValueObject\PackageAndVersion;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(AddPackageToRequireDevComposerRector::class)
        ->call('configure', [[
            AddPackageToRequireDevComposerRector::PACKAGES_AND_VERSIONS => ValueObjectInliner::inline([
                new PackageAndVersion('symfony/console', '^3.4'),
            ]),
        ]]);
};
```

↓

```diff
 {
+    "require-dev": {
+        "symfony/console": "^3.4"
+    }
 }
```

<br>

### ChangePackageVersionComposerRector

Change package version `composer.json`

:wrench: **configure it!**

- class: [`Rector\Composer\Rector\ChangePackageVersionComposerRector`](../rules/Composer/Rector/ChangePackageVersionComposerRector.php)

```php
use Rector\Composer\Rector\ChangePackageVersionComposerRector;
use Rector\Composer\ValueObject\PackageAndVersion;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ChangePackageVersionComposerRector::class)
        ->call('configure', [[
            ChangePackageVersionComposerRector::PACKAGES_AND_VERSIONS => ValueObjectInliner::inline([
                new PackageAndVersion('symfony/console', '^4.4'),
            ]),
        ]]);
};
```

↓

```diff
 {
-    "require-dev": {
-        "symfony/console": "^3.4"
+    "require": {
+        "symfony/console": "^4.4"
     }
 }
```

<br>

### RemovePackageComposerRector

Remove package from "require" and "require-dev" in `composer.json`

:wrench: **configure it!**

- class: [`Rector\Composer\Rector\RemovePackageComposerRector`](../rules/Composer/Rector/RemovePackageComposerRector.php)

```php
use Rector\Composer\Rector\RemovePackageComposerRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(RemovePackageComposerRector::class)
        ->call('configure', [[
            RemovePackageComposerRector::PACKAGE_NAMES => ['symfony/console'],
        ]]);
};
```

↓

```diff
 {
-    "require": {
-        "symfony/console": "^3.4"
-    }
 }
```

<br>

### RenamePackageComposerRector

Change package name in `composer.json`

:wrench: **configure it!**

- class: [`Rector\Composer\Rector\RenamePackageComposerRector`](../rules/Composer/Rector/RenamePackageComposerRector.php)

```php
use Rector\Composer\Rector\RenamePackageComposerRector;
use Rector\Composer\ValueObject\RenamePackage;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(RenamePackageComposerRector::class)
        ->call('configure', [[
            RenamePackageComposerRector::RENAME_PACKAGES => ValueObjectInliner::inline([
                new RenamePackage('rector/rector', 'rector/rector-src'),
            ]),
        ]]);
};
```

↓

```diff
 {
     "require": {
-        "rector/rector": "dev-main"
+        "rector/rector-src": "dev-main"
     }
 }
```

<br>

### ReplacePackageAndVersionComposerRector

Change package name and version `composer.json`

:wrench: **configure it!**

- class: [`Rector\Composer\Rector\ReplacePackageAndVersionComposerRector`](../rules/Composer/Rector/ReplacePackageAndVersionComposerRector.php)

```php
use Rector\Composer\Rector\ReplacePackageAndVersionComposerRector;
use Rector\Composer\ValueObject\ReplacePackageAndVersion;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ReplacePackageAndVersionComposerRector::class)
        ->call('configure', [[
            ReplacePackageAndVersionComposerRector::REPLACE_PACKAGES_AND_VERSIONS => ValueObjectInliner::inline([
                new ReplacePackageAndVersion('symfony/console', 'symfony/http-kernel', '^4.4'),
            ]),
        ]]);
};
```

↓

```diff
 {
     "require-dev": {
-        "symfony/console": "^3.4"
+        "symfony/http-kernel": "^4.4"
     }
 }
```

<br>

## DeadCode

### RecastingRemovalRector

Removes recasting of the same type

- class: [`Rector\DeadCode\Rector\Cast\RecastingRemovalRector`](../rules/DeadCode/Rector/Cast/RecastingRemovalRector.php)

```diff
 $string = '';
-$string = (string) $string;
+$string = $string;

 $array = [];
-$array = (array) $array;
+$array = $array;
```

<br>

### RemoveAlwaysTrueIfConditionRector

Remove if condition that is always true

- class: [`Rector\DeadCode\Rector\If_\RemoveAlwaysTrueIfConditionRector`](../rules/DeadCode/Rector/If_/RemoveAlwaysTrueIfConditionRector.php)

```diff
 final class SomeClass
 {
     public function go()
     {
-        if (1 === 1) {
-            return 'yes';
-        }
+        return 'yes';

         return 'no';
     }
 }
```

<br>

### RemoveAndTrueRector

Remove and true that has no added value

- class: [`Rector\DeadCode\Rector\BooleanAnd\RemoveAndTrueRector`](../rules/DeadCode/Rector/BooleanAnd/RemoveAndTrueRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        return true && 5 === 1;
+        return 5 === 1;
     }
 }
```

<br>

### RemoveAnnotationRector

Remove annotation by names

:wrench: **configure it!**

- class: [`Rector\DeadCode\Rector\ClassLike\RemoveAnnotationRector`](../rules/DeadCode/Rector/ClassLike/RemoveAnnotationRector.php)

```php
use Rector\DeadCode\Rector\ClassLike\RemoveAnnotationRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(RemoveAnnotationRector::class)
        ->call('configure', [[
            RemoveAnnotationRector::ANNOTATIONS_TO_REMOVE => ['method'],
        ]]);
};
```

↓

```diff
-/**
- * @method getName()
- */
 final class SomeClass
 {
 }
```

<br>

### RemoveAssignOfVoidReturnFunctionRector

Remove assign of void function/method to variable

- class: [`Rector\DeadCode\Rector\Assign\RemoveAssignOfVoidReturnFunctionRector`](../rules/DeadCode/Rector/Assign/RemoveAssignOfVoidReturnFunctionRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $value = $this->getOne();
+        $this->getOne();
     }

     private function getOne(): void
     {
     }
 }
```

<br>

### RemoveCodeAfterReturnRector

Remove dead code after return statement

- class: [`Rector\DeadCode\Rector\FunctionLike\RemoveCodeAfterReturnRector`](../rules/DeadCode/Rector/FunctionLike/RemoveCodeAfterReturnRector.php)

```diff
 class SomeClass
 {
     public function run(int $a)
     {
          return $a;
-         $a++;
     }
 }
```

<br>

### RemoveConcatAutocastRector

Remove (string) casting when it comes to concat, that does this by default

- class: [`Rector\DeadCode\Rector\Concat\RemoveConcatAutocastRector`](../rules/DeadCode/Rector/Concat/RemoveConcatAutocastRector.php)

```diff
 class SomeConcatingClass
 {
     public function run($value)
     {
-        return 'hi ' . (string) $value;
+        return 'hi ' . $value;
     }
 }
```

<br>

### RemoveDeadConditionAboveReturnRector

Remove dead condition above return

- class: [`Rector\DeadCode\Rector\Return_\RemoveDeadConditionAboveReturnRector`](../rules/DeadCode/Rector/Return_/RemoveDeadConditionAboveReturnRector.php)

```diff
 final class SomeClass
 {
     public function go()
     {
-        if (1 === 1) {
-            return 'yes';
-        }
-
         return 'yes';
     }
 }
```

<br>

### RemoveDeadConstructorRector

Remove empty constructor

- class: [`Rector\DeadCode\Rector\ClassMethod\RemoveDeadConstructorRector`](../rules/DeadCode/Rector/ClassMethod/RemoveDeadConstructorRector.php)

```diff
 class SomeClass
 {
-    public function __construct()
-    {
-    }
 }
```

<br>

### RemoveDeadIfForeachForRector

Remove if, foreach and for that does not do anything

- class: [`Rector\DeadCode\Rector\For_\RemoveDeadIfForeachForRector`](../rules/DeadCode/Rector/For_/RemoveDeadIfForeachForRector.php)

```diff
 class SomeClass
 {
     public function run($someObject)
     {
         $value = 5;
-        if ($value) {
-        }
-
         if ($someObject->run()) {
-        }
-
-        foreach ($values as $value) {
         }

         return $value;
     }
 }
```

<br>

### RemoveDeadInstanceOfRector

Remove dead instanceof check on type hinted variable

- class: [`Rector\DeadCode\Rector\If_\RemoveDeadInstanceOfRector`](../rules/DeadCode/Rector/If_/RemoveDeadInstanceOfRector.php)

```diff
 final class SomeClass
 {
     public function go(stdClass $stdClass)
     {
-        if (! $stdClass instanceof stdClass) {
-            return false;
-        }
-
         return true;
     }
 }
```

<br>

### RemoveDeadLoopRector

Remove loop with no body

- class: [`Rector\DeadCode\Rector\For_\RemoveDeadLoopRector`](../rules/DeadCode/Rector/For_/RemoveDeadLoopRector.php)

```diff
 class SomeClass
 {
     public function run($values)
     {
-        for ($i=1; $i<count($values); ++$i) {
-        }
     }
 }
```

<br>

### RemoveDeadReturnRector

Remove last return in the functions, since does not do anything

- class: [`Rector\DeadCode\Rector\FunctionLike\RemoveDeadReturnRector`](../rules/DeadCode/Rector/FunctionLike/RemoveDeadReturnRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $shallWeDoThis = true;

         if ($shallWeDoThis) {
             return;
         }
-
-        return;
     }
 }
```

<br>

### RemoveDeadStmtRector

Removes dead code statements

- class: [`Rector\DeadCode\Rector\Expression\RemoveDeadStmtRector`](../rules/DeadCode/Rector/Expression/RemoveDeadStmtRector.php)

```diff
-$value = 5;
-$value;
+$value = 5;
```

<br>

### RemoveDeadTryCatchRector

Remove dead try/catch

- class: [`Rector\DeadCode\Rector\TryCatch\RemoveDeadTryCatchRector`](../rules/DeadCode/Rector/TryCatch/RemoveDeadTryCatchRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        try {
-            // some code
-        }
-        catch (Throwable $throwable) {
-            throw $throwable;
-        }
+        // some code
     }
 }
```

<br>

### RemoveDeadZeroAndOneOperationRector

Remove operation with 1 and 0, that have no effect on the value

- class: [`Rector\DeadCode\Rector\Plus\RemoveDeadZeroAndOneOperationRector`](../rules/DeadCode/Rector/Plus/RemoveDeadZeroAndOneOperationRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $value = 5 * 1;
-        $value = 5 + 0;
+        $value = 5;
+        $value = 5;
     }
 }
```

<br>

### RemoveDelegatingParentCallRector

Removed dead parent call, that does not change anything

- class: [`Rector\DeadCode\Rector\ClassMethod\RemoveDelegatingParentCallRector`](../rules/DeadCode/Rector/ClassMethod/RemoveDelegatingParentCallRector.php)

```diff
 class SomeClass
 {
-    public function prettyPrint(array $stmts): string
-    {
-        return parent::prettyPrint($stmts);
-    }
 }
```

<br>

### RemoveDoubleAssignRector

Simplify useless double assigns

- class: [`Rector\DeadCode\Rector\Assign\RemoveDoubleAssignRector`](../rules/DeadCode/Rector/Assign/RemoveDoubleAssignRector.php)

```diff
-$value = 1;
 $value = 1;
```

<br>

### RemoveDuplicatedArrayKeyRector

Remove duplicated key in defined arrays.

- class: [`Rector\DeadCode\Rector\Array_\RemoveDuplicatedArrayKeyRector`](../rules/DeadCode/Rector/Array_/RemoveDuplicatedArrayKeyRector.php)

```diff
 $item = [
-    1 => 'A',
     1 => 'B'
 ];
```

<br>

### RemoveDuplicatedCaseInSwitchRector

2 following switch keys with identical  will be reduced to one result

- class: [`Rector\DeadCode\Rector\Switch_\RemoveDuplicatedCaseInSwitchRector`](../rules/DeadCode/Rector/Switch_/RemoveDuplicatedCaseInSwitchRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         switch ($name) {
              case 'clearHeader':
                  return $this->modifyHeader($node, 'remove');
              case 'clearAllHeaders':
-                 return $this->modifyHeader($node, 'replace');
              case 'clearRawHeaders':
                  return $this->modifyHeader($node, 'replace');
              case '...':
                  return 5;
         }
     }
 }
```

<br>

### RemoveDuplicatedIfReturnRector

Remove duplicated if stmt with return in function/method body

- class: [`Rector\DeadCode\Rector\FunctionLike\RemoveDuplicatedIfReturnRector`](../rules/DeadCode/Rector/FunctionLike/RemoveDuplicatedIfReturnRector.php)

```diff
 class SomeClass
 {
     public function run($value)
     {
         if ($value) {
             return true;
         }

         $value2 = 100;
-
-        if ($value) {
-            return true;
-        }
     }
 }
```

<br>

### RemoveDuplicatedInstanceOfRector

Remove duplicated instanceof in one call

- class: [`Rector\DeadCode\Rector\BinaryOp\RemoveDuplicatedInstanceOfRector`](../rules/DeadCode/Rector/BinaryOp/RemoveDuplicatedInstanceOfRector.php)

```diff
 class SomeClass
 {
-    public function run($value)
+    public function run($value): void
     {
-        $isIt = $value instanceof A || $value instanceof A;
-        $isIt = $value instanceof A && $value instanceof A;
+        $isIt = $value instanceof A;
+        $isIt = $value instanceof A;
     }
 }
```

<br>

### RemoveEmptyClassMethodRector

Remove empty class methods not required by parents

- class: [`Rector\DeadCode\Rector\ClassMethod\RemoveEmptyClassMethodRector`](../rules/DeadCode/Rector/ClassMethod/RemoveEmptyClassMethodRector.php)

```diff
 class OrphanClass
 {
-    public function __construct()
-    {
-    }
 }
```

<br>

### RemoveEmptyMethodCallRector

Remove empty method call

- class: [`Rector\DeadCode\Rector\MethodCall\RemoveEmptyMethodCallRector`](../rules/DeadCode/Rector/MethodCall/RemoveEmptyMethodCallRector.php)

```diff
 class SomeClass
 {
     public function callThis()
     {
     }
 }

-$some = new SomeClass();
-$some->callThis();
+$some = new SomeClass();
```

<br>

### RemoveNonExistingVarAnnotationRector

Removes non-existing `@var` annotations above the code

- class: [`Rector\DeadCode\Rector\Node\RemoveNonExistingVarAnnotationRector`](../rules/DeadCode/Rector/Node/RemoveNonExistingVarAnnotationRector.php)

```diff
 class SomeClass
 {
     public function get()
     {
-        /** @var Training[] $trainings */
         return $this->getData();
     }
 }
```

<br>

### RemoveNullPropertyInitializationRector

Remove initialization with null value from property declarations

- class: [`Rector\DeadCode\Rector\PropertyProperty\RemoveNullPropertyInitializationRector`](../rules/DeadCode/Rector/PropertyProperty/RemoveNullPropertyInitializationRector.php)

```diff
 class SunshineCommand extends ParentClassWithNewConstructor
 {
-    private $myVar = null;
+    private $myVar;
 }
```

<br>

### RemoveOverriddenValuesRector

Remove initial assigns of overridden values

- class: [`Rector\DeadCode\Rector\FunctionLike\RemoveOverriddenValuesRector`](../rules/DeadCode/Rector/FunctionLike/RemoveOverriddenValuesRector.php)

```diff
 final class SomeController
 {
     public function run()
     {
-         $directories = [];
          $possibleDirectories = [];
          $directories = array_filter($possibleDirectories, 'file_exists');
     }
 }
```

<br>

### RemoveParentCallWithoutParentRector

Remove unused parent call with no parent class

- class: [`Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector`](../rules/DeadCode/Rector/StaticCall/RemoveParentCallWithoutParentRector.php)

```diff
 class OrphanClass
 {
     public function __construct()
     {
-         parent::__construct();
     }
 }
```

<br>

### RemovePhpVersionIdCheckRector

Remove unneded PHP_VERSION_ID check

:wrench: **configure it!**

- class: [`Rector\DeadCode\Rector\ConstFetch\RemovePhpVersionIdCheckRector`](../rules/DeadCode/Rector/ConstFetch/RemovePhpVersionIdCheckRector.php)

```php
use Rector\DeadCode\Rector\ConstFetch\RemovePhpVersionIdCheckRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(RemovePhpVersionIdCheckRector::class)
        ->call('configure', [[
            RemovePhpVersionIdCheckRector::PHP_VERSION_CONSTRAINT => 80000,
        ]]);
};
```

↓

```diff
 class SomeClass
 {
     public function run()
     {
-        if (PHP_VERSION_ID < 80000) {
-            return;
-        }
         echo 'do something';
     }
 }
```

<br>

### RemoveUnreachableStatementRector

Remove unreachable statements

- class: [`Rector\DeadCode\Rector\Stmt\RemoveUnreachableStatementRector`](../rules/DeadCode/Rector/Stmt/RemoveUnreachableStatementRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         return 5;
-
-        $removeMe = 10;
     }
 }
```

<br>

### RemoveUnusedAssignVariableRector

Remove assigned unused variable

- class: [`Rector\DeadCode\Rector\Assign\RemoveUnusedAssignVariableRector`](../rules/DeadCode/Rector/Assign/RemoveUnusedAssignVariableRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $value = $this->process();
+        $this->process();
     }

     public function process()
     {
         // something going on
         return 5;
     }
 }
```

<br>

### RemoveUnusedConstructorParamRector

Remove unused parameter in constructor

- class: [`Rector\DeadCode\Rector\ClassMethod\RemoveUnusedConstructorParamRector`](../rules/DeadCode/Rector/ClassMethod/RemoveUnusedConstructorParamRector.php)

```diff
 final class SomeClass
 {
     private $hey;

-    public function __construct($hey, $man)
+    public function __construct($hey)
     {
         $this->hey = $hey;
     }
 }
```

<br>

### RemoveUnusedForeachKeyRector

Remove unused key in foreach

- class: [`Rector\DeadCode\Rector\Foreach_\RemoveUnusedForeachKeyRector`](../rules/DeadCode/Rector/Foreach_/RemoveUnusedForeachKeyRector.php)

```diff
 $items = [];
-foreach ($items as $key => $value) {
+foreach ($items as $value) {
     $result = $value;
 }
```

<br>

### RemoveUnusedNonEmptyArrayBeforeForeachRector

Remove unused if check to non-empty array before foreach of the array

- class: [`Rector\DeadCode\Rector\If_\RemoveUnusedNonEmptyArrayBeforeForeachRector`](../rules/DeadCode/Rector/If_/RemoveUnusedNonEmptyArrayBeforeForeachRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $values = [];
-        if ($values !== []) {
-            foreach ($values as $value) {
-                echo $value;
-            }
+        foreach ($values as $value) {
+            echo $value;
         }
     }
 }
```

<br>

### RemoveUnusedPrivateClassConstantRector

Remove unused class constants

- class: [`Rector\DeadCode\Rector\ClassConst\RemoveUnusedPrivateClassConstantRector`](../rules/DeadCode/Rector/ClassConst/RemoveUnusedPrivateClassConstantRector.php)

```diff
 class SomeClass
 {
-    private const SOME_CONST = 'dead';
-
     public function run()
     {
     }
 }
```

<br>

### RemoveUnusedPrivateMethodParameterRector

Remove unused parameter, if not required by interface or parent class

- class: [`Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodParameterRector`](../rules/DeadCode/Rector/ClassMethod/RemoveUnusedPrivateMethodParameterRector.php)

```diff
 class SomeClass
 {
-    private function run($value, $value2)
+    private function run($value)
     {
          $this->value = $value;
     }
 }
```

<br>

### RemoveUnusedPrivateMethodRector

Remove unused private method

- class: [`Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodRector`](../rules/DeadCode/Rector/ClassMethod/RemoveUnusedPrivateMethodRector.php)

```diff
 final class SomeController
 {
     public function run()
     {
         return 5;
     }
-
-    private function skip()
-    {
-        return 10;
-    }
 }
```

<br>

### RemoveUnusedPrivatePropertyRector

Remove unused private properties

- class: [`Rector\DeadCode\Rector\Property\RemoveUnusedPrivatePropertyRector`](../rules/DeadCode/Rector/Property/RemoveUnusedPrivatePropertyRector.php)

```diff
 class SomeClass
 {
-    private $property;
 }
```

<br>

### RemoveUnusedPromotedPropertyRector

Remove unused promoted property

- class: [`Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPromotedPropertyRector`](../rules/DeadCode/Rector/ClassMethod/RemoveUnusedPromotedPropertyRector.php)

```diff
 class SomeClass
 {
     public function __construct(
-        private $someUnusedDependency,
         private $usedDependency
     ) {
     }

     public function getUsedDependency()
     {
         return $this->usedDependency;
     }
 }
```

<br>

### RemoveUnusedVariableAssignRector

Remove unused assigns to variables

- class: [`Rector\DeadCode\Rector\Assign\RemoveUnusedVariableAssignRector`](../rules/DeadCode/Rector/Assign/RemoveUnusedVariableAssignRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $value = 5;
     }
 }
```

<br>

### RemoveUselessParamTagRector

Remove `@param` docblock with same type as parameter type

- class: [`Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector`](../rules/DeadCode/Rector/ClassMethod/RemoveUselessParamTagRector.php)

```diff
 class SomeClass
 {
     /**
-     * @param string $a
      * @param string $b description
      */
     public function foo(string $a, string $b)
     {
     }
 }
```

<br>

### RemoveUselessReturnTagRector

Remove `@return` docblock with same type as defined in PHP

- class: [`Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector`](../rules/DeadCode/Rector/ClassMethod/RemoveUselessReturnTagRector.php)

```diff
 use stdClass;

 class SomeClass
 {
-    /**
-     * @return stdClass
-     */
     public function foo(): stdClass
     {
     }
 }
```

<br>

### RemoveUselessVarTagRector

Remove unused `@var` annotation for properties

- class: [`Rector\DeadCode\Rector\Property\RemoveUselessVarTagRector`](../rules/DeadCode/Rector/Property/RemoveUselessVarTagRector.php)

```diff
 final class SomeClass
 {
-    /**
-     * @var string
-     */
     public string $name = 'name';
 }
```

<br>

### SimplifyIfElseWithSameContentRector

Remove if/else if they have same content

- class: [`Rector\DeadCode\Rector\If_\SimplifyIfElseWithSameContentRector`](../rules/DeadCode/Rector/If_/SimplifyIfElseWithSameContentRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        if (true) {
-            return 1;
-        } else {
-            return 1;
-        }
+        return 1;
     }
 }
```

<br>

### SimplifyMirrorAssignRector

Removes unneeded $a = $a assigns

- class: [`Rector\DeadCode\Rector\Expression\SimplifyMirrorAssignRector`](../rules/DeadCode/Rector/Expression/SimplifyMirrorAssignRector.php)

```diff
-$a = $a;
```

<br>

### TernaryToBooleanOrFalseToBooleanAndRector

Change ternary of bool : false to && bool

- class: [`Rector\DeadCode\Rector\Ternary\TernaryToBooleanOrFalseToBooleanAndRector`](../rules/DeadCode/Rector/Ternary/TernaryToBooleanOrFalseToBooleanAndRector.php)

```diff
 class SomeClass
 {
     public function go()
     {
-        return $value ? $this->getBool() : false;
+        return $value && $this->getBool();
     }

     private function getBool(): bool
     {
         return (bool) 5;
     }
 }
```

<br>

### UnwrapFutureCompatibleIfFunctionExistsRector

Remove functions exists if with else for always existing

- class: [`Rector\DeadCode\Rector\If_\UnwrapFutureCompatibleIfFunctionExistsRector`](../rules/DeadCode/Rector/If_/UnwrapFutureCompatibleIfFunctionExistsRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         // session locking trough other addons
-        if (function_exists('session_abort')) {
-            session_abort();
-        } else {
-            session_write_close();
-        }
+        session_abort();
     }
 }
```

<br>

### UnwrapFutureCompatibleIfPhpVersionRector

Remove php version checks if they are passed

- class: [`Rector\DeadCode\Rector\If_\UnwrapFutureCompatibleIfPhpVersionRector`](../rules/DeadCode/Rector/If_/UnwrapFutureCompatibleIfPhpVersionRector.php)

```diff
 // current PHP: 7.2
-if (version_compare(PHP_VERSION, '7.2', '<')) {
-    return 'is PHP 7.1-';
-} else {
-    return 'is PHP 7.2+';
-}
+return 'is PHP 7.2+';
```

<br>

## Defluent

### DefluentReturnMethodCallRector

Turns return of fluent, to standalone call line and return of value

- class: [`Rector\Defluent\Rector\Return_\DefluentReturnMethodCallRector`](../rules/Defluent/Rector/Return_/DefluentReturnMethodCallRector.php)

```diff
 $someClass = new SomeClass();
-return $someClass->someFunction();
+$someClass->someFunction();
+return $someClass;
```

<br>

### FluentChainMethodCallToNormalMethodCallRector

Turns fluent interface calls to classic ones.

- class: [`Rector\Defluent\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector`](../rules/Defluent/Rector/MethodCall/FluentChainMethodCallToNormalMethodCallRector.php)

```diff
 $someClass = new SomeClass();
-$someClass->someFunction()
-            ->otherFunction();
+$someClass->someFunction();
+$someClass->otherFunction();
```

<br>

### InArgFluentChainMethodCallToStandaloneMethodCallRector

Turns fluent interface calls to classic ones.

- class: [`Rector\Defluent\Rector\MethodCall\InArgFluentChainMethodCallToStandaloneMethodCallRector`](../rules/Defluent/Rector/MethodCall/InArgFluentChainMethodCallToStandaloneMethodCallRector.php)

```diff
 class UsedAsParameter
 {
     public function someFunction(FluentClass $someClass)
     {
-        $this->processFluentClass($someClass->someFunction()->otherFunction());
+        $someClass->someFunction();
+        $someClass->otherFunction();
+        $this->processFluentClass($someClass);
     }

     public function processFluentClass(FluentClass $someClass)
     {
     }
 }
```

<br>

### MethodCallOnSetterMethodCallToStandaloneAssignRector

Change method call on setter to standalone assign before the setter

- class: [`Rector\Defluent\Rector\MethodCall\MethodCallOnSetterMethodCallToStandaloneAssignRector`](../rules/Defluent/Rector/MethodCall/MethodCallOnSetterMethodCallToStandaloneAssignRector.php)

```diff
 class SomeClass
 {
     public function some()
     {
-        $this->anotherMethod(new AnotherClass())
-            ->someFunction();
+        $anotherClass = new AnotherClass();
+        $anotherClass->someFunction();
+        $this->anotherMethod($anotherClass);
     }

     public function anotherMethod(AnotherClass $anotherClass)
     {
     }
 }
```

<br>

### NewFluentChainMethodCallToNonFluentRector

Turns fluent interface calls to classic ones.

- class: [`Rector\Defluent\Rector\MethodCall\NewFluentChainMethodCallToNonFluentRector`](../rules/Defluent/Rector/MethodCall/NewFluentChainMethodCallToNonFluentRector.php)

```diff
-(new SomeClass())->someFunction()
-            ->otherFunction();
+$someClass = new SomeClass();
+$someClass->someFunction();
+$someClass->otherFunction();
```

<br>

### NormalToFluentRector

Turns fluent interface calls to classic ones.

:wrench: **configure it!**

- class: [`Rector\Defluent\Rector\ClassMethod\NormalToFluentRector`](../rules/Defluent/Rector/ClassMethod/NormalToFluentRector.php)

```php
use Rector\Defluent\Rector\ClassMethod\NormalToFluentRector;
use Rector\Defluent\ValueObject\NormalToFluent;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(NormalToFluentRector::class)
        ->call('configure', [[
            NormalToFluentRector::CALLS_TO_FLUENT => ValueObjectInliner::inline([
                new NormalToFluent('SomeClass', ['someFunction', 'otherFunction']), ]
            ),
        ]]);
};
```

↓

```diff
 $someObject = new SomeClass();
-$someObject->someFunction();
-$someObject->otherFunction();
+$someObject->someFunction()
+    ->otherFunction();
```

<br>

### ReturnFluentChainMethodCallToNormalMethodCallRector

Turns fluent interface calls to classic ones.

- class: [`Rector\Defluent\Rector\Return_\ReturnFluentChainMethodCallToNormalMethodCallRector`](../rules/Defluent/Rector/Return_/ReturnFluentChainMethodCallToNormalMethodCallRector.php)

```diff
 $someClass = new SomeClass();
+$someClass->someFunction();
+$someClass->otherFunction();

-return $someClass->someFunction()
-        ->otherFunction();
+return $someClass;
```

<br>

### ReturnNewFluentChainMethodCallToNonFluentRector

Turns fluent interface calls to classic ones.

- class: [`Rector\Defluent\Rector\Return_\ReturnNewFluentChainMethodCallToNonFluentRector`](../rules/Defluent/Rector/Return_/ReturnNewFluentChainMethodCallToNonFluentRector.php)

```diff
-return (new SomeClass())->someFunction()
-            ->otherFunction();
+$someClass = new SomeClass();
+$someClass->someFunction();
+$someClass->otherFunction();
+return $someClass;
```

<br>

### ReturnThisRemoveRector

Removes "return `$this;"` from *fluent interfaces* for specified classes.

- class: [`Rector\Defluent\Rector\ClassMethod\ReturnThisRemoveRector`](../rules/Defluent/Rector/ClassMethod/ReturnThisRemoveRector.php)

```diff
 class SomeExampleClass
 {
     public function someFunction()
     {
-        return $this;
     }

     public function otherFunction()
     {
-        return $this;
     }
 }
```

<br>

## DependencyInjection

### ActionInjectionToConstructorInjectionRector

Turns action injection in Controllers to constructor injection

- class: [`Rector\DependencyInjection\Rector\Class_\ActionInjectionToConstructorInjectionRector`](../rules/DependencyInjection/Rector/Class_/ActionInjectionToConstructorInjectionRector.php)

```diff
 final class SomeController
 {
-    public function default(ProductRepository $productRepository)
+    /**
+     * @var ProductRepository
+     */
+    private $productRepository;
+    public function __construct(ProductRepository $productRepository)
     {
-        $products = $productRepository->fetchAll();
+        $this->productRepository = $productRepository;
+    }
+
+    public function default()
+    {
+        $products = $this->productRepository->fetchAll();
     }
 }
```

<br>

### AddMethodParentCallRector

Add method parent call, in case new parent method is added

:wrench: **configure it!**

- class: [`Rector\DependencyInjection\Rector\ClassMethod\AddMethodParentCallRector`](../rules/DependencyInjection/Rector/ClassMethod/AddMethodParentCallRector.php)

```php
use Rector\DependencyInjection\Rector\ClassMethod\AddMethodParentCallRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(AddMethodParentCallRector::class)
        ->call('configure', [[
            AddMethodParentCallRector::METHODS_BY_PARENT_TYPES => [
                'ParentClassWithNewConstructor' => '__construct',

            ], ]]);
};
```

↓

```diff
 class SunshineCommand extends ParentClassWithNewConstructor
 {
     public function __construct()
     {
         $value = 5;
+
+        parent::__construct();
     }
 }
```

<br>

### MultiParentingToAbstractDependencyRector

Move dependency passed to all children to parent as `@inject/@required` dependency

:wrench: **configure it!**

- class: [`Rector\DependencyInjection\Rector\Class_\MultiParentingToAbstractDependencyRector`](../rules/DependencyInjection/Rector/Class_/MultiParentingToAbstractDependencyRector.php)

```php
use Rector\DependencyInjection\Rector\Class_\MultiParentingToAbstractDependencyRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(MultiParentingToAbstractDependencyRector::class)
        ->call('configure', [[
            MultiParentingToAbstractDependencyRector::FRAMEWORK => 'nette',
        ]]);
};
```

↓

```diff
 abstract class AbstractParentClass
 {
-    private $someDependency;
-
-    public function __construct(SomeDependency $someDependency)
-    {
-        $this->someDependency = $someDependency;
-    }
+    /**
+     * @inject
+     * @var SomeDependency
+     */
+    public $someDependency;
 }

 class FirstChild extends AbstractParentClass
 {
-    public function __construct(SomeDependency $someDependency)
-    {
-        parent::__construct($someDependency);
-    }
 }

 class SecondChild extends AbstractParentClass
 {
-    public function __construct(SomeDependency $someDependency)
-    {
-        parent::__construct($someDependency);
-    }
 }
```

<br>

### ReplaceVariableByPropertyFetchRector

Turns variable in controller action to property fetch, as follow up to action injection variable to property change.

- class: [`Rector\DependencyInjection\Rector\Variable\ReplaceVariableByPropertyFetchRector`](../rules/DependencyInjection/Rector/Variable/ReplaceVariableByPropertyFetchRector.php)

```diff
 final class SomeController
 {
     /**
      * @var ProductRepository
      */
     private $productRepository;

     public function __construct(ProductRepository $productRepository)
     {
         $this->productRepository = $productRepository;
     }

     public function default()
     {
-        $products = $productRepository->fetchAll();
+        $products = $this->productRepository->fetchAll();
     }
 }
```

<br>

## DowngradePhp53

### DirConstToFileConstRector

Refactor __DIR__ to dirname(__FILE__)

- class: [`Rector\DowngradePhp53\Rector\Dir\DirConstToFileConstRector`](../rules/DowngradePhp53/Rector/Dir/DirConstToFileConstRector.php)

```diff
 final class SomeClass
 {
     public function run()
     {
-        return __DIR__;
+        return dirname(__FILE__);
     }
 }
```

<br>

## DowngradePhp70

### DowngradeAnonymousClassRector

Remove anonymous class

- class: [`Rector\DowngradePhp70\Rector\New_\DowngradeAnonymousClassRector`](../rules/DowngradePhp70/Rector/New_/DowngradeAnonymousClassRector.php)

```diff
+class Anonymous
+{
+    public function execute()
+    {
+    }
+}
 class SomeClass
 {
     public function run()
     {
-        return new class {
-            public function execute()
-            {
-            }
-        };
+        return new Anonymous();
     }
 }
```

<br>

### DowngradeDefineArrayConstantRector

Change array contant definition via define to const

- class: [`Rector\DowngradePhp70\Rector\Expression\DowngradeDefineArrayConstantRector`](../rules/DowngradePhp70/Rector/Expression/DowngradeDefineArrayConstantRector.php)

```diff
-define('ANIMALS', [
+const ANIMALS = [
     'dog',
     'cat',
     'bird'
-]);
+];
```

<br>

### DowngradeGeneratedScalarTypesRector

Refactor scalar types in PHP code in string snippets, e.g. generated container code from symfony/dependency-injection

- class: [`Rector\DowngradePhp70\Rector\String_\DowngradeGeneratedScalarTypesRector`](../rules/DowngradePhp70/Rector/String_/DowngradeGeneratedScalarTypesRector.php)

```diff
 $code = <<<'EOF'
-    public function getParameter(string $name)
+    /**
+     * @param string
+     */
+    public function getParameter($name)
     {
         return $name;
     }
 EOF;
```

<br>

### DowngradeNullCoalesceRector

Change null coalesce to isset ternary check

- class: [`Rector\DowngradePhp70\Rector\Coalesce\DowngradeNullCoalesceRector`](../rules/DowngradePhp70/Rector/Coalesce/DowngradeNullCoalesceRector.php)

```diff
-$username = $_GET['user'] ?? 'nobody';
+$username = isset($_GET['user']) ? $_GET['user'] : 'nobody';
```

<br>

### DowngradeScalarTypeDeclarationRector

Remove the type params and return type, add `@param` and `@return` tags instead

- class: [`Rector\DowngradePhp70\Rector\FunctionLike\DowngradeScalarTypeDeclarationRector`](../rules/DowngradePhp70/Rector/FunctionLike/DowngradeScalarTypeDeclarationRector.php)

```diff
 class SomeClass
 {
-    public function run(string $input): string
+    /**
+     * @param string $input
+     * @return string
+     */
+    public function run($input)
     {
     }
 }
```

<br>

### DowngradeSessionStartArrayOptionsRector

Move array option of session_start($options) to before statement's `ini_set()`

- class: [`Rector\DowngradePhp70\Rector\FuncCall\DowngradeSessionStartArrayOptionsRector`](../rules/DowngradePhp70/Rector/FuncCall/DowngradeSessionStartArrayOptionsRector.php)

```diff
-session_start([
-    'cache_limiter' => 'private',
-]);
+ini_set('session.cache_limiter', 'private');
+session_start();
```

<br>

### DowngradeSpaceshipRector

Change spaceship with check equal, and ternary to result 0, -1, 1

- class: [`Rector\DowngradePhp70\Rector\Spaceship\DowngradeSpaceshipRector`](../rules/DowngradePhp70/Rector/Spaceship/DowngradeSpaceshipRector.php)

```diff
-return $a <=> $b;
+$battleShipcompare = function ($left, $right) {
+    if ($left === $right) {
+        return 0;
+    }
+    return $left < $right ? -1 : 1;
+};
+return $battleShipcompare($a, $b);
```

<br>

### DowngradeStrictTypeDeclarationRector

Remove the declare(strict_types=1)

- class: [`Rector\DowngradePhp70\Rector\Declare_\DowngradeStrictTypeDeclarationRector`](../rules/DowngradePhp70/Rector/Declare_/DowngradeStrictTypeDeclarationRector.php)

```diff
-declare(strict_types=1);
```

<br>

### SplitGroupedUseImportsRector

Refactor grouped use imports to standalone lines

- class: [`Rector\DowngradePhp70\Rector\GroupUse\SplitGroupedUseImportsRector`](../rules/DowngradePhp70/Rector/GroupUse/SplitGroupedUseImportsRector.php)

```diff
-use SomeNamespace\{
-    First,
-    Second
-};
+use SomeNamespace\First;
+use SomeNamespace\Second;
```

<br>

## DowngradePhp71

### DowngradeClassConstantVisibilityRector

Downgrade class constant visibility

- class: [`Rector\DowngradePhp71\Rector\ClassConst\DowngradeClassConstantVisibilityRector`](../rules/DowngradePhp71/Rector/ClassConst/DowngradeClassConstantVisibilityRector.php)

```diff
 class SomeClass
 {
-   public const PUBLIC_CONST_B = 2;
-   protected const PROTECTED_CONST = 3;
-   private const PRIVATE_CONST = 4;
+   const PUBLIC_CONST_B = 2;
+   const PROTECTED_CONST = 3;
+   const PRIVATE_CONST = 4;
 }
```

<br>

### DowngradeIsIterableRector

Change is_iterable with array and Traversable object type check

- class: [`Rector\DowngradePhp71\Rector\FuncCall\DowngradeIsIterableRector`](../rules/DowngradePhp71/Rector/FuncCall/DowngradeIsIterableRector.php)

```diff
 class SomeClass
 {
     public function run($obj)
     {
-        is_iterable($obj);
+        is_array($obj) || $obj instanceof \Traversable;
     }
 }
```

<br>

### DowngradeIterablePseudoTypeDeclarationRector

Remove the iterable pseudo type params and returns, add `@param` and `@return` tags instead

- class: [`Rector\DowngradePhp71\Rector\FunctionLike\DowngradeIterablePseudoTypeDeclarationRector`](../rules/DowngradePhp71/Rector/FunctionLike/DowngradeIterablePseudoTypeDeclarationRector.php)

```diff
 class SomeClass
 {
-    public function run(iterable $iterator): iterable
+    /**
+     * @param mixed[]|\Traversable $iterator
+     * @return mixed[]|\Traversable
+     */
+    public function run($iterator)
     {
         // do something
     }
 }
```

<br>

### DowngradeKeysInListRector

Extract keys in list to its own variable assignment

- class: [`Rector\DowngradePhp71\Rector\List_\DowngradeKeysInListRector`](../rules/DowngradePhp71/Rector/List_/DowngradeKeysInListRector.php)

```diff
 class SomeClass
 {
     public function run(): void
     {
         $data = [
             ["id" => 1, "name" => 'Tom'],
             ["id" => 2, "name" => 'Fred'],
         ];
-        list("id" => $id1, "name" => $name1) = $data[0];
+        $id1 = $data[0]["id"];
+        $name1 = $data[0]["name"];
     }
 }
```

<br>

### DowngradeNegativeStringOffsetToStrlenRector

Downgrade negative string offset to strlen

- class: [`Rector\DowngradePhp71\Rector\String_\DowngradeNegativeStringOffsetToStrlenRector`](../rules/DowngradePhp71/Rector/String_/DowngradeNegativeStringOffsetToStrlenRector.php)

```diff
-echo 'abcdef'[-2];
-echo strpos('aabbcc', 'b', -3);
-echo strpos($var, 'b', -3);
+echo 'abcdef'[strlen('abcdef') - 2];
+echo strpos('aabbcc', 'b', strlen('aabbcc') - 3);
+echo strpos($var, 'b', strlen($var) - 3);
```

<br>

### DowngradeNullableTypeDeclarationRector

Remove the nullable type params, add `@param` tags instead

- class: [`Rector\DowngradePhp71\Rector\FunctionLike\DowngradeNullableTypeDeclarationRector`](../rules/DowngradePhp71/Rector/FunctionLike/DowngradeNullableTypeDeclarationRector.php)

```diff
 class SomeClass
 {
-    public function run(?string $input): ?string
+    /**
+     * @param string|null $input
+     * @return string|null $input
+     */
+    public function run($input)
     {
     }
 }
```

<br>

### DowngradePipeToMultiCatchExceptionRector

Downgrade single one | separated to multi catch exception

- class: [`Rector\DowngradePhp71\Rector\TryCatch\DowngradePipeToMultiCatchExceptionRector`](../rules/DowngradePhp71/Rector/TryCatch/DowngradePipeToMultiCatchExceptionRector.php)

```diff
 try {
     // Some code...
- } catch (ExceptionType1 | ExceptionType2 $exception) {
+} catch (ExceptionType1 $exception) {
     $sameCode;
- }
+} catch (ExceptionType2 $exception) {
+    $sameCode;
+}
```

<br>

### DowngradeVoidTypeDeclarationRector

Remove "void" return type, add a `"@return` void" tag instead

- class: [`Rector\DowngradePhp71\Rector\FunctionLike\DowngradeVoidTypeDeclarationRector`](../rules/DowngradePhp71/Rector/FunctionLike/DowngradeVoidTypeDeclarationRector.php)

```diff
 class SomeClass
 {
-    public function run(): void
+    /**
+     * @return void
+     */
+    public function run()
     {
     }
 }
```

<br>

### SymmetricArrayDestructuringToListRector

Downgrade Symmetric array destructuring to `list()` function

- class: [`Rector\DowngradePhp71\Rector\Array_\SymmetricArrayDestructuringToListRector`](../rules/DowngradePhp71/Rector/Array_/SymmetricArrayDestructuringToListRector.php)

```diff
-[$id1, $name1] = $data;
+list($id1, $name1) = $data;
```

<br>

## DowngradePhp72

### DowngradeObjectTypeDeclarationRector

Remove the "object" param and return type, add a `@param` and `@return` tags instead

- class: [`Rector\DowngradePhp72\Rector\FunctionLike\DowngradeObjectTypeDeclarationRector`](../rules/DowngradePhp72/Rector/FunctionLike/DowngradeObjectTypeDeclarationRector.php)

```diff
 class SomeClass
 {
-    public function someFunction(object $someObject): object
+    /**
+     * @param object $someObject
+     * @return object
+     */
+    public function someFunction($someObject)
     {
     }
 }
```

<br>

### DowngradeParameterTypeWideningRector

Change param type to match the lowest type in whole family tree

- class: [`Rector\DowngradePhp72\Rector\Class_\DowngradeParameterTypeWideningRector`](../rules/DowngradePhp72/Rector/Class_/DowngradeParameterTypeWideningRector.php)

```diff
 interface SomeInterface
 {
-    public function test(array $input);
+    /**
+     * @param mixed[] $input
+     */
+    public function test($input);
 }

 final class SomeClass implements SomeInterface
 {
     public function test($input)
     {
     }
 }
```

<br>

### DowngradePregUnmatchedAsNullConstantRector

Remove PREG_UNMATCHED_AS_NULL from preg_match and set null value on empty string matched on each match

- class: [`Rector\DowngradePhp72\Rector\FuncCall\DowngradePregUnmatchedAsNullConstantRector`](../rules/DowngradePhp72/Rector/FuncCall/DowngradePregUnmatchedAsNullConstantRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        preg_match('/(a)(b)*(c)/', 'ac', $matches, PREG_UNMATCHED_AS_NULL);
+        preg_match('/(a)(b)*(c)/', 'ac', $matches);
+        array_walk_recursive($matches, function (&$value) {
+            if ($value === '') {
+                $value = null;
+            }
+        });
     }
 }
```

<br>

### DowngradeStreamIsattyRector

Downgrade `stream_isatty()` function

- class: [`Rector\DowngradePhp72\Rector\FuncCall\DowngradeStreamIsattyRector`](../rules/DowngradePhp72/Rector/FuncCall/DowngradeStreamIsattyRector.php)

```diff
 class SomeClass
 {
     public function run($stream)
     {
-        $isStream = stream_isatty($stream);
+        $streamIsatty = function ($stream) {
+            if (\function_exists('stream_isatty')) {
+                return stream_isatty($stream);
+            }
+
+            if (!\is_resource($stream)) {
+                trigger_error('stream_isatty() expects parameter 1 to be resource, '.\gettype($stream).' given', \E_USER_WARNING);
+
+                return false;
+            }
+
+            if ('\\' === \DIRECTORY_SEPARATOR) {
+                $stat = @fstat($stream);
+                // Check if formatted mode is S_IFCHR
+                return $stat ? 0020000 === ($stat['mode'] & 0170000) : false;
+            }
+
+            return \function_exists('posix_isatty') && @posix_isatty($stream);
+        };
+        $isStream = $streamIsatty($stream);
     }
 }
```

<br>

## DowngradePhp73

### DowngradeArrayKeyFirstLastRector

Downgrade `array_key_first()` and `array_key_last()` functions

- class: [`Rector\DowngradePhp73\Rector\FuncCall\DowngradeArrayKeyFirstLastRector`](../rules/DowngradePhp73/Rector/FuncCall/DowngradeArrayKeyFirstLastRector.php)

```diff
 class SomeClass
 {
     public function run($items)
     {
-        $firstItemKey = array_key_first($items);
+        reset($items);
+        $firstItemKey = key($items);
     }
 }
```

<br>

### DowngradeFlexibleHeredocSyntaxRector

Remove indentation from heredoc/nowdoc

- class: [`Rector\DowngradePhp73\Rector\String_\DowngradeFlexibleHeredocSyntaxRector`](../rules/DowngradePhp73/Rector/String_/DowngradeFlexibleHeredocSyntaxRector.php)

```diff
 $query = <<<SQL
-    SELECT *
-    FROM `table`
-    WHERE `column` = true;
-    SQL;
+SELECT *
+FROM `table`
+WHERE `column` = true;
+SQL;
```

<br>

### DowngradeIsCountableRector

Downgrade `is_countable()` to former version

- class: [`Rector\DowngradePhp73\Rector\FuncCall\DowngradeIsCountableRector`](../rules/DowngradePhp73/Rector/FuncCall/DowngradeIsCountableRector.php)

```diff
 $items = [];
-return is_countable($items);
+return is_array($items) || $items instanceof Countable;
```

<br>

### DowngradeListReferenceAssignmentRector

Convert the list reference assignment to its equivalent PHP 7.2 code

- class: [`Rector\DowngradePhp73\Rector\List_\DowngradeListReferenceAssignmentRector`](../rules/DowngradePhp73/Rector/List_/DowngradeListReferenceAssignmentRector.php)

```diff
 class SomeClass
 {
     public function run($string)
     {
-        $array = [1, 2, 3];
-        list($a, &$b) = $array;
+        $array = [1, 2];
+        list($a) = $array;
+        $b =& $array[1];

-        [&$c, $d, &$e] = $array;
+        [$c, $d, $e] = $array;
+        $c =& $array[0];
+        $e =& $array[2];

-        list(&$a, &$b) = $array;
+        $a =& $array[0];
+        $b =& $array[1];
     }
 }
```

<br>

### DowngradeTrailingCommasInFunctionCallsRector

Remove trailing commas in function calls

- class: [`Rector\DowngradePhp73\Rector\FuncCall\DowngradeTrailingCommasInFunctionCallsRector`](../rules/DowngradePhp73/Rector/FuncCall/DowngradeTrailingCommasInFunctionCallsRector.php)

```diff
 class SomeClass
 {
     public function __construct(string $value)
     {
         $compacted = compact(
             'posts',
-            'units',
+            'units'
         );
     }
 }
```

<br>

### SetCookieOptionsArrayToArgumentsRector

Convert setcookie option array to arguments

- class: [`Rector\DowngradePhp73\Rector\FuncCall\SetCookieOptionsArrayToArgumentsRector`](../rules/DowngradePhp73/Rector/FuncCall/SetCookieOptionsArrayToArgumentsRector.php)

```diff
-setcookie('name', $value, ['expires' => 360]);
+setcookie('name', $value, 360);
```

<br>

## DowngradePhp74

### ArrowFunctionToAnonymousFunctionRector

Replace arrow functions with anonymous functions

- class: [`Rector\DowngradePhp74\Rector\ArrowFunction\ArrowFunctionToAnonymousFunctionRector`](../rules/DowngradePhp74/Rector/ArrowFunction/ArrowFunctionToAnonymousFunctionRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $delimiter = ",";
-        $callable = fn($matches) => $delimiter . strtolower($matches[1]);
+        $callable = function ($matches) use ($delimiter) {
+            return $delimiter . strtolower($matches[1]);
+        };
     }
 }
```

<br>

### DowngradeArrayMergeCallWithoutArgumentsRector

Add missing param to `array_merge` and `array_merge_recursive`

- class: [`Rector\DowngradePhp74\Rector\FuncCall\DowngradeArrayMergeCallWithoutArgumentsRector`](../rules/DowngradePhp74/Rector/FuncCall/DowngradeArrayMergeCallWithoutArgumentsRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        array_merge();
-        array_merge_recursive();
+        array_merge([]);
+        array_merge_recursive([]);
     }
 }
```

<br>

### DowngradeArraySpreadRector

Replace array spread with array_merge function

- class: [`Rector\DowngradePhp74\Rector\Array_\DowngradeArraySpreadRector`](../rules/DowngradePhp74/Rector/Array_/DowngradeArraySpreadRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $parts = ['apple', 'pear'];
-        $fruits = ['banana', 'orange', ...$parts, 'watermelon'];
+        $fruits = array_merge(['banana', 'orange'], $parts, ['watermelon']);
     }

     public function runWithIterable()
     {
-        $fruits = ['banana', 'orange', ...new ArrayIterator(['durian', 'kiwi']), 'watermelon'];
+        $item0Unpacked = new ArrayIterator(['durian', 'kiwi']);
+        $fruits = array_merge(['banana', 'orange'], is_array($item0Unpacked) ? $item0Unpacked : iterator_to_array($item0Unpacked), ['watermelon']);
     }
 }
```

<br>

### DowngradeContravariantArgumentTypeRector

Remove contravariant argument type declarations

- class: [`Rector\DowngradePhp74\Rector\ClassMethod\DowngradeContravariantArgumentTypeRector`](../rules/DowngradePhp74/Rector/ClassMethod/DowngradeContravariantArgumentTypeRector.php)

```diff
 class ParentType {}
 class ChildType extends ParentType {}

 class A
 {
     public function contraVariantArguments(ChildType $type)
     {
     }
 }

 class B extends A
 {
-    public function contraVariantArguments(ParentType $type)
+    /**
+     * @param ParentType $type
+     */
+    public function contraVariantArguments($type)
     {
     }
 }
```

<br>

### DowngradeCovariantReturnTypeRector

Make method return same type as parent

- class: [`Rector\DowngradePhp74\Rector\ClassMethod\DowngradeCovariantReturnTypeRector`](../rules/DowngradePhp74/Rector/ClassMethod/DowngradeCovariantReturnTypeRector.php)

```diff
 class ParentType {}
 class ChildType extends ParentType {}

 class A
 {
     public function covariantReturnTypes(): ParentType
     {
     }
 }

 class B extends A
 {
-    public function covariantReturnTypes(): ChildType
+    /**
+     * @return ChildType
+     */
+    public function covariantReturnTypes(): ParentType
     {
     }
 }
```

<br>

### DowngradeFreadFwriteFalsyToNegationRector

Changes `fread()` or `fwrite()` compare to false to negation check

- class: [`Rector\DowngradePhp74\Rector\Identical\DowngradeFreadFwriteFalsyToNegationRector`](../rules/DowngradePhp74/Rector/Identical/DowngradeFreadFwriteFalsyToNegationRector.php)

```diff
-fread($handle, $length) === false;
-fwrite($fp, '1') === false;
+!fread($handle, $length);
+!fwrite($fp, '1');
```

<br>

### DowngradeNullCoalescingOperatorRector

Remove null coalescing operator ??=

- class: [`Rector\DowngradePhp74\Rector\Coalesce\DowngradeNullCoalescingOperatorRector`](../rules/DowngradePhp74/Rector/Coalesce/DowngradeNullCoalescingOperatorRector.php)

```diff
 $array = [];
-$array['user_id'] ??= 'value';
+$array['user_id'] = $array['user_id'] ?? 'value';
```

<br>

### DowngradeNumericLiteralSeparatorRector

Remove "_" as thousands separator in numbers

- class: [`Rector\DowngradePhp74\Rector\LNumber\DowngradeNumericLiteralSeparatorRector`](../rules/DowngradePhp74/Rector/LNumber/DowngradeNumericLiteralSeparatorRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $int = 1_000;
-        $float = 1_000_500.001;
+        $int = 1000;
+        $float = 1000500.001;
     }
 }
```

<br>

### DowngradeSelfTypeDeclarationRector

Remove "self" return type, add a `"@return` self" tag instead

- class: [`Rector\DowngradePhp74\Rector\ClassMethod\DowngradeSelfTypeDeclarationRector`](../rules/DowngradePhp74/Rector/ClassMethod/DowngradeSelfTypeDeclarationRector.php)

```diff
 class SomeClass
 {
-    public function foo(): self
+    public function foo()
     {
         return $this;
     }
 }
```

<br>

### DowngradeStripTagsCallWithArrayRector

Convert 2nd param to `strip_tags` from array to string

- class: [`Rector\DowngradePhp74\Rector\FuncCall\DowngradeStripTagsCallWithArrayRector`](../rules/DowngradePhp74/Rector/FuncCall/DowngradeStripTagsCallWithArrayRector.php)

```diff
 class SomeClass
 {
     public function run($string)
     {
         // Arrays: change to string
-        strip_tags($string, ['a', 'p']);
+        strip_tags($string, '<' . implode('><', ['a', 'p']) . '>');

         // Variables/consts/properties: if array, change to string
         $tags = ['a', 'p'];
-        strip_tags($string, $tags);
+        strip_tags($string, $tags !== null && is_array($tags) ? '<' . implode('><', $tags) . '>' : $tags);

         // Default case (eg: function call): externalize to var, then if array, change to string
-        strip_tags($string, getTags());
+        $expr = getTags();
+        strip_tags($string, is_array($expr) ? '<' . implode('><', $expr) . '>' : $expr);
     }
 }
```

<br>

### DowngradeTypedPropertyRector

Changes property type definition from type definitions to `@var` annotations.

- class: [`Rector\DowngradePhp74\Rector\Property\DowngradeTypedPropertyRector`](../rules/DowngradePhp74/Rector/Property/DowngradeTypedPropertyRector.php)

```diff
 class SomeClass
 {
-    private string $property;
+    /**
+    * @var string
+    */
+    private $property;
 }
```

<br>

## DowngradePhp80

### DowngradeAttributeToAnnotationRector

Refactor PHP attribute markers to annotations notation

:wrench: **configure it!**

- class: [`Rector\DowngradePhp80\Rector\Class_\DowngradeAttributeToAnnotationRector`](../rules/DowngradePhp80/Rector/Class_/DowngradeAttributeToAnnotationRector.php)

```php
use Rector\DowngradePhp80\Rector\Class_\DowngradeAttributeToAnnotationRector;
use Rector\DowngradePhp80\ValueObject\DowngradeAttributeToAnnotation;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(DowngradeAttributeToAnnotationRector::class)
        ->call('configure', [[
            DowngradeAttributeToAnnotationRector::ATTRIBUTE_TO_ANNOTATION => ValueObjectInliner::inline([
                new DowngradeAttributeToAnnotation('Symfony\Component\Routing\Annotation\Route', null),
            ]),
        ]]);
};
```

↓

```diff
 use Symfony\Component\Routing\Annotation\Route;

 class SymfonyRoute
 {
-    #[Route(path: '/path', name: 'action')]
+    /**
+     * @Route("/path", name="action")
+     */
     public function action()
     {
     }
 }
```

<br>

### DowngradeClassOnObjectToGetClassRector

Change `$object::class` to get_class($object)

- class: [`Rector\DowngradePhp80\Rector\ClassConstFetch\DowngradeClassOnObjectToGetClassRector`](../rules/DowngradePhp80/Rector/ClassConstFetch/DowngradeClassOnObjectToGetClassRector.php)

```diff
 class SomeClass
 {
     public function run($object)
     {
-        return $object::class;
+        return get_class($object);
     }
 }
```

<br>

### DowngradeMatchToSwitchRector

Downgrade `match()` to `switch()`

- class: [`Rector\DowngradePhp80\Rector\Expression\DowngradeMatchToSwitchRector`](../rules/DowngradePhp80/Rector/Expression/DowngradeMatchToSwitchRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $message = match ($statusCode) {
-            200, 300 => null,
-            400 => 'not found',
-            default => 'unknown status code',
-        };
+        switch ($statusCode) {
+            case 200:
+            case 300:
+                $message = null;
+                break;
+            case 400:
+                $message = 'not found';
+                break;
+            default:
+                $message = 'unknown status code';
+                break;
+        }
     }
 }
```

<br>

### DowngradeMixedTypeDeclarationRector

Remove the "mixed" param and return type, add a `@param` and `@return` tag instead

- class: [`Rector\DowngradePhp80\Rector\FunctionLike\DowngradeMixedTypeDeclarationRector`](../rules/DowngradePhp80/Rector/FunctionLike/DowngradeMixedTypeDeclarationRector.php)

```diff
 class SomeClass
 {
-    public function someFunction(mixed $anything): mixed
+    /**
+     * @param mixed $anything
+     * @return mixed
+     */
+    public function someFunction($anything)
     {
     }
 }
```

<br>

### DowngradeNamedArgumentRector

Remove named argument

- class: [`Rector\DowngradePhp80\Rector\MethodCall\DowngradeNamedArgumentRector`](../rules/DowngradePhp80/Rector/MethodCall/DowngradeNamedArgumentRector.php)

```diff
 class SomeClass
 {
     private function execute(?array $a = null, ?array $b = null)
     {
     }

     public function run(string $name = null, array $attributes = [])
     {
-        $this->execute(a: [[$name ?? 0 => $attributes]]);
+        $this->execute([[$name ?? 0 => $attributes]]);
     }
 }
```

<br>

### DowngradeNonCapturingCatchesRector

Downgrade catch () without variable to one

- class: [`Rector\DowngradePhp80\Rector\Catch_\DowngradeNonCapturingCatchesRector`](../rules/DowngradePhp80/Rector/Catch_/DowngradeNonCapturingCatchesRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         try {
             // code
-        } catch (\Exception) {
+        } catch (\Exception $exception) {
             // error
         }
     }
 }
```

<br>

### DowngradeNullsafeToTernaryOperatorRector

Change nullsafe operator to ternary operator rector

- class: [`Rector\DowngradePhp80\Rector\NullsafeMethodCall\DowngradeNullsafeToTernaryOperatorRector`](../rules/DowngradePhp80/Rector/NullsafeMethodCall/DowngradeNullsafeToTernaryOperatorRector.php)

```diff
-$dateAsString = $booking->getStartDate()?->asDateTimeString();
-$dateAsString = $booking->startDate?->dateTimeString;
+$dateAsString = ($bookingGetStartDate = $booking->getStartDate()) ? $bookingGetStartDate->asDateTimeString() : null;
+$dateAsString = ($bookingGetStartDate = $booking->startDate) ? $bookingGetStartDate->dateTimeString : null;
```

<br>

### DowngradePropertyPromotionRector

Change constructor property promotion to property asssign

- class: [`Rector\DowngradePhp80\Rector\Class_\DowngradePropertyPromotionRector`](../rules/DowngradePhp80/Rector/Class_/DowngradePropertyPromotionRector.php)

```diff
 class SomeClass
 {
-    public function __construct(public float $value = 0.0)
+    public float $value;
+
+    public function __construct(float $value = 0.0)
     {
+        $this->value = $value;
     }
 }
```

<br>

### DowngradeStaticTypeDeclarationRector

Remove "static" return and param type, add a `"@param` `$this"` and `"@return` `$this"` tag instead

- class: [`Rector\DowngradePhp80\Rector\ClassMethod\DowngradeStaticTypeDeclarationRector`](../rules/DowngradePhp80/Rector/ClassMethod/DowngradeStaticTypeDeclarationRector.php)

```diff
 class SomeClass
 {
-    public function getStatic(): static
+    /**
+     * @return static
+     */
+    public function getStatic()
     {
         return new static();
     }
 }
```

<br>

### DowngradeStrContainsRector

Replace `str_contains()` with `strpos()` !== false

- class: [`Rector\DowngradePhp80\Rector\FuncCall\DowngradeStrContainsRector`](../rules/DowngradePhp80/Rector/FuncCall/DowngradeStrContainsRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        return str_contains('abc', 'a');
+        return strpos('abc', 'a') !== false;
     }
 }
```

<br>

### DowngradeStrEndsWithRector

Downgrade `str_ends_with()` to `strncmp()` version

- class: [`Rector\DowngradePhp80\Rector\FuncCall\DowngradeStrEndsWithRector`](../rules/DowngradePhp80/Rector/FuncCall/DowngradeStrEndsWithRector.php)

```diff
-str_ends_with($haystack, $needle);
+"" === $needle || ("" !== $haystack && 0 === substr_compare($haystack, $needle, -\strlen($needle)));
```

<br>

### DowngradeStrStartsWithRector

Downgrade `str_starts_with()` to `strncmp()` version

- class: [`Rector\DowngradePhp80\Rector\FuncCall\DowngradeStrStartsWithRector`](../rules/DowngradePhp80/Rector/FuncCall/DowngradeStrStartsWithRector.php)

```diff
-str_starts_with($haystack, $needle);
+strncmp($haystack, $needle, strlen($needle)) === 0;
```

<br>

### DowngradeTrailingCommasInParamUseRector

Remove trailing commas in param or use list

- class: [`Rector\DowngradePhp80\Rector\ClassMethod\DowngradeTrailingCommasInParamUseRector`](../rules/DowngradePhp80/Rector/ClassMethod/DowngradeTrailingCommasInParamUseRector.php)

```diff
 class SomeClass
 {
-    public function __construct(string $value1, string $value2,)
+    public function __construct(string $value1, string $value2)
     {
-        function (string $value1, string $value2,) {
+        function (string $value1, string $value2) {
         };

-        function () use ($value1, $value2,) {
+        function () use ($value1, $value2) {
         };
     }
 }

-function inFunction(string $value1, string $value2,)
+function inFunction(string $value1, string $value2)
 {
 }
```

<br>

### DowngradeUnionTypeDeclarationRector

Remove the union type params and returns, add `@param/@return` tags instead

- class: [`Rector\DowngradePhp80\Rector\FunctionLike\DowngradeUnionTypeDeclarationRector`](../rules/DowngradePhp80/Rector/FunctionLike/DowngradeUnionTypeDeclarationRector.php)

```diff
 class SomeClass
 {
-    public function echoInput(string|int $input): int|bool
+    /**
+     * @param string|int $input
+     * @return int|bool
+     */
+    public function echoInput($input)
     {
         echo $input;
     }
 }
```

<br>

### DowngradeUnionTypeTypedPropertyRector

Removes union type property type definition, adding `@var` annotations instead.

- class: [`Rector\DowngradePhp80\Rector\Property\DowngradeUnionTypeTypedPropertyRector`](../rules/DowngradePhp80/Rector/Property/DowngradeUnionTypeTypedPropertyRector.php)

```diff
 class SomeClass
 {
-    private string|int $property;
+    /**
+    * @var string|int
+    */
+    private $property;
 }
```

<br>

## EarlyReturn

### ChangeAndIfToEarlyReturnRector

Changes if && to early return

- class: [`Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector`](../rules/EarlyReturn/Rector/If_/ChangeAndIfToEarlyReturnRector.php)

```diff
 class SomeClass
 {
     public function canDrive(Car $car)
     {
-        if ($car->hasWheels && $car->hasFuel) {
-            return true;
+        if (!$car->hasWheels) {
+            return false;
         }

-        return false;
+        if (!$car->hasFuel) {
+            return false;
+        }
+
+        return true;
     }
 }
```

<br>

### ChangeIfElseValueAssignToEarlyReturnRector

Change if/else value to early return

- class: [`Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector`](../rules/EarlyReturn/Rector/If_/ChangeIfElseValueAssignToEarlyReturnRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         if ($this->hasDocBlock($tokens, $index)) {
-            $docToken = $tokens[$this->getDocBlockIndex($tokens, $index)];
-        } else {
-            $docToken = null;
+            return $tokens[$this->getDocBlockIndex($tokens, $index)];
         }
-
-        return $docToken;
+        return null;
     }
 }
```

<br>

### ChangeNestedForeachIfsToEarlyContinueRector

Change nested ifs to foreach with continue

- class: [`Rector\EarlyReturn\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector`](../rules/EarlyReturn/Rector/Foreach_/ChangeNestedForeachIfsToEarlyContinueRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $items = [];

         foreach ($values as $value) {
-            if ($value === 5) {
-                if ($value2 === 10) {
-                    $items[] = 'maybe';
-                }
+            if ($value !== 5) {
+                continue;
             }
+            if ($value2 !== 10) {
+                continue;
+            }
+
+            $items[] = 'maybe';
         }
     }
 }
```

<br>

### ChangeNestedIfsToEarlyReturnRector

Change nested ifs to early return

- class: [`Rector\EarlyReturn\Rector\If_\ChangeNestedIfsToEarlyReturnRector`](../rules/EarlyReturn/Rector/If_/ChangeNestedIfsToEarlyReturnRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        if ($value === 5) {
-            if ($value2 === 10) {
-                return 'yes';
-            }
+        if ($value !== 5) {
+            return 'no';
+        }
+
+        if ($value2 === 10) {
+            return 'yes';
         }

         return 'no';
     }
 }
```

<br>

### ChangeOrIfContinueToMultiContinueRector

Changes if || to early return

- class: [`Rector\EarlyReturn\Rector\If_\ChangeOrIfContinueToMultiContinueRector`](../rules/EarlyReturn/Rector/If_/ChangeOrIfContinueToMultiContinueRector.php)

```diff
 class SomeClass
 {
     public function canDrive(Car $newCar)
     {
         foreach ($cars as $car) {
-            if ($car->hasWheels() || $car->hasFuel()) {
+            if ($car->hasWheels()) {
+                continue;
+            }
+            if ($car->hasFuel()) {
                 continue;
             }

             $car->setWheel($newCar->wheel);
             $car->setFuel($newCar->fuel);
         }
     }
 }
```

<br>

### ChangeOrIfReturnToEarlyReturnRector

Changes if || with return to early return

- class: [`Rector\EarlyReturn\Rector\If_\ChangeOrIfReturnToEarlyReturnRector`](../rules/EarlyReturn/Rector/If_/ChangeOrIfReturnToEarlyReturnRector.php)

```diff
 class SomeClass
 {
     public function run($a, $b)
     {
-        if ($a || $b) {
+        if ($a) {
+            return null;
+        }
+        if ($b) {
             return null;
         }

         return 'another';
     }
 }
```

<br>

### PreparedValueToEarlyReturnRector

Return early prepared value in ifs

- class: [`Rector\EarlyReturn\Rector\Return_\PreparedValueToEarlyReturnRector`](../rules/EarlyReturn/Rector/Return_/PreparedValueToEarlyReturnRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $var = null;
-
         if (rand(0,1)) {
-            $var = 1;
+            return 1;
         }

         if (rand(0,1)) {
-            $var = 2;
+            return 2;
         }

-        return $var;
+        return null;
     }
 }
```

<br>

### RemoveAlwaysElseRector

Split if statement, when if condition always break execution flow

- class: [`Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector`](../rules/EarlyReturn/Rector/If_/RemoveAlwaysElseRector.php)

```diff
 class SomeClass
 {
     public function run($value)
     {
         if ($value) {
             throw new \InvalidStateException;
-        } else {
-            return 10;
         }
+
+        return 10;
     }
 }
```

<br>

### ReturnAfterToEarlyOnBreakRector

Change return after foreach to early return in foreach on break

- class: [`Rector\EarlyReturn\Rector\Foreach_\ReturnAfterToEarlyOnBreakRector`](../rules/EarlyReturn/Rector/Foreach_/ReturnAfterToEarlyOnBreakRector.php)

```diff
 class SomeClass
 {
     public function run(array $pathConstants, string $allowedPath)
     {
-        $pathOK = false;
-
         foreach ($pathConstants as $allowedPath) {
             if ($dirPath == $allowedPath) {
-                $pathOK = true;
-                break;
+                return true;
             }
         }

-        return $pathOK;
+        return false;
     }
 }
```

<br>

### ReturnBinaryAndToEarlyReturnRector

Changes Single return of && to early returns

- class: [`Rector\EarlyReturn\Rector\Return_\ReturnBinaryAndToEarlyReturnRector`](../rules/EarlyReturn/Rector/Return_/ReturnBinaryAndToEarlyReturnRector.php)

```diff
 class SomeClass
 {
     public function accept()
     {
-        return $this->something() && $this->somethingelse();
+        if (!$this->something()) {
+            return false;
+        }
+        return (bool) $this->somethingelse();
     }
 }
```

<br>

### ReturnBinaryOrToEarlyReturnRector

Changes Single return of || to early returns

- class: [`Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector`](../rules/EarlyReturn/Rector/Return_/ReturnBinaryOrToEarlyReturnRector.php)

```diff
 class SomeClass
 {
     public function accept()
     {
-        return $this->something() || $this->somethingElse();
+        if ($this->something()) {
+            return true;
+        }
+        return (bool) $this->somethingElse();
     }
 }
```

<br>

## Generics

### GenericsPHPStormMethodAnnotationRector

Complete PHPStorm `@method` annotations, to make it understand the PHPStan/Psalm generics

- class: [`Rector\Generics\Rector\Class_\GenericsPHPStormMethodAnnotationRector`](../rules/Generics/Rector/Class_/GenericsPHPStormMethodAnnotationRector.php)

```diff
 /**
  * @template TEntity as object
  */
 abstract class AbstractRepository
 {
     /**
      * @return TEntity
      */
     public function find($id)
     {
     }
 }

 /**
  * @template TEntity as SomeObject
  * @extends AbstractRepository<TEntity>
+ * @method SomeObject find($id)
  */
 final class AndroidDeviceRepository extends AbstractRepository
 {
 }
```

<br>

## LeagueEvent

### DispatchStringToObjectRector

Change string events to anonymous class which implement \League\Event\HasEventName

- class: [`Rector\LeagueEvent\Rector\MethodCall\DispatchStringToObjectRector`](../rules/LeagueEvent/Rector/MethodCall/DispatchStringToObjectRector.php)

```diff
 final class SomeClass
 {
     /** @var \League\Event\EventDispatcher */
     private $dispatcher;

     public function run()
     {
-        $this->dispatcher->dispatch('my-event');
+        $this->dispatcher->dispatch(new class implements \League\Event\HasEventName
+        {
+            public function eventName(): string
+            {
+                return 'my-event';
+            }
+        });
     }
 }
```

<br>

## MockeryToProphecy

### MockeryCloseRemoveRector

Removes mockery close from test classes

- class: [`Rector\MockeryToProphecy\Rector\StaticCall\MockeryCloseRemoveRector`](../rules/MockeryToProphecy/Rector/StaticCall/MockeryCloseRemoveRector.php)

```diff
 public function tearDown() : void
 {
-    \Mockery::close();
 }
```

<br>

### MockeryCreateMockToProphizeRector

Changes mockery mock creation to Prophesize

- class: [`Rector\MockeryToProphecy\Rector\ClassMethod\MockeryCreateMockToProphizeRector`](../rules/MockeryToProphecy/Rector/ClassMethod/MockeryCreateMockToProphizeRector.php)

```diff
-$mock = \Mockery::mock('MyClass');
+$mock = $this->prophesize('MyClass');
+
 $service = new Service();
-$service->injectDependency($mock);
+$service->injectDependency($mock->reveal());
```

<br>

## MysqlToMysqli

### MysqlAssignToMysqliRector

Converts more complex mysql functions to mysqli

- class: [`Rector\MysqlToMysqli\Rector\Assign\MysqlAssignToMysqliRector`](../rules/MysqlToMysqli/Rector/Assign/MysqlAssignToMysqliRector.php)

```diff
-$data = mysql_db_name($result, $row);
+mysqli_data_seek($result, $row);
+$fetch = mysql_fetch_row($result);
+$data = $fetch[0];
```

<br>

### MysqlFuncCallToMysqliRector

Converts more complex mysql functions to mysqli

- class: [`Rector\MysqlToMysqli\Rector\FuncCall\MysqlFuncCallToMysqliRector`](../rules/MysqlToMysqli/Rector/FuncCall/MysqlFuncCallToMysqliRector.php)

```diff
-mysql_drop_db($database);
+mysqli_query('DROP DATABASE ' . $database);
```

<br>

### MysqlPConnectToMysqliConnectRector

Replace `mysql_pconnect()` with `mysqli_connect()` with host p: prefix

- class: [`Rector\MysqlToMysqli\Rector\FuncCall\MysqlPConnectToMysqliConnectRector`](../rules/MysqlToMysqli/Rector/FuncCall/MysqlPConnectToMysqliConnectRector.php)

```diff
 final class SomeClass
 {
     public function run($host, $username, $password)
     {
-        return mysql_pconnect($host, $username, $password);
+        return mysqli_connect('p:' . $host, $username, $password);
     }
 }
```

<br>

### MysqlQueryMysqlErrorWithLinkRector

Add mysql_query and mysql_error with connection

- class: [`Rector\MysqlToMysqli\Rector\FuncCall\MysqlQueryMysqlErrorWithLinkRector`](../rules/MysqlToMysqli/Rector/FuncCall/MysqlQueryMysqlErrorWithLinkRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $conn = mysqli_connect('host', 'user', 'pass');

-        mysql_error();
+        mysqli_error($conn);
         $sql = 'SELECT';

-        return mysql_query($sql);
+        return mysqli_query($conn, $sql);
     }
 }
```

<br>

## Naming

### MakeBoolPropertyRespectIsHasWasMethodNamingRector

Renames property to respect is/has/was method naming

- class: [`Rector\Naming\Rector\Property\MakeBoolPropertyRespectIsHasWasMethodNamingRector`](../rules/Naming/Rector/Property/MakeBoolPropertyRespectIsHasWasMethodNamingRector.php)

```diff
 class SomeClass
 {
-private $full = false;
+private $isFull = false;

 public function isFull()
 {
-    return $this->full;
+    return $this->isFull;
 }
+
 }
```

<br>

### RenameForeachValueVariableToMatchExprVariableRector

Renames value variable name in foreach loop to match expression variable

- class: [`Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchExprVariableRector`](../rules/Naming/Rector/Foreach_/RenameForeachValueVariableToMatchExprVariableRector.php)

```diff
 class SomeClass
 {
 public function run()
 {
     $array = [];
-    foreach ($variables as $foo) {
-        $array[] = $property;
+    foreach ($variables as $variable) {
+        $array[] = $variable;
     }
 }
 }
```

<br>

### RenameForeachValueVariableToMatchMethodCallReturnTypeRector

Renames value variable name in foreach loop to match method type

- class: [`Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector`](../rules/Naming/Rector/Foreach_/RenameForeachValueVariableToMatchMethodCallReturnTypeRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $array = [];
-        foreach ($object->getMethods() as $property) {
-            $array[] = $property;
+        foreach ($object->getMethods() as $method) {
+            $array[] = $method;
         }
     }
 }
```

<br>

### RenameParamToMatchTypeRector

Rename param to match ClassType

- class: [`Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector`](../rules/Naming/Rector/ClassMethod/RenameParamToMatchTypeRector.php)

```diff
 final class SomeClass
 {
-    public function run(Apple $pie)
+    public function run(Apple $apple)
     {
-        $food = $pie;
+        $food = $apple;
     }
 }
```

<br>

### RenamePropertyToMatchTypeRector

Rename property and method param to match its type

- class: [`Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector`](../rules/Naming/Rector/Class_/RenamePropertyToMatchTypeRector.php)

```diff
 class SomeClass
 {
     /**
      * @var EntityManager
      */
-    private $eventManager;
+    private $entityManager;

-    public function __construct(EntityManager $eventManager)
+    public function __construct(EntityManager $entityManager)
     {
-        $this->eventManager = $eventManager;
+        $this->entityManager = $entityManager;
     }
 }
```

<br>

### RenameVariableToMatchMethodCallReturnTypeRector

Rename variable to match method return type

- class: [`Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector`](../rules/Naming/Rector/Assign/RenameVariableToMatchMethodCallReturnTypeRector.php)

```diff
 class SomeClass
 {
 public function run()
 {
-    $a = $this->getRunner();
+    $runner = $this->getRunner();
 }

 public function getRunner(): Runner
 {
     return new Runner();
 }
 }
```

<br>

### RenameVariableToMatchNewTypeRector

Rename variable to match new ClassType

- class: [`Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector`](../rules/Naming/Rector/ClassMethod/RenameVariableToMatchNewTypeRector.php)

```diff
 final class SomeClass
 {
     public function run()
     {
-        $search = new DreamSearch();
-        $search->advance();
+        $dreamSearch = new DreamSearch();
+        $dreamSearch->advance();
     }
 }
```

<br>

## Order

### OrderPrivateMethodsByUseRector

Order private methods in order of their use

- class: [`Rector\Order\Rector\Class_\OrderPrivateMethodsByUseRector`](../rules/Order/Rector/Class_/OrderPrivateMethodsByUseRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $this->call1();
         $this->call2();
     }

-    private function call2()
+    private function call1()
     {
     }

-    private function call1()
+    private function call2()
     {
     }
 }
```

<br>

## PHPOffice

### AddRemovedDefaultValuesRector

Complete removed default values explicitly

- class: [`Rector\PHPOffice\Rector\StaticCall\AddRemovedDefaultValuesRector`](../rules/PHPOffice/Rector/StaticCall/AddRemovedDefaultValuesRector.php)

```diff
 final class SomeClass
 {
     public function run(): void
     {
         $logger = new \PHPExcel_CalcEngine_Logger;
-        $logger->setWriteDebugLog();
+        $logger->setWriteDebugLog(false);
     }
 }
```

<br>

### CellStaticToCoordinateRector

Methods to manipulate coordinates that used to exists in PHPExcel_Cell to PhpOffice\PhpSpreadsheet\Cell\Coordinate

- class: [`Rector\PHPOffice\Rector\StaticCall\CellStaticToCoordinateRector`](../rules/PHPOffice/Rector/StaticCall/CellStaticToCoordinateRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        \PHPExcel_Cell::stringFromColumnIndex();
+        \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex();
     }
 }
```

<br>

### ChangeChartRendererRector

Change chart renderer

- class: [`Rector\PHPOffice\Rector\StaticCall\ChangeChartRendererRector`](../rules/PHPOffice/Rector/StaticCall/ChangeChartRendererRector.php)

```diff
 final class SomeClass
 {
     public function run(): void
     {
-        \PHPExcel_Settings::setChartRenderer($rendererName, $rendererLibraryPath);
+        \PHPExcel_Settings::setChartRenderer(\PhpOffice\PhpSpreadsheet\Chart\Renderer\JpGraph::class);
     }
 }
```

<br>

### ChangeConditionalGetConditionRector

Change argument `PHPExcel_Style_Conditional->getCondition()` to `getConditions()`

- class: [`Rector\PHPOffice\Rector\MethodCall\ChangeConditionalGetConditionRector`](../rules/PHPOffice/Rector/MethodCall/ChangeConditionalGetConditionRector.php)

```diff
 final class SomeClass
 {
     public function run(): void
     {
         $conditional = new \PHPExcel_Style_Conditional;
-        $someCondition = $conditional->getCondition();
+        $someCondition = $conditional->getConditions()[0] ?? '';
     }
 }
```

<br>

### ChangeConditionalReturnedCellRector

Change conditional call to `getCell()`

- class: [`Rector\PHPOffice\Rector\MethodCall\ChangeConditionalReturnedCellRector`](../rules/PHPOffice/Rector/MethodCall/ChangeConditionalReturnedCellRector.php)

```diff
 final class SomeClass
 {
     public function run(): void
     {
         $worksheet = new \PHPExcel_Worksheet();
-        $cell = $worksheet->setCellValue('A1', 'value', true);
+        $cell = $worksheet->getCell('A1')->setValue('value');
     }
 }
```

<br>

### ChangeConditionalSetConditionRector

Change argument `PHPExcel_Style_Conditional->setCondition()` to `setConditions()`

- class: [`Rector\PHPOffice\Rector\MethodCall\ChangeConditionalSetConditionRector`](../rules/PHPOffice/Rector/MethodCall/ChangeConditionalSetConditionRector.php)

```diff
 final class SomeClass
 {
     public function run(): void
     {
         $conditional = new \PHPExcel_Style_Conditional;
-        $someCondition = $conditional->setCondition(1);
+        $someCondition = $conditional->setConditions((array) 1);
     }
 }
```

<br>

### ChangeDataTypeForValueRector

Change argument `DataType::dataTypeForValue()` to DefaultValueBinder

- class: [`Rector\PHPOffice\Rector\StaticCall\ChangeDataTypeForValueRector`](../rules/PHPOffice/Rector/StaticCall/ChangeDataTypeForValueRector.php)

```diff
 final class SomeClass
 {
     public function run(): void
     {
-        $type = \PHPExcel_Cell_DataType::dataTypeForValue('value');
+        $type = \PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder::dataTypeForValue('value');
     }
 }
```

<br>

### ChangeDuplicateStyleArrayToApplyFromArrayRector

Change method call `duplicateStyleArray()` to `getStyle()` + `applyFromArray()`

- class: [`Rector\PHPOffice\Rector\MethodCall\ChangeDuplicateStyleArrayToApplyFromArrayRector`](../rules/PHPOffice/Rector/MethodCall/ChangeDuplicateStyleArrayToApplyFromArrayRector.php)

```diff
 final class SomeClass
 {
     public function run(): void
     {
         $worksheet = new \PHPExcel_Worksheet();
-        $worksheet->duplicateStyleArray($styles, $range, $advanced);
+        $worksheet->getStyle($range)->applyFromArray($styles, $advanced);
     }
 }
```

<br>

### ChangeIOFactoryArgumentRector

Change argument of `PHPExcel_IOFactory::createReader()`, `PHPExcel_IOFactory::createWriter()` and `PHPExcel_IOFactory::identify()`

- class: [`Rector\PHPOffice\Rector\StaticCall\ChangeIOFactoryArgumentRector`](../rules/PHPOffice/Rector/StaticCall/ChangeIOFactoryArgumentRector.php)

```diff
 final class SomeClass
 {
     public function run(): void
     {
-        $writer = \PHPExcel_IOFactory::createWriter('CSV');
+        $writer = \PHPExcel_IOFactory::createWriter('Csv');
     }
 }
```

<br>

### ChangePdfWriterRector

Change init of PDF writer

- class: [`Rector\PHPOffice\Rector\StaticCall\ChangePdfWriterRector`](../rules/PHPOffice/Rector/StaticCall/ChangePdfWriterRector.php)

```diff
 final class SomeClass
 {
     public function run(): void
     {
-        \PHPExcel_Settings::setPdfRendererName(PHPExcel_Settings::PDF_RENDERER_MPDF);
-        \PHPExcel_Settings::setPdfRenderer($somePath);
-        $writer = \PHPExcel_IOFactory::createWriter($spreadsheet, 'PDF');
+        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheet);
     }
 }
```

<br>

### ChangeSearchLocationToRegisterReaderRector

Change argument `addSearchLocation()` to `registerReader()`

- class: [`Rector\PHPOffice\Rector\StaticCall\ChangeSearchLocationToRegisterReaderRector`](../rules/PHPOffice/Rector/StaticCall/ChangeSearchLocationToRegisterReaderRector.php)

```diff
 final class SomeClass
 {
     public function run(): void
     {
-        \PHPExcel_IOFactory::addSearchLocation($type, $location, $classname);
+        \PhpOffice\PhpSpreadsheet\IOFactory::registerReader($type, $classname);
     }
 }
```

<br>

### GetDefaultStyleToGetParentRector

Methods to (new `Worksheet())->getDefaultStyle()` to `getParent()->getDefaultStyle()`

- class: [`Rector\PHPOffice\Rector\MethodCall\GetDefaultStyleToGetParentRector`](../rules/PHPOffice/Rector/MethodCall/GetDefaultStyleToGetParentRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $worksheet = new \PHPExcel_Worksheet();
-        $worksheet->getDefaultStyle();
+        $worksheet->getParent()->getDefaultStyle();
     }
 }
```

<br>

### IncreaseColumnIndexRector

Column index changed from 0 to 1 - run only ONCE! changes current value without memory

- class: [`Rector\PHPOffice\Rector\MethodCall\IncreaseColumnIndexRector`](../rules/PHPOffice/Rector/MethodCall/IncreaseColumnIndexRector.php)

```diff
 final class SomeClass
 {
     public function run(): void
     {
         $worksheet = new \PHPExcel_Worksheet();
-        $worksheet->setCellValueByColumnAndRow(0, 3, '1150');
+        $worksheet->setCellValueByColumnAndRow(1, 3, '1150');
     }
 }
```

<br>

### RemoveSetTempDirOnExcelWriterRector

Remove `setTempDir()` on PHPExcel_Writer_Excel5

- class: [`Rector\PHPOffice\Rector\MethodCall\RemoveSetTempDirOnExcelWriterRector`](../rules/PHPOffice/Rector/MethodCall/RemoveSetTempDirOnExcelWriterRector.php)

```diff
 final class SomeClass
 {
     public function run(): void
     {
         $writer = new \PHPExcel_Writer_Excel5;
-        $writer->setTempDir();
     }
 }
```

<br>

## PSR4

### MultipleClassFileToPsr4ClassesRector

Change multiple classes in one file to standalone PSR-4 classes.

- class: [`Rector\PSR4\Rector\Namespace_\MultipleClassFileToPsr4ClassesRector`](../rules/PSR4/Rector/Namespace_/MultipleClassFileToPsr4ClassesRector.php)

```diff
+// new file: "app/Exceptions/FirstException.php"
 namespace App\Exceptions;

 use Exception;

 final class FirstException extends Exception
 {
 }
+
+// new file: "app/Exceptions/SecondException.php"
+namespace App\Exceptions;
+
+use Exception;

 final class SecondException extends Exception
 {
 }
```

<br>

### NormalizeNamespaceByPSR4ComposerAutoloadRector

Adds namespace to namespace-less files or correct namespace to match PSR-4 in `composer.json` autoload section. Run with combination with "Rector\PSR4\Rector\Namespace_\MultipleClassFileToPsr4ClassesRector"

- class: [`Rector\PSR4\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector`](../rules/PSR4/Rector/FileWithoutNamespace/NormalizeNamespaceByPSR4ComposerAutoloadRector.php)

- with `composer.json`:

```json
{
    "autoload": {
        "psr-4": {
            "App\\CustomNamespace\\": "src"
        }
    }
}
```

↓

```diff
 // src/SomeClass.php

+namespace App\CustomNamespace;
+
 class SomeClass
 {
 }
```

<br>

## Php52

### ContinueToBreakInSwitchRector

Use break instead of continue in switch statements

- class: [`Rector\Php52\Rector\Switch_\ContinueToBreakInSwitchRector`](../rules/Php52/Rector/Switch_/ContinueToBreakInSwitchRector.php)

```diff
 function some_run($value)
 {
     switch ($value) {
         case 1:
             echo 'Hi';
-            continue;
+            break;
         case 2:
             echo 'Hello';
             break;
     }
 }
```

<br>

### VarToPublicPropertyRector

Change property modifier from `var` to `public`

- class: [`Rector\Php52\Rector\Property\VarToPublicPropertyRector`](../rules/Php52/Rector/Property/VarToPublicPropertyRector.php)

```diff
 final class SomeController
 {
-    var $name = 'Tom';
+    public $name = 'Tom';
 }
```

<br>

## Php53

### ClearReturnNewByReferenceRector

Remove reference from "$assign = &new Value;"

- class: [`Rector\Php53\Rector\AssignRef\ClearReturnNewByReferenceRector`](../rules/Php53/Rector/AssignRef/ClearReturnNewByReferenceRector.php)

```diff
-$assign = &new Value;
+$assign = new Value;
```

<br>

### DirNameFileConstantToDirConstantRector

Convert dirname(__FILE__) to __DIR__

- class: [`Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector`](../rules/Php53/Rector/FuncCall/DirNameFileConstantToDirConstantRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        return dirname(__FILE__);
+        return __DIR__;
     }
 }
```

<br>

### ReplaceHttpServerVarsByServerRector

Rename old `$HTTP_*` variable names to new replacements

- class: [`Rector\Php53\Rector\Variable\ReplaceHttpServerVarsByServerRector`](../rules/Php53/Rector/Variable/ReplaceHttpServerVarsByServerRector.php)

```diff
-$serverVars = $HTTP_SERVER_VARS;
+$serverVars = $_SERVER;
```

<br>

### TernaryToElvisRector

Use ?: instead of ?, where useful

- class: [`Rector\Php53\Rector\Ternary\TernaryToElvisRector`](../rules/Php53/Rector/Ternary/TernaryToElvisRector.php)

```diff
 function elvis()
 {
-    $value = $a ? $a : false;
+    $value = $a ?: false;
 }
```

<br>

## Php54

### RemoveReferenceFromCallRector

Remove & from function and method calls

- class: [`Rector\Php54\Rector\FuncCall\RemoveReferenceFromCallRector`](../rules/Php54/Rector/FuncCall/RemoveReferenceFromCallRector.php)

```diff
 final class SomeClass
 {
     public function run($one)
     {
-        return strlen(&$one);
+        return strlen($one);
     }
 }
```

<br>

### RemoveZeroBreakContinueRector

Remove 0 from break and continue

- class: [`Rector\Php54\Rector\Break_\RemoveZeroBreakContinueRector`](../rules/Php54/Rector/Break_/RemoveZeroBreakContinueRector.php)

```diff
 class SomeClass
 {
     public function run($random)
     {
-        continue 0;
-        break 0;
+        continue;
+        break;

         $five = 5;
-        continue $five;
+        continue 5;

-        break $random;
+        break;
     }
 }
```

<br>

## Php55

### ClassConstantToSelfClassRector

Change `__CLASS__` to self::class

- class: [`Rector\Php55\Rector\Class_\ClassConstantToSelfClassRector`](../rules/Php55/Rector/Class_/ClassConstantToSelfClassRector.php)

```diff
 class SomeClass
 {
    public function callOnMe()
    {
-       var_dump(__CLASS__);
+       var_dump(self::class);
    }
 }
```

<br>

### PregReplaceEModifierRector

The /e modifier is no longer supported, use preg_replace_callback instead

- class: [`Rector\Php55\Rector\FuncCall\PregReplaceEModifierRector`](../rules/Php55/Rector/FuncCall/PregReplaceEModifierRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $comment = preg_replace('~\b(\w)(\w+)~e', '"$1".strtolower("$2")', $comment);
+        $comment = preg_replace_callback('~\b(\w)(\w+)~', function ($matches) {
+              return($matches[1].strtolower($matches[2]));
+        }, , $comment);
     }
 }
```

<br>

### StringClassNameToClassConstantRector

Replace string class names by <class>::class constant

:wrench: **configure it!**

- class: [`Rector\Php55\Rector\String_\StringClassNameToClassConstantRector`](../rules/Php55/Rector/String_/StringClassNameToClassConstantRector.php)

```php
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(StringClassNameToClassConstantRector::class)
        ->call('configure', [[
            StringClassNameToClassConstantRector::CLASSES_TO_SKIP => ['ClassName', 'AnotherClassName'],
        ]]);
};
```

↓

```diff
 class AnotherClass
 {
 }

 class SomeClass
 {
     public function run()
     {
-        return 'AnotherClass';
+        return \AnotherClass::class;
     }
 }
```

<br>

## Php56

### AddDefaultValueForUndefinedVariableRector

Adds default value for undefined variable

- class: [`Rector\Php56\Rector\FunctionLike\AddDefaultValueForUndefinedVariableRector`](../rules/Php56/Rector/FunctionLike/AddDefaultValueForUndefinedVariableRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
+        $a = null;
         if (rand(0, 1)) {
             $a = 5;
         }
         echo $a;
     }
 }
```

<br>

### PowToExpRector

Changes pow(val, val2) to ** (exp) parameter

- class: [`Rector\Php56\Rector\FuncCall\PowToExpRector`](../rules/Php56/Rector/FuncCall/PowToExpRector.php)

```diff
-pow(1, 2);
+1**2;
```

<br>

## Php70

### BreakNotInLoopOrSwitchToReturnRector

Convert break outside for/foreach/switch context to return

- class: [`Rector\Php70\Rector\Break_\BreakNotInLoopOrSwitchToReturnRector`](../rules/Php70/Rector/Break_/BreakNotInLoopOrSwitchToReturnRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         if ($isphp5)
             return 1;
         else
             return 2;
-        break;
+        return;
     }
 }
```

<br>

### CallUserMethodRector

Changes `call_user_method()/call_user_method_array()` to `call_user_func()/call_user_func_array()`

- class: [`Rector\Php70\Rector\FuncCall\CallUserMethodRector`](../rules/Php70/Rector/FuncCall/CallUserMethodRector.php)

```diff
-call_user_method($method, $obj, "arg1", "arg2");
+call_user_func(array(&$obj, "method"), "arg1", "arg2");
```

<br>

### EmptyListRector

`list()` cannot be empty

- class: [`Rector\Php70\Rector\List_\EmptyListRector`](../rules/Php70/Rector/List_/EmptyListRector.php)

```diff
-'list() = $values;'
+'list($unusedGenerated) = $values;'
```

<br>

### EregToPregMatchRector

Changes ereg*() to preg*() calls

- class: [`Rector\Php70\Rector\FuncCall\EregToPregMatchRector`](../rules/Php70/Rector/FuncCall/EregToPregMatchRector.php)

```diff
-ereg("hi")
+preg_match("#hi#");
```

<br>

### ExceptionHandlerTypehintRector

Change typehint from `Exception` to `Throwable`.

- class: [`Rector\Php70\Rector\FunctionLike\ExceptionHandlerTypehintRector`](../rules/Php70/Rector/FunctionLike/ExceptionHandlerTypehintRector.php)

```diff
-function handler(Exception $exception) { ... }
+function handler(Throwable $exception) { ... }
 set_exception_handler('handler');
```

<br>

### IfToSpaceshipRector

Changes if/else to spaceship <=> where useful

- class: [`Rector\Php70\Rector\If_\IfToSpaceshipRector`](../rules/Php70/Rector/If_/IfToSpaceshipRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         usort($languages, function ($a, $b) {
-            if ($a[0] === $b[0]) {
-                return 0;
-            }
-
-            return ($a[0] < $b[0]) ? 1 : -1;
+            return $b[0] <=> $a[0];
         });
     }
 }
```

<br>

### ListSplitStringRector

`list()` cannot split string directly anymore, use `str_split()`

- class: [`Rector\Php70\Rector\Assign\ListSplitStringRector`](../rules/Php70/Rector/Assign/ListSplitStringRector.php)

```diff
-list($foo) = "string";
+list($foo) = str_split("string");
```

<br>

### ListSwapArrayOrderRector

`list()` assigns variables in reverse order - relevant in array assign

- class: [`Rector\Php70\Rector\Assign\ListSwapArrayOrderRector`](../rules/Php70/Rector/Assign/ListSwapArrayOrderRector.php)

```diff
-list($a[], $a[]) = [1, 2];
+list($a[], $a[]) = array_reverse([1, 2]);
```

<br>

### MultiDirnameRector

Changes multiple `dirname()` calls to one with nesting level

- class: [`Rector\Php70\Rector\FuncCall\MultiDirnameRector`](../rules/Php70/Rector/FuncCall/MultiDirnameRector.php)

```diff
-dirname(dirname($path));
+dirname($path, 2);
```

<br>

### NonVariableToVariableOnFunctionCallRector

Transform non variable like arguments to variable where a function or method expects an argument passed by reference

- class: [`Rector\Php70\Rector\FuncCall\NonVariableToVariableOnFunctionCallRector`](../rules/Php70/Rector/FuncCall/NonVariableToVariableOnFunctionCallRector.php)

```diff
-reset(a());
+$a = a(); reset($a);
```

<br>

### Php4ConstructorRector

Changes PHP 4 style constructor to __construct.

- class: [`Rector\Php70\Rector\ClassMethod\Php4ConstructorRector`](../rules/Php70/Rector/ClassMethod/Php4ConstructorRector.php)

```diff
 class SomeClass
 {
-    public function SomeClass()
+    public function __construct()
     {
     }
 }
```

<br>

### RandomFunctionRector

Changes rand, srand and getrandmax by new mt_* alternatives.

- class: [`Rector\Php70\Rector\FuncCall\RandomFunctionRector`](../rules/Php70/Rector/FuncCall/RandomFunctionRector.php)

```diff
-rand();
+mt_rand();
```

<br>

### ReduceMultipleDefaultSwitchRector

Remove first default switch, that is ignored

- class: [`Rector\Php70\Rector\Switch_\ReduceMultipleDefaultSwitchRector`](../rules/Php70/Rector/Switch_/ReduceMultipleDefaultSwitchRector.php)

```diff
 switch ($expr) {
     default:
-         echo "Hello World";
-
-    default:
          echo "Goodbye Moon!";
          break;
 }
```

<br>

### RenameMktimeWithoutArgsToTimeRector

Renames `mktime()` without arguments to `time()`

- class: [`Rector\Php70\Rector\FuncCall\RenameMktimeWithoutArgsToTimeRector`](../rules/Php70/Rector/FuncCall/RenameMktimeWithoutArgsToTimeRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
         $time = mktime(1, 2, 3);
-        $nextTime = mktime();
+        $nextTime = time();
     }
 }
```

<br>

### StaticCallOnNonStaticToInstanceCallRector

Changes static call to instance call, where not useful

- class: [`Rector\Php70\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector`](../rules/Php70/Rector/StaticCall/StaticCallOnNonStaticToInstanceCallRector.php)

```diff
 class Something
 {
     public function doWork()
     {
     }
 }

 class Another
 {
     public function run()
     {
-        return Something::doWork();
+        return (new Something)->doWork();
     }
 }
```

<br>

### TernaryToNullCoalescingRector

Changes unneeded null check to ?? operator

- class: [`Rector\Php70\Rector\Ternary\TernaryToNullCoalescingRector`](../rules/Php70/Rector/Ternary/TernaryToNullCoalescingRector.php)

```diff
-$value === null ? 10 : $value;
+$value ?? 10;
```

<br>

```diff
-isset($value) ? $value : 10;
+$value ?? 10;
```

<br>

### TernaryToSpaceshipRector

Use <=> spaceship instead of ternary with same effect

- class: [`Rector\Php70\Rector\Ternary\TernaryToSpaceshipRector`](../rules/Php70/Rector/Ternary/TernaryToSpaceshipRector.php)

```diff
 function order_func($a, $b) {
-    return ($a < $b) ? -1 : (($a > $b) ? 1 : 0);
+    return $a <=> $b;
 }
```

<br>

### ThisCallOnStaticMethodToStaticCallRector

Changes `$this->call()` to static method to static call

- class: [`Rector\Php70\Rector\MethodCall\ThisCallOnStaticMethodToStaticCallRector`](../rules/Php70/Rector/MethodCall/ThisCallOnStaticMethodToStaticCallRector.php)

```diff
 class SomeClass
 {
     public static function run()
     {
-        $this->eat();
+        static::eat();
     }

     public static function eat()
     {
     }
 }
```

<br>

### WrapVariableVariableNameInCurlyBracesRector

Ensure variable variables are wrapped in curly braces

- class: [`Rector\Php70\Rector\Variable\WrapVariableVariableNameInCurlyBracesRector`](../rules/Php70/Rector/Variable/WrapVariableVariableNameInCurlyBracesRector.php)

```diff
 function run($foo)
 {
-    global $$foo->bar;
+    global ${$foo->bar};
 }
```

<br>

## Php71

### AssignArrayToStringRector

String cannot be turned into array by assignment anymore

- class: [`Rector\Php71\Rector\Assign\AssignArrayToStringRector`](../rules/Php71/Rector/Assign/AssignArrayToStringRector.php)

```diff
-$string = '';
+$string = [];
 $string[] = 1;
```

<br>

### BinaryOpBetweenNumberAndStringRector

Change binary operation between some number + string to PHP 7.1 compatible version

- class: [`Rector\Php71\Rector\BinaryOp\BinaryOpBetweenNumberAndStringRector`](../rules/Php71/Rector/BinaryOp/BinaryOpBetweenNumberAndStringRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $value = 5 + '';
-        $value = 5.0 + 'hi';
+        $value = 5 + 0;
+        $value = 5.0 + 0
     }
 }
```

<br>

### CountOnNullRector

Changes `count()` on null to safe ternary check

- class: [`Rector\Php71\Rector\FuncCall\CountOnNullRector`](../rules/Php71/Rector/FuncCall/CountOnNullRector.php)

```diff
 $values = null;
-$count = count($values);
+$count = count((array) $values);
```

<br>

### IsIterableRector

Changes is_array + Traversable check to is_iterable

- class: [`Rector\Php71\Rector\BooleanOr\IsIterableRector`](../rules/Php71/Rector/BooleanOr/IsIterableRector.php)

```diff
-is_array($foo) || $foo instanceof Traversable;
+is_iterable($foo);
```

<br>

### ListToArrayDestructRector

Change `list()` to array destruct

- class: [`Rector\Php71\Rector\List_\ListToArrayDestructRector`](../rules/Php71/Rector/List_/ListToArrayDestructRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        list($id1, $name1) = $data;
+        [$id1, $name1] = $data;

-        foreach ($data as list($id, $name)) {
+        foreach ($data as [$id, $name]) {
         }
     }
 }
```

<br>

### MultiExceptionCatchRector

Changes multi catch of same exception to single one | separated.

- class: [`Rector\Php71\Rector\TryCatch\MultiExceptionCatchRector`](../rules/Php71/Rector/TryCatch/MultiExceptionCatchRector.php)

```diff
 try {
-    // Some code...
-} catch (ExceptionType1 $exception) {
-    $sameCode;
-} catch (ExceptionType2 $exception) {
-    $sameCode;
+   // Some code...
+} catch (ExceptionType1 | ExceptionType2 $exception) {
+   $sameCode;
 }
```

<br>

### PublicConstantVisibilityRector

Add explicit public constant visibility.

- class: [`Rector\Php71\Rector\ClassConst\PublicConstantVisibilityRector`](../rules/Php71/Rector/ClassConst/PublicConstantVisibilityRector.php)

```diff
 class SomeClass
 {
-    const HEY = 'you';
+    public const HEY = 'you';
 }
```

<br>

### RemoveExtraParametersRector

Remove extra parameters

- class: [`Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector`](../rules/Php71/Rector/FuncCall/RemoveExtraParametersRector.php)

```diff
-strlen("asdf", 1);
+strlen("asdf");
```

<br>

### ReservedObjectRector

Changes reserved "Object" name to "<Smart>Object" where <Smart> can be configured

:wrench: **configure it!**

- class: [`Rector\Php71\Rector\Name\ReservedObjectRector`](../rules/Php71/Rector/Name/ReservedObjectRector.php)

```php
use Rector\Php71\Rector\Name\ReservedObjectRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ReservedObjectRector::class)
        ->call('configure', [[
            ReservedObjectRector::RESERVED_KEYWORDS_TO_REPLACEMENTS => [
                'ReservedObject' => 'SmartObject',
                'Object' => 'AnotherSmartObject',

            ], ]]);
};
```

↓

```diff
-class Object
+class SmartObject
 {
 }
```

<br>

## Php72

### CreateFunctionToAnonymousFunctionRector

Use anonymous functions instead of deprecated `create_function()`

- class: [`Rector\Php72\Rector\FuncCall\CreateFunctionToAnonymousFunctionRector`](../rules/Php72/Rector/FuncCall/CreateFunctionToAnonymousFunctionRector.php)

```diff
 class ClassWithCreateFunction
 {
     public function run()
     {
-        $callable = create_function('$matches', "return '$delimiter' . strtolower(\$matches[1]);");
+        $callable = function($matches) use ($delimiter) {
+            return $delimiter . strtolower($matches[1]);
+        };
     }
 }
```

<br>

### GetClassOnNullRector

Null is no more allowed in `get_class()`

- class: [`Rector\Php72\Rector\FuncCall\GetClassOnNullRector`](../rules/Php72/Rector/FuncCall/GetClassOnNullRector.php)

```diff
 final class SomeClass
 {
     public function getItem()
     {
         $value = null;
-        return get_class($value);
+        return $value !== null ? get_class($value) : self::class;
     }
 }
```

<br>

### IsObjectOnIncompleteClassRector

Incomplete class returns inverted bool on `is_object()`

- class: [`Rector\Php72\Rector\FuncCall\IsObjectOnIncompleteClassRector`](../rules/Php72/Rector/FuncCall/IsObjectOnIncompleteClassRector.php)

```diff
 $incompleteObject = new __PHP_Incomplete_Class;
-$isObject = is_object($incompleteObject);
+$isObject = ! is_object($incompleteObject);
```

<br>

### ListEachRector

`each()` function is deprecated, use `key()` and `current()` instead

- class: [`Rector\Php72\Rector\Assign\ListEachRector`](../rules/Php72/Rector/Assign/ListEachRector.php)

```diff
-list($key, $callback) = each($callbacks);
+$key = key($callbacks);
+$callback = current($callbacks);
+next($callbacks);
```

<br>

### ParseStrWithResultArgumentRector

Use `$result` argument in `parse_str()` function

- class: [`Rector\Php72\Rector\FuncCall\ParseStrWithResultArgumentRector`](../rules/Php72/Rector/FuncCall/ParseStrWithResultArgumentRector.php)

```diff
-parse_str($this->query);
-$data = get_defined_vars();
+parse_str($this->query, $result);
+$data = $result;
```

<br>

### ReplaceEachAssignmentWithKeyCurrentRector

Replace `each()` assign outside loop

- class: [`Rector\Php72\Rector\Assign\ReplaceEachAssignmentWithKeyCurrentRector`](../rules/Php72/Rector/Assign/ReplaceEachAssignmentWithKeyCurrentRector.php)

```diff
 $array = ['b' => 1, 'a' => 2];
-$eachedArray = each($array);
+$eachedArray[1] = current($array);
+$eachedArray['value'] = current($array);
+$eachedArray[0] = key($array);
+$eachedArray['key'] = key($array);
+next($array);
```

<br>

### StringifyDefineRector

Make first argument of `define()` string

- class: [`Rector\Php72\Rector\FuncCall\StringifyDefineRector`](../rules/Php72/Rector/FuncCall/StringifyDefineRector.php)

```diff
 class SomeClass
 {
     public function run(int $a)
     {
-         define(CONSTANT_2, 'value');
+         define('CONSTANT_2', 'value');
          define('CONSTANT', 'value');
     }
 }
```

<br>

### StringsAssertNakedRector

String asserts must be passed directly to `assert()`

- class: [`Rector\Php72\Rector\FuncCall\StringsAssertNakedRector`](../rules/Php72/Rector/FuncCall/StringsAssertNakedRector.php)

```diff
 function nakedAssert()
 {
-    assert('true === true');
-    assert("true === true");
+    assert(true === true);
+    assert(true === true);
 }
```

<br>

### UnsetCastRector

Removes (unset) cast

- class: [`Rector\Php72\Rector\Unset_\UnsetCastRector`](../rules/Php72/Rector/Unset_/UnsetCastRector.php)

```diff
-$different = (unset) $value;
+$different = null;

-$value = (unset) $value;
+unset($value);
```

<br>

### WhileEachToForeachRector

`each()` function is deprecated, use `foreach()` instead.

- class: [`Rector\Php72\Rector\While_\WhileEachToForeachRector`](../rules/Php72/Rector/While_/WhileEachToForeachRector.php)

```diff
-while (list($key, $callback) = each($callbacks)) {
+foreach ($callbacks as $key => $callback) {
     // ...
 }
```

<br>

```diff
-while (list($key) = each($callbacks)) {
+foreach (array_keys($callbacks) as $key) {
     // ...
 }
```

<br>

## Php73

### ArrayKeyFirstLastRector

Make use of `array_key_first()` and `array_key_last()`

- class: [`Rector\Php73\Rector\FuncCall\ArrayKeyFirstLastRector`](../rules/Php73/Rector/FuncCall/ArrayKeyFirstLastRector.php)

```diff
-reset($items);
-$firstKey = key($items);
+$firstKey = array_key_first($items);
```

<br>

```diff
-end($items);
-$lastKey = key($items);
+$lastKey = array_key_last($items);
```

<br>

### IsCountableRector

Changes is_array + Countable check to is_countable

- class: [`Rector\Php73\Rector\BooleanOr\IsCountableRector`](../rules/Php73/Rector/BooleanOr/IsCountableRector.php)

```diff
-is_array($foo) || $foo instanceof Countable;
+is_countable($foo);
```

<br>

### JsonThrowOnErrorRector

Adds JSON_THROW_ON_ERROR to `json_encode()` and `json_decode()` to throw JsonException on error

- class: [`Rector\Php73\Rector\FuncCall\JsonThrowOnErrorRector`](../rules/Php73/Rector/FuncCall/JsonThrowOnErrorRector.php)

```diff
-json_encode($content);
-json_decode($json);
+json_encode($content, JSON_THROW_ON_ERROR);
+json_decode($json, null, 512, JSON_THROW_ON_ERROR);
```

<br>

### RegexDashEscapeRector

Escape - in some cases

- class: [`Rector\Php73\Rector\FuncCall\RegexDashEscapeRector`](../rules/Php73/Rector/FuncCall/RegexDashEscapeRector.php)

```diff
-preg_match("#[\w-()]#", 'some text');
+preg_match("#[\w\-()]#", 'some text');
```

<br>

### SensitiveConstantNameRector

Changes case insensitive constants to sensitive ones.

- class: [`Rector\Php73\Rector\ConstFetch\SensitiveConstantNameRector`](../rules/Php73/Rector/ConstFetch/SensitiveConstantNameRector.php)

```diff
 define('FOO', 42, true);
 var_dump(FOO);
-var_dump(foo);
+var_dump(FOO);
```

<br>

### SensitiveDefineRector

Changes case insensitive constants to sensitive ones.

- class: [`Rector\Php73\Rector\FuncCall\SensitiveDefineRector`](../rules/Php73/Rector/FuncCall/SensitiveDefineRector.php)

```diff
-define('FOO', 42, true);
+define('FOO', 42);
```

<br>

### SensitiveHereNowDocRector

Changes heredoc/nowdoc that contains closing word to safe wrapper name

- class: [`Rector\Php73\Rector\String_\SensitiveHereNowDocRector`](../rules/Php73/Rector/String_/SensitiveHereNowDocRector.php)

```diff
-$value = <<<A
+$value = <<<A_WRAP
     A
-A
+A_WRAP
```

<br>

### SetCookieRector

Convert setcookie argument to PHP7.3 option array

- class: [`Rector\Php73\Rector\FuncCall\SetCookieRector`](../rules/Php73/Rector/FuncCall/SetCookieRector.php)

```diff
-setcookie('name', $value, 360);
+setcookie('name', $value, ['expires' => 360]);
```

<br>

```diff
-setcookie('name', $name, 0, '', '', true, true);
+setcookie('name', $name, ['expires' => 0, 'path' => '', 'domain' => '', 'secure' => true, 'httponly' => true]);
```

<br>

### StringifyStrNeedlesRector

Makes needles explicit strings

- class: [`Rector\Php73\Rector\FuncCall\StringifyStrNeedlesRector`](../rules/Php73/Rector/FuncCall/StringifyStrNeedlesRector.php)

```diff
 $needle = 5;
-$fivePosition = strpos('725', $needle);
+$fivePosition = strpos('725', (string) $needle);
```

<br>

## Php74

### AddLiteralSeparatorToNumberRector

Add "_" as thousands separator in numbers for higher or equals to limitValue config

:wrench: **configure it!**

- class: [`Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector`](../rules/Php74/Rector/LNumber/AddLiteralSeparatorToNumberRector.php)

```php
use Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(AddLiteralSeparatorToNumberRector::class)
        ->call('configure', [[
            AddLiteralSeparatorToNumberRector::LIMIT_VALUE => 1000000,
        ]]);
};
```

↓

```diff
 class SomeClass
 {
     public function run()
     {
-        $int = 500000;
-        $float = 1000500.001;
+        $int = 500_000;
+        $float = 1_000_500.001;
     }
 }
```

<br>

### ArrayKeyExistsOnPropertyRector

Change `array_key_exists()` on property to `property_exists()`

- class: [`Rector\Php74\Rector\FuncCall\ArrayKeyExistsOnPropertyRector`](../rules/Php74/Rector/FuncCall/ArrayKeyExistsOnPropertyRector.php)

```diff
 class SomeClass
 {
      public $value;
 }
 $someClass = new SomeClass;

-array_key_exists('value', $someClass);
+property_exists($someClass, 'value');
```

<br>

### ArraySpreadInsteadOfArrayMergeRector

Change `array_merge()` to spread operator, except values with possible string key values

- class: [`Rector\Php74\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector`](../rules/Php74/Rector/FuncCall/ArraySpreadInsteadOfArrayMergeRector.php)

```diff
 class SomeClass
 {
     public function run($iter1, $iter2)
     {
-        $values = array_merge(iterator_to_array($iter1), iterator_to_array($iter2));
+        $values = [...$iter1, ...$iter2];

         // Or to generalize to all iterables
-        $anotherValues = array_merge(
-            is_array($iter1) ? $iter1 : iterator_to_array($iter1),
-            is_array($iter2) ? $iter2 : iterator_to_array($iter2)
-        );
+        $anotherValues = [...$iter1, ...$iter2];
     }
 }
```

<br>

### ChangeReflectionTypeToStringToGetNameRector

Change string calls on ReflectionType

- class: [`Rector\Php74\Rector\MethodCall\ChangeReflectionTypeToStringToGetNameRector`](../rules/Php74/Rector/MethodCall/ChangeReflectionTypeToStringToGetNameRector.php)

```diff
 class SomeClass
 {
     public function go(ReflectionFunction $reflectionFunction)
     {
         $parameterReflection = $reflectionFunction->getParameters()[0];

-        $paramType = (string) $parameterReflection->getType();
+        $paramType = (string) ($parameterReflection->getType() ? $parameterReflection->getType()->getName() : null);

-        $stringValue = 'hey' . $reflectionFunction->getReturnType();
+        $stringValue = 'hey' . ($reflectionFunction->getReturnType() ? $reflectionFunction->getReturnType()->getName() : null);

         // keep
         return $reflectionFunction->getReturnType();
     }
 }
```

<br>

### ClosureToArrowFunctionRector

Change closure to arrow function

- class: [`Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector`](../rules/Php74/Rector/Closure/ClosureToArrowFunctionRector.php)

```diff
 class SomeClass
 {
     public function run($meetups)
     {
-        return array_filter($meetups, function (Meetup $meetup) {
-            return is_object($meetup);
-        });
+        return array_filter($meetups, fn(Meetup $meetup) => is_object($meetup));
     }
 }
```

<br>

### ExportToReflectionFunctionRector

Change `export()` to ReflectionFunction alternatives

- class: [`Rector\Php74\Rector\StaticCall\ExportToReflectionFunctionRector`](../rules/Php74/Rector/StaticCall/ExportToReflectionFunctionRector.php)

```diff
-$reflectionFunction = ReflectionFunction::export('foo');
-$reflectionFunctionAsString = ReflectionFunction::export('foo', true);
+$reflectionFunction = new ReflectionFunction('foo');
+$reflectionFunctionAsString = (string) new ReflectionFunction('foo');
```

<br>

### FilterVarToAddSlashesRector

Change `filter_var()` with slash escaping to `addslashes()`

- class: [`Rector\Php74\Rector\FuncCall\FilterVarToAddSlashesRector`](../rules/Php74/Rector/FuncCall/FilterVarToAddSlashesRector.php)

```diff
 $var= "Satya's here!";
-filter_var($var, FILTER_SANITIZE_MAGIC_QUOTES);
+addslashes($var);
```

<br>

### GetCalledClassToStaticClassRector

Change `get_called_class()` to static::class

- class: [`Rector\Php74\Rector\FuncCall\GetCalledClassToStaticClassRector`](../rules/Php74/Rector/FuncCall/GetCalledClassToStaticClassRector.php)

```diff
 class SomeClass
 {
    public function callOnMe()
    {
-       var_dump(get_called_class());
+       var_dump(static::class);
    }
 }
```

<br>

### MbStrrposEncodingArgumentPositionRector

Change `mb_strrpos()` encoding argument position

- class: [`Rector\Php74\Rector\FuncCall\MbStrrposEncodingArgumentPositionRector`](../rules/Php74/Rector/FuncCall/MbStrrposEncodingArgumentPositionRector.php)

```diff
-mb_strrpos($text, "abc", "UTF-8");
+mb_strrpos($text, "abc", 0, "UTF-8");
```

<br>

### NullCoalescingOperatorRector

Use null coalescing operator ??=

- class: [`Rector\Php74\Rector\Assign\NullCoalescingOperatorRector`](../rules/Php74/Rector/Assign/NullCoalescingOperatorRector.php)

```diff
 $array = [];
-$array['user_id'] = $array['user_id'] ?? 'value';
+$array['user_id'] ??= 'value';
```

<br>

### RealToFloatTypeCastRector

Change deprecated (real) to (float)

- class: [`Rector\Php74\Rector\Double\RealToFloatTypeCastRector`](../rules/Php74/Rector/Double/RealToFloatTypeCastRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $number = (real) 5;
+        $number = (float) 5;
         $number = (float) 5;
         $number = (double) 5;
     }
 }
```

<br>

### ReservedFnFunctionRector

Change `fn()` function name, since it will be reserved keyword

:wrench: **configure it!**

- class: [`Rector\Php74\Rector\Function_\ReservedFnFunctionRector`](../rules/Php74/Rector/Function_/ReservedFnFunctionRector.php)

```php
use Rector\Php74\Rector\Function_\ReservedFnFunctionRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ReservedFnFunctionRector::class)
        ->call('configure', [[
            ReservedFnFunctionRector::RESERVED_NAMES_TO_NEW_ONES => [
                'fn' => 'someFunctionName',

            ], ]]);
};
```

↓

```diff
 class SomeClass
 {
     public function run()
     {
-        function fn($value)
+        function f($value)
         {
             return $value;
         }

-        fn(5);
+        f(5);
     }
 }
```

<br>

### RestoreDefaultNullToNullableTypePropertyRector

Add null default to properties with PHP 7.4 property nullable type

- class: [`Rector\Php74\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector`](../rules/Php74/Rector/Property/RestoreDefaultNullToNullableTypePropertyRector.php)

```diff
 class SomeClass
 {
-    public ?string $name;
+    public ?string $name = null;
 }
```

<br>

### TypedPropertyRector

Changes property `@var` annotations from annotation to type.

:wrench: **configure it!**

- class: [`Rector\Php74\Rector\Property\TypedPropertyRector`](../rules/Php74/Rector/Property/TypedPropertyRector.php)

```php
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(TypedPropertyRector::class)
        ->call('configure', [[
            TypedPropertyRector::CLASS_LIKE_TYPE_ONLY => false,
        ]]);
};
```

↓

```diff
 final class SomeClass
 {
-    /**
-     * @var int
-     */
-    private count;
+    private int count;
 }
```

<br>

## Php80

### AnnotationToAttributeRector

Change annotation to attribute

:wrench: **configure it!**

- class: [`Rector\Php80\Rector\Class_\AnnotationToAttributeRector`](../rules/Php80/Rector/Class_/AnnotationToAttributeRector.php)

```php
use Rector\Php80\Rector\Class_\AnnotationToAttributeRector;
use Rector\Php80\ValueObject\AnnotationToAttribute;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(AnnotationToAttributeRector::class)
        ->call('configure', [[
            AnnotationToAttributeRector::ANNOTATION_TO_ATTRIBUTE => ValueObjectInliner::inline([
                new AnnotationToAttribute('Symfony\Component\Routing\Annotation\Route', null),
            ]),
        ]]);
};
```

↓

```diff
 use Symfony\Component\Routing\Annotation\Route;

 class SymfonyRoute
 {
-    /**
-     * @Route("/path", name="action")
-     */
+    #[Route(path: '/path', name: 'action')]
     public function action()
     {
     }
 }
```

<br>

### ChangeSwitchToMatchRector

Change `switch()` to `match()`

- class: [`Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector`](../rules/Php80/Rector/Switch_/ChangeSwitchToMatchRector.php)

```diff
-switch ($input) {
-    case Lexer::T_SELECT:
-        $statement = 'select';
-        break;
-    case Lexer::T_UPDATE:
-        $statement = 'update';
-        break;
-    default:
-        $statement = 'error';
-}
+$statement = match ($input) {
+    Lexer::T_SELECT => 'select',
+    Lexer::T_UPDATE => 'update',
+    default => 'error',
+};
```

<br>

### ClassOnObjectRector

Change get_class($object) to faster `$object::class`

- class: [`Rector\Php80\Rector\FuncCall\ClassOnObjectRector`](../rules/Php80/Rector/FuncCall/ClassOnObjectRector.php)

```diff
 class SomeClass
 {
     public function run($object)
     {
-        return get_class($object);
+        return $object::class;
     }
 }
```

<br>

### ClassPropertyAssignToConstructorPromotionRector

Change simple property init and assign to constructor promotion

- class: [`Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector`](../rules/Php80/Rector/Class_/ClassPropertyAssignToConstructorPromotionRector.php)

```diff
 class SomeClass
 {
-    public float $someVariable;
-
-    public function __construct(float $someVariable = 0.0)
+    public function __construct(private float $someVariable = 0.0)
     {
-        $this->someVariable = $someVariable;
     }
 }
```

<br>

### DoctrineAnnotationClassToAttributeRector

Refactor Doctrine `@annotation` annotated class to a PHP 8.0 attribute class

:wrench: **configure it!**

- class: [`Rector\Php80\Rector\Class_\DoctrineAnnotationClassToAttributeRector`](../rules/Php80/Rector/Class_/DoctrineAnnotationClassToAttributeRector.php)

```php
use Rector\Php80\Rector\Class_\DoctrineAnnotationClassToAttributeRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(DoctrineAnnotationClassToAttributeRector::class)
        ->call('configure', [[
            DoctrineAnnotationClassToAttributeRector::REMOVE_ANNOTATIONS => true,
        ]]);
};
```

↓

```diff
-use Doctrine\Common\Annotations\Annotation\Target;
+use Attribute;

-/**
- * @Annotation
- * @Target({"METHOD"})
- */
+#[Attribute(Attribute::TARGET_METHOD)]
 class SomeAnnotation
 {
 }
```

<br>

### FinalPrivateToPrivateVisibilityRector

Changes method visibility from final private to only private

- class: [`Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector`](../rules/Php80/Rector/ClassMethod/FinalPrivateToPrivateVisibilityRector.php)

```diff
 class SomeClass
 {
-    final private function getter() {
+    private function getter() {
         return $this;
     }
 }
```

<br>

### GetDebugTypeRector

Change ternary type resolve to `get_debug_type()`

- class: [`Rector\Php80\Rector\Ternary\GetDebugTypeRector`](../rules/Php80/Rector/Ternary/GetDebugTypeRector.php)

```diff
 class SomeClass
 {
     public function run($value)
     {
-        return is_object($value) ? get_class($value) : gettype($value);
+        return get_debug_type($value);
     }
 }
```

<br>

### NullsafeOperatorRector

Change if null check with nullsafe operator ?-> with full short circuiting

- class: [`Rector\Php80\Rector\If_\NullsafeOperatorRector`](../rules/Php80/Rector/If_/NullsafeOperatorRector.php)

```diff
 class SomeClass
 {
     public function run($someObject)
     {
-        $someObject2 = $someObject->mayFail1();
-        if ($someObject2 === null) {
-            return null;
-        }
-
-        return $someObject2->mayFail2();
+        return $someObject->mayFail1()?->mayFail2();
     }
 }
```

<br>

### OptionalParametersAfterRequiredRector

Move required parameters after optional ones

- class: [`Rector\Php80\Rector\ClassMethod\OptionalParametersAfterRequiredRector`](../rules/Php80/Rector/ClassMethod/OptionalParametersAfterRequiredRector.php)

```diff
 class SomeObject
 {
-    public function run($optional = 1, $required)
+    public function run($required, $optional = 1)
     {
     }
 }
```

<br>

### RemoveUnusedVariableInCatchRector

Remove unused variable in `catch()`

- class: [`Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector`](../rules/Php80/Rector/Catch_/RemoveUnusedVariableInCatchRector.php)

```diff
 final class SomeClass
 {
     public function run()
     {
         try {
-        } catch (Throwable $notUsedThrowable) {
+        } catch (Throwable) {
         }
     }
 }
```

<br>

### SetStateToStaticRector

Adds static visibility to `__set_state()` methods

- class: [`Rector\Php80\Rector\ClassMethod\SetStateToStaticRector`](../rules/Php80/Rector/ClassMethod/SetStateToStaticRector.php)

```diff
 class SomeClass
 {
-    public function __set_state($properties) {
+    public static function __set_state($properties) {

     }
 }
```

<br>

### StrContainsRector

Replace `strpos()` !== false and `strstr()`  with `str_contains()`

- class: [`Rector\Php80\Rector\NotIdentical\StrContainsRector`](../rules/Php80/Rector/NotIdentical/StrContainsRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        return strpos('abc', 'a') !== false;
+        return str_contains('abc', 'a');
     }
 }
```

<br>

### StrEndsWithRector

Change helper functions to `str_ends_with()`

- class: [`Rector\Php80\Rector\Identical\StrEndsWithRector`](../rules/Php80/Rector/Identical/StrEndsWithRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $isMatch = substr($haystack, -strlen($needle)) === $needle;
+        $isMatch = str_ends_with($haystack, $needle);
     }
 }
```

<br>

### StrStartsWithRector

Change helper functions to `str_starts_with()`

- class: [`Rector\Php80\Rector\Identical\StrStartsWithRector`](../rules/Php80/Rector/Identical/StrStartsWithRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        $isMatch = substr($haystack, 0, strlen($needle)) === $needle;
+        $isMatch = str_starts_with($haystack, $needle);

-        $isNotMatch = substr($haystack, 0, strlen($needle)) !== $needle;
+        $isNotMatch = ! str_starts_with($haystack, $needle);
     }
 }
```

<br>

### StringableForToStringRector

Add `Stringable` interface to classes with `__toString()` method

- class: [`Rector\Php80\Rector\Class_\StringableForToStringRector`](../rules/Php80/Rector/Class_/StringableForToStringRector.php)

```diff
-class SomeClass
+class SomeClass implements Stringable
 {
-    public function __toString()
+    public function __toString(): string
     {
         return 'I can stringz';
     }
 }
```

<br>

### TokenGetAllToObjectRector

Convert `token_get_all` to `PhpToken::getAll`

- class: [`Rector\Php80\Rector\FuncCall\TokenGetAllToObjectRector`](../rules/Php80/Rector/FuncCall/TokenGetAllToObjectRector.php)

```diff
 final class SomeClass
 {
     public function run()
     {
-        $tokens = token_get_all($code);
-        foreach ($tokens as $token) {
-            if (is_array($token)) {
-               $name = token_name($token[0]);
-               $text = $token[1];
-            } else {
-               $name = null;
-               $text = $token;
-            }
+        $tokens = \PhpToken::getAll($code);
+        foreach ($tokens as $phpToken) {
+           $name = $phpToken->getTokenName();
+           $text = $phpToken->text;
         }
     }
 }
```

<br>

### UnionTypesRector

Change docs types to union types, where possible (properties are covered by TypedPropertiesRector)

- class: [`Rector\Php80\Rector\FunctionLike\UnionTypesRector`](../rules/Php80/Rector/FunctionLike/UnionTypesRector.php)

```diff
 class SomeClass
 {
-    /**
-     * @param array|int $number
-     * @return bool|float
-     */
-    public function go($number)
+    public function go(array|int $number): bool|float
     {
     }
 }
```

<br>

## Php81

### MyCLabsClassToEnumRector

Refactor MyCLabs enum class to native Enum

- class: [`Rector\Php81\Rector\Class_\MyCLabsClassToEnumRector`](../rules/Php81/Rector/Class_/MyCLabsClassToEnumRector.php)

```diff
-use MyCLabs\Enum\Enum;
-
-final class Action extends Enum
+enum Action
 {
-    private const VIEW = 'view';
-    private const EDIT = 'edit';
+    case VIEW = 'view';
+    case EDIT = 'edit';
 }
```

<br>

### MyCLabsMethodCallToEnumConstRector

Refactor MyCLabs enum fetch to Enum const

- class: [`Rector\Php81\Rector\MethodCall\MyCLabsMethodCallToEnumConstRector`](../rules/Php81/Rector/MethodCall/MyCLabsMethodCallToEnumConstRector.php)

```diff
-$name = SomeEnum::VALUE()->getKey();
+$name = SomeEnum::VALUE;
```

<br>

## PhpSpecToPHPUnit

### AddMockPropertiesRector

Migrate PhpSpec behavior to PHPUnit test

- class: [`Rector\PhpSpecToPHPUnit\Rector\Class_\AddMockPropertiesRector`](../rules/PhpSpecToPHPUnit/Rector/Class_/AddMockPropertiesRector.php)

```diff
 namespace spec\SomeNamespaceForThisTest;

-use PhpSpec\ObjectBehavior;
-
 class OrderSpec extends ObjectBehavior
 {
-    public function let(OrderFactory $factory, ShippingMethod $shippingMethod): void
+    /**
+     * @var \SomeNamespaceForThisTest\Order
+     */
+    private $order;
+    protected function setUp()
     {
-        $factory->createShippingMethodFor(Argument::any())->shouldBeCalled()->willReturn($shippingMethod);
+        /** @var OrderFactory|\PHPUnit\Framework\MockObject\MockObject $factory */
+        $factory = $this->createMock(OrderFactory::class);
+
+        /** @var ShippingMethod|\PHPUnit\Framework\MockObject\MockObject $shippingMethod */
+        $shippingMethod = $this->createMock(ShippingMethod::class);
+
+        $factory->expects($this->once())->method('createShippingMethodFor')->willReturn($shippingMethod);
     }
 }
```

<br>

### MockVariableToPropertyFetchRector

Migrate PhpSpec behavior to PHPUnit test

- class: [`Rector\PhpSpecToPHPUnit\Rector\Variable\MockVariableToPropertyFetchRector`](../rules/PhpSpecToPHPUnit/Rector/Variable/MockVariableToPropertyFetchRector.php)

```diff
 namespace spec\SomeNamespaceForThisTest;

-use PhpSpec\ObjectBehavior;
-
 class OrderSpec extends ObjectBehavior
 {
-    public function let(OrderFactory $factory, ShippingMethod $shippingMethod): void
+    /**
+     * @var \SomeNamespaceForThisTest\Order
+     */
+    private $order;
+    protected function setUp()
     {
-        $factory->createShippingMethodFor(Argument::any())->shouldBeCalled()->willReturn($shippingMethod);
+        /** @var OrderFactory|\PHPUnit\Framework\MockObject\MockObject $factory */
+        $factory = $this->createMock(OrderFactory::class);
+
+        /** @var ShippingMethod|\PHPUnit\Framework\MockObject\MockObject $shippingMethod */
+        $shippingMethod = $this->createMock(ShippingMethod::class);
+
+        $factory->expects($this->once())->method('createShippingMethodFor')->willReturn($shippingMethod);
     }
 }
```

<br>

### PhpSpecClassToPHPUnitClassRector

Migrate PhpSpec behavior to PHPUnit test

- class: [`Rector\PhpSpecToPHPUnit\Rector\Class_\PhpSpecClassToPHPUnitClassRector`](../rules/PhpSpecToPHPUnit/Rector/Class_/PhpSpecClassToPHPUnitClassRector.php)

```diff
 namespace spec\SomeNamespaceForThisTest;

-use PhpSpec\ObjectBehavior;
-
 class OrderSpec extends ObjectBehavior
 {
-    public function let(OrderFactory $factory, ShippingMethod $shippingMethod): void
+    /**
+     * @var \SomeNamespaceForThisTest\Order
+     */
+    private $order;
+    protected function setUp()
     {
-        $factory->createShippingMethodFor(Argument::any())->shouldBeCalled()->willReturn($shippingMethod);
+        /** @var OrderFactory|\PHPUnit\Framework\MockObject\MockObject $factory */
+        $factory = $this->createMock(OrderFactory::class);
+
+        /** @var ShippingMethod|\PHPUnit\Framework\MockObject\MockObject $shippingMethod */
+        $shippingMethod = $this->createMock(ShippingMethod::class);
+
+        $factory->expects($this->once())->method('createShippingMethodFor')->willReturn($shippingMethod);
     }
 }
```

<br>

### PhpSpecMethodToPHPUnitMethodRector

Migrate PhpSpec behavior to PHPUnit test

- class: [`Rector\PhpSpecToPHPUnit\Rector\ClassMethod\PhpSpecMethodToPHPUnitMethodRector`](../rules/PhpSpecToPHPUnit/Rector/ClassMethod/PhpSpecMethodToPHPUnitMethodRector.php)

```diff
 namespace spec\SomeNamespaceForThisTest;

-use PhpSpec\ObjectBehavior;
-
 class OrderSpec extends ObjectBehavior
 {
-    public function let(OrderFactory $factory, ShippingMethod $shippingMethod): void
+    /**
+     * @var \SomeNamespaceForThisTest\Order
+     */
+    private $order;
+    protected function setUp()
     {
-        $factory->createShippingMethodFor(Argument::any())->shouldBeCalled()->willReturn($shippingMethod);
+        /** @var OrderFactory|\PHPUnit\Framework\MockObject\MockObject $factory */
+        $factory = $this->createMock(OrderFactory::class);
+
+        /** @var ShippingMethod|\PHPUnit\Framework\MockObject\MockObject $shippingMethod */
+        $shippingMethod = $this->createMock(ShippingMethod::class);
+
+        $factory->expects($this->once())->method('createShippingMethodFor')->willReturn($shippingMethod);
     }
 }
```

<br>

### PhpSpecMocksToPHPUnitMocksRector

Migrate PhpSpec behavior to PHPUnit test

- class: [`Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecMocksToPHPUnitMocksRector`](../rules/PhpSpecToPHPUnit/Rector/MethodCall/PhpSpecMocksToPHPUnitMocksRector.php)

```diff
 namespace spec\SomeNamespaceForThisTest;

-use PhpSpec\ObjectBehavior;
-
 class OrderSpec extends ObjectBehavior
 {
-    public function let(OrderFactory $factory, ShippingMethod $shippingMethod): void
+    /**
+     * @var \SomeNamespaceForThisTest\Order
+     */
+    private $order;
+    protected function setUp()
     {
-        $factory->createShippingMethodFor(Argument::any())->shouldBeCalled()->willReturn($shippingMethod);
+        /** @var OrderFactory|\PHPUnit\Framework\MockObject\MockObject $factory */
+        $factory = $this->createMock(OrderFactory::class);
+
+        /** @var ShippingMethod|\PHPUnit\Framework\MockObject\MockObject $shippingMethod */
+        $shippingMethod = $this->createMock(ShippingMethod::class);
+
+        $factory->expects($this->once())->method('createShippingMethodFor')->willReturn($shippingMethod);
     }
 }
```

<br>

### PhpSpecPromisesToPHPUnitAssertRector

Migrate PhpSpec behavior to PHPUnit test

- class: [`Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecPromisesToPHPUnitAssertRector`](../rules/PhpSpecToPHPUnit/Rector/MethodCall/PhpSpecPromisesToPHPUnitAssertRector.php)

```diff
 namespace spec\SomeNamespaceForThisTest;

-use PhpSpec\ObjectBehavior;
-
 class OrderSpec extends ObjectBehavior
 {
-    public function let(OrderFactory $factory, ShippingMethod $shippingMethod): void
+    /**
+     * @var \SomeNamespaceForThisTest\Order
+     */
+    private $order;
+    protected function setUp()
     {
-        $factory->createShippingMethodFor(Argument::any())->shouldBeCalled()->willReturn($shippingMethod);
+        /** @var OrderFactory|\PHPUnit\Framework\MockObject\MockObject $factory */
+        $factory = $this->createMock(OrderFactory::class);
+
+        /** @var ShippingMethod|\PHPUnit\Framework\MockObject\MockObject $shippingMethod */
+        $shippingMethod = $this->createMock(ShippingMethod::class);
+
+        $factory->expects($this->once())->method('createShippingMethodFor')->willReturn($shippingMethod);
     }
 }
```

<br>

### RenameSpecFileToTestFileRector

Rename "*Spec.php" file to "*Test.php" file

- class: [`Rector\PhpSpecToPHPUnit\Rector\Class_\RenameSpecFileToTestFileRector`](../rules/PhpSpecToPHPUnit/Rector/Class_/RenameSpecFileToTestFileRector.php)

```diff
-// tests/SomeSpec.php
+// tests/SomeTest.php
```

<br>

## PostRector

### ClassRenamingPostRector

Rename references for classes that were renamed during Rector run

- class: [`Rector\PostRector\Rector\ClassRenamingPostRector`](../packages/PostRector/Rector/ClassRenamingPostRector.php)

```diff
-function (OriginalClass $someClass)
+function (RenamedClass $someClass)
 {
 }
```

<br>

### NameImportingPostRector

Imports fully qualified names

- class: [`Rector\PostRector\Rector\NameImportingPostRector`](../packages/PostRector/Rector/NameImportingPostRector.php)

```diff
+use App\AnotherClass;
+
 class SomeClass
 {
-    public function run(App\AnotherClass $anotherClass)
+    public function run(AnotherClass $anotherClass)
     {
     }
 }
```

<br>

### NodeAddingPostRector

Add nodes on weird positions

- class: [`Rector\PostRector\Rector\NodeAddingPostRector`](../packages/PostRector/Rector/NodeAddingPostRector.php)

```diff
 class SomeClass
 {
     public function run($value)
     {
-        return 1;
+        if ($value) {
+            return 1;
+        }
     }
 }
```

<br>

### NodeRemovingPostRector

Remove nodes from weird positions

- class: [`Rector\PostRector\Rector\NodeRemovingPostRector`](../packages/PostRector/Rector/NodeRemovingPostRector.php)

```diff
 class SomeClass
 {
     public function run($value)
     {
-        if ($value) {
-            return 1;
-        }
+        return 1;
     }
 }
```

<br>

### NodeToReplacePostRector

Replaces nodes on weird positions

- class: [`Rector\PostRector\Rector\NodeToReplacePostRector`](../packages/PostRector/Rector/NodeToReplacePostRector.php)

```diff
 class SomeClass
 {
     public function run($value)
     {
-        return 1;
+        return $value;
     }
 }
```

<br>

### PropertyAddingPostRector

Add dependency properties

- class: [`Rector\PostRector\Rector\PropertyAddingPostRector`](../packages/PostRector/Rector/PropertyAddingPostRector.php)

```diff
 class SomeClass
 {
+    private $value;
     public function run()
     {
         return $this->value;
     }
 }
```

<br>

### UseAddingPostRector

Add unique use imports collected during Rector run

- class: [`Rector\PostRector\Rector\UseAddingPostRector`](../packages/PostRector/Rector/UseAddingPostRector.php)

```diff
+use App\AnotherClass;
+
 class SomeClass
 {
     public function run(AnotherClass $anotherClass)
     {
     }
 }
```

<br>

## Privatization

### ChangeGlobalVariablesToPropertiesRector

Change global `$variables` to private properties

- class: [`Rector\Privatization\Rector\ClassMethod\ChangeGlobalVariablesToPropertiesRector`](../rules/Privatization/Rector/ClassMethod/ChangeGlobalVariablesToPropertiesRector.php)

```diff
 class SomeClass
 {
+    private $variable;
     public function go()
     {
-        global $variable;
-        $variable = 5;
+        $this->variable = 5;
     }

     public function run()
     {
-        global $variable;
-        var_dump($variable);
+        var_dump($this->variable);
     }
 }
```

<br>

### ChangeLocalPropertyToVariableRector

Change local property used in single method to local variable

- class: [`Rector\Privatization\Rector\Class_\ChangeLocalPropertyToVariableRector`](../rules/Privatization/Rector/Class_/ChangeLocalPropertyToVariableRector.php)

```diff
 class SomeClass
 {
-    private $count;
     public function run()
     {
-        $this->count = 5;
-        return $this->count;
+        $count = 5;
+        return $count;
     }
 }
```

<br>

### ChangeReadOnlyPropertyWithDefaultValueToConstantRector

Change property with read only status with default value to constant

- class: [`Rector\Privatization\Rector\Property\ChangeReadOnlyPropertyWithDefaultValueToConstantRector`](../rules/Privatization/Rector/Property/ChangeReadOnlyPropertyWithDefaultValueToConstantRector.php)

```diff
 class SomeClass
 {
     /**
      * @var string[]
      */
-    private $magicMethods = [
+    private const MAGIC_METHODS = [
         '__toString',
         '__wakeup',
     ];

     public function run()
     {
-        foreach ($this->magicMethods as $magicMethod) {
+        foreach (self::MAGIC_METHODS as $magicMethod) {
             echo $magicMethod;
         }
     }
 }
```

<br>

### ChangeReadOnlyVariableWithDefaultValueToConstantRector

Change variable with read only status with default value to constant

- class: [`Rector\Privatization\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector`](../rules/Privatization/Rector/Class_/ChangeReadOnlyVariableWithDefaultValueToConstantRector.php)

```diff
 class SomeClass
 {
+    /**
+     * @var string[]
+     */
+    private const REPLACEMENTS = [
+        'PHPUnit\Framework\TestCase\Notice' => 'expectNotice',
+        'PHPUnit\Framework\TestCase\Deprecated' => 'expectDeprecation',
+    ];
+
     public function run()
     {
-        $replacements = [
-            'PHPUnit\Framework\TestCase\Notice' => 'expectNotice',
-            'PHPUnit\Framework\TestCase\Deprecated' => 'expectDeprecation',
-        ];
-
-        foreach ($replacements as $class => $method) {
+        foreach (self::REPLACEMENTS as $class => $method) {
         }
     }
 }
```

<br>

### FinalizeClassesWithoutChildrenRector

Finalize every class that has no children

- class: [`Rector\Privatization\Rector\Class_\FinalizeClassesWithoutChildrenRector`](../rules/Privatization/Rector/Class_/FinalizeClassesWithoutChildrenRector.php)

```diff
-class FirstClass
+final class FirstClass
 {
 }

 class SecondClass
 {
 }

-class ThirdClass extends SecondClass
+final class ThirdClass extends SecondClass
 {
 }
```

<br>

### PrivatizeFinalClassMethodRector

Change protected class method to private if possible

- class: [`Rector\Privatization\Rector\ClassMethod\PrivatizeFinalClassMethodRector`](../rules/Privatization/Rector/ClassMethod/PrivatizeFinalClassMethodRector.php)

```diff
 final class SomeClass
 {
-    protected function someMethod()
+    private function someMethod()
     {
     }
 }
```

<br>

### PrivatizeFinalClassPropertyRector

Change property to private if possible

- class: [`Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector`](../rules/Privatization/Rector/Property/PrivatizeFinalClassPropertyRector.php)

```diff
 final class SomeClass
 {
-    protected $value;
+    private $value;
 }
```

<br>

### PrivatizeLocalGetterToPropertyRector

Privatize getter of local property to property

- class: [`Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector`](../rules/Privatization/Rector/MethodCall/PrivatizeLocalGetterToPropertyRector.php)

```diff
 class SomeClass
 {
     private $some;

     public function run()
     {
-        return $this->getSome() + 5;
+        return $this->some + 5;
     }

     private function getSome()
     {
         return $this->some;
     }
 }
```

<br>

### PrivatizeLocalPropertyToPrivatePropertyRector

Privatize local-only property to private property

- class: [`Rector\Privatization\Rector\Property\PrivatizeLocalPropertyToPrivatePropertyRector`](../rules/Privatization/Rector/Property/PrivatizeLocalPropertyToPrivatePropertyRector.php)

```diff
 class SomeClass
 {
-    public $value;
+    private $value;

     public function run()
     {
         return $this->value;
     }
 }
```

<br>

### RepeatedLiteralToClassConstantRector

Replace repeated strings with constant

- class: [`Rector\Privatization\Rector\Class_\RepeatedLiteralToClassConstantRector`](../rules/Privatization/Rector/Class_/RepeatedLiteralToClassConstantRector.php)

```diff
 class SomeClass
 {
+    /**
+     * @var string
+     */
+    private const REQUIRES = 'requires';
     public function run($key, $items)
     {
-        if ($key === 'requires') {
-            return $items['requires'];
+        if ($key === self::REQUIRES) {
+            return $items[self::REQUIRES];
         }
     }
 }
```

<br>

### ReplaceStringWithClassConstantRector

Replace string values in specific method call by constant of provided class

:wrench: **configure it!**

- class: [`Rector\Privatization\Rector\MethodCall\ReplaceStringWithClassConstantRector`](../rules/Privatization/Rector/MethodCall/ReplaceStringWithClassConstantRector.php)

```php
use Rector\Privatization\Rector\MethodCall\ReplaceStringWithClassConstantRector;
use Rector\Privatization\ValueObject\ReplaceStringWithClassConstant;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ReplaceStringWithClassConstantRector::class)
        ->call('configure', [[
            ReplaceStringWithClassConstantRector::REPLACE_STRING_WITH_CLASS_CONSTANT => ValueObjectInliner::inline([
                new ReplaceStringWithClassConstant('SomeClass', 'call', 0, 'Placeholder'),
            ]),
        ]]);
};
```

↓

```diff
 class SomeClass
 {
     public function run()
     {
-        $this->call('name');
+        $this->call(Placeholder::NAME);
     }
 }
```

<br>

## Removing

### ArgumentRemoverRector

Removes defined arguments in defined methods and their calls.

:wrench: **configure it!**

- class: [`Rector\Removing\Rector\ClassMethod\ArgumentRemoverRector`](../rules/Removing/Rector/ClassMethod/ArgumentRemoverRector.php)

```php
use Rector\Removing\Rector\ClassMethod\ArgumentRemoverRector;
use Rector\Removing\ValueObject\ArgumentRemover;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ArgumentRemoverRector::class)
        ->call('configure', [[
            ArgumentRemoverRector::REMOVED_ARGUMENTS => ValueObjectInliner::inline([
                new ArgumentRemover('ExampleClass', 'someMethod', 0, 'true'),
            ]),
        ]]);
};
```

↓

```diff
 $someObject = new SomeClass;
-$someObject->someMethod(true);
+$someObject->someMethod();'
```

<br>

### RemoveFuncCallArgRector

Remove argument by position by function name

:wrench: **configure it!**

- class: [`Rector\Removing\Rector\FuncCall\RemoveFuncCallArgRector`](../rules/Removing/Rector/FuncCall/RemoveFuncCallArgRector.php)

```php
use Rector\Removing\Rector\FuncCall\RemoveFuncCallArgRector;
use Rector\Removing\ValueObject\RemoveFuncCallArg;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(RemoveFuncCallArgRector::class)
        ->call('configure', [[
            RemoveFuncCallArgRector::REMOVED_FUNCTION_ARGUMENTS => ValueObjectInliner::inline([
                new RemoveFuncCallArg('remove_last_arg', 1),
            ]),
        ]]);
};
```

↓

```diff
-remove_last_arg(1, 2);
+remove_last_arg(1);
```

<br>

### RemoveFuncCallRector

Remove ini_get by configuration

:wrench: **configure it!**

- class: [`Rector\Removing\Rector\FuncCall\RemoveFuncCallRector`](../rules/Removing/Rector/FuncCall/RemoveFuncCallRector.php)

```php
use Rector\Removing\Rector\FuncCall\RemoveFuncCallRector;
use Rector\Removing\ValueObject\RemoveFuncCall;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(RemoveFuncCallRector::class)
        ->call('configure', [[
            RemoveFuncCallRector::REMOVE_FUNC_CALLS => ValueObjectInliner::inline([
                new RemoveFuncCall('ini_get', [['y2k_compliance']]), ]
            ),
        ]]);
};
```

↓

```diff
-ini_get('y2k_compliance');
 ini_get('keep_me');
```

<br>

### RemoveInterfacesRector

Removes interfaces usage from class.

:wrench: **configure it!**

- class: [`Rector\Removing\Rector\Class_\RemoveInterfacesRector`](../rules/Removing/Rector/Class_/RemoveInterfacesRector.php)

```php
use Rector\Removing\Rector\Class_\RemoveInterfacesRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(RemoveInterfacesRector::class)
        ->call('configure', [[
            RemoveInterfacesRector::INTERFACES_TO_REMOVE => ['SomeInterface'],
        ]]);
};
```

↓

```diff
-class SomeClass implements SomeInterface
+class SomeClass
 {
 }
```

<br>

### RemoveParentRector

Removes extends class by name

:wrench: **configure it!**

- class: [`Rector\Removing\Rector\Class_\RemoveParentRector`](../rules/Removing/Rector/Class_/RemoveParentRector.php)

```php
use Rector\Removing\Rector\Class_\RemoveParentRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(RemoveParentRector::class)
        ->call('configure', [[
            RemoveParentRector::PARENT_TYPES_TO_REMOVE => ['SomeParentClass'],
        ]]);
};
```

↓

```diff
-final class SomeClass extends SomeParentClass
+final class SomeClass
 {
 }
```

<br>

### RemoveTraitRector

Remove specific traits from code

:wrench: **configure it!**

- class: [`Rector\Removing\Rector\Class_\RemoveTraitRector`](../rules/Removing/Rector/Class_/RemoveTraitRector.php)

```php
use Rector\Removing\Rector\Class_\RemoveTraitRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(RemoveTraitRector::class)
        ->call('configure', [[
            RemoveTraitRector::TRAITS_TO_REMOVE => ['TraitNameToRemove'],
        ]]);
};
```

↓

```diff
 class SomeClass
 {
-    use SomeTrait;
 }
```

<br>

## RemovingStatic

### DesiredClassTypeToDynamicRector

Change full static service, to dynamic one

- class: [`Rector\RemovingStatic\Rector\Class_\DesiredClassTypeToDynamicRector`](../rules/RemovingStatic/Rector/Class_/DesiredClassTypeToDynamicRector.php)

```diff
 class AnotherClass
 {
+    /**
+     * @var SomeClass
+     */
+    private $someClass;
+
+    public fuction __construct(SomeClass $someClass)
+    {
+        $this->someClass = $someClass;
+    }
+
     public function run()
     {
         SomeClass::someStatic();
     }
 }

 class SomeClass
 {
-    public static function run()
+    public function run()
     {
-        self::someStatic();
+        $this->someStatic();
     }

-    private static function someStatic()
+    private function someStatic()
     {
     }
 }
```

<br>

### DesiredPropertyClassMethodTypeToDynamicRector

Change defined static properties and methods to dynamic

- class: [`Rector\RemovingStatic\Rector\Property\DesiredPropertyClassMethodTypeToDynamicRector`](../rules/RemovingStatic/Rector/Property/DesiredPropertyClassMethodTypeToDynamicRector.php)

```diff
 final class SomeClass
 {
-    public static $name;
+    public $name;

-    public static function go()
+    public function go()
     {
     }
 }
```

<br>

### DesiredStaticCallTypeToDynamicRector

Change defined static service to dynamic one

- class: [`Rector\RemovingStatic\Rector\StaticCall\DesiredStaticCallTypeToDynamicRector`](../rules/RemovingStatic/Rector/StaticCall/DesiredStaticCallTypeToDynamicRector.php)

```diff
 final class SomeClass
 {
     public function run()
     {
-        SomeStaticMethod::someStatic();
+        $this->someStaticMethod::someStatic();
     }
 }
```

<br>

### DesiredStaticPropertyFetchTypeToDynamicRector

Change defined static service to dynamic one

- class: [`Rector\RemovingStatic\Rector\StaticPropertyFetch\DesiredStaticPropertyFetchTypeToDynamicRector`](../rules/RemovingStatic/Rector/StaticPropertyFetch/DesiredStaticPropertyFetchTypeToDynamicRector.php)

```diff
 final class SomeClass
 {
     public function run()
     {
-        SomeStaticMethod::$someStatic;
+        $this->someStaticMethod::$someStatic;
     }
 }
```

<br>

### LocallyCalledStaticMethodToNonStaticRector

Change static method and local-only calls to non-static

- class: [`Rector\RemovingStatic\Rector\ClassMethod\LocallyCalledStaticMethodToNonStaticRector`](../rules/RemovingStatic/Rector/ClassMethod/LocallyCalledStaticMethodToNonStaticRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        self::someStatic();
+        $this->someStatic();
     }

-    private static function someStatic()
+    private function someStatic()
     {
     }
 }
```

<br>

### NewUniqueObjectToEntityFactoryRector

Convert new X to new factories

:wrench: **configure it!**

- class: [`Rector\RemovingStatic\Rector\Class_\NewUniqueObjectToEntityFactoryRector`](../rules/RemovingStatic/Rector/Class_/NewUniqueObjectToEntityFactoryRector.php)

```php
use Rector\RemovingStatic\Rector\Class_\NewUniqueObjectToEntityFactoryRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(NewUniqueObjectToEntityFactoryRector::class)
        ->call('configure', [[
            NewUniqueObjectToEntityFactoryRector::TYPES_TO_SERVICES => ['ClassName'],
        ]]);
};
```

↓

```diff
-<?php
-
 class SomeClass
 {
+    public function __construct(AnotherClassFactory $anotherClassFactory)
+    {
+        $this->anotherClassFactory = $anotherClassFactory;
+    }
+
     public function run()
     {
-        return new AnotherClass;
+        return $this->anotherClassFactory->create();
     }
 }

 class AnotherClass
 {
     public function someFun()
     {
         return StaticClass::staticMethod();
     }
 }
```

<br>

### PHPUnitStaticToKernelTestCaseGetRector

Convert static calls in PHPUnit test cases, to `get()` from the container of KernelTestCase

:wrench: **configure it!**

- class: [`Rector\RemovingStatic\Rector\Class_\PHPUnitStaticToKernelTestCaseGetRector`](../rules/RemovingStatic/Rector/Class_/PHPUnitStaticToKernelTestCaseGetRector.php)

```php
use Rector\RemovingStatic\Rector\Class_\PHPUnitStaticToKernelTestCaseGetRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(PHPUnitStaticToKernelTestCaseGetRector::class)
        ->call('configure', [[
            PHPUnitStaticToKernelTestCaseGetRector::STATIC_CLASS_TYPES => ['EntityFactory'],
        ]]);
};
```

↓

```diff
-<?php
+use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

-use PHPUnit\Framework\TestCase;
+final class SomeTestCase extends KernelTestCase
+{
+    /**
+     * @var EntityFactory
+     */
+    private $entityFactory;

-final class SomeTestCase extends TestCase
-{
+    protected function setUp(): void
+    {
+        parent::setUp();
+        $this->entityFactory = $this->getService(EntityFactory::class);
+    }
+
     public function test()
     {
-        $product = EntityFactory::create('product');
+        $product = $this->entityFactory->create('product');
     }
 }
```

<br>

### PassFactoryToUniqueObjectRector

Convert new `X/Static::call()` to factories in entities, pass them via constructor to each other

:wrench: **configure it!**

- class: [`Rector\RemovingStatic\Rector\Class_\PassFactoryToUniqueObjectRector`](../rules/RemovingStatic/Rector/Class_/PassFactoryToUniqueObjectRector.php)

```php
use Rector\RemovingStatic\Rector\Class_\PassFactoryToUniqueObjectRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(PassFactoryToUniqueObjectRector::class)
        ->call('configure', [[
            PassFactoryToUniqueObjectRector::TYPES_TO_SERVICES => ['StaticClass'],
        ]]);
};
```

↓

```diff
-<?php
-
 class SomeClass
 {
+    public function __construct(AnotherClassFactory $anotherClassFactory)
+    {
+        $this->anotherClassFactory = $anotherClassFactory;
+    }
+
     public function run()
     {
-        return new AnotherClass;
+        return $this->anotherClassFactory->create();
     }
 }

 class AnotherClass
 {
+    public function __construct(StaticClass $staticClass)
+    {
+        $this->staticClass = $staticClass;
+    }
+
     public function someFun()
     {
-        return StaticClass::staticMethod();
+        return $this->staticClass->staticMethod();
+    }
+}
+
+final class AnotherClassFactory
+{
+    /**
+     * @var StaticClass
+     */
+    private $staticClass;
+
+    public function __construct(StaticClass $staticClass)
+    {
+        $this->staticClass = $staticClass;
+    }
+
+    public function create(): AnotherClass
+    {
+        return new AnotherClass($this->staticClass);
     }
 }
```

<br>

### StaticTypeToSetterInjectionRector

Changes types to setter injection

:wrench: **configure it!**

- class: [`Rector\RemovingStatic\Rector\Class_\StaticTypeToSetterInjectionRector`](../rules/RemovingStatic/Rector/Class_/StaticTypeToSetterInjectionRector.php)

```php
use Rector\RemovingStatic\Rector\Class_\StaticTypeToSetterInjectionRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(StaticTypeToSetterInjectionRector::class)
        ->call('configure', [[
            StaticTypeToSetterInjectionRector::STATIC_TYPES => ['SomeStaticClass'],
        ]]);
};
```

↓

```diff
 <?php

 final class CheckoutEntityFactory
 {
+    /**
+     * @var SomeStaticClass
+     */
+    private $someStaticClass;
+
+    public function setSomeStaticClass(SomeStaticClass $someStaticClass)
+    {
+        $this->someStaticClass = $someStaticClass;
+    }
+
     public function run()
     {
-        return SomeStaticClass::go();
+        return $this->someStaticClass->go();
     }
 }
```

<br>

## Renaming

### PseudoNamespaceToNamespaceRector

Replaces defined Pseudo_Namespaces by Namespace\Ones.

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector`](../rules/Renaming/Rector/FileWithoutNamespace/PseudoNamespaceToNamespaceRector.php)

```php
use Rector\Renaming\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector;
use Rector\Renaming\ValueObject\PseudoNamespaceToNamespace;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(PseudoNamespaceToNamespaceRector::class)
        ->call('configure', [[
            PseudoNamespaceToNamespaceRector::NAMESPACE_PREFIXES_WITH_EXCLUDED_CLASSES => ValueObjectInliner::inline([
                new PseudoNamespaceToNamespace('Some_', ['Some_Class_To_Keep']), ]
            ),
        ]]);
};
```

↓

```diff
-/** @var Some_Chicken $someService */
-$someService = new Some_Chicken;
+/** @var Some\Chicken $someService */
+$someService = new Some\Chicken;
 $someClassToKeep = new Some_Class_To_Keep;
```

<br>

### RenameAnnotationRector

Turns defined annotations above properties and methods to their new values.

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector`](../rules/Renaming/Rector/ClassMethod/RenameAnnotationRector.php)

```php
use Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector;
use Rector\Renaming\ValueObject\RenameAnnotation;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(RenameAnnotationRector::class)
        ->call('configure', [[
            RenameAnnotationRector::RENAMED_ANNOTATIONS_IN_TYPES => ValueObjectInliner::inline([
                new RenameAnnotation('PHPUnit\Framework\TestCase', 'test', 'scenario'),
            ]),
        ]]);
};
```

↓

```diff
 class SomeTest extends PHPUnit\Framework\TestCase
 {
     /**
-     * @test
+     * @scenario
      */
     public function someMethod()
     {
     }
 }
```

<br>

### RenameClassConstFetchRector

Replaces defined class constants in their calls.

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector`](../rules/Renaming/Rector/ClassConstFetch/RenameClassConstFetchRector.php)

```php
use Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector;
use Rector\Renaming\ValueObject\RenameClassAndConstFetch;
use Rector\Renaming\ValueObject\RenameClassConstFetch;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(RenameClassConstFetchRector::class)
        ->call('configure', [[
            RenameClassConstFetchRector::CLASS_CONSTANT_RENAME => ValueObjectInliner::inline([
                new RenameClassConstFetch('SomeClass', 'OLD_CONSTANT', 'NEW_CONSTANT'),
                new RenameClassAndConstFetch('SomeClass', 'OTHER_OLD_CONSTANT', 'DifferentClass', 'NEW_CONSTANT'),
            ]),
        ]]);
};
```

↓

```diff
-$value = SomeClass::OLD_CONSTANT;
-$value = SomeClass::OTHER_OLD_CONSTANT;
+$value = SomeClass::NEW_CONSTANT;
+$value = DifferentClass::NEW_CONSTANT;
```

<br>

### RenameClassRector

Replaces defined classes by new ones.

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\Name\RenameClassRector`](../rules/Renaming/Rector/Name/RenameClassRector.php)

```php
use Rector\Renaming\Rector\Name\RenameClassRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(RenameClassRector::class)
        ->call('configure', [[
            RenameClassRector::OLD_TO_NEW_CLASSES => [
                'App\SomeOldClass' => 'App\SomeNewClass',

            ], ]]);
};
```

↓

```diff
 namespace App;

-use SomeOldClass;
+use SomeNewClass;

-function someFunction(SomeOldClass $someOldClass): SomeOldClass
+function someFunction(SomeNewClass $someOldClass): SomeNewClass
 {
-    if ($someOldClass instanceof SomeOldClass) {
-        return new SomeOldClass;
+    if ($someOldClass instanceof SomeNewClass) {
+        return new SomeNewClass;
     }
 }
```

<br>

### RenameConstantRector

Replace constant by new ones

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\ConstFetch\RenameConstantRector`](../rules/Renaming/Rector/ConstFetch/RenameConstantRector.php)

```php
use Rector\Renaming\Rector\ConstFetch\RenameConstantRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(RenameConstantRector::class)
        ->call('configure', [[
            RenameConstantRector::OLD_TO_NEW_CONSTANTS => [
                'MYSQL_ASSOC' => 'MYSQLI_ASSOC',
                'OLD_CONSTANT' => 'NEW_CONSTANT',

            ], ]]);
};
```

↓

```diff
 final class SomeClass
 {
     public function run()
     {
-        return MYSQL_ASSOC;
+        return MYSQLI_ASSOC;
     }
 }
```

<br>

### RenameFunctionRector

Turns defined function call new one.

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\FuncCall\RenameFunctionRector`](../rules/Renaming/Rector/FuncCall/RenameFunctionRector.php)

```php
use Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(RenameFunctionRector::class)
        ->call('configure', [[
            RenameFunctionRector::OLD_FUNCTION_TO_NEW_FUNCTION => [
                'view' => 'Laravel\Templating\render',

            ], ]]);
};
```

↓

```diff
-view("...", []);
+Laravel\Templating\render("...", []);
```

<br>

### RenameMethodRector

Turns method names to new ones.

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\MethodCall\RenameMethodRector`](../rules/Renaming/Rector/MethodCall/RenameMethodRector.php)

```php
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(RenameMethodRector::class)
        ->call('configure', [[
            RenameMethodRector::METHOD_CALL_RENAMES => ValueObjectInliner::inline([
                new MethodCallRename('SomeExampleClass', 'oldMethod', 'newMethod'),
            ]),
        ]]);
};
```

↓

```diff
 $someObject = new SomeExampleClass;
-$someObject->oldMethod();
+$someObject->newMethod();
```

<br>

### RenameNamespaceRector

Replaces old namespace by new one.

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\Namespace_\RenameNamespaceRector`](../rules/Renaming/Rector/Namespace_/RenameNamespaceRector.php)

```php
use Rector\Renaming\Rector\Namespace_\RenameNamespaceRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(RenameNamespaceRector::class)
        ->call('configure', [[
            RenameNamespaceRector::OLD_TO_NEW_NAMESPACES => [
                'SomeOldNamespace' => 'SomeNewNamespace',

            ], ]]);
};
```

↓

```diff
-$someObject = new SomeOldNamespace\SomeClass;
+$someObject = new SomeNewNamespace\SomeClass;
```

<br>

### RenamePropertyRector

Replaces defined old properties by new ones.

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector`](../rules/Renaming/Rector/PropertyFetch/RenamePropertyRector.php)

```php
use Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use Rector\Renaming\ValueObject\RenameProperty;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(RenamePropertyRector::class)
        ->call('configure', [[
            RenamePropertyRector::RENAMED_PROPERTIES => ValueObjectInliner::inline([
                new RenameProperty('SomeClass', 'someOldProperty', 'someNewProperty'),
            ]),
        ]]);
};
```

↓

```diff
-$someObject->someOldProperty;
+$someObject->someNewProperty;
```

<br>

### RenameStaticMethodRector

Turns method names to new ones.

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector`](../rules/Renaming/Rector/StaticCall/RenameStaticMethodRector.php)

```php
use Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector;
use Rector\Renaming\ValueObject\RenameStaticMethod;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(RenameStaticMethodRector::class)
        ->call('configure', [[
            RenameStaticMethodRector::OLD_TO_NEW_METHODS_BY_CLASSES => ValueObjectInliner::inline([
                new RenameStaticMethod('SomeClass', 'oldMethod', 'AnotherExampleClass', 'newStaticMethod'),
            ]),
        ]]);
};
```

↓

```diff
-SomeClass::oldStaticMethod();
+AnotherExampleClass::newStaticMethod();
```

<br>

```php
use Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector;
use Rector\Renaming\ValueObject\RenameStaticMethod;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(RenameStaticMethodRector::class)
        ->call('configure', [[
            RenameStaticMethodRector::OLD_TO_NEW_METHODS_BY_CLASSES => ValueObjectInliner::inline([
                new RenameStaticMethod('SomeClass', 'oldMethod', 'SomeClass', 'newStaticMethod'),
            ]),
        ]]);
};
```

↓

```diff
-SomeClass::oldStaticMethod();
+SomeClass::newStaticMethod();
```

<br>

### RenameStringRector

Change string value

:wrench: **configure it!**

- class: [`Rector\Renaming\Rector\String_\RenameStringRector`](../rules/Renaming/Rector/String_/RenameStringRector.php)

```php
use Rector\Renaming\Rector\String_\RenameStringRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(RenameStringRector::class)
        ->call('configure', [[
            RenameStringRector::STRING_CHANGES => [
                'ROLE_PREVIOUS_ADMIN' => 'IS_IMPERSONATOR',

            ], ]]);
};
```

↓

```diff
 class SomeClass
 {
     public function run()
     {
-        return 'ROLE_PREVIOUS_ADMIN';
+        return 'IS_IMPERSONATOR';
     }
 }
```

<br>

## Restoration

### CompleteImportForPartialAnnotationRector

In case you have accidentally removed use imports but code still contains partial use statements, this will save you

:wrench: **configure it!**

- class: [`Rector\Restoration\Rector\Namespace_\CompleteImportForPartialAnnotationRector`](../rules/Restoration/Rector/Namespace_/CompleteImportForPartialAnnotationRector.php)

```php
use Rector\Restoration\Rector\Namespace_\CompleteImportForPartialAnnotationRector;
use Rector\Restoration\ValueObject\CompleteImportForPartialAnnotation;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(CompleteImportForPartialAnnotationRector::class)
        ->call('configure', [[
            CompleteImportForPartialAnnotationRector::USE_IMPORTS_TO_RESTORE => ValueObjectInliner::inline([
                new CompleteImportForPartialAnnotation('Doctrine\ORM\Mapping', 'ORM'),
            ]),
        ]]);
};
```

↓

```diff
+use Doctrine\ORM\Mapping as ORM;
+
 class SomeClass
 {
     /**
      * @ORM\Id
      */
     public $id;
 }
```

<br>

### CompleteMissingDependencyInNewRector

Complete missing constructor dependency instance by type

:wrench: **configure it!**

- class: [`Rector\Restoration\Rector\New_\CompleteMissingDependencyInNewRector`](../rules/Restoration/Rector/New_/CompleteMissingDependencyInNewRector.php)

```php
use Rector\Restoration\Rector\New_\CompleteMissingDependencyInNewRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(CompleteMissingDependencyInNewRector::class)
        ->call('configure', [[
            CompleteMissingDependencyInNewRector::CLASS_TO_INSTANTIATE_BY_TYPE => [
                'RandomDependency' => 'RandomDependency',

            ], ]]);
};
```

↓

```diff
 final class SomeClass
 {
     public function run()
     {
-        $valueObject = new RandomValueObject();
+        $valueObject = new RandomValueObject(new RandomDependency());
     }
 }

 class RandomValueObject
 {
     public function __construct(RandomDependency $randomDependency)
     {
     }
 }
```

<br>

### InferParamFromClassMethodReturnRector

Change `@param` doc based on another method return type

:wrench: **configure it!**

- class: [`Rector\Restoration\Rector\ClassMethod\InferParamFromClassMethodReturnRector`](../rules/Restoration/Rector/ClassMethod/InferParamFromClassMethodReturnRector.php)

```php
use Rector\Restoration\Rector\ClassMethod\InferParamFromClassMethodReturnRector;
use Rector\Restoration\ValueObject\InferParamFromClassMethodReturn;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(InferParamFromClassMethodReturnRector::class)
        ->call('configure', [[
            InferParamFromClassMethodReturnRector::INFER_PARAMS_FROM_CLASS_METHOD_RETURNS => ValueObjectInliner::inline([
                new InferParamFromClassMethodReturn('SomeClass', 'process', 'getNodeTypes'),
            ]),
        ]]);
};
```

↓

```diff
 class SomeClass
 {
     public function getNodeTypes(): array
     {
         return [String_::class];
     }

+    /**
+     * @param String_ $node
+     */
     public function process(Node $node)
     {
     }
 }
```

<br>

### MakeTypedPropertyNullableIfCheckedRector

Make typed property nullable if checked

- class: [`Rector\Restoration\Rector\Property\MakeTypedPropertyNullableIfCheckedRector`](../rules/Restoration/Rector/Property/MakeTypedPropertyNullableIfCheckedRector.php)

```diff
 final class SomeClass
 {
-    private AnotherClass $anotherClass;
+    private ?AnotherClass $anotherClass = null;

     public function run()
     {
         if ($this->anotherClass === null) {
             $this->anotherClass = new AnotherClass;
         }
     }
 }
```

<br>

### MissingClassConstantReferenceToStringRector

Convert missing class reference to string

- class: [`Rector\Restoration\Rector\ClassConstFetch\MissingClassConstantReferenceToStringRector`](../rules/Restoration/Rector/ClassConstFetch/MissingClassConstantReferenceToStringRector.php)

```diff
 class SomeClass
 {
     public function run()
     {
-        return NonExistingClass::class;
+        return 'NonExistingClass';
     }
 }
```

<br>

### RemoveFinalFromEntityRector

Remove final from Doctrine entities

- class: [`Rector\Restoration\Rector\Class_\RemoveFinalFromEntityRector`](../rules/Restoration/Rector/Class_/RemoveFinalFromEntityRector.php)

```diff
 use Doctrine\ORM\Mapping as ORM;

 /**
  * @ORM\Entity
  */
-final class SomeClass
+class SomeClass
 {
 }
```

<br>

### UpdateFileNameByClassNameFileSystemRector

Rename file to respect class name

- class: [`Rector\Restoration\Rector\ClassLike\UpdateFileNameByClassNameFileSystemRector`](../rules/Restoration/Rector/ClassLike/UpdateFileNameByClassNameFileSystemRector.php)

```diff
-// app/SomeClass.php
+// app/AnotherClass.php
 class AnotherClass
 {
 }
```

<br>

## Transform

### AddInterfaceByParentRector

Add interface by parent

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\Class_\AddInterfaceByParentRector`](../rules/Transform/Rector/Class_/AddInterfaceByParentRector.php)

```php
use Rector\Transform\Rector\Class_\AddInterfaceByParentRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(AddInterfaceByParentRector::class)
        ->call('configure', [[
            AddInterfaceByParentRector::INTERFACE_BY_PARENT => [
                'SomeParent' => 'SomeInterface',

            ], ]]);
};
```

↓

```diff
-class SomeClass extends SomeParent
+class SomeClass extends SomeParent implements SomeInterface
 {

 }
```

<br>

### AddInterfaceByTraitRector

Add interface by used trait

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\Class_\AddInterfaceByTraitRector`](../rules/Transform/Rector/Class_/AddInterfaceByTraitRector.php)

```php
use Rector\Transform\Rector\Class_\AddInterfaceByTraitRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(AddInterfaceByTraitRector::class)
        ->call('configure', [[
            AddInterfaceByTraitRector::INTERFACE_BY_TRAIT => [
                'SomeTrait' => 'SomeInterface',

            ], ]]);
};
```

↓

```diff
-class SomeClass
+class SomeClass implements SomeInterface
 {
     use SomeTrait;
 }
```

<br>

### ArgumentFuncCallToMethodCallRector

Move help facade-like function calls to constructor injection

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector`](../rules/Transform/Rector/FuncCall/ArgumentFuncCallToMethodCallRector.php)

```php
use Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector;
use Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ArgumentFuncCallToMethodCallRector::class)
        ->call('configure', [[
            ArgumentFuncCallToMethodCallRector::FUNCTIONS_TO_METHOD_CALLS => ValueObjectInliner::inline([
                new ArgumentFuncCallToMethodCall('view', 'Illuminate\Contracts\View\Factory', 'make', null),
            ]),
        ]]);
};
```

↓

```diff
 class SomeController
 {
+    /**
+     * @var \Illuminate\Contracts\View\Factory
+     */
+    private $viewFactory;
+
+    public function __construct(\Illuminate\Contracts\View\Factory $viewFactory)
+    {
+        $this->viewFactory = $viewFactory;
+    }
+
     public function action()
     {
-        $template = view('template.blade');
-        $viewFactory = view();
+        $template = $this->viewFactory->make('template.blade');
+        $viewFactory = $this->viewFactory;
     }
 }
```

<br>

### CallableInMethodCallToVariableRector

Change a callable in method call to standalone variable assign

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\MethodCall\CallableInMethodCallToVariableRector`](../rules/Transform/Rector/MethodCall/CallableInMethodCallToVariableRector.php)

```php
use Rector\Transform\Rector\MethodCall\CallableInMethodCallToVariableRector;
use Rector\Transform\ValueObject\CallableInMethodCallToVariable;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(CallableInMethodCallToVariableRector::class)
        ->call('configure', [[
            CallableInMethodCallToVariableRector::CALLABLE_IN_METHOD_CALL_TO_VARIABLE => ValueObjectInliner::inline([
                new CallableInMethodCallToVariable('Nette\Caching\Cache', 'save', 1),
            ]),
        ]]);
};
```

↓

```diff
 final class SomeClass
 {
     public function run()
     {
         /** @var \Nette\Caching\Cache $cache */
-        $cache->save($key, function () use ($container) {
-            return 100;
-        });
+        $result = 100;
+        $cache->save($key, $result);
     }
 }
```

<br>

### ChangeSingletonToServiceRector

Change singleton class to normal class that can be registered as a service

- class: [`Rector\Transform\Rector\Class_\ChangeSingletonToServiceRector`](../rules/Transform/Rector/Class_/ChangeSingletonToServiceRector.php)

```diff
 class SomeClass
 {
-    private static $instance;
-
-    private function __construct()
+    public function __construct()
     {
-    }
-
-    public static function getInstance()
-    {
-        if (null === static::$instance) {
-            static::$instance = new static();
-        }
-
-        return static::$instance;
     }
 }
```

<br>

### ClassConstFetchToValueRector

Replaces constant by value

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\ClassConstFetch\ClassConstFetchToValueRector`](../rules/Transform/Rector/ClassConstFetch/ClassConstFetchToValueRector.php)

```php
use Rector\Transform\Rector\ClassConstFetch\ClassConstFetchToValueRector;
use Rector\Transform\ValueObject\ClassConstFetchToValue;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ClassConstFetchToValueRector::class)
        ->call('configure', [[
            ClassConstFetchToValueRector::CLASS_CONST_FETCHES_TO_VALUES => ValueObjectInliner::inline([
                new ClassConstFetchToValue('Nette\Configurator', 'DEVELOPMENT', 'development'),
                new ClassConstFetchToValue('Nette\Configurator', 'PRODUCTION', 'production'),
            ]),
        ]]);
};
```

↓

```diff
-$value === Nette\Configurator::DEVELOPMENT
+$value === "development"
```

<br>

### DimFetchAssignToMethodCallRector

Change magic array access add to `$list[],` to explicit `$list->addMethod(...)`

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\Assign\DimFetchAssignToMethodCallRector`](../rules/Transform/Rector/Assign/DimFetchAssignToMethodCallRector.php)

```php
use Rector\Transform\Rector\Assign\DimFetchAssignToMethodCallRector;
use Rector\Transform\ValueObject\DimFetchAssignToMethodCall;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(DimFetchAssignToMethodCallRector::class)
        ->call('configure', [[
            DimFetchAssignToMethodCallRector::DIM_FETCH_ASSIGN_TO_METHOD_CALL => ValueObjectInliner::inline([
                new DimFetchAssignToMethodCall(
                    'Nette\Application\Routers\RouteList',
                    'Nette\Application\Routers\Route',
                    'addRoute'
                ),
            ]),
        ]]);
};
```

↓

```diff
-use Nette\Application\Routers\Route;
 use Nette\Application\Routers\RouteList;

 class RouterFactory
 {
     public static function createRouter()
     {
         $routeList = new RouteList();
-        $routeList[] = new Route('...');
+        $routeList->addRoute('...');
     }
 }
```

<br>

### FuncCallToConstFetchRector

Changes use of function calls to use constants

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\FuncCall\FuncCallToConstFetchRector`](../rules/Transform/Rector/FuncCall/FuncCallToConstFetchRector.php)

```php
use Rector\Transform\Rector\FuncCall\FuncCallToConstFetchRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(FuncCallToConstFetchRector::class)
        ->call('configure', [[
            FuncCallToConstFetchRector::FUNCTIONS_TO_CONSTANTS => [
                'php_sapi_name' => 'PHP_SAPI',

            ], ]]);
};
```

↓

```diff
 class SomeClass
 {
     public function run()
     {
-        $value = php_sapi_name();
+        $value = PHP_SAPI;
     }
 }
```

<br>

### FuncCallToMethodCallRector

Turns defined function calls to local method calls.

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector`](../rules/Transform/Rector/FuncCall/FuncCallToMethodCallRector.php)

```php
use Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector;
use Rector\Transform\ValueObject\FuncCallToMethodCall;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(FuncCallToMethodCallRector::class)
        ->call('configure', [[
            FuncCallToMethodCallRector::FUNC_CALL_TO_CLASS_METHOD_CALL => ValueObjectInliner::inline([
                new FuncCallToMethodCall('view', 'Namespaced\SomeRenderer', 'render'),
            ]),
        ]]);
};
```

↓

```diff
 class SomeClass
 {
+    /**
+     * @var \Namespaced\SomeRenderer
+     */
+    private $someRenderer;
+
+    public function __construct(\Namespaced\SomeRenderer $someRenderer)
+    {
+        $this->someRenderer = $someRenderer;
+    }
+
     public function run()
     {
-        view('...');
+        $this->someRenderer->view('...');
     }
 }
```

<br>

### FuncCallToNewRector

Change configured function calls to new Instance

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\FuncCall\FuncCallToNewRector`](../rules/Transform/Rector/FuncCall/FuncCallToNewRector.php)

```php
use Rector\Transform\Rector\FuncCall\FuncCallToNewRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(FuncCallToNewRector::class)
        ->call('configure', [[
            FuncCallToNewRector::FUNCTIONS_TO_NEWS => [
                'collection' => ['Collection'],

            ], ]]);
};
```

↓

```diff
 class SomeClass
 {
     public function run()
     {
-        $array = collection([]);
+        $array = new \Collection([]);
     }
 }
```

<br>

### FuncCallToStaticCallRector

Turns defined function call to static method call.

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\FuncCall\FuncCallToStaticCallRector`](../rules/Transform/Rector/FuncCall/FuncCallToStaticCallRector.php)

```php
use Rector\Transform\Rector\FuncCall\FuncCallToStaticCallRector;
use Rector\Transform\ValueObject\FuncCallToStaticCall;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(FuncCallToStaticCallRector::class)
        ->call('configure', [[
            FuncCallToStaticCallRector::FUNC_CALLS_TO_STATIC_CALLS => ValueObjectInliner::inline([
                new FuncCallToStaticCall('view', 'SomeStaticClass', 'render'),
            ]),
        ]]);
};
```

↓

```diff
-view("...", []);
+SomeClass::render("...", []);
```

<br>

### FunctionToStaticMethodRector

Change functions to static calls, so composer can autoload them

- class: [`Rector\Transform\Rector\FileWithoutNamespace\FunctionToStaticMethodRector`](../rules/Transform/Rector/FileWithoutNamespace/FunctionToStaticMethodRector.php)

```diff
-function some_function()
+class SomeUtilsClass
 {
+    public static function someFunction()
+    {
+    }
 }

-some_function('lol');
+SomeUtilsClass::someFunction('lol');
```

<br>

### GetAndSetToMethodCallRector

Turns defined `__get`/`__set` to specific method calls.

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\Assign\GetAndSetToMethodCallRector`](../rules/Transform/Rector/Assign/GetAndSetToMethodCallRector.php)

```php
use Rector\Transform\Rector\Assign\GetAndSetToMethodCallRector;
use Rector\Transform\ValueObject\GetAndSetToMethodCall;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(GetAndSetToMethodCallRector::class)
        ->call('configure', [[
            GetAndSetToMethodCallRector::TYPE_TO_METHOD_CALLS => ValueObjectInliner::inline([
                new GetAndSetToMethodCall('SomeContainer', 'addService', 'getService'),
            ]),
        ]]);
};
```

↓

```diff
 $container = new SomeContainer;
-$container->someService = $someService;
+$container->setService("someService", $someService);
```

<br>

### MergeInterfacesRector

Merges old interface to a new one, that already has its methods

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\Class_\MergeInterfacesRector`](../rules/Transform/Rector/Class_/MergeInterfacesRector.php)

```php
use Rector\Transform\Rector\Class_\MergeInterfacesRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(MergeInterfacesRector::class)
        ->call('configure', [[
            MergeInterfacesRector::OLD_TO_NEW_INTERFACES => [
                'SomeOldInterface' => 'SomeInterface',

            ], ]]);
};
```

↓

```diff
-class SomeClass implements SomeInterface, SomeOldInterface
+class SomeClass implements SomeInterface
 {
 }
```

<br>

### MethodCallToAnotherMethodCallWithArgumentsRector

Turns old method call with specific types to new one with arguments

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\MethodCall\MethodCallToAnotherMethodCallWithArgumentsRector`](../rules/Transform/Rector/MethodCall/MethodCallToAnotherMethodCallWithArgumentsRector.php)

```php
use Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey;
use Rector\Transform\Rector\MethodCall\MethodCallToAnotherMethodCallWithArgumentsRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(MethodCallToAnotherMethodCallWithArgumentsRector::class)
        ->call('configure', [[
            MethodCallToAnotherMethodCallWithArgumentsRector::METHOD_CALL_RENAMES_WITH_ADDED_ARGUMENTS => ValueObjectInliner::inline([
                new MethodCallRenameWithArrayKey('Nette\DI\ServiceDefinition', 'setInject', 'addTag', 'inject'),
            ]),
        ]]);
};
```

↓

```diff
 $serviceDefinition = new Nette\DI\ServiceDefinition;
-$serviceDefinition->setInject();
+$serviceDefinition->addTag('inject');
```

<br>

### MethodCallToPropertyFetchRector

Turns method call `"$this->something()"` to property fetch "$this->something"

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\MethodCall\MethodCallToPropertyFetchRector`](../rules/Transform/Rector/MethodCall/MethodCallToPropertyFetchRector.php)

```php
use Rector\Transform\Rector\MethodCall\MethodCallToPropertyFetchRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(MethodCallToPropertyFetchRector::class)
        ->call('configure', [[
            MethodCallToPropertyFetchRector::METHOD_CALL_TO_PROPERTY_FETCHES => [
                'someMethod' => 'someProperty',

            ], ]]);
};
```

↓

```diff
 class SomeClass
 {
     public function run()
     {
-        $this->someMethod();
+        $this->someProperty;
     }
 }
```

<br>

### MethodCallToReturnRector

Wrap method call to return

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\Expression\MethodCallToReturnRector`](../rules/Transform/Rector/Expression/MethodCallToReturnRector.php)

```php
use Rector\Transform\Rector\Expression\MethodCallToReturnRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(MethodCallToReturnRector::class)
        ->call('configure', [[
            MethodCallToReturnRector::METHOD_CALL_WRAPS => [
                'SomeClass' => ['deny'],

            ], ]]);
};
```

↓

```diff
 class SomeClass
 {
     public function run()
     {
-        $this->deny();
+        return $this->deny();
     }

     public function deny()
     {
         return 1;
     }
 }
```

<br>

### MethodCallToStaticCallRector

Change method call to desired static call

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\MethodCall\MethodCallToStaticCallRector`](../rules/Transform/Rector/MethodCall/MethodCallToStaticCallRector.php)

```php
use Rector\Transform\Rector\MethodCall\MethodCallToStaticCallRector;
use Rector\Transform\ValueObject\MethodCallToStaticCall;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(MethodCallToStaticCallRector::class)
        ->call('configure', [[
            MethodCallToStaticCallRector::METHOD_CALLS_TO_STATIC_CALLS => ValueObjectInliner::inline([
                new MethodCallToStaticCall('AnotherDependency', 'process', 'StaticCaller', 'anotherMethod'),
            ]),
        ]]);
};
```

↓

```diff
 final class SomeClass
 {
     private $anotherDependency;

     public function __construct(AnotherDependency $anotherDependency)
     {
         $this->anotherDependency = $anotherDependency;
     }

     public function loadConfiguration()
     {
-        return $this->anotherDependency->process('value');
+        return StaticCaller::anotherMethod('value');
     }
 }
```

<br>

### NewArgToMethodCallRector

Change new with specific argument to method call

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\New_\NewArgToMethodCallRector`](../rules/Transform/Rector/New_/NewArgToMethodCallRector.php)

```php
use Rector\Transform\Rector\New_\NewArgToMethodCallRector;
use Rector\Transform\ValueObject\NewArgToMethodCall;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(NewArgToMethodCallRector::class)
        ->call('configure', [[
            NewArgToMethodCallRector::NEW_ARGS_TO_METHOD_CALLS => ValueObjectInliner::inline([
                new NewArgToMethodCall('Dotenv', true, 'usePutenv'),
            ]),
        ]]);
};
```

↓

```diff
 class SomeClass
 {
     public function run()
     {
-        $dotenv = new Dotenv(true);
+        $dotenv = new Dotenv();
+        $dotenv->usePutenv();
     }
 }
```

<br>

### NewToConstructorInjectionRector

Change defined new type to constructor injection

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\New_\NewToConstructorInjectionRector`](../rules/Transform/Rector/New_/NewToConstructorInjectionRector.php)

```php
use Rector\Transform\Rector\New_\NewToConstructorInjectionRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(NewToConstructorInjectionRector::class)
        ->call('configure', [[
            NewToConstructorInjectionRector::TYPES_TO_CONSTRUCTOR_INJECTION => ['Validator'],
        ]]);
};
```

↓

```diff
 class SomeClass
 {
+    /**
+     * @var Validator
+     */
+    private $validator;
+
+    public function __construct(Validator $validator)
+    {
+        $this->validator = $validator;
+    }
+
     public function run()
     {
-        $validator = new Validator();
-        $validator->validate(1000);
+        $this->validator->validate(1000);
     }
 }
```

<br>

### NewToMethodCallRector

Replaces creating object instances with "new" keyword with factory method.

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\New_\NewToMethodCallRector`](../rules/Transform/Rector/New_/NewToMethodCallRector.php)

```php
use Rector\Transform\Rector\New_\NewToMethodCallRector;
use Rector\Transform\ValueObject\NewToMethodCall;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(NewToMethodCallRector::class)
        ->call('configure', [[
            NewToMethodCallRector::NEWS_TO_METHOD_CALLS => ValueObjectInliner::inline([
                new NewToMethodCall('MyClass', 'MyClassFactory', 'create'),
            ]),
        ]]);
};
```

↓

```diff
 class SomeClass
 {
+	/**
+	 * @var \MyClassFactory
+	 */
+	private $myClassFactory;
+
 	public function example() {
-		new MyClass($argument);
+		$this->myClassFactory->create($argument);
 	}
 }
```

<br>

### NewToStaticCallRector

Change new Object to static call

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\New_\NewToStaticCallRector`](../rules/Transform/Rector/New_/NewToStaticCallRector.php)

```php
use Rector\Transform\Rector\New_\NewToStaticCallRector;
use Rector\Transform\ValueObject\NewToStaticCall;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(NewToStaticCallRector::class)
        ->call('configure', [[
            NewToStaticCallRector::TYPE_TO_STATIC_CALLS => ValueObjectInliner::inline([
                new NewToStaticCall('Cookie', 'Cookie', 'create'),
            ]),
        ]]);
};
```

↓

```diff
 class SomeClass
 {
     public function run()
     {
-        new Cookie($name);
+        Cookie::create($name);
     }
 }
```

<br>

### ParentClassToTraitsRector

Replaces parent class to specific traits

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\Class_\ParentClassToTraitsRector`](../rules/Transform/Rector/Class_/ParentClassToTraitsRector.php)

```php
use Rector\Transform\Rector\Class_\ParentClassToTraitsRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ParentClassToTraitsRector::class)
        ->call('configure', [[
            ParentClassToTraitsRector::PARENT_CLASS_TO_TRAITS => [
                'Nette\Object' => ['Nette\SmartObject'],

            ], ]]);
};
```

↓

```diff
-class SomeClass extends Nette\Object
+class SomeClass
 {
+    use Nette\SmartObject;
 }
```

<br>

### PropertyAssignToMethodCallRector

Turns property assign of specific type and property name to method call

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\Assign\PropertyAssignToMethodCallRector`](../rules/Transform/Rector/Assign/PropertyAssignToMethodCallRector.php)

```php
use Rector\Transform\Rector\Assign\PropertyAssignToMethodCallRector;
use Rector\Transform\ValueObject\PropertyAssignToMethodCall;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(PropertyAssignToMethodCallRector::class)
        ->call('configure', [[
            PropertyAssignToMethodCallRector::PROPERTY_ASSIGNS_TO_METHODS_CALLS => ValueObjectInliner::inline([
                new PropertyAssignToMethodCall('SomeClass', 'oldProperty', 'newMethodCall'),
            ]),
        ]]);
};
```

↓

```diff
 $someObject = new SomeClass;
-$someObject->oldProperty = false;
+$someObject->newMethodCall(false);
```

<br>

### PropertyFetchToMethodCallRector

Replaces properties assign calls be defined methods.

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\Assign\PropertyFetchToMethodCallRector`](../rules/Transform/Rector/Assign/PropertyFetchToMethodCallRector.php)

```php
use Rector\Transform\Rector\Assign\PropertyFetchToMethodCallRector;
use Rector\Transform\ValueObject\PropertyFetchToMethodCall;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(PropertyFetchToMethodCallRector::class)
        ->call('configure', [[
            PropertyFetchToMethodCallRector::PROPERTIES_TO_METHOD_CALLS => ValueObjectInliner::inline([
                new PropertyFetchToMethodCall('SomeObject', 'property', 'getProperty', 'setProperty', []), ]
            ),
        ]]);
};
```

↓

```diff
-$result = $object->property;
-$object->property = $value;
+$result = $object->getProperty();
+$object->setProperty($value);
```

<br>

```php
use Rector\Transform\Rector\Assign\PropertyFetchToMethodCallRector;
use Rector\Transform\ValueObject\PropertyFetchToMethodCall;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(PropertyFetchToMethodCallRector::class)
        ->call('configure', [[
            PropertyFetchToMethodCallRector::PROPERTIES_TO_METHOD_CALLS => ValueObjectInliner::inline([
                new PropertyFetchToMethodCall('SomeObject', 'property', 'getConfig', null, ['someArg']), ]
            ),
        ]]);
};
```

↓

```diff
-$result = $object->property;
+$result = $object->getProperty('someArg');
```

<br>

### ReplaceParentCallByPropertyCallRector

Changes method calls in child of specific types to defined property method call

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\MethodCall\ReplaceParentCallByPropertyCallRector`](../rules/Transform/Rector/MethodCall/ReplaceParentCallByPropertyCallRector.php)

```php
use Rector\Transform\Rector\MethodCall\ReplaceParentCallByPropertyCallRector;
use Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ReplaceParentCallByPropertyCallRector::class)
        ->call('configure', [[
            ReplaceParentCallByPropertyCallRector::PARENT_CALLS_TO_PROPERTIES => ValueObjectInliner::inline([
                new ReplaceParentCallByPropertyCall('SomeTypeToReplace', 'someMethodCall', 'someProperty'),
            ]),
        ]]);
};
```

↓

```diff
 final class SomeClass
 {
     public function run(SomeTypeToReplace $someTypeToReplace)
     {
-        $someTypeToReplace->someMethodCall();
+        $this->someProperty->someMethodCall();
     }
 }
```

<br>

### ServiceGetterToConstructorInjectionRector

Get service call to constructor injection

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector`](../rules/Transform/Rector/MethodCall/ServiceGetterToConstructorInjectionRector.php)

```php
use Rector\Transform\Rector\MethodCall\ServiceGetterToConstructorInjectionRector;
use Rector\Transform\ValueObject\ServiceGetterToConstructorInjection;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ServiceGetterToConstructorInjectionRector::class)
        ->call('configure', [[
            ServiceGetterToConstructorInjectionRector::METHOD_CALL_TO_SERVICES => ValueObjectInliner::inline([
                new ServiceGetterToConstructorInjection('FirstService', 'getAnotherService', 'AnotherService'),
            ]),
        ]]);
};
```

↓

```diff
 final class SomeClass
 {
     /**
      * @var FirstService
      */
     private $firstService;

-    public function __construct(FirstService $firstService)
-    {
-        $this->firstService = $firstService;
-    }
-
-    public function run()
-    {
-        $anotherService = $this->firstService->getAnotherService();
-        $anotherService->run();
-    }
-}
-
-class FirstService
-{
     /**
      * @var AnotherService
      */
     private $anotherService;

-    public function __construct(AnotherService $anotherService)
+    public function __construct(FirstService $firstService, AnotherService $anotherService)
     {
+        $this->firstService = $firstService;
         $this->anotherService = $anotherService;
     }

-    public function getAnotherService(): AnotherService
+    public function run()
     {
-         return $this->anotherService;
+        $anotherService = $this->anotherService;
+        $anotherService->run();
     }
 }
```

<br>

### SingleToManyMethodRector

Change method that returns single value to multiple values

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\ClassMethod\SingleToManyMethodRector`](../rules/Transform/Rector/ClassMethod/SingleToManyMethodRector.php)

```php
use Rector\Transform\Rector\ClassMethod\SingleToManyMethodRector;
use Rector\Transform\ValueObject\SingleToManyMethod;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(SingleToManyMethodRector::class)
        ->call('configure', [[
            SingleToManyMethodRector::SINGLES_TO_MANY_METHODS => ValueObjectInliner::inline([
                new SingleToManyMethod('SomeClass', 'getNode', 'getNodes'),
            ]),
        ]]);
};
```

↓

```diff
 class SomeClass
 {
-    public function getNode(): string
+    /**
+     * @return string[]
+     */
+    public function getNodes(): array
     {
-        return 'Echo_';
+        return ['Echo_'];
     }
 }
```

<br>

### StaticCallToFuncCallRector

Turns static call to function call.

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector`](../rules/Transform/Rector/StaticCall/StaticCallToFuncCallRector.php)

```php
use Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector;
use Rector\Transform\ValueObject\StaticCallToFuncCall;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(StaticCallToFuncCallRector::class)
        ->call('configure', [[
            StaticCallToFuncCallRector::STATIC_CALLS_TO_FUNCTIONS => ValueObjectInliner::inline([
                new StaticCallToFuncCall('OldClass', 'oldMethod', 'new_function'),
            ]),
        ]]);
};
```

↓

```diff
-OldClass::oldMethod("args");
+new_function("args");
```

<br>

### StaticCallToMethodCallRector

Change static call to service method via constructor injection

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector`](../rules/Transform/Rector/StaticCall/StaticCallToMethodCallRector.php)

```php
use Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector;
use Rector\Transform\ValueObject\StaticCallToMethodCall;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(StaticCallToMethodCallRector::class)
        ->call('configure', [[
            StaticCallToMethodCallRector::STATIC_CALLS_TO_METHOD_CALLS => ValueObjectInliner::inline([
                new StaticCallToMethodCall(
                    'Nette\Utils\FileSystem',
                    'write',
                    'Symplify\SmartFileSystem\SmartFileSystem',
                    'dumpFile'
                ),
            ]),
        ]]);
};
```

↓

```diff
-use Nette\Utils\FileSystem;
+use Symplify\SmartFileSystem\SmartFileSystem;

 class SomeClass
 {
+    /**
+     * @var SmartFileSystem
+     */
+    private $smartFileSystem;
+
+    public function __construct(SmartFileSystem $smartFileSystem)
+    {
+        $this->smartFileSystem = $smartFileSystem;
+    }
+
     public function run()
     {
-        return FileSystem::write('file', 'content');
+        return $this->smartFileSystem->dumpFile('file', 'content');
     }
 }
```

<br>

### StaticCallToNewRector

Change static call to new instance

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\StaticCall\StaticCallToNewRector`](../rules/Transform/Rector/StaticCall/StaticCallToNewRector.php)

```php
use Rector\Transform\Rector\StaticCall\StaticCallToNewRector;
use Rector\Transform\ValueObject\StaticCallToNew;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(StaticCallToNewRector::class)
        ->call('configure', [[
            StaticCallToNewRector::STATIC_CALLS_TO_NEWS => ValueObjectInliner::inline([
                new StaticCallToNew('JsonResponse', 'create'),
            ]),
        ]]);
};
```

↓

```diff
 class SomeClass
 {
     public function run()
     {
-        $dotenv = JsonResponse::create(true);
+        $dotenv = new JsonResponse();
     }
 }
```

<br>

### StringToClassConstantRector

Changes strings to specific constants

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\String_\StringToClassConstantRector`](../rules/Transform/Rector/String_/StringToClassConstantRector.php)

```php
use Rector\Transform\Rector\String_\StringToClassConstantRector;
use Rector\Transform\ValueObject\StringToClassConstant;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(StringToClassConstantRector::class)
        ->call('configure', [[
            StringToClassConstantRector::STRINGS_TO_CLASS_CONSTANTS => ValueObjectInliner::inline([
                new StringToClassConstant('compiler.post_dump', 'Yet\AnotherClass', 'CONSTANT'),
            ]),
        ]]);
};
```

↓

```diff
 final class SomeSubscriber
 {
     public static function getSubscribedEvents()
     {
-        return ['compiler.post_dump' => 'compile'];
+        return [\Yet\AnotherClass::CONSTANT => 'compile'];
     }
 }
```

<br>

### ToStringToMethodCallRector

Turns defined code uses of `"__toString()"` method  to specific method calls.

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\String_\ToStringToMethodCallRector`](../rules/Transform/Rector/String_/ToStringToMethodCallRector.php)

```php
use Rector\Transform\Rector\String_\ToStringToMethodCallRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ToStringToMethodCallRector::class)
        ->call('configure', [[
            ToStringToMethodCallRector::METHOD_NAMES_BY_TYPE => [
                'SomeObject' => 'getPath',

            ], ]]);
};
```

↓

```diff
 $someValue = new SomeObject;
-$result = (string) $someValue;
-$result = $someValue->__toString();
+$result = $someValue->getPath();
+$result = $someValue->getPath();
```

<br>

### UnsetAndIssetToMethodCallRector

Turns defined `__isset`/`__unset` calls to specific method calls.

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\Isset_\UnsetAndIssetToMethodCallRector`](../rules/Transform/Rector/Isset_/UnsetAndIssetToMethodCallRector.php)

```php
use Rector\Transform\Rector\Isset_\UnsetAndIssetToMethodCallRector;
use Rector\Transform\ValueObject\UnsetAndIssetToMethodCall;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(UnsetAndIssetToMethodCallRector::class)
        ->call('configure', [[
            UnsetAndIssetToMethodCallRector::ISSET_UNSET_TO_METHOD_CALL => ValueObjectInliner::inline([
                new UnsetAndIssetToMethodCall('SomeContainer', 'hasService', 'removeService'),
            ]),
        ]]);
};
```

↓

```diff
 $container = new SomeContainer;
-isset($container["someKey"]);
-unset($container["someKey"]);
+$container->hasService("someKey");
+$container->removeService("someKey");
```

<br>

### VariableMethodCallToServiceCallRector

Replace variable method call to a service one

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\MethodCall\VariableMethodCallToServiceCallRector`](../rules/Transform/Rector/MethodCall/VariableMethodCallToServiceCallRector.php)

```php
use Rector\Transform\Rector\MethodCall\VariableMethodCallToServiceCallRector;
use Rector\Transform\ValueObject\VariableMethodCallToServiceCall;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(VariableMethodCallToServiceCallRector::class)
        ->call('configure', [[
            VariableMethodCallToServiceCallRector::VARIABLE_METHOD_CALLS_TO_SERVICE_CALLS => ValueObjectInliner::inline([
                new VariableMethodCallToServiceCall(
                    'PhpParser\Node',
                    'getAttribute',
                    'php_doc_info',
                    'Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory',
                    'createFromNodeOrEmpty'
                ),
            ]),
        ]]);
};
```

↓

```diff
+use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
 use PhpParser\Node;

 class SomeClass
 {
+    public function __construct(PhpDocInfoFactory $phpDocInfoFactory)
+    {
+        $this->phpDocInfoFactory = $phpDocInfoFactory;
+    }
     public function run(Node $node)
     {
-        $phpDocInfo = $node->getAttribute('php_doc_info');
+        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
     }
 }
```

<br>

### WrapReturnRector

Wrap return value of specific method

:wrench: **configure it!**

- class: [`Rector\Transform\Rector\ClassMethod\WrapReturnRector`](../rules/Transform/Rector/ClassMethod/WrapReturnRector.php)

```php
use Rector\Transform\Rector\ClassMethod\WrapReturnRector;
use Rector\Transform\ValueObject\WrapReturn;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(WrapReturnRector::class)
        ->call('configure', [[
            WrapReturnRector::TYPE_METHOD_WRAPS => ValueObjectInliner::inline([
                new WrapReturn('SomeClass', 'getItem', true),
            ]),
        ]]);
};
```

↓

```diff
 final class SomeClass
 {
     public function getItem()
     {
-        return 1;
+        return [1];
     }
 }
```

<br>

## TypeDeclaration

### AddArrayParamDocTypeRector

Adds `@param` annotation to array parameters inferred from the rest of the code

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\AddArrayParamDocTypeRector`](../rules/TypeDeclaration/Rector/ClassMethod/AddArrayParamDocTypeRector.php)

```diff
 class SomeClass
 {
     /**
      * @var int[]
      */
     private $values;

+    /**
+     * @param int[] $values
+     */
     public function __construct(array $values)
     {
         $this->values = $values;
     }
 }
```

<br>

### AddArrayReturnDocTypeRector

Adds `@return` annotation to array parameters inferred from the rest of the code

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector`](../rules/TypeDeclaration/Rector/ClassMethod/AddArrayReturnDocTypeRector.php)

```diff
 class SomeClass
 {
     /**
      * @var int[]
      */
     private $values;

+    /**
+     * @return int[]
+     */
     public function getValues(): array
     {
         return $this->values;
     }
 }
```

<br>

### AddClosureReturnTypeRector

Add known return type to functions

- class: [`Rector\TypeDeclaration\Rector\Closure\AddClosureReturnTypeRector`](../rules/TypeDeclaration/Rector/Closure/AddClosureReturnTypeRector.php)

```diff
 class SomeClass
 {
     public function run($meetups)
     {
-        return array_filter($meetups, function (Meetup $meetup) {
+        return array_filter($meetups, function (Meetup $meetup): bool {
             return is_object($meetup);
         });
     }
 }
```

<br>

### AddMethodCallBasedStrictParamTypeRector

Change param type to strict type of passed expression

:wrench: **configure it!**

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\AddMethodCallBasedStrictParamTypeRector`](../rules/TypeDeclaration/Rector/ClassMethod/AddMethodCallBasedStrictParamTypeRector.php)

```php
use Rector\TypeDeclaration\Rector\ClassMethod\AddMethodCallBasedStrictParamTypeRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(AddMethodCallBasedStrictParamTypeRector::class)
        ->call('configure', [[
            AddMethodCallBasedStrictParamTypeRector::TRUST_DOC_BLOCKS => false,
        ]]);
};
```

↓

```diff
 class SomeClass
 {
-    public function getById($id)
+    public function getById(int $id)
     {
     }
 }

 class CallerClass
 {
     public function run(SomeClass $someClass)
     {
         $someClass->getById($this->getId());
     }

     public function getId(): int
     {
         return 1000;
     }
 }
```

<br>

### AddParamTypeDeclarationRector

Add param types where needed

:wrench: **configure it!**

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector`](../rules/TypeDeclaration/Rector/ClassMethod/AddParamTypeDeclarationRector.php)

```php
use PHPStan\Type\StringType;
use Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(AddParamTypeDeclarationRector::class)
        ->call('configure', [[
            AddParamTypeDeclarationRector::PARAMETER_TYPEHINTS => ValueObjectInliner::inline([
                new AddParamTypeDeclaration('SomeClass', 'process', 0, new StringType()),
            ]),
        ]]);
};
```

↓

```diff
 class SomeClass
 {
-    public function process($name)
+    public function process(string $name)
     {
     }
 }
```

<br>

### AddReturnTypeDeclarationRector

Changes defined return typehint of method and class.

:wrench: **configure it!**

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector`](../rules/TypeDeclaration/Rector/ClassMethod/AddReturnTypeDeclarationRector.php)

```php
use PHPStan\Type\ArrayType;
use PHPStan\Type\MixedType;
use Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(AddReturnTypeDeclarationRector::class)
        ->call('configure', [[
            AddReturnTypeDeclarationRector::METHOD_RETURN_TYPES => ValueObjectInliner::inline([
                new AddReturnTypeDeclaration('SomeClass', 'getData', new ArrayType(new MixedType(
                    false,
                    null
                ), new MixedType(
                    false,
                    null
                ))),
            ]),
        ]]);
};
```

↓

```diff
 class SomeClass
 {
-    public getData()
+    public getData(): array
     {
     }
 }
```

<br>

### AddVoidReturnTypeWhereNoReturnRector

Add return type void to function like without any return

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector`](../rules/TypeDeclaration/Rector/ClassMethod/AddVoidReturnTypeWhereNoReturnRector.php)

```diff
 final class SomeClass
 {
-    public function getValues()
+    public function getValues(): void
     {
         $value = 1000;
         return;
     }
 }
```

<br>

### CompleteVarDocTypePropertyRector

Complete property `@var` annotations or correct the old ones

- class: [`Rector\TypeDeclaration\Rector\Property\CompleteVarDocTypePropertyRector`](../rules/TypeDeclaration/Rector/Property/CompleteVarDocTypePropertyRector.php)

```diff
 final class SomeClass
 {
+    /**
+     * @var EventDispatcher
+     */
     private $eventDispatcher;

     public function __construct(EventDispatcher $eventDispatcher)
     {
         $this->eventDispatcher = $eventDispatcher;
     }
 }
```

<br>

### FormerNullableArgumentToScalarTypedRector

Change null in argument, that is now not nullable anymore

- class: [`Rector\TypeDeclaration\Rector\MethodCall\FormerNullableArgumentToScalarTypedRector`](../rules/TypeDeclaration/Rector/MethodCall/FormerNullableArgumentToScalarTypedRector.php)

```diff
 final class SomeClass
 {
     public function run()
     {
-        $this->setValue(null);
+        $this->setValue('');
     }

     public function setValue(string $value)
     {
     }
 }
```

<br>

### ParamTypeDeclarationRector

Change `@param` types to type declarations if not a BC-break

- class: [`Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector`](../rules/TypeDeclaration/Rector/FunctionLike/ParamTypeDeclarationRector.php)

```diff
 class ParentClass
 {
     /**
      * @param int $number
      */
     public function keep($number)
     {
     }
 }

 final class ChildClass extends ParentClass
 {
     /**
      * @param int $number
      */
     public function keep($number)
     {
     }

-    /**
-     * @param int $number
-     */
-    public function change($number)
+    public function change(int $number)
     {
     }
 }
```

<br>

### ParamTypeFromStrictTypedPropertyRector

Add param type from `$param` set to typed property

- class: [`Rector\TypeDeclaration\Rector\Param\ParamTypeFromStrictTypedPropertyRector`](../rules/TypeDeclaration/Rector/Param/ParamTypeFromStrictTypedPropertyRector.php)

```diff
 final class SomeClass
 {
     private int $age;

-    public function setAge($age)
+    public function setAge(int $age)
     {
         $this->age = $age;
     }
 }
```

<br>

### PropertyTypeDeclarationRector

Add `@var` to properties that are missing it

- class: [`Rector\TypeDeclaration\Rector\Property\PropertyTypeDeclarationRector`](../rules/TypeDeclaration/Rector/Property/PropertyTypeDeclarationRector.php)

```diff
 class SomeClass
 {
+    /**
+     * @var int
+     */
     private $value;

     public function run()
     {
         $this->value = 123;
     }
 }
```

<br>

### ReturnNeverTypeRector

Add "never" type for methods that never return anything

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\ReturnNeverTypeRector`](../rules/TypeDeclaration/Rector/ClassMethod/ReturnNeverTypeRector.php)

```diff
 final class SomeClass
 {
-    public function run()
+    public function run(): never
     {
         throw new InvalidException();
     }
 }
```

<br>

### ReturnTypeDeclarationRector

Change `@return` types and type from static analysis to type declarations if not a BC-break

- class: [`Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector`](../rules/TypeDeclaration/Rector/FunctionLike/ReturnTypeDeclarationRector.php)

```diff
 class SomeClass
 {
-    /**
-     * @return int
-     */
-    public function getCount()
+    public function getCount(): int
     {
     }
 }
```

<br>

### ReturnTypeFromReturnNewRector

Add return type to function like with return new

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnNewRector`](../rules/TypeDeclaration/Rector/ClassMethod/ReturnTypeFromReturnNewRector.php)

```diff
 final class SomeClass
 {
-    public function action()
+    public function action(): Response
     {
         return new Response();
     }
 }
```

<br>

### ReturnTypeFromStrictTypedCallRector

Add return type from strict return type of call

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedCallRector`](../rules/TypeDeclaration/Rector/ClassMethod/ReturnTypeFromStrictTypedCallRector.php)

```diff
 final class SomeClass
 {
-    public function getData()
+    public function getData(): int
     {
         return $this->getNumber();
     }

     private function getNumber(): int
     {
         return 1000;
     }
 }
```

<br>

### ReturnTypeFromStrictTypedPropertyRector

Add return method return type based on strict typed property

- class: [`Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedPropertyRector`](../rules/TypeDeclaration/Rector/ClassMethod/ReturnTypeFromStrictTypedPropertyRector.php)

```diff
 final class SomeClass
 {
     private int $age = 100;

-    public function getAge()
+    public function getAge(): int
     {
         return $this->age;
     }
 }
```

<br>

### TypedPropertyFromStrictConstructorRector

Add typed properties based only on strict constructor types

- class: [`Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictConstructorRector`](../rules/TypeDeclaration/Rector/Property/TypedPropertyFromStrictConstructorRector.php)

```diff
 class SomeObject
 {
-    private $name;
+    private string $name;

     public function __construct(string $name)
     {
         $this->name = $name;
     }
 }
```

<br>

## Visibility

### ChangeConstantVisibilityRector

Change visibility of constant from parent class.

:wrench: **configure it!**

- class: [`Rector\Visibility\Rector\ClassConst\ChangeConstantVisibilityRector`](../rules/Visibility/Rector/ClassConst/ChangeConstantVisibilityRector.php)

```php
use Rector\Visibility\Rector\ClassConst\ChangeConstantVisibilityRector;
use Rector\Visibility\ValueObject\ChangeConstantVisibility;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ChangeConstantVisibilityRector::class)
        ->call('configure', [[
            ChangeConstantVisibilityRector::CLASS_CONSTANT_VISIBILITY_CHANGES => ValueObjectInliner::inline([
                new ChangeConstantVisibility('ParentObject', 'SOME_CONSTANT', 2),
            ]),
        ]]);
};
```

↓

```diff
 class FrameworkClass
 {
     protected const SOME_CONSTANT = 1;
 }

 class MyClass extends FrameworkClass
 {
-    public const SOME_CONSTANT = 1;
+    protected const SOME_CONSTANT = 1;
 }
```

<br>

### ChangeMethodVisibilityRector

Change visibility of method from parent class.

:wrench: **configure it!**

- class: [`Rector\Visibility\Rector\ClassMethod\ChangeMethodVisibilityRector`](../rules/Visibility/Rector/ClassMethod/ChangeMethodVisibilityRector.php)

```php
use Rector\Visibility\Rector\ClassMethod\ChangeMethodVisibilityRector;
use Rector\Visibility\ValueObject\ChangeMethodVisibility;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ChangeMethodVisibilityRector::class)
        ->call('configure', [[
            ChangeMethodVisibilityRector::METHOD_VISIBILITIES => ValueObjectInliner::inline([
                new ChangeMethodVisibility('FrameworkClass', 'someMethod', 2),
            ]),
        ]]);
};
```

↓

```diff
 class FrameworkClass
 {
     protected someMethod()
     {
     }
 }

 class MyClass extends FrameworkClass
 {
-    public someMethod()
+    protected someMethod()
     {
     }
 }
```

<br>

### ChangePropertyVisibilityRector

Change visibility of property from parent class.

:wrench: **configure it!**

- class: [`Rector\Visibility\Rector\Property\ChangePropertyVisibilityRector`](../rules/Visibility/Rector/Property/ChangePropertyVisibilityRector.php)

```php
use Rector\Visibility\Rector\Property\ChangePropertyVisibilityRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ChangePropertyVisibilityRector::class)
        ->call('configure', [[
            ChangePropertyVisibilityRector::PROPERTY_TO_VISIBILITY_BY_CLASS => [
                'FrameworkClass' => [
                    'someProperty' => 2,

                ], ], ]]);
};
```

↓

```diff
 class FrameworkClass
 {
     protected $someProperty;
 }

 class MyClass extends FrameworkClass
 {
-    public $someProperty;
+    protected $someProperty;
 }
```

<br>
