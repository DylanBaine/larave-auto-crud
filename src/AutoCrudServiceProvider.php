<?php

namespace Baine\AutoCrud;

use Illuminate\Support\ServiceProvider;
use Baine\AutoCrud\Console\Commands\GenerateCrudControllerCommand;

class AutoCrudServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    if ($this->app->runningInConsole()) {
      $this->commands([
        GenerateCrudControllerCommand::class,
      ]);
    }
  }
}
