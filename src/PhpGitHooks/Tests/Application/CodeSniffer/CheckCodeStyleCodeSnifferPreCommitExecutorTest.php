<?php

namespace PhpGitHooks\Tests\Application\CodeSniffer;

use Mockery\Mock;
use PhpGitHooks\Application\CodeSniffer\CheckCodeStyleCodeSnifferPreCommitExecutor;
use PhpGitHooks\Infrastructure\CodeSniffer\CodeSnifferHandler;
use PhpGitHooks\Infrastructure\Component\InMemoryOutputInterface;
use PhpGitHooks\Infrastructure\Config\InMemoryHookConfig;

/**
 * Class CheckCodeStyleCodeSnifferPreCommitExecutorTest.
 */
class CheckCodeStyleCodeSnifferPreCommitExecutorTest extends \PHPUnit_Framework_TestCase
{
    /** @var  CheckCodeStyleCodeSnifferPreCommitExecutor */
    private $checkCodeStyleCodeSnifferPreCommitExecutor;
    /** @var  InMemoryHookConfig */
    private $preCommitConfig;
    /** @var  Mock */
    private $codeSnifferHandler;
    /** @var InMemoryOutputInterface */
    private $outputInterface;

    protected function setUp()
    {
        $this->outputInterface = new InMemoryOutputInterface();
        $this->preCommitConfig = new InMemoryHookConfig();
        $this->codeSnifferHandler = \Mockery::mock(CodeSnifferHandler::class);
        $this->checkCodeStyleCodeSnifferPreCommitExecutor  = new CheckCodeStyleCodeSnifferPreCommitExecutor(
            $this->preCommitConfig,
            $this->codeSnifferHandler
        );
    }

    /**
     * @test
     */
    public function isDisabled()
    {
        $this->preCommitConfig->setEnabled(false);

        $this->checkCodeStyleCodeSnifferPreCommitExecutor->run(
            $this->outputInterface,
            array(),
            'needle'
        );
    }

    /**
     * @test
     */
    public function isEnable()
    {
        $this->preCommitConfig->setEnabled(true);

        $this->codeSnifferHandler->shouldReceive('setOutput');
        $this->codeSnifferHandler->shouldReceive('setFiles');
        $this->codeSnifferHandler->shouldReceive('setNeddle');
        $this->codeSnifferHandler->shouldReceive('run');

        $this->checkCodeStyleCodeSnifferPreCommitExecutor->run(
            $this->outputInterface,
            array(),
            'needle'
        );
    }
}
