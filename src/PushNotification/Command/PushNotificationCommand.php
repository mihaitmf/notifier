<?php

namespace Notifier\PushNotification\Command;

use Notifier\PushNotification\PushNotificationService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PushNotificationCommand extends Command
{
    private const INPUT_MESSAGE = 'message';
    private const INPUT_LINK_URL = 'linkURL';

    private PushNotificationService $pushNotificationService;

    public function __construct(PushNotificationService $pushNotificationService)
    {
        parent::__construct();
        $this->pushNotificationService = $pushNotificationService;
    }

    protected function configure(): void
    {
        $commandName = 'notify:push';
        $this->setName($commandName)
            ->setDescription(
                'Send push notification to phone via IFTTT webhook'
            )
            ->setHelp(
                "Send push notification to phone via IFTTT webhook, containing a message and a link\r\n"
                . "Example command: php <script-name>.php $commandName " . '"<message>" "<linkURL (optional)>"'
            )
            ->setDefinition(
                new InputDefinition(
                    [
                        new InputArgument(
                            self::INPUT_MESSAGE,
                            InputArgument::REQUIRED,
                            'The notification message; make sure to enclose it in double quotes: "<message>"',
                        ),
                        new InputArgument(
                            self::INPUT_LINK_URL,
                            InputArgument::OPTIONAL,
                            '(Optional) An URL to send in the notification',
                            ''
                        ),
                    ]
                )
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $message = $input->getArgument(self::INPUT_MESSAGE);
        $linkUrl = $input->getArgument(self::INPUT_LINK_URL);

        $response = $this->pushNotificationService->notify($message, $linkUrl);

        if ($response->isSuccessful()) {
            $output->writeln('SUCCESS! Push notification sent!');

            return Command::SUCCESS;
        }

        $output->writeln(sprintf('ERROR! %s', $response->getError()));

        return Command::FAILURE;
    }
}
