<?php

namespace App\Dto;

use App\Contracts\EntitySeoPageContract;

class EntitySeoPageList
{
    protected int $pageCount = 0;

    /**
     * @var EntitySeoPageContract[]
     */
    protected array $data = [];

    /**
     * @return int
     */
    public function getPageCount(): int
    {
        return $this->pageCount;
    }

    /**
     * @param int $pageCount
     */
    public function setPageCount(int $pageCount): void
    {
        $this->pageCount = $pageCount;
    }

    /**
     * @return EntitySeoPageContract[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param EntitySeoPageContract $data
     */
    public function addData(EntitySeoPageContract $data): void
    {
        $this->data[] = $data;
    }

    /**
     * @param EntitySeoPageContract[] $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
