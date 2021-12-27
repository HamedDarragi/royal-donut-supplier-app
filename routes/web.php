<?php

use Illuminate\Http\Request;
use bilawalsh\cart\Models\Order;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Catalog\UnitController;
use App\Http\Controllers\Catalog\OrderController;
use App\Http\Controllers\Catalog\ProductController;
use App\Http\Controllers\Catalog\CategoryController;
use App\Http\Controllers\Catalog\CustomerController;
use App\Http\Controllers\Catalog\SupplierController;
use App\Http\Controllers\Catalog\BroadcastController;
use App\Http\Controllers\Catalog\InventoryController;
use App\Http\Controllers\Catalog\RoleController;
use App\Http\Controllers\Catalog\AdminsController;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Catalog\BroadcastGroupController;
use App\Http\Controllers\Catalog\ManufacturingPartnerController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DeliveryCompanyController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\AssociateController;
use App\Models\Product;
use App\Http\Controllers\BackLogsController;
use App\Models\Date;
use App\Models\Rule;
use Spatie\Activitylog\Models\Activity;


use App\Models\AssociateRule;
// use App\Http\Controllers\Auth\CustomerAuthenticatedSessionController;

use Sarfraznawaz2005\BackupManager\Http\Controllers\BackupManagerController;


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
Route::get('/backup_database', function(){
    // lock all tables
    \DB::table('emails')->truncate();
    // \DB::table('orders')->truncate();
    // \Artisan::call('backupmanager:restore');
    return 'database backed up';

});
Route::get('/', function () {
    return view('auth.login');
});

require __DIR__ . '/supplier.php';
require __DIR__ . '/customer.php';
Route::middleware(['auth'])->group(
    function () {
        Route::get('order/status', [App\Http\Controllers\OrderController::class, 'updateStatus'])->name('order.status');
        Route::get('rectify_orders', [App\Http\Controllers\OrderController::class, 'rectifyOrder'])->name('order.rectify');

    }
);
// Catalog
Route::resource('admins', AdminsController::class);

