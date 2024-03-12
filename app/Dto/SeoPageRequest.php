<?php

namespace App\Dto;

use App\Dto\SeoPage\EntitySeoPageFilterRequest;
use Illuminate\Contracts\Support\Arrayable;

class SeoPageRequest implements Arrayable
{
    /**
     * @OA\Schema(
     *     schema="SeoPage",
     *     @OA\Property(
     *          property="slug",
     *          type="string",
     *          example="deshovie",
     *          description="Slug of page"
     *     ),
     *     @OA\Property(
     *          property="active",
     *          type="boolean",
     *          example="true",
     *          description="Active\Not active"
     *     ),
     *     @OA\Property(
     *          property="seoTitle",
     *          type="string",
     *          example="Test title",
     *          description="Title"
     *     ),
     *     @OA\Property(
     *          property="seoH1",
     *          type="string",
     *          example="test H1",
     *          description="H1"
     *     ),
     *     @OA\Property(
     *          property="seoKeywords",
     *          type="string",
     *          example="test Keywords",
     *          description="Keywords of seo page"
     *     ),
     *     @OA\Property(
     *          property="seoDescription",
     *          type="string",
     *          example="test description",
     *          description="Description"
     *     ),
     *     @OA\Property(
     *          property="seoText",
     *          type="string",
     *          example="test text",
     *          description="text"
     *     ),
     *     @OA\Property(
     *          property="filters",
     *          type="object",
     *          ref="#/components/schemas/SeoPageFilter",
     *          description="Filters"
     *     ),
     *     @OA\Property(
     *          property="sort",
     *          type="integer",
     *          nullable=true
     *     ),
     *     @OA\Property(
     *          property="fillManually",
     *          type="boolean",
     *          nullable=true
     *     ),
     * )
     */
    public function __construct(
        protected ?int $id = null,
        protected ?string $slug = null,
        protected ?string $name = null,
        protected ?bool $active = null,
        protected ?int $groupId = null,
        protected ?int $sort = null,
        protected ?string $seoTitle = null,
        protected ?string $seoH1 = null,
        protected ?string $seoDescription = null,
        protected ?string $seoKeywords = null,
        protected ?string $seoText = null,
        protected ?EntitySeoPageFilterRequest $filters = null,
        protected ?bool $fillManually = null
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     */
    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return bool|null
     */
    public function getActive(): ?bool
    {
        return $this->active;
    }

    /**
     * @param bool|null $active
     */
    public function setActive(?bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return int|null
     */
    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    /**
     * @param int|null $groupId
     */
    public function setGroupId(?int $groupId): void
    {
        $this->groupId = $groupId;
    }

    /**
     * @return string|null
     */
    public function getSeoTitle(): ?string
    {
        return $this->seoTitle;
    }

    /**
     * @param string|null $seoTitle
     */
    public function setSeoTitle(?string $seoTitle): void
    {
        $this->seoTitle = $seoTitle;
    }

    /**
     * @return string|null
     */
    public function getSeoH1(): ?string
    {
        return $this->seoH1;
    }

    /**
     * @param string|null $seoH1
     */
    public function setSeoH1(?string $seoH1): void
    {
        $this->seoH1 = $seoH1;
    }

    /**
     * @return string|null
     */
    public function getSeoDescription(): ?string
    {
        return $this->seoDescription;
    }

    /**
     * @param string|null $seoDescription
     */
    public function setSeoDescription(?string $seoDescription): void
    {
        $this->seoDescription = $seoDescription;
    }

    /**
     * @return string|null
     */
    public function getSeoKeywords(): ?string
    {
        return $this->seoKeywords;
    }

    /**
     * @param string|null $seoKeywords
     */
    public function setSeoKeywords(?string $seoKeywords): void
    {
        $this->seoKeywords = $seoKeywords;
    }

    /**
     * @return string|null
     */
    public function getSeoText(): ?string
    {
        return $this->seoText;
    }

    /**
     * @param string|null $seoText
     */
    public function setSeoText(?string $seoText): void
    {
        $this->seoText = $seoText;
    }

    /**
     * @return EntitySeoPageFilterRequest|null
     */
    public function getFilters(): ?EntitySeoPageFilterRequest
    {
        return $this->filters;
    }

    /**
     * @param EntitySeoPageFilterRequest|null $filters
     */
    public function setFilters(?EntitySeoPageFilterRequest $filters): void
    {
        $this->filters = $filters;
    }

    /**
     * @return int|null
     */
    public function getSort(): ?int
    {
        return $this->sort;
    }

    /**
     * @param int|null $sort
     */
    public function setSort(?int $sort): void
    {
        $this->sort = $sort;
    }

    /**
     * @return bool|null
     */
    public function getFillManually(): ?bool
    {
        return $this->fillManually;
    }

    /**
     * @param bool|null $fillManually
     */
    public function setFillManually(?bool $fillManually): void
    {
        $this->fillManually = $fillManually;
    }

    public function toArray(): array
    {
        return [
            'slug' => $this->slug,
            'active' => $this->active,
            'seoH1' => $this->seoH1,
            'seoTitle' => $this->seoTitle,
            'seoKeywords' => $this->seoKeywords,
            'seoDescription' => $this->seoDescription,
            'seoText' => $this->seoText,
            'filters' => $this->filters->toArray(),
            'fillManually' => $this->fillManually,
            'sort' => $this->sort
        ];
    }
}
