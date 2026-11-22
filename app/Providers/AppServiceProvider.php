<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Models\TbLogAktivitas;

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
        // Mencatat ketika user login
        Event::listen(Login::class, function ($event) {

            TbLogAktivitas::create([
                'id_user' => $event->user->getAuthIdentifier(),
                'aktivitas' => 'Login ke sistem',
                'jenis_kendaraan' => null,
                'waktu_aktivitas' => now(),
            ]);

        });

        // Mencatat ketika user logout
        Event::listen(Logout::class, function ($event) {

            if ($event->user) {
                TbLogAktivitas::create([
                    'id_user' => $event->user->getAuthIdentifier(),
                    'aktivitas' => 'Logout dari sistem',
                    'jenis_kendaraan' => null,
                    'waktu_aktivitas' => now(),
                ]);
            }

        });
    }
}
