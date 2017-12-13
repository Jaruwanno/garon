<?php

namespace User;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      require __DIR__ . '/routes/routes.php';
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->bind('user', function(){
        return new User();
      });
    }
}
