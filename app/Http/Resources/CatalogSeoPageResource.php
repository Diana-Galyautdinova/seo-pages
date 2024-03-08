<?php

namespace App\Http\Resources;

//use Anflat\EntityEnum\Deal\Type;
use App\Http\Resources\Options\OptionsArrayResource;
use App\Entity\Catalog\SeoPage as CatalogSeoPage;
use App\Enum\Catalog\ObjectType;
//use App\Filters\Catalog\RoomCountFilter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CatalogSeoPageResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="SiteCatalogSeoPageDistrict",
     *     @OA\Property(
     *          property="districtId",
     *          type="array",
     *          description="Id района",
     *          @OA\Items(
     *               type="object",
     *               @OA\Property(
     *                    property="value",
     *                    type="string"
     *               ),
     *               @OA\Property(
     *                    property="name",
     *                    type="string"
     *               ),
     *          )
     *     ),
     *     @OA\Property(
     *          property="cityId",
     *          type="array",
     *          description="Id города",
     *          @OA\Items(
     *               type="object",
     *               @OA\Property(
     *                    property="value",
     *                    type="string"
     *               ),
     *               @OA\Property(
     *                    property="name",
     *                    type="string"
     *               ),
     *          )
     *     ),
     *     @OA\Property(
     *          property="settlementId",
     *          type="array",
     *          description="Id населенного пункта",
     *          @OA\Items(
     *               type="object",
     *               @OA\Property(
     *                    property="value",
     *                    type="string"
     *               ),
     *               @OA\Property(
     *                    property="name",
     *                    type="string"
     *               ),
     *          )
     *     ),
     *     @OA\Property(
     *          property="objectType",
     *          type="array",
     *          description="Тип объекта",
     *          @OA\Items(
     *               type="object",
     *               @OA\Property(
     *                    property="value",
     *                    type="string"
     *               ),
     *               @OA\Property(
     *                    property="name",
     *                    type="string"
     *               ),
     *          )
     *     ),
     *     @OA\Property(
     *          property="dealType",
     *          type="array",
     *          description="Тип сделки",
     *          @OA\Items(
     *               type="object",
     *               @OA\Property(
     *                    property="value",
     *                    type="string"
     *               ),
     *               @OA\Property(
     *                    property="name",
     *                    type="string"
     *               ),
     *          )
     *     ),
     * )
     * @param Request $request
     * @return OptionsArrayResource[][]|array
     */
    public function with($request)
    {
        if (!($this->resource instanceof CatalogSeoPage)) {
            throw new Exception('need ' . CatalogSeoPage::class);
        }

        /** @var CatalogSeoPage $this */

        $objectType = [];
        foreach (ObjectType::cases() as $case) {
            $objectType[$case->value] = $case->name;
        }

        $dealType = [
            Type::Rent->value => Type::Rent->getLabel(),
            Type::Sale->value => Type::Sale->getLabel(),
        ];

        $roomCount = new RoomCountFilter();
        $roomCountOptions = $roomCount->valueOptions();
        unset($roomCountOptions['studio']); // во вторичке нет студии

        $filters = [
            'roomCount' => new OptionsArrayResource($roomCountOptions),
        ];

        $dictionarySeo = (new SeoPageResource($this->getSeoPage()))->with($request)['dictionary'];
        $dictionary = array_merge([
            'objectType' => new OptionsArrayResource($objectType),
            'dealType' => new OptionsArrayResource($dealType),
        ], $dictionarySeo, $filters);

        return [
            'dictionary' => $dictionary
        ];
    }

    /**
     * @param $request
     * @return array
     * @throws Exception
     */
    public function toArray($request): array
    {
        if (!($this->resource instanceof CatalogSeoPage)) {
            throw new Exception('need ' . CatalogSeoPage::class);
        }

        /** @var CatalogSeoPage $this */

        return [
            'id' => $this->getId(),
            'seoPage' => new SeoPageResource($this->getSeoPage()),
            'objectType' => $this->getObjectType(),
            'dealType' => $this->getDealType(),
        ];
    }
}
