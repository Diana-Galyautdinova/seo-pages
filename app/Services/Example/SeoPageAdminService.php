<?php

namespace App\Services\Example;

use App\Contracts\Example\ExampleSeoPageRepository;
use App\Dto\EntitySeoPageRequest;
use App\Services\EntitySeoPageAdminService;
use App\Services\ValidateSeoPageService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SeoPageAdminService extends EntitySeoPageAdminService
{
    public function __construct()
    {
        parent::__construct();
        /** @phpstan-ignore-next-line */
        $this->repository = app(ExampleSeoPageRepository::class);
        $this->alias = 'example_entity_seo_page';
    }

    /**
     * @throws ValidationException
     */
    protected function validate(EntitySeoPageRequest $request, ?int $id = null)
    {
        $data = $request->toArray();
        $validator = Validator::make($data, [
            'additionalField' => ['required', 'string'],
            'seoPage' => ['required', 'array'],
            'seoPage.filters' => ['array'],
            'seoPage.filters.price' => ['sometimes', 'nullable', 'array', 'max:50'],
            'seoPage.filters.price.*' => ['required', 'numeric'],
        ]);

        $validator->validate();

        ValidateSeoPageService::validate($request->getSeoPage(), $request->getSeoPage()->getId());
    }
}
