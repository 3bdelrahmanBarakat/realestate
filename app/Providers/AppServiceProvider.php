<?php

namespace App\Providers;

use App\Interfaces\AppointmentInterface;
use App\Interfaces\CategoryInterface;
use App\Interfaces\FavoriteInterface;
use App\Interfaces\OwnerInterface;
use App\Interfaces\PropertyActionInterface;
use App\Interfaces\PropertyInterface;
use App\Interfaces\PropertyListingInterface;
use App\Interfaces\ReportInterface;
use App\Interfaces\UserInterface;
use App\Repositories\AppointmentRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\FavoriteRepository;
use App\Repositories\OwnerRepository;
use App\Repositories\PropertyActionRepository;
use App\Repositories\PropertyListingRepository;
use App\Repositories\PropertyRepository;
use App\Repositories\ReportRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(PropertyInterface::class, PropertyRepository::class);
        $this->app->bind(PropertyActionInterface::class, PropertyActionRepository::class);
        $this->app->bind(ReportInterface::class, ReportRepository::class);
        $this->app->bind(PropertyListingInterface::class, PropertyListingRepository::class);
        $this->app->bind(AppointmentInterface::class, AppointmentRepository::class);
        $this->app->bind(OwnerInterface::class, OwnerRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(FavoriteInterface::class, FavoriteRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
