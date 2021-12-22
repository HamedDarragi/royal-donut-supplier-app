<?php

use bilawalsh\cart\CartController;
use bilawalsh\cart\OrderController;

Route::group(
    ['middleware' => ['web', 'auth']],
    function () {

        // for cart

        // Route::get('cart', [CartController::class, 'index'])->name('cart');
        Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
        Route::get('cart/item/remove/{cart}/{item}', [CartController::class, 'cartItemRemove'])->name('cart.item.remove');
        Route::post('cart/item/increment', [CartController::class, 'cartItemIncrement'])->name('cart.item.increment');


        // for order
        Route::get('order/confirmed/{id}/{message}/{date}', [OrderController::class, 'orderConfirmed'])->name('order.confirmed');
    }
);
