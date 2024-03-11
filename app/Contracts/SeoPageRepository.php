<?php

namespace App\Contracts;

use App\Dto\SeoPageRequest;
use App\Entity\SeoPage;
use Doctrine\Persistence\ObjectRepository;

interface SeoPageRepository extends ObjectRepository
{
    public function findById(int $id): SeoPage;

    public function fill(SeoPage &$page, SeoPageRequest $data): void;

    public function save(SeoPage &$page): void;

    public function findOneBySlug(string $slug): ?object;
}
