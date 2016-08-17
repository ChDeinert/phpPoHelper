<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    // define public methods as commands
    public function watch()
    {
        $this->taskWatch()
            ->monitor('src', function () {
                $this->styleCheck();
                $this->testsRun();
            })
            ->monitor('tests', function () {
                $this->testsRun();
            })
            ->run();
    }

    public function testsRun()
    {
        $this->taskPHPUnit()
            ->arg('--colors=always')
            ->configFile('./phpunit.xml')
            ->run();
    }

    public function styleCheck()
    {
        $this->styleRun('fix ./src/ --dry-run --level=psr2');
    }

    public function styleDiff()
    {
        $this->styleRun('fix ./src/ --dry-run --diff --level=psr2');
    }

    public function styleFix()
    {
        $this->styleRun('fix ./src/ --diff --level=psr2');
    }

    private function styleRun($argString)
    {
        $this->taskExec("./vendor/bin/php-cs-fixer {$argString}")->run();
    }
}
