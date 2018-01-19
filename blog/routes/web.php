<?php

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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('index');

// Route::get('/', function () {
//     return view('welcome');
// });


Route::group(['prefix' => 'post', 'middleware' => 'auth'], function () {
});

/** login */
Route::get('login', 'Login\LoginController@show')->name('login');
Route::post('login', 'Login\LoginController@login')->name('login');
Route::get('logout', 'Login\LoginController@logout')->name('logout');
Route::get('login/reset', 'Login\LoginController@passwordReset')->name('password.reset');
Route::post('login/reset', 'Login\LoginController@passwordMail')->name('password.mail');
Route::get('login/password/{key}', 'Login\LoginController@pwdResetByURL')->name('login.pwdUpdateByURL')->where('key', '[A-Fa-f0-9]{64}');
Route::post('login/password/{key}', 'Login\LoginController@pwdUpdateByURL')->name('login.pwdUpdateByURL')->where('key', '[A-Fa-f0-9]{64}');

/**  register */
Route::get('register', 'Login\RegisterController@show')->name('register');
Route::post('register', 'Login\RegisterController@register')->name('register');
/**  register enable */
Route::get('register/enable/{key}', 'Login\RegisterController@enable')->name('register.enable')->where('key', '[A-Fa-f0-9]{64}');
Route::post('register/enable/{key}', 'Login\RegisterController@password')->name('register.enable')->where('key', '[A-Fa-f0-9]{64}');
Route::get('register/enable/success', 'Login\RegisterController@success')->name('register.success');

Route::group(['middleware' => 'auth'], function () {
    /** user center*/
    Route::get('user', 'User\UserController@show')->name('user');
    Route::get('user/edit', 'User\UserController@edit')->name('user.edit');
    Route::post('user/update', 'User\UserController@update')->name('user.update');
    Route::get('user/password', 'User\UserController@pwdEdit')->name('user.password');
    Route::post('user/password', 'User\UserController@pwdUpdate')->name('user.password');
   
    /** userProfile */
    Route::get('userProfile', 'User\UserProfileController@read')->name('userProfile.read');
    Route::post('userProfile/store', 'User\UserProfileController@store')->name('userProfile.store');
    Route::get('userProfile/edit', 'User\UserProfileController@edit')->name('userProfile.edit');
// Route::get('userProfile/create', 'User\UserProfileController@create')->name('userProfile.create');
// Route::post('userProfile/update', 'User\UserProfileController@update')->name('userProfile.update');
});


Route::group(['middleware' => ['auth', 'checkUser']], function () {

    /** meal record 當日*/
    Route::get('mealRecord/read', 'MealRecord\MealRecordController@read')->name('mealRecord.read');
    Route::get('mealRecord/create', 'MealRecord\MealRecordController@create')->name('mealRecord.create');
    Route::post('mealRecord/createStore', 'MealRecord\MealRecordController@createStore')->name('mealRecord.createStore');
    Route::get('mealRecord/createDate', 'MealRecord\MealRecordController@createDate')->name('mealRecord.createDate');
    /** create food */
    Route::get('food/create', 'MealRecord\FoodController@create')->name('food.create');
    Route::post('food/createStore', 'MealRecord\FoodController@createStore')->name('food.createStore');

    Route::get('mealRecord/getFood', 'MealRecord\MealRecordController@getFood')->name('mealRecord.getFood');
    Route::get('mealRecord/getFoodDesc', 'MealRecord\MealRecordController@getFoodDesc')->name('mealRecord.getFoodDesc');

    // 列表跟圖表
    Route::get('sevenMealRecord/readList', 'MealRecord\SevenMealRecordController@readList')->name('sevenMealRecord.readList');
    Route::get('sevenMealRecord/readChart', 'MealRecord\SevenMealRecordController@readChart')->name('sevenMealRecord.readChart');

    // 日期
    Route::get('dateMealRecord/readList', 'MealRecord\DateMealRecordController@readList')->name('dateMealRecord.readList');
    Route::get('dateMealRecord/readChart', 'MealRecord\DateMealRecordController@readChart')->name('dateMealRecord.readChart');
});
/** test */
// Route::group(['middleware' => 'auth'], function () {
//     Route::get('user/{id}', 'UserController@show');
// });
// Route::get('foo/{id}', function ($id) {
//     return 'Hello World' . $id;
// });
