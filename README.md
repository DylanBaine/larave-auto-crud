# Auto Generate Laravel Resourceful CRUD controllers

To install run ```composer require baine/laravel-auto-crud```.

To generate an auto-crud controller from the console, run ```php artisan generate:auto-crud App\\Models\<CrudModel>```.
A new <CrudModel>Controller class will be put into the App\Http\Controllers directory.
  
To generate an auto-crud controller from anywhere else, you can use the following code:
 ```(new Baine\AutoCrud\Services\CreateController(App\Models\<CrudModel>::class))->execute()```
 and the class will create a crud controller just like the command.
