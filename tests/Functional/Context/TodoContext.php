<?php

namespace EsTodosApi\Tests\Functional\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use EsTodosApi\Tests\Functional\Context\Wildcards\WildcardsTrait;
use EsTodosApi\Application\Todo\Command\CreateTodo\CreateTodoCommand;
use Zisato\CQRS\WriteModel\Service\CommandBus;

final class TodoContext implements Context
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
     * @Given /^the following todos exists:$/
     *
     * @param TableNode $table
     */
    public function theFollowingTodoExists(TableNode $table): void
    {
        foreach ($table as $row) {
            self::$commandBus->handle(new CreateTodoCommand(
                $row['id'],
                $row['user_id'],
                $row['title'],
                $row['description']
            ));
        }
    }
}
