<?php

declare(strict_types=1);

namespace Rector\Core\Tests\FileSystem\FilesFinder\ExcludePaths;

use Rector\Core\FileSystem\FilesFinder;
use Rector\Testing\PHPUnit\AbstractTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;

final class ExcludePathsTest extends AbstractTestCase
{
    public function testShouldFail(): void
    {
        $this->bootFromConfigFileInfos([new SmartFileInfo(__DIR__ . '/config/config-with-excluded-paths.php')]);

        $filesFinder = $this->getService(FilesFinder::class);

        $foundFileInfos = $filesFinder->findInDirectoriesAndFiles([__DIR__ . '/Source'], ['php']);
        $this->assertCount(1, $foundFileInfos);
    }
}
