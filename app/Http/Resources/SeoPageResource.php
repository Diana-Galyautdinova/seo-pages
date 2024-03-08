<?php

namespace App\Http\Resources;

use App\Http\Resources\Options\OptionsArrayResource;
use App\Contracts\SeoPageGroupRepository;
use App\Entity\SeoPage;
use App\Entity\SeoPageGroup;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeoPageResource extends JsonResource
{
    /**
     * @param Request $request
     * @return OptionsArrayResource[][]|array
     */
    public function with($request)
    {
        /** @var SeoPageGroupRepository $groupRepo */
        $groupRepo = app(SeoPageGroupRepository::class);
        $Groups = $groupRepo->findAll();

        $arGroup = [];
        foreach ($Groups as $Group) {
            /** @var SeoPageGroup $Group */
            $arGroup[$Group->getId()] = $Group->getName();
        }

        $dictionary = [
            'groupId' => new OptionsArrayResource($arGroup),
        ];

        return [
            'dictionary' => $dictionary
        ];
    }

    /**
     * @param $request
     * @return array
     * @throws Exception
     */
    public function toArray($request)
    {
        if (!($this->resource instanceof SeoPage)) {
            throw new Exception('need ' . SeoPage::class);
        }

        /** @var SeoPage $this */

        return [
            'id' => $this->getId(),
            'active' => $this->getActive(),
            'slug' => $this->getSlug(),
            'name' => $this->getName(),
            'groupId' => $this->getGroup()?->getId(),
            'seoH1' => $this->getSeoH1(),
            'seoTitle' => $this->getSeoTitle(),
            'seoDescription' => $this->getSeoDescription(),
            'seoKeywords' => $this->getSeoKeywords(),
            'seoText' => $this->getSeoText(),
            'filters' => $this->getFilters(),
            'sort' => $this->getSort(),
            'fillManually' => $this->getFillManually()
        ];
    }
}
