<?php

namespace App\Contracts;

use App\Entity\SeoPageGroup;
use Doctrine\Persistence\ObjectRepository;

interface SeoPageGroupRepository extends ObjectRepository
{
    public function findById(int $id): SeoPageGroup;

    public function save(SeoPageGroup &$page): void;
}
