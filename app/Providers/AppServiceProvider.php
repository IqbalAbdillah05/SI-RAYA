<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

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
        \DB::enableQueryLog(); // Mengaktifkan log query
        
        // Tambahkan listener untuk SQL query
        \DB::listen(function($query) {
            \Log::info(
                'SQL Query: ' . $query->sql,
                [
                    'Bindings' => $query->bindings,
                    'Time' => $query->time
                ]
            );
        });
        Log::info('AppServiceProvider boot method called');
    }
}
