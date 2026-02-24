<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('requests', VendorController::class);
    $router->resource('users', UserController::class);
    $router->resource('quotations', QuotationController::class);
    $router->resource('invoices', InvoiceController::class);
    $router->resource('invoice-items', InvoiceItemController::class);
    $router->resource('deliveries', DeliveryController::class);
    $router->resource('product-categories', ProductCategoryController::class);

    $router->resource('gens', GenController::class);
    $router->resource('products', ProductController::class);
    $router->resource('product-orders', ProductOrderController::class);
    $router->resource('orders', OrderController::class);
    // Custom route for enhanced order detail view
    $router->get('orders/{id}/detail', 'OrderController@detail');
    $router->resource('reviews', ReviewController::class);
    $router->resource('images', ImageController::class);

    $router->resource('delivery-addresses', DeliveryAddressController::class);

    // OneSignal Push Notifications - Enhanced
    $router->resource('notifications', NotificationController::class);

    // Quick actions
    $router->post('notifications/quick-send', 'NotificationController@quickSend')->name('notifications.quick-send');
    $router->post('notifications/test-connection', 'NotificationController@testConnection')->name('notifications.test-connection');
    $router->post('notifications/{id}/send', 'NotificationController@send')->name('notifications.send');
    $router->post('notifications/{id}/cancel', 'NotificationController@cancel')->name('notifications.cancel');

    // Device Management
    $router->get('onesignal-devices', 'NotificationController@devices')->name('onesignal.devices');
    $router->post('onesignal/sync-devices', 'NotificationController@syncDevices')->name('onesignal.sync-devices');
    $router->post('onesignal/test-notification', 'NotificationController@sendTestNotification')->name('onesignal.test-notification');

    // Analytics & Reporting
    $router->get('notifications/analytics', 'NotificationController@analytics')->name('notifications.analytics');
    $router->get('notifications/{id}/analytics', 'NotificationController@notificationAnalytics')->name('notifications.single-analytics');

    // Templates & Scheduling
    $router->get('notifications/templates', 'NotificationController@templates')->name('notifications.templates');
    $router->post('notifications/{id}/schedule', 'NotificationController@schedule')->name('notifications.schedule');

    $router->resource('tinify-models', TinifyModelController::class);
});
