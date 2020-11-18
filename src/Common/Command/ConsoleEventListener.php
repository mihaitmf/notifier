<?php

namespace Notifier\Common\Command;

use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleEventListener
{
    private ExecutionStatistics $executionStatistics;
    private OutputInterface $output;

    public function __construct(ExecutionStatistics $executionStatistics, ConsoleOutput $output)
    {
        $this->executionStatistics = $executionStatistics;
        $this->output = $output;
    }

    public function onCommandBegin(ConsoleCommandEvent $event): void
    {
        $this->executionStatistics->start();
        $this->output->writeln(sprintf("Command %s started...\n", $event->getCommand()->getName()));
    }

    public function onCommandFinish(ConsoleTerminateEvent $event): void
    {
        $this->executionStatistics->end();
        $this->output->writeln(
            sprintf("\nCommand %s finished with exit code %s.", $event->getCommand()->getName(), $event->getExitCode())
        );
        $this->output->writeln($this->executionStatistics->getPrintMessage());
    }

    public function onCommandError(ConsoleErrorEvent $event): void
    {
        $this->executionStatistics->end();
        $this->output->writeln(
            sprintf("\nCommand %s exited with ERROR: %s.", $event->getCommand()->getName(), $event->getError()->getMessage())
        );
        $this->output->writeln($this->executionStatistics->getPrintMessage());
    }
}
