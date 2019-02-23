<?php
namespace Baine\AutoCrud\Services;

use File;
use Illuminate\Database\Eloquent\Model;

class CreateController
{
  public function __construct(string $model, bool $addRoutes = false)
  {
    $this->verifyModel($model);
    $this->model = $model;
    $this->explodedModelNamespace = explode('\\', $this->model);
  }
  private function verifyModel($model)
  {
    if (!new $model instanceof Model) {
      throw new \InvalidArgumentException("[$model] must be an instance of " . Model::class . " to generate a CRUD Controller.");
    }
  }
  public function execute()
  {
    $stub = $this->fillStub([
      'model' => $this->getModelClassName(),
      'fillArray' => $this->generateFillArrayString(),
      'fullModelNamespace' => $this->model . ';',
      'controllerNamespace' => $this->getControllerNamespace()
    ]);
    $controllerName = $this->getControllerName();
    File::put(app_path("Http/Controllers/$controllerName"), $stub);
  }

  protected function getModelClassName()
  {
    return array_last($this->explodedModelNamespace);
  }

  protected function getControllerName()
  {
    return $this->getModelClassName() . "Controller.php";
  }

  protected function getControllerNamespace()
  {
    return 'App\\Http\\Controllers';
  }

  protected function generateFillArrayString()
  {
    $fillableArray = (new $this->model)->getFillable();
    $tabs = "           ";
    $fillArrayString = "[\n";
    $fillArray = [];
    foreach ($fillableArray as $key => $value) {
      $fillArrayString .= "$tabs'$value' => \$request->$value,\n";
    }
    $fillArrayString .= "        ]";
    return $fillArrayString;
  }

  protected function fillStub(array $keyVals)
  {
    $controllerStub = File::get(dirname(__DIR__, 1) . '/Stubs/CrudController.stub', false);
    foreach ($keyVals as $key => $value) {
      $controllerStub = str_replace("[$key]", $value, $controllerStub);
    }
    return $controllerStub;
  }
}