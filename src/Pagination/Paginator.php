<?php

namespace Pagination;

use Doctrine\ORM\QueryBuilder;

class Paginator
{
    public function __construct(
        private readonly QueryBuilder $queryBuilder,
        private readonly  int $page,
        private readonly  int $perPage,
    )
    {
    }

    public function paginate(): array
    {
        $qbCount = clone $this->queryBuilder;
        $total = $qbCount->select('count(h.id)')->getQuery()->getSingleScalarResult();

        $this->queryBuilder->setMaxResults($this->perPage);
        $this->queryBuilder->setFirstResult(($this->page - 1 ) * $this->perPage);

        $query = $this->queryBuilder->getQuery();
        $data =  $query->getResult();

        return [
            'data' => $data,
            'perPage' => $this->perPage,
            'page' => $this->page,
            'total' => $total
        ];
    }
}