<?php

namespace App\Repositories;

use App\Contracts\SeoPageRepository;
use App\Dto\SeoPageRequest;
use App\Entity\SeoPage;
use Doctrine\ORM\EntityRepository;
use Illuminate\Database\RecordsNotFoundException;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;

/**
 * @method  findOne(array $array)
 */
class DoctrineSeoPageRepository extends EntityRepository implements SeoPageRepository
{
    use PaginatesFromParams;

    /**
     * @param int $id
     * @return SeoPage
     * @throws RecordsNotFoundException
     */
    public function findById(int $id): SeoPage
    {
        $Page = $this->findOneBy([
            'id' => $id,
        ]);

        if (!($Page instanceof SeoPage)) {
            throw new RecordsNotFoundException();
        }

        return $Page;
    }

    public function fill(SeoPage &$page, SeoPageRequest $data): void
    {
        $page->setSlug($data->getSlug());
        $page->setName($data->getName());
        $page->setActive($data->getActive());
        $page->setSeoTitle($data->getSeoTitle());
        $page->setSeoH1($data->getSeoH1());
        $page->setSeoKeywords($data->getSeoKeywords());
        $page->setSeoDescription($data->getSeoDescription());
        $page->setSeoText($data->getSeoText() ?? '');
        $page->setFilters($data->getFilters()->toArray());
        $page->setFillManually($data->getFillManually());
    }

    public function save(SeoPage &$page): void
    {
        $this->_em->persist($page);
        $this->_em->flush();
    }

    public function findOneBySlug(string $slug): ?object
    {
        return $this->findOneBy([
            'slug' => $slug,
        ]);
    }
}
