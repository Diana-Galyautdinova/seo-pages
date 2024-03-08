<?php

namespace App\Dto\Catalog;

use App\Dto\EntitySeoPageRequest;
use App\Dto\SeoPageRequest as MainSeoPageRequest;

class SeoPageRequest extends EntitySeoPageRequest
{
    /**
     * @OA\Schema(
     *     schema="SiteCatalogSeoPage",
     *     @OA\Property(
     *          property="seoPage",
     *          type="object",
     *          ref="#/components/schemas/SiteSeoPage"
     *     ),
     *     @OA\Property(
     *          property="objectType",
     *          type="string",
     *          example="apartments",
     *          description="тип объекта"
     *     ),
     *     @OA\Property(
     *          property="dealType",
     *          type="string",
     *          example="sale",
     *          description="тип сделки"
     *     )
     * )
     */
    public function __construct(
        protected MainSeoPageRequest $seoPage,
        protected ?int $id = null,
        protected ?string $dealType = null,
        protected ?string $objectType = null
    ) {
        parent::__construct($seoPage);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDealType(): ?string
    {
        return $this->dealType;
    }

    public function getObjectType(): ?string
    {
        return $this->objectType;
    }

    public function toArray(): array
    {
        return [
            'seoPage' => $this->getSeoPage()->toArray(),
            'id' => $this->getId(),
            'dealType' => $this->getDealType(),
            'objectType' => $this->getObjectType(),
        ];
    }
}
