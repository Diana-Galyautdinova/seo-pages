<?php

namespace App\Contracts\Example;

use App\Dto\Example\SeoPageRequest as ExampleSeoPageRequest;
use App\Entity\ExampleEntity\SeoPage as ExampleSeoPage;
use App\Entity\EntitySeoPage;
use App\Entity\SeoPage;
use Doctrine\Persistence\ObjectRepository;

interface ExampleSeoPageRepository extends ObjectRepository
{
    public function findById(int $id): EntitySeoPage;

    public function new(): EntitySeoPage;

    public function fill(ExampleSeoPage &$page, SeoPage $seoPage, ExampleSeoPageRequest $data): void;

    public function save(ExampleSeoPage &$page): void;
}
