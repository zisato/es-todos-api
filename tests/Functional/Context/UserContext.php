<?php

namespace EsTodosApi\Tests\Functional\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use EsTodosApi\Tests\Functional\Context\Wildcards\WildcardsTrait;
use EsTodosApi\Application\User\Command\CreateUser\CreateUserCommand;
use Zisato\CQRS\WriteModel\Service\CommandBus;

class UserContext implements Context
{
    use WildcardsTrait {
        WildcardsTrait::__construct as private __wilcardsConstruct;
    }

    private static CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->__wilcardsConstruct();
        
        self::$commandBus = $commandBus;
    }

    /**
     * @Given /^the following users exists:$/
     *
     * @param TableNode $table
     */
    public function theFollowingUsersExists(TableNode $table): void
    {
        foreach ($table as $row) {
            self::$commandBus->handle(new CreateUserCommand(
                $row['id'],
                $row['identification'],
                $row['name']
            ));
        }
    }
}
