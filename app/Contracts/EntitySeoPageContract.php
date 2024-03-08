<?php

namespace App\Contracts;

use App\Entity\SeoPage;

interface EntitySeoPageContract
{
    public function getSeoPage(): SeoPage;
    public function setSeoPage(SeoPage $seoPage): void;
}
