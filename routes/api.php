<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BlogApiController;
use App\Http\Controllers\Api\PackageApiController;
use App\Http\Controllers\Api\ServicePlanApiController;
use App\Http\Controllers\Api\HeaderMenuApiController;
use App\Http\Controllers\Api\FooterApiController;
use App\Http\Controllers\Api\FaqApiController;
use App\Http\Controllers\Api\HomeApiController;
use App\Http\Controllers\Api\HeroBannerApiController;
use App\Http\Controllers\Api\ReviewApiController;
use App\Http\Controllers\Api\About\CoreValueApiController;
use App\Http\Controllers\Api\About\MissionValueApiController;
use App\Http\Controllers\Api\About\WhyPlatformApiController;
use App\Http\Controllers\Api\InquiryApiController;
use App\Http\Controllers\Api\PageSectionApiController;
use App\Http\Controllers\Api\ContactDetailApiController;
use App\Http\Controllers\AngelData\AngelController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;

//-----------------------------------------
                    // Authentication Api's 
                    //-----------------------------------------
                    Route::prefix('auth')->group(function () {

                        Route::post('login', [LoginController::class, 'login']);
                        Route::middleware('auth:sanctum')->post('logout', [LogoutController::class, 'logout']);
                    });
                    Route::prefix('auth/register')->group(function () {

                        Route::post('details', [RegisterController::class, 'storeDetails']);
                        Route::post('phone', [RegisterController::class, 'sendOtp']);
                        Route::post('verify-otp', [RegisterController::class, 'verifyOtp']);
                    });



Route::prefix('angel')->group(function () {
    Route::get('login', [AngelController::class, 'login']);
    Route::get('history', [AngelController::class, 'history']);
    Route::get('quote', [AngelController::class, 'quote']);
    Route::get('ws-token', [AngelController::class, 'wsToken']);
    Route::get('gainers-losers', [AngelController::class, 'gainersLosers']);
    Route::get('indices', [AngelController::class, 'getIndices']);
});

// Public
Route::post('send-otp', [AuthApiController::class, 'sendOtp']);
Route::post('verify-otp', [AuthApiController::class, 'verifyOtp']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout', [AuthApiController::class, 'logout']);
    Route::get('user', [UserApiController::class, 'user']);
     Route::put('user/update', [UserApiController::class, 'update']); // Update current user
    Route::put('user/{id}', [UserApiController::class, 'update']);

    // ⭐ TEST API
    Route::get('test-api', function () {
        return response()->json([
            'success' => true,
            'message' => 'Sanctum token verified successfully!',
            'user' => Auth::user(),
        ]);
    });
});


// blogs api
Route::middleware('auth:sanctum')->group(function () {
    Route::get('blogs', [BlogApiController::class, 'index']);
    Route::get('blogs/{id}', [BlogApiController::class, 'show']);
    Route::post('blogs', [BlogApiController::class, 'store']);
    Route::put('blogs/{id}', [BlogApiController::class, 'update']);
    Route::delete('blogs/{id}', [BlogApiController::class, 'destroy']);
});


// packages api
Route::middleware('auth:sanctum')->prefix('packages')->group(function () {
    Route::get('/',            [PackageApiController::class, 'index']);
    Route::get('/{id}',        [PackageApiController::class, 'show']);
    Route::post('/',           [PackageApiController::class, 'store']);
    Route::put('/{id}',       [PackageApiController::class, 'update']);
    Route::delete('/{id}',     [PackageApiController::class, 'destroy']);
});


// service plans api
Route::middleware('auth:sanctum')->prefix('service-plans')->group(function () {

    Route::get('/', [ServicePlanApiController::class, 'index']);
    Route::get('/{id}', [ServicePlanApiController::class, 'show']);
    Route::post('/', [ServicePlanApiController::class, 'store']);
    Route::put('/{id}', [ServicePlanApiController::class, 'update']);
    Route::delete('/{id}', [ServicePlanApiController::class, 'destroy']);

    // MULTIPLE DELETE
    Route::post('/multi-delete', [ServicePlanApiController::class, 'multiDelete']);
});


// header menus api
Route::middleware('auth:sanctum')->prefix('header-menus')->group(function () {

    Route::get('/', [HeaderMenuApiController::class, 'index']);
    Route::post('/', [HeaderMenuApiController::class, 'store']);
    Route::get('/settings', [HeaderMenuApiController::class, 'settings']);

    Route::patch('/{menu}/toggle', [HeaderMenuApiController::class, 'toggleStatus']);
    Route::patch('/{menu}/quick-update', [HeaderMenuApiController::class, 'quickUpdate']);
    Route::delete('/{menu}', [HeaderMenuApiController::class, 'destroy']);
});


// footer api
Route::middleware('auth:sanctum')->prefix('footer')->group(function () {

    Route::get('/', [FooterApiController::class, 'index']);

    // settings
    Route::post('/settings/update', [FooterApiController::class, 'updateSettings']);

    // columns
    Route::post('/column/store', [FooterApiController::class, 'storeColumn']);
    Route::post('/column/update/{id}', [FooterApiController::class, 'updateColumn']);
    Route::delete('/column/delete/{id}', [FooterApiController::class, 'deleteColumn']);
    Route::post('/column/reorder', [FooterApiController::class, 'reorderColumns']);

    // links
    Route::post('/link/store', [FooterApiController::class, 'storeLink']);
    Route::post('/link/update/{id}', [FooterApiController::class, 'updateLink']);
    Route::delete('/link/delete/{id}', [FooterApiController::class, 'deleteLink']);
    Route::post('/link/reorder', [FooterApiController::class, 'reorderLinks']);

    // socials
    Route::post('/social/store', [FooterApiController::class, 'storeSocial']);
    Route::post('/social/update/{id}', [FooterApiController::class, 'updateSocial']);
    Route::delete('/social/delete/{id}', [FooterApiController::class, 'deleteSocial']);
    Route::post('/social/reorder', [FooterApiController::class, 'reorderSocial']);
});


