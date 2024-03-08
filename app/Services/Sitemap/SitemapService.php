<?php

namespace App\Services\Sitemap;

use Carbon\Carbon;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

abstract class SitemapService implements Sitemapable
{
    protected ?int $time = null;
    protected string $frequency = 'weekly';
    protected string $priority = '0.8';
    protected ?string $url = null;

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function setLastModificationDate(int $time): void
    {
        $this->time = $time;
    }

    public function setChangeFrequency(string $frequency = 'weekly'): void
    {
        $this->frequency = $frequency;
    }

    public function setPriority(string $priority = '0.8'): void
    {
        $this->priority = $priority;
    }

    public function toSitemapTag(): Url | string | array
    {
        return Url::create($this->url . '/')
            ->setLastModificationDate($this->time ?? Carbon::now())
            ->setChangeFrequency($this->frequency)
            ->setPriority((float) $this->priority);
    }
}
