<?php
namespace App\Providers;

use App\Models\Invitation;
use App\Models\ShortUrl;
use App\Policies\InvitationPolicy;
use App\Policies\ShortUrlPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        ShortUrl::class   => ShortUrlPolicy::class,
        Invitation::class => InvitationPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
