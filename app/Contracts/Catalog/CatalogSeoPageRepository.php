<?php

namespace App\Contracts\Catalog;

use App\Dto\Catalog\SeoPageRequest as CatalogSeoPageRequest;
use App\Entity\Catalog\SeoPage as CatalogSeoPage;
use App\Entity\EntitySeoPage;
use App\Entity\SeoPage;
use Doctrine\Persistence\ObjectRepository;

interface CatalogSeoPageRepository extends ObjectRepository
{
    public function findById(int $id): EntitySeoPage;

    public function new(): EntitySeoPage;

    public function fill(CatalogSeoPage &$page, SeoPage $seoPage, CatalogSeoPageRequest $data): void;

    public function save(CatalogSeoPage &$page): void;
}
