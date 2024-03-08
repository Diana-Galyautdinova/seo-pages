<?php

namespace App\Entity;

use App\Contracts\EntitySeoPageContract;
use App\Services\Sitemap\SitemapService;
use Doctrine\ORM\Mapping as ORM;
use Spatie\Sitemap\Tags\Url;

abstract class EntitySeoPage extends SitemapService implements EntitySeoPageContract
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SeoPage", fetch="EAGER", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    protected SeoPage $seoPage;

    public function __construct(SeoPage $seoPage)
    {
        $this->setSeoPage($seoPage);
    }

    /**
     * @return SeoPage
     */
    public function getSeoPage(): SeoPage
    {
        return $this->seoPage;
    }

    /**
     * @param SeoPage $seoPage
     * @return void
     */
    public function setSeoPage(SeoPage $seoPage): void
    {
        $this->seoPage = $seoPage;
    }

    public function toSitemapTag(): Url | string | array
    {
        return Url::create($this->url . '/' . $this->getSeoPage()->getSlug());
    }
}
