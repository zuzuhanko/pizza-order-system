<?php






use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Middleware\UserCheckMiddleware;
use App\Http\Controllers\PizzaUserController;
use App\Http\Middleware\AdminCheckMiddleware;





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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
       if(Auth::check()){
        if(Auth::user()->roll == 'admin'){
            return redirect()->route('admin#profile');
        }else if(Auth::user()->roll == 'user'){
            return redirect()->route('user#profile');
        }
       }
    })->name('dashboard');
});

Route::group(['prefix' => 'admin','middleware'=>[AdminCheckMiddleware::class] ],function(){

Route::get('profile',[AdminController::class,'profile'])->name('admin#profile');
Route::post('updateProfile/{id}',[AdminController::class,'updateProfile'])->name('admin#updateProfile');
Route::get('changePassword',[AdminController::class,'changePasswordPage'])->name('admin#changePasswordPage');
Route::post('changePassword/{id}',[AdminController::class,'changePassword'])->name('admin#changePassword');
Route::get('editUserInfo/{id}',[AdminController::class,'editUserInfo'])->name('admin#editUserInfo');
Route::post('updateUserInfo/{id}',[AdminController::class,'updateUserInfo'])->name('admin#updateUserInfo');

Route::get('category',[CategoryController::class,'category'])->name('admin#category');
Route::get('addCategory',[CategoryController::class,'addCategory'])->name('admin#addCategory');
Route::post('createCategory',[CategoryController::class,'createCategory'])->name('admin#createCategory');

Route::get('deleteCategory/{id}' ,[CategoryController::class,'deleteCategory'])->name('admin#delete');
Route::get('editCategory/{id}',[CategoryController::class,'editCategory'])->name('admin#edit');
Route::post('updateCategory',[CategoryController::class,'updateCategory'])->name('admin#update');
Route::get('searchCategory',[CategoryController::class,'searchCategory'])->name('admin#search');
Route::get('category/download',[CategoryController::class,'categoryDownload'])->name('admin#categoryDownload');


Route::get('pizza',[PizzaController::class,'pizza'])->name('admin#pizza');
Route::get('createPizza',[PizzaController::class,'createPizza'])->name('admin#createPizza');
Route::post('insertPizza',[PizzaController::class,'insertPizza'])->name('admin#insertPizza');
Route::get('deletePizza/{id}',[PizzaController::class,'deletePizza'])->name('admin#deletePizza');
Route::get('pizzaInfo/{id}',[PizzaController::class,'pizzaInfo'])->name('admin#pizzaInfo');
Route::get('editPizza/{id}',[PizzaController::class,'editPizza'])->name('admin#editPizza');
Route::post('updatePizza/{id}',[PizzaController::class,'updatePizza'])->name('admin#updatePizza');
Route::get('searchPizza',[PizzaController::class,'searchPizza'])->name('admin#searchPizza');
Route::get('categoryItem/{id}',[PizzaController::class,'categoryItem'])->name('admin#categoryItem');
Route::get('CSVdownload',[PizzaController::class,'pizzaDownload'])->name('admin#pizzaDownload');


Route::get('userList',[PizzaUserController::class,'userList'])->name('admin#userList');
Route::get('adminList',[PizzaUserController::class,'adminList'])->name('admin#adminList');
Route::get('userList/Search',[PizzaUserController::class,'Usersearch'])->name('admin#userSearch');
Route::get('userlist/delete/{id}',[PizzaUserController::class,'deleteUser'])->name('admin#userDelete');
Route::get('adminList/Search',[PizzaUserController::class,'adminSearch'])->name('admin#adminSearch');
Route::get('adminList/delete/{id}',[PizzaUserController::class,'deleteAdmin'])->name('admin#deleteAdmin');

Route::get('contact/list',[ContactController::class,'contactList'])->name('admin#contactList');
Route::get('contact/search',[ContactController::class,'contactSearch'])->name('admin#contactSearch');
Route::get('contactDownload',[ContactController::class,'contactDownload'])->name('admin#contactDownload');

Route::get('orderList',[OrderController::class,'orderList'])->name('admin#orderList');
Route::get('orderSearch',[OrderController::class,'orderSearch'])->name('admin#orderSearch');
Route::get('orderDownload',[OrderController::class,'orderDownload'])->name('admin#orderDownload');

});

Route::group(['prefix' => 'user','middleware'=>[UserCheckMiddleware::class]], function(){
    Route::get('/',[userController::class,'index'])->name('user#profile');
    Route::post('create/contact',[ContactController::class,'createContact'])->name('user#contact');
    Route::get('detail/{id}',[userController::class,'pizzaDetail'])->name('user#detail');

    Route::get('order',[userController::class,'pizzaOrder'])->name('user#order');

    Route::post('order',[userController::class,'payment'])->name('user#payment');

    Route::get('searchPizza',[userController::class,'searchPizza'])->name('user#searchPizza');
    Route::get('searchItem',[userController::class,'searchItem'])->name('user#searchItem');

    Route::get('categorySearch/{id}',[userController::class,'categorySearch'])->name('user#categorySearch');




});