Route::middleware(['auth', 'role:Admin|SuperAdmin'])->group(function () {

    Route::post('product/update/index/align', function (Request $request) {
        try {
            $value = preg_replace('/[^0-9.]+/', '', $request->index);
            Product::whereId($request->id)->update([
                'index' => $value,
            ]);
            return response()->json('done');
        } catch (Exception $e) {
            return response()->json('duplicate');
        }
    });

    Route::post('log/update/index/align', function (Request $request) {
        try {
            $value = preg_replace('/[^a-z A-Z]+/', '', $request->index);
       
            
            Activity::whereId($request->id)->update([
                'comments' => $value,
            ]);
            return response()->json('done');
        } catch (Exception $e) {
            return response()->json('duplicate');
        }
    });
    Route::get('quantity/update', [App\Http\Controllers\OrderController::class, 'updateQuantity'])->name('quantity.update');

    Route::get('broadcast/status', [BroadcastController::class, 'broadcast_status']);
    Route::resource('broadcast', BroadcastController::class);
    Route::get('broadcast/group/add/members', [BroadcastGroupController::class, 'add_members'])->name('addmembers');
    Route::post('broadcast/group/add/members', [BroadcastGroupController::class, 'add_members_store'])->name('addmembers.store');
    Route::resource('broadcast_group', BroadcastGroupController::class);
    Route::get('users', [BroadcastGroupController::class, 'get_users'])->name('getusers');
    Route::post('broadcast/groupId', [BroadcastGroupController::class, 'groupId'])->name('groupId');
    Route::post('broadcast_group/search', [BroadcastGroupController::class, 'search'])->name('search');
    Route::post('broadcast/search', [BroadcastController::class, 'search'])->name('search');


    Route::get('category/status/{id}', [CategoryController::class, 'status'])->name('category.status');
    Route::resource('category', CategoryController::class);

    Route::get('product/status/{id}', [ProductController::class, 'status'])->name('product.status');
    Route::resource('product', ProductController::class);
    Route::post('search', [ProductController::class, 'search']);


    Route::resource('unit', UnitController::class);
    Route::get('unit/status/{id}', [UnitController::class, 'status'])->name('unit.status');
    Route::post('unit/search', [UnitController::class, 'search']);


    Route::get('supplier/status/{id}', [SupplierController::class, 'status'])->name('supplier.status');
    Route::post('supplier/search', [SupplierController::class, 'search']);
    Route::resource('supplier', SupplierController::class);


    Route::get('customer/status/{id}', [CustomerController::class, 'status'])->name('customer.status');
    Route::post('profile/{id}', [RegisteredUserController::class, 'update'])->name('profile.update');
    Route::resource('customer', CustomerController::class);
    Route::post('customer/search', [CustomerController::class, 'search']);


    Route::resource('inventory', InventoryController::class);
    Route::post('inventory/search', [InventoryController::class, 'search']);

    Route::get('manufacturing_partner/status/{id}', [ManufacturingPartnerController::class, 'status'])->name('manufacturing_partner.status');
    Route::resource('manufacturing_partner', ManufacturingPartnerController::class);
    Route::post('manufacturer/search', [ManufacturingPartnerController::class, 'search']);

    // API routes

    Route::resource('order', OrderController::class);
    // Route::post('confirm_order', [OrderController::class, 'confirm_order'])->name('confirm_order');
    Route::get('new_order', [OrderController::class, 'new_order']);

    // Email section
    Route::get('footer', [SettingsController::class, 'footer'])->name('footer');
    Route::post('footerupdate', [SettingsController::class, 'footerUpdate'])->name('footer.update');

    Route::get('title', [SettingsController::class, 'title'])->name('title');
    Route::post('titleupdate', [SettingsController::class, 'titleUpdate'])->name('title.update');

    Route::get('email/{id}', [SettingsController::class, 'email'])->name('email');
    Route::post('emailsend', [SettingsController::class, 'emailSend'])->name('email.send');

    Route::get('emailhistory', [SettingsController::class, 'emailHistory'])->name('emailhistory');
    Route::get('/chek', [SettingsController::class, 'chek'])->name('chek');

    Route::get('/calendar', [CalendarController::class, 'calendar'])->name('calendar');
    Route::get('/savedate', [CalendarController::class, 'saveDate'])->name('savedate');


    Route::resource('deliverycompany', DeliveryCompanyController::class);
    Route::resource('roles', RoleController::class);

    Route::resource('rule', RuleController::class);
    Route::resource('associate_rule', AssociateController::class);

    Route::get('/getheader/{id}', [SupplierController::class, 'getHeader'])->name('getheader');

    Route::post('addhead', [SupplierController::class, 'editHeader'])->name('header.store');
    Route::post('edithead', [SupplierController::class, 'editHeader'])->name('header.update');


    Route::resource('backlogs', BackLogsController::class);
    Route::post('filter', [BackLogsController::class, 'filter'])->name('filter-backlogs');



    // backups


    
            // list backups
            Route::get('/backupmanager', [BackupManagerController::class, 'index'])->name('backupmanager');
    
            // create backups
            Route::post('create', [BackupManagerController::class,'createBackup'])->name('backupmanager_create');
    
            // restore/delete backups
            Route::post('restore_delete',
            [BackupManagerController::class,'restoreOrDeleteBackups'])->name('backupmanager_restore_delete');
    
            // download backup
            Route::get('download/{file}', [BackupManagerController::class,'download'])->name('backupmanager_download');
   
                Route::get('reset', [BackupManagerController::class, 'resetData'])->name('reset_data');

                Route::get('db_update', [BackupManagerController::class, 'updateDbFile'])->name('database_updation');


    Route::get('orders', function () {
        // dd('jhgjh');
                $orders = Order::with('products.unit')->paginate(5);

        return view('catalog.order.allorders', compact('orders'));
    });
});
Route::get('getproducts', [ProductController::class, 'getProducts'])->name('getproducts');

//API route
Route::get('credentials', [CustomerController::class, 'login']);



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::get('/delivery_partial', function () {
    $rule = Rule::all();
    return view('delivery_partial.delivery_partial', compact('rule'));
});
Route::post('get_rule_delivery', function (Request $request) {
    $rule = Rule::find($request->rule_id);
    return response()->json($rule);
});
Route::post('check_db', function (Request $request) {
    $date = Date::where('c_date', $request->date)->first();
    // dd($request->date);
    if ($date != null) {
        return response()->json(['db' => true, 'data' => $date]);
    } else {
        return response()->json(['db' => false, 'data' => $request->date]);
    }
});

require __DIR__ . '/auth.php';
