<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Todo;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::group(['middleware'=>'auth'], function(){
    //fetch contacts
    Route::get('todos', 'HomeController@fetchTodos');
    //fetch single contact
    Route::get('todo/{id}', 'HomeController@fetchTodo');
    //add contact
    Route::post('todo/store','HomeController@addTodo');
    //update contact
    Route::patch('todo/update/{id}','HomeController@updateTodo');
    //delete contact
    Route::delete('todo/delete/{id}','HomeController@deleteTodo');
    //mark done
    Route::post('todo/done/{id}','HomeController@markAsDone');
});
