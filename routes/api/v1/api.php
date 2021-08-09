<?php

use App\Http\Controllers\admin\FlipTheSwitchController;
use App\Http\Controllers\api\v1\AddressController;
use App\Http\Controllers\api\v1\BugReportController;
use App\Http\Controllers\api\v1\ConfigurationController;
use App\Http\Controllers\api\v1\ContactUsController;
use App\Http\Controllers\api\v1\ContentLibraryController;
use App\Http\Controllers\api\v1\DailyCheckQuestionController;
use App\Http\Controllers\api\v1\DailyQuestionController;
use App\Http\Controllers\api\v1\EmailSendController;
use App\Http\Controllers\api\v1\FAQController;
use App\Http\Controllers\api\v1\FeedBackController;
use App\Http\Controllers\api\v1\FlipTheSwitchController as FlipSwitch;
use App\Http\Controllers\api\v1\FocusController;
use App\Http\Controllers\api\v1\InvitePartnerController;
use App\Http\Controllers\api\v1\IsRecordExists;
use App\Http\Controllers\api\v1\LoginController;
use App\Http\Controllers\api\v1\NotesController;
use App\Http\Controllers\api\v1\OrderController;
use App\Http\Controllers\api\v1\PodcastsController;
use App\Http\Controllers\api\v1\ProductController;
use App\Http\Controllers\api\v1\RegisterController;
use App\Http\Controllers\api\v1\ScoreCardController;
use App\Http\Controllers\api\v1\ShoppingCartController;
use App\Http\Controllers\api\v1\SocialSetupController;
use App\Http\Controllers\api\v1\StripeInitiatePaymentController;
use App\Http\Controllers\api\v1\TermConditionController;
use App\Http\Controllers\api\v1\Twilio;
use App\Http\Controllers\api\v1\UserDailyCheckQuestionController;
use App\Http\Controllers\api\v1\WeeklyGoalsController;
use App\Http\Controllers\api\v1\YourDayController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Stripe\Customer;
use Stripe\EphemeralKey;
use Stripe\PaymentIntent;
use Stripe\Stripe;

/*
|--------------------------------------------------------------------------
| Return un-authenticated if not login
|--------------------------------------------------------------------------
*/


Route::get('/login', [LoginController::class, 'unauthorized'])->name('un-authorized');

/*
|--------------------------------------------------------------------------
| Register & Login api's
|--------------------------------------------------------------------------
*/

Route::prefix('/user')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);
});
Route::post('/social/setup', [SocialSetupController::class, 'social_setup']);

/*
|--------------------------------------------------------------------------
| Forgot password & reset password api's
|--------------------------------------------------------------------------
*/

//Route::post('forgot-password', [RegisterController::class,'forgot']);
//Route::post('password/reset', [RegisterController::class,'reset']);

Route::get('/verify-token', [RegisterController::class, 'verifyToken']);