// About Api Routes for these sections 
Route::middleware('auth:sanctum')->prefix('about')->group(function () {

    // ===== CORE VALUES =====
    Route::get('core-values', [CoreValueApiController::class, 'index']);
    Route::post('core-values/section', [CoreValueApiController::class, 'storeSection']);
    Route::post('core-values/value', [CoreValueApiController::class, 'storeValue']);
    Route::put('core-values/value/{id}', [CoreValueApiController::class, 'updateValue']);
    Route::delete('core-values/value/{id}', [CoreValueApiController::class, 'deleteValue']);

    // ===== MISSION =====
    Route::get('mission', [MissionValueApiController::class, 'show']);
    Route::post('mission', [MissionValueApiController::class, 'storeOrUpdate']);
    Route::put('mission/{id}', [MissionValueApiController::class, 'delete']);


  // ===== WHY PLATFORM =====
    Route::get('why-platform', [WhyPlatformApiController::class, 'index']);  
    Route::post('why-platform', [WhyPlatformApiController::class, 'store']); 
    Route::put('why-platform/{id}', [WhyPlatformApiController::class, 'update']);
    Route::delete('why-platform/{id}', [WhyPlatformApiController::class, 'deleteSection']); 
});



// FAQ API Routes 
Route::middleware('auth:sanctum')->prefix('faq')->group(function () {

    Route::get('/', [FaqApiController::class, 'index']);          
    Route::post('/', [FaqApiController::class, 'store']);       
    Route::put('/{id}', [FaqApiController::class, 'update']);    
    Route::delete('/{id}', [FaqApiController::class, 'destroy']); 
});


// Hero Banner API Routes 
Route::middleware('auth:sanctum')->prefix('hero-banners')->group(function () {

    Route::get('/', [HeroBannerApiController::class, 'index']);                
    Route::get('/page/{page_key}', [HeroBannerApiController::class, 'byPage']); 
    Route::post('/', [HeroBannerApiController::class, 'store']);              
    Route::put('/{id}', [HeroBannerApiController::class, 'update']);           
    Route::delete('/{id}', [HeroBannerApiController::class, 'destroy']);       
    Route::post('/reorder', [HeroBannerApiController::class, 'reorder']);      
    // Media APIs (Spatie)
    Route::get('/media', [HeroBannerApiController::class, 'mediaApi']);
    Route::post('/media/upload', [HeroBannerApiController::class, 'mediaUpload']);
});



// Home Page All Sections API Routes
Route::middleware('auth:sanctum')->prefix('home')->group(function () {

    // Counters
    Route::get('counters', [HomeApiController::class, 'counters']);
    Route::post('counters', [HomeApiController::class, 'counterStore']);
    Route::put('counters/{id}', [HomeApiController::class, 'counterUpdate']);
    Route::delete('counters/{id}', [HomeApiController::class, 'counterDelete']);
    Route::post('counters/{id}/toggle', [HomeApiController::class, 'counterToggle']);
    Route::post('counters/reorder', [HomeApiController::class, 'counterReorder']);

    // Why Choose
    Route::get('why-choose', [HomeApiController::class, 'whyChoose']);
    Route::post('why-choose', [HomeApiController::class, 'whyChooseSave']);
    Route::delete('why-choose/{id}', [HomeApiController::class, 'whyChooseDelete']);
    Route::post('why-choose/{id}/toggle', [HomeApiController::class, 'whyChooseToggle']);
    Route::post('why-choose/reorder', [HomeApiController::class, 'whyChooseReorder']);

    // How It Works
    Route::get('how-it-works', [HomeApiController::class, 'howItWorks']);
    Route::post('how-it-works', [HomeApiController::class, 'howItWorksSave']);

    // Key Features
    Route::get('key-features', [HomeApiController::class, 'keyFeatures']);
    Route::post('key-features', [HomeApiController::class, 'keyFeatureUpdate']);
    Route::post('key-features/item', [HomeApiController::class, 'keyFeatureItemStore']);
    Route::delete('key-features/item/{id}', [HomeApiController::class, 'keyFeatureItemDelete']);
    Route::post('key-features/reorder', [HomeApiController::class, 'keyFeatureReorder']);

    // Download App
    Route::get('download-app/{page_key}', [HomeApiController::class, 'downloadApp']);
    Route::post('download-app', [HomeApiController::class, 'downloadAppStore']);
});


// Reviews API Routes
Route::middleware('auth:sanctum')->prefix('reviews')->group(function () {

    Route::get('/', [ReviewApiController::class, 'index']);          
    Route::post('/', [ReviewApiController::class, 'store']);  
    Route::put('/{id}', [ReviewApiController::class, 'update']);    
    Route::delete('/{id}', [ReviewApiController::class, 'destroy']); 
});

// Inquiry API Routes
Route::post('inquiries', [InquiryApiController::class, 'store'])->middleware('auth:sanctum');



// Page Sections API Routes
Route::middleware('auth:sanctum')->prefix('page-sections')->group(function () {
    Route::get('{page_key}', [PageSectionApiController::class, 'index']);
    Route::post('/', [PageSectionApiController::class, 'store']);
    Route::delete('{id}', [PageSectionApiController::class, 'destroy']);
});


// Contact Details API Routes
Route::middleware('auth:sanctum')->prefix('contact-details')->group(function () {
    Route::get('/', [ContactDetailApiController::class, 'show']);   // Fetch
    Route::post('/', [ContactDetailApiController::class, 'store']); // Create / Update
});


