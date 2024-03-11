<?php

namespace App\Providers;

use App\Contracts\Example\ExampleSeoPageRepository;
use App\Contracts\SeoPageGroupRepository;
use App\Contracts\SeoPageRepository;
use App\Entity\ExampleEntity\SeoPage as ExampleSeoPage;
use App\Entity\SeoPage;
use App\Entity\SeoPageGroup;
use App\Repositories\DoctrineExampleSeoPageRepository;
use App\Repositories\DoctrineSeoPageGroupRepository;
use App\Repositories\DoctrineSeoPageRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->getRepo() as $repository) {
            $this->app->bind($repository[0], function ($app) use ($repository) {
                return new $repository[1]($app['em'], $app['em']->getClassMetaData($repository[2]));
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    protected function getRepo(): array
    {
        return [
            [
                SeoPageRepository::class,
                DoctrineSeoPageRepository::class,
                SeoPage::class
            ],
            [
                SeoPageGroupRepository::class,
                DoctrineSeoPageGroupRepository::class,
                SeoPageGroup::class
            ],
            [
                ExampleSeoPageRepository::class,
                DoctrineExampleSeoPageRepository::class,
                ExampleSeoPage::class
            ]
        ];
    }
}
