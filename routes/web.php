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
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Auth::routes(['register' => false]);

Route::get('/login', function () {
        Auth::logout();
        return view('auth.login');
})->name('login');

Route::get('/','StartController@home')->middleware(['auth', 'auth.unique.user', 'check.sec.user']);
Route::group(['prefix' => '/inicio', 'middleware' => ['auth', 'web', 'auth.unique.user']], function () {
    Route::get('/','StartController@home')->name('home');
});
Route::group(['prefix' => '/employees', 'middleware' => ['auth', 'web', 'auth.unique.user', 'check.sec.user']], function () {

    Route::get('/', 'EmployeesController@show')->name('showEmployees');
    Route::get('/add', 'EmployeesController@criaFunc')->name('criaFunc');
    Route::post('/create', 'EmployeesController@create')->name('createFunc');
    Route::get('/delete/{id}', 'EmployeesController@delete')->name('deleteFunc');
    Route::get('/allfuncs/{id}', 'EmployeesController@allFuncs')->name('allFuncs');
    Route::get('/auths/{id}', 'EmployeesController@authsFuncVehi')->name('authsFuncVehi');
    Route::get('/editfunc/{id}', 'EmployeesController@editFunc')->name('editFunc');
    Route::post('/update', 'EmployeesController@update')->name('updateFunc');
    Route::get('/getdata', 'EmployeesController@getdata')->name('getdataFunc');
    Route::get('/profile', 'EmployeesController@profileFunc')->name('profileFunc');
    Route::post('/upprofile', 'EmployeesController@upProfileFunc')->name('upProfileFunc');
    Route::get('/auths/{id}', 'EmployeesController@authsFuncVehi')->name('authsFuncVehi');
    Route::get('/deleteauth/{id}', 'EmployeesController@deleteAuth')->name('deleteAuth');
    Route::get('/allfuncs/secretaria/{id}', 'EmployeesController@funcsSec');

});

Route::group(['prefix' => '/setores', 'middleware' => ['auth', 'web', 'auth.unique.user', 'check.sec.user']], function () {

    Route::get('/', 'SetoresController@show')->name('setoresShow');
    Route::get('/add', 'SetoresController@adcSetor')->name('adcSetor');
    Route::post('/create', 'SetoresController@create')->name('createSector');
    Route::get('/pesquisaSector/{id}', 'SetoresController@sectors')->name('sector');
    Route::get('/delete/{id}', 'SetoresController@delete')->name('deleteSector');
    Route::get('/getdata', 'SetoresController@getdata')->name('getdataSectors');
    Route::get('/getsectors/{id}', 'SetoresController@getsectors')->name('getsectors');

});
Route::group(['prefix' => '/secretarias', 'middleware' => ['auth', 'web', 'auth.unique.user', 'check.sec.user']], function () {

    Route::get('/', 'SecretariasController@show')->name('SecretariasShow');
    Route::get('/add', 'SecretariasController@adicionar')->name('adicionarSec');
    Route::post('/create', 'SecretariasController@create')->name('createSec');
    Route::get('/view/{id}', 'SecretariasController@view')->name('viewSec');
    Route::get('/usersAdmin/{id}', 'SecretariasController@usersAdmin')->name('usersAdmin');
    Route::post('/add/admin', 'SecretariasController@addFuncAdmSec')->name('addUsrAdmSec');
    Route::get('/delUserAdmSec/{id}', 'SecretariasController@delUserAdmSec')->name('delUserAdmSec');
    Route::get('/usersForAdm/{id}', 'SecretariasController@usersForAdm')->name('usersForAdm');
    Route::get('/getdata', 'SecretariasController@getdata')->name('getdataSecs');
});
Route::group(['prefix' => '/logs', 'middleware' => ['auth', 'web', 'auth.unique.user', 'check.sec.user']], function () {

    Route::get('/', 'UsersActionsController@show')->name('UsersActionsShow');
    Route::get('/getdata', 'UsersActionsController@getdata')->name('getdataUsersActions');
});
Route::group(['prefix' => '/relatorios', 'middleware' => ['auth', 'web', 'auth.unique.user', 'check.sec.user']], function () {

    Route::get('/getdata', 'RelatoriosController@getdata')->name('getdataRelatorio');
    Route::get('/registroLogBook', 'RelatoriosController@registroLogBook')->name('registroLogBook');
    Route::post('/relatorioRequest', 'RelatoriosController@relatorioRequest')->name('relatorioRequest');
    Route::get('/viewDetails/{id}', 'RelatoriosController@viewDetails')->name('viewDetailsRelatorio');
    Route::get('/filtro', 'RelatoriosController@filtro')->name('filtroRela');
    Route::post('/gerador', 'RelatoriosController@gerador')->name('gerador');
});
Route::group(['prefix' => '/patrimonios', 'middleware' => ['auth', 'web', 'auth.unique.user', 'check.sec.user']], function () {

    Route::get('/show/{id}', 'PatrimoniosController@show')->name('patrimoniosShow');
    Route::get('/getpatrimonio/{id}', 'PatrimoniosController@getPatri')->name('getPatri');
    Route::get('/getdata/{id}', 'PatrimoniosController@getdata')->name('patrimoniosget');
    Route::get('/add', 'PatrimoniosController@adicionar')->name('addpatrimonio');
    Route::post('/create', 'PatrimoniosController@create')->name('createPatri');
    Route::post('/update', 'PatrimoniosController@update')->name('updatePatri');
    Route::post('/import', 'PatrimoniosController@import')->name('importExcel');
});
