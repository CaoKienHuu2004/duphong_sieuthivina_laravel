<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\DanhmucModel;
use App\Models\TukhoaModel;
use Illuminate\Support\Facades\View;
use App\Livewire\GiohangComponent;
use Illuminate\Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {   
        Livewire::component('giohang-thong-nhat', GiohangComponent::class);
    }
}
