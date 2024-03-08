<?php

namespace App\Contracts;

use App\Dto\EntitySeoPageRequest;
use App\Entity\EntitySeoPage;
use App\Entity\SeoPage;
use Doctrine\Persistence\ObjectRepository;

interface EntitySeoPageRepository extends ObjectRepository
{
    public function findById(int $id): EntitySeoPage;

    public function new(): EntitySeoPage;

    public function fill(EntitySeoPage &$page, SeoPage $seoPage, EntitySeoPageRequest $data): void;

    public function save(EntitySeoPage &$page): void;
}
