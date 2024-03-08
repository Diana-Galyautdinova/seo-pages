<?php

namespace App\Dto\Catalog;

use App\Dto\SeoPage\EntitySeoPageFilterRequest;

class SeoPageFilterRequest extends EntitySeoPageFilterRequest
{
    /**
     * @OA\Schema(
     *     schema="SiteSeoPageFilter",
     *     @OA\Property(
     *          property="address",
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/SiteSeoPageFilterAddress"),
     *          description="Массив объектов с id городов, районов, улиц и т.д."
     *     ),
     *     @OA\Property(
     *          property="price",
     *          type="array",
     *          @OA\Items(type="integer"),
     *          example="[1,2]",
     *          description="Диапазон цены"
     *     ),
     *     @OA\Property(
     *          property="roomCount",
     *          type="array",
     *          @OA\Items(type="integer"),
     *          example="[1, 2]",
     *          description="Комнатность"
     *     ),
     *     @OA\Property(
     *          property="kitchenArea",
     *          type="array",
     *          @OA\Items(type="float"),
     *          example="[12.32, 15]",
     *          description="Площадь кухни"
     *     ),
     * )
     */
    public function __construct(
        protected ?array $address = [],
        protected ?array $roomCount = [],
        protected ?array $price = [],
        protected ?array $kitchenArea = [],
    ) {
    }

    public function toArray(): array
    {
        $arrAddress = [];
        foreach ($this->address as $address) {
            /** @var SeoPageFilterAddressRequest $address */
            $arrAddress[] = $address->toArray();
        }

        return [
            'address' => $arrAddress,
            'roomCount' => $this->roomCount,
            'price' => $this->price,
            'kitchenArea' => $this->kitchenArea,
        ];
    }
}
