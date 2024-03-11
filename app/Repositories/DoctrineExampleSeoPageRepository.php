<?php

namespace App\Repositories;

use App\Contracts\Example\ExampleSeoPageRepository;
use App\Dto\Example\SeoPageFilterRequest;
use App\Dto\Example\SeoPageRequest;
use App\Dto\EntitySeoPageRequest;
use App\Entity\ExampleEntity\SeoPage as ExampleSeoPage;
use App\Entity\EntitySeoPage;
use App\Entity\SeoPage;

class DoctrineExampleSeoPageRepository extends DoctrineEntitySeoPageRepository implements ExampleSeoPageRepository
{
    public function fill(EntitySeoPage &$page, SeoPage $seoPage, EntitySeoPageRequest $data): void
    {
        /** @var ExampleSeoPage $page */
        /** @var SeoPageRequest $data */
        $page->setSeoPage($seoPage);
        $page->setAdditionalField($data->getAdditionalField());
    }

    public function new(): EntitySeoPage
    {
        $seoPage = new SeoPage();
        $seoPage->setFilters((new SeoPageFilterRequest())->toArray());

        return new ExampleSeoPage('test', $seoPage);
    }
}
