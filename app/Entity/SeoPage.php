<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="site_seo_page",
 * )
 */
class SeoPage
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected ?int $id = null;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected ?bool $active = true;

    /**
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    protected ?string $slug = null;

    /**
     * @ORM\Column(type="string", nullable=true, options={"default": null})
     */
    protected ?string $name = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SeoPageGroup", fetch="EAGER", cascade={"persist"})
     * @ORM\JoinColumn(fieldName="group_id", nullable=true)
     */
    protected ?SeoPageGroup $group = null;

    /**
     * @ORM\Column(type="string")
     */
    protected ?string $seoTitle = null;

    /**
     * @ORM\Column(type="string")
     */
    protected ?string $seoH1 = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $seoKeywords = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $seoDescription = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected ?string $seoText = null;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    protected ?array $filters = null;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    protected int $sort = 0;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default": null})
     */
    protected ?bool $fillManually = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
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
     * @return string|null
     */
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
     * @return SeoPageGroup|null
     */
    public function getGroup(): ?SeoPageGroup
    {
        return $this->group;
    }

    /**
     * @param SeoPageGroup|null $group
     */
    public function setGroup(?SeoPageGroup $group): void
    {
        $this->group = $group;
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
     * @return array|null
     */
    public function getFilters(): ?array
    {
        return $this->filters;
    }

    /**
     * @param array|null $filters
     */
    public function setFilters(?array $filters): void
    {
        $this->filters = $filters;
    }

    /**
     * @return int
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * @param int $sort
     */
    public function setSort(int $sort): void
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
}
