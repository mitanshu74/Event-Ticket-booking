    <?php

    use Illuminate\Support\Facades\Route;

    // Admin Route
    Route::middleware('guest:admin')->group(function () {
        Route::get('/admin/login', 'Admin\AdminController@show_login')->name('admin.login');
        Route::post('/admin/login', 'Admin\AdminController@login')->name('admin.login.submit');
    });

    Route::middleware(['admin.login'])->group(function () {
        Route::get('/admin/home', 'Admin\AdminController@home')->name('admin.home');
        Route::get('/admin/profile', 'Admin\AdminController@profile')->name('admin.profile');
        Route::post('/admin/profile', 'Admin\AdminController@ProfileUpdate')->name('admin.profile.update');

        Route::delete('admin/DeleteUser/{id}', 'Admin\AdminController@destroy')->name('admin.DeleteUser');

        Route::get('admin/manageEvent', 'Admin\EventController@index')->name('admin.manageEvent');
        Route::get('admin/addEvent', 'Admin\EventController@create')->name('admin.addEvent');
        Route::post('admin/storeEvent', 'Admin\EventController@store')->name('admin.storeEvent');
        Route::get('admin/EditEvent/{id}', 'Admin\EventController@edit')->name('admin.EditEvent');
        Route::post('admin/UpdateEvent/{id}', 'Admin\EventController@update')->name('admin.UpdateEvent');
        Route::delete('admin/DeleteEvent/{id}', 'Admin\EventController@destroy')->name('admin.DeleteEvent');
        // Route::post('store-file', 'Admin\EventController@storeFile')->name('store_file');
        // Route::post('update-file', 'Admin\EventController@updateFile')->name('update_File');


        Route::get('admin/manageSubAdmin', 'Admin\SubAdminController@index')->name('admin.manageSubAdmin');
        Route::get('admin/addSubAdmin', 'Admin\SubAdminController@create')->name('admin.addSubAdmin');
        Route::post('admin/storeSubAdmin', 'Admin\SubAdminController@store')->name('admin.storeSubAdmin');
        Route::get('admin/EditSubAdmin/{id}', 'Admin\SubAdminController@edit')->name('admin.EditSubAdmin');
        Route::put('admin/UpdateSubAdmin/{id}', 'Admin\SubAdminController@update')->name('admin.UpdateSubAdmin');
        Route::delete('admin/DeleteSubAdm   in/{id}', 'Admin\SubAdminController@destroy')->name('admin.DeleteSubAdmin');

        Route::resource('admin/booking', 'Admin\BookingController');
        Route::post('admin/booking/cancel/{id}', 'Admin\BookingController@cancel')->name('admin.booking.cancel');
        Route::post('/admin/booking/multi-delete', 'Admin\BookingController@MultiDelete')->name('admin.MultiDelete');
        Route::post('admin/logout', 'Admin\AdminController@logout')->name('admin.logout');
    });

    // User Route
    Route::get('/user/home', 'User\UserController@home')->name('user.home');
    Route::get('/user/event-details/{id}', 'User\UserController@eventDetails')->name('user.event.details');

    Route::middleware(['guest:web'])->group(function () {

        Route::get('/user/register', 'User\UserController@showRegisterForm')->name('user.register');
        Route::post('/user/register', 'User\UserController@register');

        Route::get('/user/verify-otp', 'User\UserController@showVerifyForm')->name('verify-otp');
        Route::post('/user/verify-otp', 'User\UserController@verifyOtp');
        Route::post('/user/resend-otp', 'User\UserController@resendOtp')->name('resend-otp');

        Route::get('/user/login', 'User\UserController@showLoginForm')->name('user.login');
        Route::post('/user/login', 'User\UserController@login');
    });

    Route::middleware(['user.login'])->group(function () {

        // Route::post('User/booking', 'User\UserBookingController@store')->name('user.booking');
        Route::delete('User/booking/cancel/{id}', 'User\UserBookingController@cancel')->name('user.booking.cancel');

        // Route::get('/razorpay', 'RazorpayController@index');
        Route::post('/razorpay/success', 'RazorpayController@success')->name('razorpay.success');

        Route::post('/razorpay/payment', 'RazorpayController@payment')->name('razorpay.payment');
        Route::get('/razorpay/pay/{bookingId}', 'RazorpayController@redirectToPayment')->name('razorpay.payment.redirect');

        Route::get('/user/tickets', 'User\UserController@booked_ticket')->name('booked_ticket');
        Route::get('/user/profile/edit', 'User\UserController@view_profile')->name('view_profile');
        Route::put('/user/profile', 'User\UserController@User_profile')->name('User_profile.update');

        Route::post('/user/logout', 'User\UserController@logout')->name('user.logout');
    });
