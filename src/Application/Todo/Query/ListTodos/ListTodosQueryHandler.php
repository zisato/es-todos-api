<?php

declare(strict_types=1);

namespace EsTodosApi\Application\Todo\Query\ListTodos;

use EsTodosApi\Application\Todo\Transformer\TodoJsonApiTransformer;
use EsTodosApi\Domain\Todo\ReadModel\Repository\TodoProjectionRepository;
use Zisato\CQRS\ReadModel\Service\QueryHandler;

class ListTodosQueryHandler implements QueryHandler
{
    public function __construct(private readonly TodoProjectionRepository $todoProjectionRepository) {}

    public function __invoke(ListTodosQuery $query): ListTodosQueryResult
    {
        $offset = (($query->page() - 1) * $query->perPage());

        $todosCollection = $this->todoProjectionRepository->findAll($offset, $query->perPage());

        return ListTodosQueryResult::create($todosCollection, new TodoJsonApiTransformer(), $query->page(), $query->perPage());
    }
}
