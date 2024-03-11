<?php

namespace App\Dto\Example;

use App\Dto\EntitySeoPageRequest;
use App\Dto\SeoPageRequest as MainSeoPageRequest;

class SeoPageRequest extends EntitySeoPageRequest
{
    /**
     * @OA\Schema(
     *     schema="ExampleSeoPage",
     *     @OA\Property(
     *          property="seoPage",
     *          type="object",
     *          ref="#/components/schemas/SeoPage"
     *     ),
     *     @OA\Property(
     *          property="additionalField",
     *          type="string",
     *          example="test",
     *          description="Additional field"
     *     )
     * )
     */
    public function __construct(
        protected MainSeoPageRequest $seoPage,
        protected ?int $id = null,
        protected ?string $additionalField = null
    ) {
        parent::__construct($seoPage);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdditionalField(): ?string
    {
        return $this->additionalField;
    }

    public function toArray(): array
    {
        return [
            'seoPage' => $this->getSeoPage()->toArray(),
            'id' => $this->getId(),
            'additionalField' => $this->getAdditionalField(),
        ];
    }
}
