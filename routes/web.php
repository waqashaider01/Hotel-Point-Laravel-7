<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/test-email-me', function(){

\Mail::send([], [], function ($message) {
  $message->to('talha.ali7575@gmail.com')
    ->subject('Test Email')
   
    ->setBody('Hi, welcome user!')
 
    ->setBody('<h1>Hi, welcome user!</h1>', 'text/html'); 
});


});



Route::get('/test', [App\Http\Controllers\CalendarController::class, 'test'])->name('test');


Route::get('/guest_confirmation/{confirmation}/{id}', [App\Http\Controllers\ReservationController::class, 'guest_confirmation']);
Route::post('/guest_confirmation/add_transaction', [App\Http\Controllers\ReservationController::class, 'add_transaction'])->name('add_payment_transaction');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/getAvailableRoomsByDate', [App\Http\Controllers\HomeController::class, 'getAvailableRoomsByDate'])->name('get-available-rooms-by-date');
    Route::get('/test-channex-api', [App\Http\Controllers\ChannexApiController::class, 'test_api'])->name('test-channex-api');
    Route::get('/users-list', [App\Http\Controllers\UserController::class, 'list'])->name('users-list');
    Route::get('/reservations-list', [App\Http\Controllers\ReservationController::class, 'list'])->name('reservations-list');
    Route::get('/checkout-reservation/{id}', [App\Http\Controllers\ReservationController::class, 'makeCheckout']);

    Route::get('/reservations-list/cancelled/{reservation}/print', [App\Http\Controllers\ReservationController::class, 'cancelled_reservation_print'])->name('reservations-cancelled-print');
    Route::post('/reservations-list/cancelled/add-guest', [App\Http\Controllers\ReservationController::class, 'add_reservation_guest'])->name('reservations-add-guest');
    Route::get('/reservations/{reservation}/show', [App\Http\Controllers\ReservationController::class, 'show'])->name('reservation-show');
    Route::get('/ex-reservations-list', [App\Http\Controllers\ReservationController::class, 'ex_reservation_list'])->name('ex-reservations-list');
    Route::post('/ex-reservations-list/import-excel', [App\Http\Controllers\ReservationController::class, 'ex_reservation_import_list'])->name('ex-reservations-import-list');
    Route::post('/ex-reservations-list/store', [App\Http\Controllers\ReservationController::class, 'ex_reservation_store'])->name('ex-reservations-store');
    Route::get('/no-show-list', [App\Http\Controllers\ReservationController::class, 'no_show_list'])->name('no-show-list');
    Route::get('/channel-list', [App\Http\Controllers\ChannelController::class, 'list'])->name('channel-list');
    Route::get('/hotels', [App\Http\Controllers\SettingController::class, 'index'])->name('hotels.index');
    Route::get('/hotel-settings/{hotel?}', [App\Http\Controllers\SettingController::class, 'hotel_settings'])->name('hotel-settings');
    Route::get('/calendar', [App\Http\Controllers\CalendarController::class, 'index'])->name('calendar');
    Route::get('/super-calendar', [App\Http\Controllers\CalendarController::class, 'super_calendar'])->name('super-calendar');
    Route::get('/old-calendar', [App\Http\Controllers\CalendarController::class, 'old_calendar'])->name('old-calendar');
    Route::get('/new-reservation', [App\Http\Controllers\ReservationController::class, 'create'])->name('new-reservation');
    Route::get('/edit-reservation/{id}', [App\Http\Controllers\ReservationController::class, 'editReservation'])->name('edit-reservation');
    Route::get('/companies-list', [App\Http\Controllers\ReservationController::class, 'companiesList'])->name('companies-list');
    Route::get('/companie-folio', [App\Http\Controllers\ReservationController::class, 'companyFolio']);
    Route::get('/guest-profiles', [App\Http\Controllers\ReservationController::class, 'guestProfiles'])->name('guest-profiles');
    Route::put('/guest-update/{id}', [App\Http\Controllers\ReservationController::class, 'guestUpdate'])->name('guest-update');
    Route::get('/guest-reservations/{id}', [App\Http\Controllers\ReservationController::class, 'guestReservations'])->name('guest-reservations');
    Route::get('/guest-payment-folio/{id}', [App\Http\Controllers\ReservationController::class, 'guestPaymentFolio'])->name('guest-payment-folio');
    Route::get('/guest-reservation-fee/{reservation}', [App\Http\Controllers\ReservationController::class, 'guestReservationFee'])->name('guest-reservation-fee');
    Route::get('/reservation-payments/{id}', [App\Http\Controllers\ReservationController::class, 'reservationPayments'])->name('reservation-payments');
    Route::get('/reservation-extra-charge/{id}', [App\Http\Controllers\ReservationController::class, 'reservationExtraCharges'])->name('reservation-extra-charge');
    Route::get('/create-reservation-extra-charge/{id}/{receipt?}', [App\Http\Controllers\ReservationController::class, 'createReservationExtraCharges'])->name('create-reservation-extra-charges');
    Route::get('/delete-reservation-extra-charge/{id}', [App\Http\Controllers\ReservationController::class, 'deleteReservationExtraCharge'])->name('delete-reservation-extra-charge');
    Route::post('/post-payment', [App\Http\Controllers\ReservationController::class, 'postPayment'])->name('post-payment');
    //   Finance Menu
    //    Tax
    Route::get('/receipt-list', [App\Http\Controllers\FinanceController::class, 'receiptList'])->name('receipt-list');
    Route::get('/invoice-list', [App\Http\Controllers\FinanceController::class, 'invoiceList'])->name('invoice-list');
    Route::get('/cancellation-fee-list', [App\Http\Controllers\FinanceController::class, 'cancellationList'])->name('cancellation-fee-list');
    Route::get('/credit-note-list', [App\Http\Controllers\FinanceController::class, 'creditNoteList'])->name('credit-note-list');
    Route::get('/special-annulling-documents', [App\Http\Controllers\FinanceController::class, 'specialAnnullingList'])->name('special-annulling-documents');
    Route::get('/overnight-tax-list', [App\Http\Controllers\FinanceController::class, 'overnightsList'])->name('overnight-tax-list');
    Route::post('/add-special-annulling', [App\Http\Controllers\FinanceController::class, 'addSpecialAnnulling'])->name('add-special-annulling');
    Route::post('/add-refund', [App\Http\Controllers\FinanceController::class, 'createRefund'])->name('add-refund');
    Route::post('/add-credit-note', [App\Http\Controllers\FinanceController::class, 'addCreditNote'])->name('add-credit-note');

    //    opex
    Route::get('/opex-form', [App\Http\Controllers\FinanceController::class, 'opexForm'])->name('opex-form');
    Route::get('/opex-list', [App\Http\Controllers\FinanceController::class, 'opexList'])->name('opex-list');
    Route::post('/post-opex', [App\Http\Controllers\FinanceController::class, 'postOpex'])->name('post-opex');
    Route::get('/create-supplier', [App\Http\Controllers\FinanceController::class, 'createSupplier'])->name('create-supplier');
    //Daily Cashier
    Route::get('/daily-cashier', [App\Http\Controllers\FinanceController::class, 'dailyCashier'])->name('daily-cashier');
    //    Payment Tracker
    Route::get('/payment-tracker', [App\Http\Controllers\FinanceController::class, 'paymentTracker'])->name('payment-tracker');
    Route::post('/payment-tracker', [App\Http\Controllers\FinanceController::class, 'paymentTracker'])->name('payment-tracker.store');
    Route::post('/payment-tracker/otp', [App\Http\Controllers\FinanceController::class, 'generate_otp'])->name('payment-tracker.otp');
    Route::post('/payment-tracker/show_card', [App\Http\Controllers\FinanceController::class, 'show_card'])->name('payment-tracker.show_card');
    Route::post('/payment/store', [App\Http\Controllers\FinanceController::class, 'paymentStore'])->name('payment.store');
    Route::post('/get/currency', [App\Http\Controllers\FinanceController::class, 'get_currency'])->name('currency.get');
    Route::post('/save_credit_card_payment', [App\Http\Controllers\FinanceController::class, 'save_credit_card_payment'])->name('save_credit_card_payment.store');
    //Comission
    Route::get('/commision-list', [App\Http\Controllers\FinanceController::class, 'comissionList'])->name('comission-list');
    Route::get('/credit-card-list', [App\Http\Controllers\FinanceController::class, 'creditCardList'])->name('credit-card-list');
    //Debtor Ledger
    Route::get('/sales-ledger', [App\Http\Controllers\FinanceController::class, 'salesLedger'])->name('sales-ledger');
    Route::get('/sales-ledger-modal-show', [App\Http\Controllers\FinanceController::class, 'saledLedgerModalShow']);
    Route::get('/sales-ledger-update-modal', [App\Http\Controllers\FinanceController::class, 'saledLedgerModalUpdate']);
    Route::put('/sales-ledger-update', [App\Http\Controllers\FinanceController::class, 'saledLedgerUpdate']);

    //    Comments
    Route::get('/comments', [App\Http\Controllers\HomeController::class, 'comments'])->name('comments');
    //service settings
    Route::get('/services-settings', [App\Http\Controllers\SettingController::class, 'serviceSettings'])->name('services-settings');

    // Rooms Types and Rooms Routes
    Route::get('/room-type-and-room', [App\Http\Controllers\RoomsController::class, 'roomTypeAndRoomShow'])->name('room-type-and-room.show');
    Route::get('/syn-rooms-with-channex', [App\Http\Controllers\RoomsController::class, 'syncRoomsWithChannex'])->name('room-type-and-room.sync-with-channex');
    Route::post('/update-room-type-status', [App\Http\Controllers\RoomsController::class, 'roomTypeStatusUpdate'])->name('room-type-status.update');
    Route::post('/show-room-types-data', [App\Http\Controllers\RoomsController::class, 'showRoomTypesData'])->name('room-types-data.fetch');
    Route::post('/edit-room-type', [App\Http\Controllers\RoomsController::class, 'roomTypeUpdate'])->name('room-type.update');
    Route::post('/delete-room-type', [App\Http\Controllers\RoomsController::class, 'roomTypeDestroy'])->name('room-type.destroy');
    Route::post('/update-room-types-position', [App\Http\Controllers\RoomsController::class, 'updateRoomTypesPosition'])->name('room-types-position.update');
    Route::post('/rooms-for-roomtype', [App\Http\Controllers\RoomsController::class, 'roomsForRoomtype'])->name('rooms-for-roomtype.fetch');
    Route::post('/add-room', [App\Http\Controllers\RoomsController::class, 'create'])->name('room.create');
    Route::post('/room/fetch', [App\Http\Controllers\RoomsController::class, 'showRoom'])->name('room.fetch');
    Route::post('/room/update', [App\Http\Controllers\RoomsController::class, 'updateRoom'])->name('room.update');
    Route::post('/room/delete', [App\Http\Controllers\RoomsController::class, 'destroy'])->name('room.destroy');
    Route::post('/room/status-update', [App\Http\Controllers\RoomsController::class, 'roomStatusUpdate'])->name('room-status.update');
    Route::post('/room-type/create', [App\Http\Controllers\RoomsController::class, 'roomTypeCreate'])->name('room-type.create');

    //Meal Categories
    Route::resource('/meal-category', App\Http\Controllers\RoomTypeCategoriesController::class);
    // Route::post('/edit-meal-categories-modal-contents',[App\Http\Controllers\RoomTypeCategoriesController::class,'edit_meal_categories_modal_contents'])->name('edit-meal-categories-modal-contents.fetch');

    //Rate Plans
    Route::resource('/rate-plans', App\Http\Controllers\RatePlansController::class);
    Route::post('/rate-plans/status', [App\Http\Controllers\RatePlansController::class, 'status_update'])->name('rate-plans-status.updates');
    Route::post('/rate-plans/meal-category/match', [App\Http\Controllers\RatePlansController::class, 'meal_category_to_rate_plan_match'])->name('meal-category-to-rate-plan.match');

    //Inventory Route
    Route::get('/channex-otp', [App\Http\Controllers\ChannelController::class, 'channex_otp'])->name('channex-otp.get');
    Route::get('/channex-inventory', [App\Http\Controllers\ChannelController::class, 'show_inventory'])->name('channex-inventory.index');
    Route::get('/channex-channel', [App\Http\Controllers\ChannelController::class, 'show_channel'])->name('channex-channel.index');
    Route::get('/channex-room_rate', [App\Http\Controllers\ChannelController::class, 'show_room_rate'])->name('channex-room_rate.index');

    Route::get('/booking-engine', [App\Http\Controllers\BookingEngineController::class, 'index'])->name('booking-engine.index');

    // Reports
    Route::get('/revenue-reports', [App\Http\Controllers\ReportController::class, 'revenue_report'])->name('revenue-reports');
    Route::get('/housekeeping-reports', [App\Http\Controllers\ReportController::class, 'housekeeping_report'])->name('housekeeping-reports');
    Route::get('/kpi-reports', [App\Http\Controllers\ReportController::class, 'kpi_report'])->name('kpi-reports');
    Route::get('/b2b-reports', [App\Http\Controllers\ReportController::class, 'b2b_report'])->name('b2b-reports');
    Route::get('/accounting-reports', [App\Http\Controllers\ReportController::class, 'accounting_report'])->name('accounting-reports');
    Route::get('/opex-reports', [App\Http\Controllers\ReportController::class, 'opex_report'])->name('opex-reports');
    Route::get('/room-division-reports', [App\Http\Controllers\ReportController::class, 'roomdivision_report'])->name('roomdivision-reports');
    //Hotel Budget
    Route::get('/hotel-budget', [App\Http\Controllers\FinanceController::class, 'hotel_budget'])->name('hotel-budget');
    //Hotel Actual
    Route::get('/hotel-actual', [App\Http\Controllers\FinanceController::class, 'hotel_actual'])->name('hotel-actual');

    //Payment Tracker
    //  Route::resource('/payment-tracker',App\Http\Controllers\PaymentTrackerController::class);
    //  Route::post('/payment-tracker',[App\Http\Controllers\PaymentTrackerController::class,'index']);
    //  Route::post('/get/currency',[App\Http\Controllers\PaymentTrackerController::class,'get_currency'])->name('currency.get');

    //    Route::get('/test', [App\Http\Controllers\UserController::class, 'list']);
    //    Route::get('/test', function (){
    //    $url = route('password.reset', ['token' => 'asd']) . '?email=' . auth()->user()->email;
    //    $user_name = auth()->user()->name;
    //    return new PasswordReset($url, $user_name);
    //        return view('front.User.users_list');
    //    });
});
//Calendar AJax Routes
Route::post('/getTimelineRooms', [App\Http\Controllers\CalendarController::class, 'getTimelineRooms'])->name('getTimelineRooms');
Route::post('/loadRatesInfo', [App\Http\Controllers\CalendarController::class, 'loadRatesInfo'])->name('loadRatesInfo');
Route::post('/getReservations', [App\Http\Controllers\CalendarController::class, 'getReservations'])->name('getReservations');
Route::post('/getRoomStats', [App\Http\Controllers\CalendarController::class, 'getRoomStats'])->name('getRoomStats');
Route::post('/loadResizeData', [App\Http\Controllers\CalendarController::class, 'loadResizeData'])->name('loadResizeData');
Route::post('/getRateTypes', [App\Http\Controllers\CalendarController::class, 'getRateTypes'])->name('getRateTypes');
Route::get('/getCountries', [App\Http\Controllers\CalendarController::class, 'getCountries'])->name('getCountries');
Route::get('/getAgencies', [App\Http\Controllers\CalendarController::class, 'getAgencies'])->name('getAgencies');
Route::get('/getPaymentModes', [App\Http\Controllers\CalendarController::class, 'getPaymentModes'])->name('getPaymentModes');
Route::post('/getAvailableRooms', [App\Http\Controllers\CalendarController::class, 'getAvailableRooms'])->name('getAvailableRooms');
Route::post('/getDailyRates', [App\Http\Controllers\CalendarController::class, 'getDailyRates'])->name('getDailyRates');
Route::post('/getAvailabilityRoomType', [App\Http\Controllers\CalendarController::class, 'getAvailabilityRoomType'])->name('getAvailabilityRoomType');
Route::post('/getAvailabilityThisRoom', [App\Http\Controllers\CalendarController::class, 'getAvailabilityThisRoom'])->name('getAvailabilityThisRoom');
Route::post('/postResizeReservation', [App\Http\Controllers\CalendarController::class, 'postResizeReservation'])->name('postResizeReservation');
Route::post('/getRoomForSplit', [App\Http\Controllers\CalendarController::class, 'getRoomForSplit'])->name('getRoomForSplit');
Route::post('/checkRoomAvailable', [App\Http\Controllers\CalendarController::class, 'checkRoomAvailable'])->name('checkRoomAvailable');
Route::post('/splitReservation', [App\Http\Controllers\CalendarController::class, 'splitReservation'])->name('splitReservation');
Route::post('/postMoveReservation', [App\Http\Controllers\CalendarController::class, 'postMoveReservation'])->name('postMoveReservation');
Route::post('/postMaintenance', [App\Http\Controllers\CalendarController::class, 'postMaintenance'])->name('postMaintenance');
Route::post('/postStopSellOfRateType', [App\Http\Controllers\CalendarController::class, 'postStopSellOfRateType'])->name('postStopSellOfRateType');
Route::post('/postResizeOutOfOrder', [App\Http\Controllers\CalendarController::class, 'postResizeOutOfOrder'])->name('postResizeOutOfOrder');
Route::post('/getOutOfOrderForResize', [App\Http\Controllers\CalendarController::class, 'getOutOfOrderForResize'])->name('getOutOfOrderForResize');
Route::post('/deleteOutOfOrder', [App\Http\Controllers\CalendarController::class, 'deleteOutOfOrder'])->name('deleteOutOfOrder');
Route::get('/getMinDate', [App\Http\Controllers\ReportController::class, 'getMinDate'])->name('getMinDate');
//End Calendar Ajax routes

// Email Verification routes
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Auth::routes();

/* Route::get("/test", function() {
    $s = new OxygenService;
    $r = $s->getInvoicePdf("e550c052-81b2-47cc-8563-503020089b1a");
    return $r;
}); */
