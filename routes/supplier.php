<?php
use App\Http\Controllers\OrderController;

Route::prefix('supplier')->middleware(['auth','role:Supplier'])->group(function () {

Route::get('/orders',[OrderController::class,'index'])->name('orders');

});
