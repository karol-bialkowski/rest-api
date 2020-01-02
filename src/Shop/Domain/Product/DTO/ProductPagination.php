<?php

namespace App\Shop\Domain\Product\DTO;

use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;

class ProductPagination
{

    public const PRODUCTS_PER_PAGE = 3;
    private SlidingPagination $pagination;

    /**
     * ProductPagination constructor.
     * @param SlidingPagination $pagination
     */
    public function __construct(SlidingPagination $pagination)
    {
        $this->pagination = $pagination;
    }

    /**
     * @return array
     */
    public function getApiPayload(): array
    {
        $totalPages = ceil($this->pagination->getTotalItemCount() / self::PRODUCTS_PER_PAGE);
        $currentPageNumber = $this->pagination->getCurrentPageNumber();
        $nextPage = (($currentPageNumber + 1) > $totalPages) ? $totalPages : $currentPageNumber + 1;
        $prevPage = (($currentPageNumber - 1) < 1) ? 1 : $currentPageNumber - 1;

        return [
            'products' => $this->pagination->getItems(),
            'paginator' => [
                'currentPageNumber' => $currentPageNumber,
                'totalPages' => $totalPages,
                'nextPage' => $nextPage,
                'prevPage' => $prevPage,
            ],
        ];
    }
}
