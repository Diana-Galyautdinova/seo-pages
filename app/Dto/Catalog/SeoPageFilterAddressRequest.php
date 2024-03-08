<?php

namespace App\Dto\Catalog;

use App\Dto\SeoPage\EntitySeoPageFilterRequest;

class SeoPageFilterAddressRequest extends EntitySeoPageFilterRequest
{
    /**
     * @OA\Schema(
     *     schema="SiteSeoPageFilterAddress",
     *     @OA\Property(
     *          property="fiasId",
     *          type="string",
     *          example="1",
     *          description="Конечная точка Id fias"
     *     ),
     *     @OA\Property(
     *          property="districtId",
     *          type="string",
     *          example="2",
     *          description="Конечная точка Id district"
     *     )
     * )
     */
    public function __construct(
        protected ?string $districtId = null,
        protected ?string $fiasId = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'fiasId' => $this->fiasId,
            'districtId' => $this->districtId,
        ];
    }
}
