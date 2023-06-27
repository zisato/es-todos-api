<?php

declare(strict_types=1);

namespace EsTodosApi\Application\Todo\Query\DetailTodo;

use EsTodosApi\Application\Todo\Transformer\TodoJsonApiTransformer;
use EsTodosApi\Domain\Todo\ReadModel\Repository\TodoProjectionRepository;
use Zisato\CQRS\ReadModel\Service\QueryHandler;
use Zisato\CQRS\ReadModel\ValueObject\QueryResult;

final class DetailTodoQueryHandler implements QueryHandler
{
    public function __construct(private readonly TodoProjectionRepository $todoProjectionRepository) {}

    public function __invoke(DetailTodoQuery $query): QueryResult
    {
        $todo = $this->todoProjectionRepository->get($query->id());

        return DetailTodoQueryResult::create($todo, new TodoJsonApiTransformer());
    }
}
