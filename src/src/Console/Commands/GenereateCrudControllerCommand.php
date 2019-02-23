<?php

namespace Baine\AutoCrud\Console\Commands;

use Illuminate\Console\Command;
use File;
use Baine\AutoCrud\Services\CreateController;

class GenerateCrudControllerCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'generate:auto-crud {model}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Generate a Controller with all CRUD actions.';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    $model = $this->argument('model');
    (new CreateController($model))->execute();
    $this->info("Controller generated successfully.");
  }
}
