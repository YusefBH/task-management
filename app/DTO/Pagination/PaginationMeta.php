<?php

namespace App\DTO\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class PaginationMeta extends DataTransferObject
{
    public int $current_page;
    public ?int $from;
    public ?int $to;
    public int $last_page;
    public array $links;
    public string $path;
    public int $per_page;
    public int $total;

    /**
     * @throws UnknownProperties
     */
    public static function fromPaginator(LengthAwarePaginator $paginator): PaginationMeta
    {
        return new PaginationMeta([
            'current_page' => $paginator->currentPage(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
            'last_page' => $paginator->lastPage(),
            'links' => array_values($paginator->getUrlRange(1, $paginator->lastPage())),
            'path' => $paginator->path(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
        ]);
    }
}
