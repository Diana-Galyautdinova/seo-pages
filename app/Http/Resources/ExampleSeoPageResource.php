<?php

namespace App\Http\Resources;

use App\Entity\ExampleEntity\SeoPage as ExampleSeoPage;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;

class ExampleSeoPageResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     * @throws Exception
     */
    public function toArray($request): array
    {
        if (!($this->resource instanceof ExampleSeoPage)) {
            throw new Exception('need ' . ExampleSeoPage::class);
        }

        /** @var ExampleSeoPage $this */

        return [
            'id' => $this->getId(),
            'seoPage' => new SeoPageResource($this->getSeoPage()),
            'additionalField' => $this->getAdditionalField(),
        ];
    }
}
