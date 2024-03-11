<?php

namespace App\Repositories;

use App\Contracts\SeoPageGroupRepository;
use App\Entity\SeoPageGroup;
use Doctrine\ORM\EntityRepository;
use Illuminate\Database\RecordsNotFoundException;

/**
 * @method  findOne(array $array)
 */
class DoctrineSeoPageGroupRepository extends EntityRepository implements SeoPageGroupRepository
{
    public function findById(int $id): SeoPageGroup
    {
        $PageGroup = $this->findOneBy([
            'id' => $id,
        ]);

        if (!($PageGroup instanceof SeoPageGroup)) {
            throw new RecordsNotFoundException();
        }

        return $PageGroup;
    }

    public function save(SeoPageGroup &$page): void
    {
        $this->_em->persist($page);
        $this->_em->flush();
    }
}
