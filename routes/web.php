    <?php

    use Illuminate\Support\Facades\Route;

    // Admin Route
    Route::middleware('guest:admin')->group(function () {
        Route::get('/admin/login', 'Admin\Auth\LoginController@show_login')->name('admin.login');
        Route::post('/admin/login', 'Admin\Auth\LoginController@login')->name('admin.login.submit');
    });

    Route::middleware(['admin.login'])->group(function () {

        Route::get('/admin/deshboard', 'Admin\AdminController@deshboard')->name('admin.deshboard');
        Route::get('/admin/profile', 'Admin\AdminController@profile')->name('admin.profile');
        Route::post('/admin/profile', 'Admin\AdminController@ProfileUpdate')->name('profile.update');
        Route::delete('admin/DeleteUser/{id}', 'Admin\AdminController@destroy')->name('admin.DeleteUser');

        Route::post('admin/logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');

        Route::resource('admin/subadmin', 'Admin\SubAdminController')->names('subadmin');
        Route::resource('admin/event', 'Admin\EventController')->names('event');

        Route::resource('admin/booking', 'Admin\BookingController')->names('booking');

        Route::post('admin/booking/cancel/{id}', 'Admin\BookingController@cancel')->name('admin.booking.cancel');
        Route::post('/admin/booking/multi-delete', 'Admin\BookingController@MultiDelete')->name('admin.MultiDelete');
    });

    // User Route
    Route::get('/user/home', 'User\UserController@home')->name('user.home');
    Route::get('/user/event-details/{id}', 'User\UserController@eventDetails')->name('user.event.details');

    Route::middleware(['guest:web'])->group(function () {

        Route::get('/user/register', 'User\Auth\AuthController@showRegisterForm')->name('user.register');
        Route::post('/user/register', 'User\Auth\AuthController@register');

        Route::get('/user/verify-otp', 'User\Auth\AuthController@showVerifyForm')->name('verify-otp');
        Route::post('/user/verify-otp', 'User\Auth\AuthController@verifyOtp');
        Route::post('/user/resend-otp', 'User\Auth\AuthController@resendOtp')->name('resend-otp');

        Route::get('/user/login', 'User\Auth\AuthController@showLoginForm')->name('user.login');
        Route::post('/user/login', 'User\Auth\AuthController@login');
    });

    Route::middleware(['user.login'])->group(function () {

        Route::delete('User/booking/cancel/{id}', 'User\UserBookingController@cancel')->name('user.booking.cancel');

        Route::post('/razorpay/success', 'user\RazorpayController@success')->name('razorpay.success');
        Route::post('/razorpay/payment', 'user\RazorpayController@payment')->name('razorpay.payment');
        Route::get('/razorpay/pay/{bookingId}', 'user\RazorpayController@redirectToPayment')->name('razorpay.payment.redirect');

        Route::get('/user/ticket-booked', 'User\UserController@booked_ticket')->name('booked_ticket');
        Route::get('/user/profile/edit', 'User\UserController@view_profile')->name('view_profile');
        Route::put('/user/profile', 'User\UserController@User_profile')->name('User_profile.update');

        Route::post('/user/logout', 'User\Auth\AuthController@logout')->name('user.logout');
    });
