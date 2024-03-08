<?php

namespace App\Contracts;

use App\Dto\SeoPageRequest;

interface EntitySeoPageRequestContract
{
    public function getSeoPage(): SeoPageRequest;
}
