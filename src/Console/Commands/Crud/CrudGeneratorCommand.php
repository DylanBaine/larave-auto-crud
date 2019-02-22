<?php

namespace App\Console\Commands\Crud;

use Illuminate\Console\Command;
use File;

class CrudGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:crud {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $explodedModel = explode('\\', $model);
        $modelClassName = array_last($explodedModel);
        /* unset($explodedModel[count($explodedModel) -1]);
        $modelNameSpace = implode('\\', $explodedModel); */
        $fillableArray = (new $model)->getFillable();
        $fillArray = [];
        foreach ($fillableArray as $value) {
            $fillArray[$value] = '$request->'."$value";
        }
        $tabs = "           ";
        $fillArrayString = "[\n";
        foreach ($fillArray as $key => $value) {
            $fillArrayString.="$tabs'$key' => $value,\n";
        }
        $fillArrayString .= "        ]";
        $stub = $this->fillStub([
            'model' => $modelClassName,
            'fillArray' => $fillArrayString,
            'fullModelNamespace' => $model.';',
        ]);
        File::put(app_path('Http/Controllers/Crud/'.$modelClassName.'Controller.php'), $stub);
        $this->info("App\Http\Controllers\Crud\\".$modelClassName."Controller generated.");
    }

    protected function fillStub(array $keyVals)
    {
        $controllerStub = File::get(
            app_path('Console/Commands/Generators/Crud/Stubs/Controller.stub')
        );
        foreach ($keyVals as $key => $value) {
            $controllerStub = str_replace("[$key]", $value, $controllerStub);
        }
        return $controllerStub;
    }
}
