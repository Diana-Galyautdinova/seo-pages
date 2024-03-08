<?php

namespace App\Dto;

use App\Contracts\EntitySeoPageRequestContract;

abstract class EntitySeoPageRequest implements EntitySeoPageRequestContract
{
    public function __construct(
        protected SeoPageRequest $seoPage,
    ) {
    }

    public function getSeoPage(): SeoPageRequest
    {
        return $this->seoPage;
    }

    public function toArray(): array
    {
        return [
            'seoPage' => $this->getSeoPage()->toArray(),
        ];
    }
}
