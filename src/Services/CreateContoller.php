<?php
namespace Baine\AutoCrud\Services;

use File;

class CreateController
{
  public function __construct(string $model)
  {
    $this->model = $model;
  }
  public function execute()
  {
    $explodedModel = explode('\\', $this->model);
    $modelClassName = array_last($explodedModel);
    $fillableArray = (new $this->model)->getFillable();
    $fillArray = [];
    foreach ($fillableArray as $value) {
      $fillArray[$value] = '$request->' . "$value";
    }
    $tabs = "           ";
    $fillArrayString = "[\n";
    foreach ($fillArray as $key => $value) {
      $fillArrayString .= "$tabs'$key' => $value,\n";
    }
    $fillArrayString .= "        ]";
    $stub = $this->fillStub([
      'model' => $modelClassName,
      'fillArray' => $fillArrayString,
      'fullModelNamespace' => $this->model . ';',
    ]);
    File::put(app_path('Http/Controllers/' . $modelClassName . 'Controller.php'), $stub);
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