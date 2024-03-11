<?php

namespace App\Contracts;

use App\Dto\EntitySeoPageRequest;
use App\Entity\EntitySeoPage;
use Illuminate\Pagination\LengthAwarePaginator;

interface EntitySeoPageAdminServiceContract
{
    public function list(int $page, int $pageSize): LengthAwarePaginator;

    public function show(int $id): EntitySeoPage;

    public function create(): EntitySeoPage;

    public function store(EntitySeoPageRequest $data): EntitySeoPage;

    public function update(int $id, EntitySeoPageRequest $data): EntitySeoPage;

    public function destroy(int $id): void;
}
