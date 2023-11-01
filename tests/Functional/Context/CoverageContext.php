<?php

namespace EsTodosApi\Tests\Functional\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use SebastianBergmann\CodeCoverage\CodeCoverage;
use SebastianBergmann\CodeCoverage\Driver\PcovDriver;
use SebastianBergmann\CodeCoverage\Filter;
use SebastianBergmann\CodeCoverage\Report\PHP;

class CoverageContext implements Context
{
    const INCLUDE_DIRS = [
        __DIR__ . "/../../../src",
    ];

    const EXCLUDE = [
        'directories' => [
            __DIR__ . '/../../../src/Infrastructure/Doctrine/Migrations',
        ],
        'files' => [
            __DIR__ . '/../../../src/Infrastructure/Framework/Kernel.php',
        ],
    ];

    private static CodeCoverage $coverage;

    /**
     * @beforeSuite
     */
    public static function setup(): void
    {
        $filter = new Filter();

        foreach (self::INCLUDE_DIRS as $directory) {
            $filter->includeDirectory($directory);
        }

        foreach (self::EXCLUDE['directories'] as $directory) {
            $filter->excludeDirectory($directory);
        }

        foreach (self::EXCLUDE['files'] as $file) {
            $filter->excludeFile($file);
        }

        self::$coverage = new CodeCoverage(new PcovDriver($filter), $filter);
    }

    /**
     * @afterSuite
     */
    public static function tearDown(): void
    {
        $writer = new PHP();

        $writer->process(self::$coverage, __DIR__ . "/../../../build/coverage/behat.cov");
    }

    /**
     * @beforeScenario
     */
    public function startCoverage(BeforeScenarioScope $scope): void
    {
        self::$coverage->start($this->getCoverageKeyFromScope($scope));
    }

    /**
     * @afterScenario
     */
    public function stopCoverage(): void
    {
        self::$coverage->stop();
    }

    private function getCoverageKeyFromScope(BeforeScenarioScope $scope): string
    {
        return $scope->getFeature()->getFile() . '::' . $scope->getScenario()->getTitle();
    }
}
