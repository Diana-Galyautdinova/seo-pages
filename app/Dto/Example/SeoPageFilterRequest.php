<?php

namespace App\Dto\Example;

use App\Dto\SeoPage\EntitySeoPageFilterRequest;

class SeoPageFilterRequest extends EntitySeoPageFilterRequest
{
    /**
     * @OA\Schema(
     *     schema="SeoPageFilter",
     *     @OA\Property(
     *          property="price",
     *          type="array",
     *          @OA\Items(type="integer"),
     *          example="[1,2]",
     *          description="Price range"
     *     )
     * )
     */
    public function __construct(
        protected ?array $price = [],
    ) {
    }

    public function toArray(): array
    {
        return [
            'price' => $this->price,
        ];
    }
}
