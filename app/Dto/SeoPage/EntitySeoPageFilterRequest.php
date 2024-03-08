<?php

namespace App\Dto\SeoPage;

abstract class EntitySeoPageFilterRequest
{
    abstract public function __construct();

    abstract public function toArray(): array;
}
