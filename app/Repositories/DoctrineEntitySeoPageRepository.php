<?php

namespace App\Repositories;

use App\Contracts\EntitySeoPageRepository;
use App\Dto\EntitySeoPageRequest;
use App\Entity\EntitySeoPage;
use App\Entity\SeoPage;
use Doctrine\ORM\EntityRepository;
use Illuminate\Database\RecordsNotFoundException;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;

/**
 * @method  findOne(array $array)
 */
abstract class DoctrineEntitySeoPageRepository extends EntityRepository implements EntitySeoPageRepository
{
    use PaginatesFromParams;

    /**
     * @param int $id
     * @return EntitySeoPage
     * @throws RecordsNotFoundException
     */
    public function findById(int $id): EntitySeoPage
    {
        $Page = $this->findOneBy([
            'id' => $id,
        ]);

        if (!($Page instanceof EntitySeoPage)) {
            throw new RecordsNotFoundException();
        }

        return $Page;
    }

    public function fill(EntitySeoPage &$page, SeoPage $seoPage, EntitySeoPageRequest $data): void
    {
        $page->setSeoPage($seoPage);
    }

    public function save(EntitySeoPage &$page): void
    {
        $this->_em->persist($page);
        $this->_em->flush();
    }
}
