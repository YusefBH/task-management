<?php

namespace App\DTO\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class Pagination extends DataTransferObject
{
    public PaginationLinks $links;
    public array $data;
    public PaginationMeta $meta;


    public static function fromModelPaginatorAndData(
        LengthAwarePaginator $paginator,
        array                $data
    ): Pagination {
        try {
            return new self([
                'links' => PaginationLinks::fromPaginator($paginator),
                'data' => $data,
                'meta' => PaginationMeta::fromPaginator($paginator),
            ]);
        }catch (UnknownProperties $e){
            throw new \RuntimeException($e->getMessage());
        }

    }
}
