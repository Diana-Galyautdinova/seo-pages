<?php

namespace App\Services\Catalog;

//use App\Modules\Fias\Entity\District;
//use App\Modules\Fias\Entity\FiasAddress;
use App\Contracts\Catalog\CatalogSeoPageRepository;
use App\Dto\EntitySeoPageRequest;
use App\Enum\RoomCountEnum;
use App\Entity\Catalog\SeoPage as CatalogSeoPage;
use App\Entity\EntitySeoPage;
//use App\Job\Catalog\RabbitSendCatalogSeoPage;
use App\Services\EntitySeoPageAdminService;
use App\Services\ValidateSeoPageService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SeoPageAdminService extends EntitySeoPageAdminService
{
    public function __construct()
    {
        parent::__construct();
        /** @phpstan-ignore-next-line */
        $this->repository = app(CatalogSeoPageRepository::class);
        $this->alias = 'site_catalog_seo_page';
    }

    /**
     * @throws ValidationException
     */
    protected function validate(EntitySeoPageRequest $request, ?int $id = null)
    {
        $data = $request->toArray();
        $validator = Validator::make($data, [
            'dealType' => ['required', 'in:sale,rent'],
            'seoPage' => ['required', 'array'],
            'seoPage.filters' => ['array'],
            'seoPage.filters.address' => ['sometimes', 'nullable', 'array', 'max:50'],
            'seoPage.filters.address.*.fiasId' => [
                'required_without:seoPage.filters.address.*.districtId',
                'nullable',
                'string',
                Rule::exists(FiasAddress::class, 'fiasGuid')
            ],
            'seoPage.filters.address.*.districtId' => [
                'required_without:seoPage.filters.address.*.fiasId',
                'nullable',
                'uuid',
                'exists:' . District::class . ',id'
            ],
            'seoPage.filters.kitchenArea' => ['sometimes', 'nullable', 'array'],
            'seoPage.filters.roomCount' => ['sometimes', 'nullable', 'array'],
            'seoPage.filters.roomCount.*' => ['numeric', Rule::in(array_column(RoomCountEnum::cases(), 'value'))],
            'seoPage.filters.price' => ['sometimes', 'array', 'max:2'],
            'seoPage.filters.price.0' => ['sometimes', 'nullable', 'numeric', 'min: 0', 'max: 1000000000'],
            'seoPage.filters.price.1' => ['sometimes', 'nullable', 'numeric', 'min: 0', 'max: 1000000000'],
        ]);
        $validator->after(function (\Illuminate\Contracts\Validation\Validator $validator) use ($data) {
            if (!$validator->failed()) {
                $ar = CatalogSeoPage::getStructure();
                if (!in_array($data['objectType'], $ar[$data['dealType']])) {
                    $validator->errors()->add(
                        "objectType",
                        'Неверный тип объекта'
                    );
                }
            }
        });

        $validator->validate();

        ValidateSeoPageService::validate($request->getSeoPage(), $request->getSeoPage()->getId());
    }

    public function store(EntitySeoPageRequest $data): EntitySeoPage
    {
        $entity = parent::store($data);
        /** @var CatalogSeoPage $entity */
        $Job = new RabbitSendCatalogSeoPage($entity->getId());
        dispatch($Job);

        return $entity;
    }

    public function update(int $id, EntitySeoPageRequest $data): EntitySeoPage
    {
        $entity = parent::update($id, $data);
        /** @var CatalogSeoPage $entity */
        $Job = new RabbitSendCatalogSeoPage($entity->getId());
        dispatch($Job);

        return $entity;
    }
}