Route::middleware('auth:api')->group(function () {
    Route::get('/score-card', [ScoreCardController::class, 'index']);
    /*
    |--------------------------------------------------------------------------
    | User profile & logout api's
    |--------------------------------------------------------------------------
    */

    Route::prefix('/user')->group(function () {
        Route::get('/', [RegisterController::class, 'profile']);
        Route::post('/update/profile', [RegisterController::class, 'update_profile']);
        Route::delete('/logout', [RegisterController::class, 'logout']);
    });
    /*
    |--------------------------------------------------------------------------
    | User Configuration
    |--------------------------------------------------------------------------
    */
    Route::prefix('/configuration')->group(function () {
        Route::get('/', [ConfigurationController::class, 'show']);
        Route::post('/update', [ConfigurationController::class, 'update']);
    });

    /*
       |--------------------------------------------------------------------------
       | User Addresss
       |--------------------------------------------------------------------------
       */
    Route::prefix('/address')->group(function () {
        Route::get('/', [AddressController::class, 'index']);
        Route::post('/create', [AddressController::class, 'store']);
    });

    /*
    |--------------------------------------------------------------------------
    | User Feedback about APP
    |--------------------------------------------------------------------------
    */
    Route::prefix('/feedback')->group(function () {
        Route::post('/create', [FeedBackController::class, 'store']);
    });


    /*
    |--------------------------------------------------------------------------
    | Route for Notes
    |--------------------------------------------------------------------------
    */

    Route::prefix('/notes')->group(function () {
        Route::get('/{limit?}', [NotesController::class, 'index']);
        Route::post('/create', [NotesController::class, 'store']);
        Route::delete('/{id}/delete', [NotesController::class, 'destroy']);
    });

    Route::prefix('/shopping-cart')->group(function () {
        Route::get('/{limit?}', [ShoppingCartController::class, 'index']);
        Route::post('/create', [ShoppingCartController::class, 'store']);
        Route::delete('/{id}/delete', [ShoppingCartController::class, 'destroy']);
    });

    /*
    |--------------------------------------------------------------------------
    | Route for Weekly Goals
    |--------------------------------------------------------------------------
    */

    Route::prefix('/goals')->group(function () {
        Route::get('/', [WeeklyGoalsController::class, 'index']);
        Route::post('/create', [WeeklyGoalsController::class, 'store']);
        Route::get('/date/{date}', [WeeklyGoalsController::class, 'specificGoalsDayList']);
        Route::get('/week/{date?}', [WeeklyGoalsController::class, 'currentWeekGoalsList']);
        Route::get('/{id}/status', [WeeklyGoalsController::class, 'updateStatus']);
        Route::get('/stats/{date?}', [WeeklyGoalsController::class, 'stats']);
        Route::get('/week/{start_date?}/{end_date?}', [WeeklyGoalsController::class, 'weeklyGoalListByDate']);
    });

    /*
    |--------------------------------------------------------------------------
    | Route for Daily Check Question
    |--------------------------------------------------------------------------
    */

    Route::prefix('/daily-check-question')->group(function () {
        Route::get('/', [DailyCheckQuestionController::class, 'index']);
    });


    /*
    |--------------------------------------------------------------------------
    | Route for User Daily Check Question
    |--------------------------------------------------------------------------
    */

    Route::prefix('/user-daily-check-question')->group(function () {
        Route::post('/create', [UserDailyCheckQuestionController::class, 'store']);
    });

    /*
    |--------------------------------------------------------------------------
    | Route for Focus create & get
    |--------------------------------------------------------------------------
    */

    Route::prefix('/focus')->group(function () {
        Route::post('/create', [FocusController::class, 'dayFocusScore']);
        Route::get('/{date?}', [FocusController::class, 'getDayFocusScore']);
    });

    /*
    |--------------------------------------------------------------------------
    | Route for Daily Questions
    |--------------------------------------------------------------------------
    */

    Route::prefix('/questions')->group(function () {
        Route::get('/{limit?}', [DailyQuestionController::class, 'index']);
        Route::post('/create', [DailyQuestionController::class, 'store']);
    });

    /*
    |--------------------------------------------------------------------------
    | Route for Your Day
    |--------------------------------------------------------------------------
    */
    Route::prefix('/day')->group(function () {
        Route::get('/{limit?}', [YourDayController::class, 'index']);
        Route::post('/create', [YourDayController::class, 'store']);
        Route::get('/{date?}', [YourDayController::class, 'show']);
    });


    /*
    |--------------------------------------------------------------------------
    | Route for bugreport & contact us
    |--------------------------------------------------------------------------
    */

    Route::post('/bug/report', [BugReportController::class, 'store']);
    Route::post('/contact/us', [ContactUsController::class, 'store']);


    /*
    |--------------------------------------------------------------------------
    | Route for checkout, user orders
    |--------------------------------------------------------------------------
    */
    Route::post('/checkout', [OrderController::class, 'place_order']);
    Route::prefix('/order')->group(function () {
        Route::get('/{status_id?}/{limit?}', [OrderController::class, 'index']);
    });
    Route::get('/show/order/{id}', [OrderController::class, 'show']);
    Route::get('/transaction', [OrderController::class, 'transaction']);
    Route::post('/dashboard', [FocusController::class, 'dashboard']);

    /*
    |--------------------------------------------------------------------------
    | Route for Invite Partner
    |--------------------------------------------------------------------------
    */

    Route::get('/partner', [InvitePartnerController::class, 'index']);

});


/*
|--------------------------------------------------------------------------
| Route for Register Reset Password on Email & Mobile
|--------------------------------------------------------------------------
*/

Route::post('send/sms', [Twilio::class, 'sendConfirmationMessage']);
Route::post('reset/password/sms', [Twilio::class, 'sendResetPasswordOnMobile']);
Route::post('reset/password/email', [EmailSendController::class, 'sendResetPasswordOnEmail']);
Route::post('password/reset', [RegisterController::class, 'resetPassword']);


/*
|--------------------------------------------------------------------------
| Route for Flip the Switch & Content Library & Podcasts & their searches
|--------------------------------------------------------------------------
*/

Route::get('podcasts', [PodcastsController::class, 'index']);
Route::get('flip-the-switch', [FlipSwitch::class, 'index']);
Route::get('content-library', [ContentLibraryController::class, 'index']);
Route::get('content-library/{filter}', [ContentLibraryController::class, 'filter']);


/*
|--------------------------------------------------------------------------
| Check if Email & Phone Number exists
|--------------------------------------------------------------------------
*/
Route::prefix('/unique')->group(function () {
    Route::get('email/{user}', [IsRecordExists::class, 'email']);
    Route::get('phone/{user}', [IsRecordExists::class, 'phone']);
});


Route::get('user/list', [RegisterController::class, 'users']);


/*
|--------------------------------------------------------------------------
| Route for Products
|--------------------------------------------------------------------------
*/
Route::prefix('/products')->group(function () {
    Route::get('/{limit?}', [ProductController::class, 'index']);
    Route::get('/{id}/details', [ProductController::class, 'show']);
});


/*
|--------------------------------------------------------------------------
| FAQ List
|--------------------------------------------------------------------------
*/
Route::get('/faq', [FAQController::class, 'index']);
Route::get('/terms-and-conditions', [TermConditionController::class, 'index']);
Route::get('/faq-search/{search}', [FAQController::class, 'search']);


Route::post('/payment-sheet', [StripeInitiatePaymentController::class, 'store']);
