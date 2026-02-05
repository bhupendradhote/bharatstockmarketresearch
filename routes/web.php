<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\ServicePlansController;
use App\Http\Controllers\Admin\HeaderMenuController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\HeroBannerController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\AboutMissionValueController;
use App\Http\Controllers\Admin\AboutCoreValueController;
use App\Http\Controllers\Admin\AboutWhyPlatformController;
use App\Http\Controllers\Admin\PageSectionController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\ContactDetailController;
use App\Http\Controllers\Admin\TipController;
use App\Http\Controllers\Admin\PolicyController;
use App\Http\Controllers\Admin\PopupController;
use App\Http\Controllers\User\UserChatController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\NewsBlogsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\ReviewController as ReviewAdminController;
use App\Http\Controllers\Admin\AdminChatController;
use App\Events\ChatMessageSent;
use App\Http\Controllers\PolicyDisplayController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserDashboardController\UserSettingsController;
use App\Http\Controllers\UserDashboardController\MarketCallController;
use App\Http\Controllers\DigioKycController;
use App\Http\Controllers\Admin\InvestorCharterPolicyController;
use App\Http\Controllers\Admin\OfferBannerController;
use App\Http\Controllers\Admin\MessageCampaignController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\NewsController as FrontendNewsController;
use App\Http\Controllers\InvestorCharterController;
use App\Http\Controllers\PaymentInvoiceController;
use App\Http\Controllers\ProxyController;
use App\Http\Controllers\Admin\RiskRewardMasterController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\UserCertificateShowController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserDashboardController\WatchlistController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\UserDashboardController\UserAnnouncementController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin\Tickets\AllTicketsController;
use App\Http\Controllers\Admin\AdminDemoSubscriptionController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\UserDashboardController\NewsAndBlogsController;



Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    
    Route::resource('tips', TipController::class);

    Route::post('tips/{id}/follow-up', [TipController::class, 'storeFollowUp'])->name('admin.tips.followup');

});

Route::get('/latestNews', [NewsAndBlogsController::class, 'index'])->name('latest.news');

Route::middleware(['auth'])->group(function () {
    Route::get('/help-center', [TicketController::class, 'index'])
        ->name('tickets.index');


    Route::post('/help-center', [TicketController::class, 'store'])
        ->name('tickets.store');

});

Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/demo-subscriptions', 
        [AdminDemoSubscriptionController::class, 'index']
    )->name('admin.demo.index');

    Route::post('/demo-subscriptions/grant', 
        [AdminDemoSubscriptionController::class, 'grantDemo']
    )->name('admin.demo.grant');

});

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/tickets', [AllTicketsController::class, 'index'])
            ->name('tickets.all');

        Route::post('/tickets/{id}/open', [AllTicketsController::class, 'open'])
            ->name('tickets.open');

        Route::post('/tickets/{id}/resolve', [AllTicketsController::class, 'resolve'])
            ->name('tickets.resolve');

});

Route::get('/announcement', [UserAnnouncementController::class, 'index'])->name('user.announcement.index');

            Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
                Route::resource('announcements', AnnouncementController::class);
            });

            Route::get('/announcements/fetch', [UserAnnouncementController::class, 'fetchUnseen'])
    ->middleware('auth');
    
Route::post('/announcements/read/{id}', [UserAnnouncementController::class, 'markSeen'])
    ->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/watchlists', [WatchlistController::class, 'index']);
    Route::post('/watchlists', [WatchlistController::class, 'store']);
    Route::delete('/watchlists/{watchlist}', [WatchlistController::class, 'destroy']);
    Route::post('/watchlists/{watchlist}/scripts', [WatchlistController::class, 'addScript']);
    Route::delete('/watchlist-scripts/{script}', [WatchlistController::class, 'removeScript']);
    Route::put('/watchlists/{watchlist}', [WatchlistController::class, 'update'])->name('watchlists.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications/fetch', [NotificationController::class, 'fetchNotifications'])->name('notifications.fetch');
    Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

Route::post('/admin/tips/{id}/update-live-status', [App\Http\Controllers\Admin\TipController::class, 'updateLiveStatus'])->name('admin.tips.update_live');


Route::get('/api/proxy/scrips', [ProxyController::class, 'scripMaster'])->name('proxy.scrips');


Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin']) 
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


    Route::post('/blogs/category', [BlogController::class, 'storeCategory'])->name('blogs.category.store');
    
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [AboutController::class, 'index'])->name('about');
    Route::get('/services', [ServicesController::class, 'index'])->name('services');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/store', [ReviewController::class, 'store'])->name('reviews.store');    
    Route::post('/inquiry/store', [InquiryController::class, 'store'])->name('inquiry.store');
    Route::get('/newsblogs', [NewsBlogsController::class, 'index'])->name('newsblogs');
    Route::get('/blogdetails/{slug}', [NewsBlogsController::class, 'show'])->name('blogdetails');
    Route::get('/moreBlogs', [NewsBlogsController::class, 'moreBlogs'])->name('moreblogs');
    Route::get('/blogs/{id}', [BlogController::class, 'show'])->name('blogs.show');

    Route::middleware('admin')->group(function () {

        Route::get('/users',[UserController::class,'index'])->name('users.index');
        Route::get('/listUser',[UserController::class,'listUsers'])->name('users.list');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
            // =============================
            // ADMIN BLOG MANAGEMENT
            // =============================
            Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
                    
                Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
                Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
                Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
                Route::get('/blogs/{id}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
                Route::put('/blogs/{id}', [BlogController::class, 'update'])->name('blogs.update');
                Route::delete('/blogs/{id}', [BlogController::class, 'destroy'])->name('blogs.destroy');
                Route::get('/blogs/{id}', [BlogController::class, 'show'])->name('blogs.show');

                
            });


             Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

                Route::get('blog-categories', [\App\Http\Controllers\Admin\BlogCategoryController::class, 'index'])->name('blog-categories.index');
                Route::post('blog-categories', [\App\Http\Controllers\Admin\BlogCategoryController::class, 'store'])->name('blog-categories.store');
                Route::put('blog-categories/{category}', [\App\Http\Controllers\Admin\BlogCategoryController::class, 'update'])->name('blog-categories.update');
                Route::delete('blog-categories/{category}', [\App\Http\Controllers\Admin\BlogCategoryController::class, 'destroy'])->name('blog-categories.destroy');
            });


            // =============================
            // ADMIN PACKAGE MANAGEMENT
            // =============================
            Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

                Route::resource('packages', PackageController::class);
                Route::post('packages-category', [PackageController::class, 'storeCategory'])->name('packages_category.store');
                Route::get('/packages/{package}', [PackageController::class, 'show'])->name('packages.show');
                

                Route::get('/service-plans', [ServicePlansController::class, 'index'])->name('service-plans.index');
                Route::get('/service-plans/create', [ServicePlansController::class, 'create'])->name('service-plans.create');
                Route::post('/service-plans/store', [ServicePlansController::class, 'store'])->name('service-plans.store');
                Route::get('/service-plans/{id}/edit', [ServicePlansController::class, 'edit'])->name('service-plans.edit');
                Route::put('/service-plans/{servicePlan}', [ServicePlansController::class, 'update'])->name('service-plans.update');
                Route::delete('/service-plans/{id}', [ServicePlansController::class, 'destroy'])->name('admin.service-plans.destroy');
                Route::post('/service-plans/multi-delete', [ServicePlansController::class, 'multiDelete'])->name('admin.service-plans.multi-delete');

                // header routes
                Route::resource('header-menus', HeaderMenuController::class);
                Route::post('header-menus/reorder', [HeaderMenuController::class, 'reorder'])->name('header-menus.reorder');
                Route::patch('/header-menus/{menu}/toggle', [HeaderMenuController::class, 'toggleStatus'])->name('header-menus.toggle');
                Route::patch('/header-menus/{menu}/quick-update', [HeaderMenuController::class, 'quickUpdate'])->name('header-menus.quick-update');
                Route::delete('/header-menus/{menu}', [HeaderMenuController::class, 'destroy'])->name('admin.header-menus.destroy');
                Route::post('/header-menus/append', [HeaderMenuController::class, 'appendLink'])->name('header-menus.applylink'); 
            });

            // =============================
            // ADMIN FOOTER MANAGEMENT
            // =============================
            Route::prefix('admin')->name('admin.')->group(function () {

                // Main Footer Builder
                Route::get('footer', [FooterController::class, 'index'])->name('footer.index');
                Route::get('footer/create', [FooterController::class, 'create'])->name('footer.column.create');

                // Footer Branding Section (NEW)
                Route::post('footer/brand/update', [FooterController::class, 'updateBrand'])->name('footer.brand.update');

                // Footer Columns
                Route::post('footer/column', [FooterController::class, 'storeColumn'])->name('footer.column.store');
                Route::patch('footer/column/{id}', [FooterController::class, 'updateColumn'])->name('footer.column.update');
                Route::delete('footer/column/{id}', [FooterController::class, 'deleteColumn'])->name('footer.column.delete');
                Route::post('footer/column/reorder', [FooterController::class, 'reorderColumns'])->name('footer.column.reorder');

                // Footer Links
                Route::post('footer/link', [FooterController::class, 'storeLink'])->name('footer.link.store');
                Route::patch('footer/link/{id}', [FooterController::class, 'updateLink'])->name('footer.link.update');
                Route::delete('footer/link/{id}', [FooterController::class, 'deleteLink'])->name('footer.link.delete');
                Route::post('footer/link/reorder', [FooterController::class, 'reorderLinks'])->name('footer.link.reorder');

                // Footer Settings
                Route::post('footer/settings', [FooterController::class, 'updateSettings'])->name('footer.settings.update');

                // Social Icons
                Route::post('footer/social', [FooterController::class, 'storeSocial'])->name('footer.social.store');
                Route::patch('footer/social/{id}', [FooterController::class, 'updateSocial'])->name('footer.social.update');
                Route::delete('footer/social/{id}', [FooterController::class, 'deleteSocial'])->name('footer.social.delete');
                Route::post('footer/social/reorder', [FooterController::class, 'reorderSocial'])->name('footer.social.reorder');
                Route::post('footer/link/move', [FooterController::class, 'moveLink'])->name('footer.link.move');

            });

            // =============================
            // HERO BANNERS MANAGEMENT
            // =============================
            Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

                // Index + CRUD (manual)
                Route::get('/hero-banners', [HeroBannerController::class, 'index'])->name('hero-banners.index');
                Route::post('/hero-banners', [HeroBannerController::class, 'store'])->name('hero-banners.store');
                Route::put('/hero-banners/{id}', [HeroBannerController::class, 'update'])->name('hero-banners.update');
                Route::delete('/hero-banners/{id}', [HeroBannerController::class, 'destroy'])->name('hero-banners.destroy');
                Route::post('/hero-banners/reorder', [HeroBannerController::class, 'reorder'])->name('hero-banners.reorder');
                Route::patch('/hero-banners/{id}/toggle-status',[HeroBannerController::class, 'toggleStatus'])->name('hero-banners.toggle-status');

                        
                // Media inside SAME controller
                Route::get('hero-banners/media/api',  [HeroBannerController::class, 'mediaApi'])->name('media.api');
                Route::post('hero-banners/media/upload', [HeroBannerController::class, 'mediaUpload'])->name('media.upload');

                Route::get('media', function () {
                    return view('admin.media.index'); 
                })->name('media.page');
            });

            // =============================
            // FAQ MANAGEMENT
            // =============================
            Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

                Route::get('faq', [FaqController::class, 'index'])->name('faq.index');
                Route::post('faq', [FaqController::class, 'store'])->name('faq.store');

                // UPDATE (explicit)
                Route::put('faq/{faq}', [FaqController::class, 'update'])->name('faq.update');

                Route::delete('faq/{faq}', [FaqController::class, 'destroy'])->name('faq.destroy');
            });

            // =============================
            // ABOUT PAGE MANAGEMENT
            // =============================
            Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

                // Mission & Values
                Route::get('/about/mission', [AboutMissionValueController::class, 'index'])->name('about.mission.index');
                Route::post('/about/mission/store', [AboutMissionValueController::class, 'store']);
                Route::put('/about/mission/{id}', [AboutMissionValueController::class, 'update']);

                // Core Values (Section + Cards)
                Route::get('/about/core-values', [AboutCoreValueController::class, 'index'])->name('about.core-values.index');
                Route::post('/about/core-values/section', [AboutCoreValueController::class, 'storeSection']);
                Route::post('/about/core-values/card', [AboutCoreValueController::class, 'storeValue']);
                Route::put('/about/core-values/card/{id}', [AboutCoreValueController::class, 'updateValue']);
                Route::delete('/about/core-values/card/{id}', [AboutCoreValueController::class, 'deleteValue']);

                // Why We Built Platform
            
                Route::get('about/why-platform', [AboutWhyPlatformController::class, 'index'])->name('about.why-platform.index');

                Route::post('about/why-platform/store', [AboutWhyPlatformController::class, 'store']);

                Route::delete('about/why-platform/{id}', [AboutWhyPlatformController::class, 'deleteSection']);


            });

            // =============================
            // PAGE SECTIONS MANAGEMENT
            // =============================
            Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
                Route::resource('page-sections', PageSectionController::class);
            });


            // =============================
            // ADMIN HOME MANAGEMENT
            // =============================
            Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
                
                        Route::get('/home', [AdminHomeController::class, 'index'])->name('home.index');
                        Route::post('/home/counter', [AdminHomeController::class, 'storeCounter']);
                        Route::post('/home/counter/{counter}', [AdminHomeController::class, 'updateCounter']);
                        Route::delete('/home/counter/{counter}', [AdminHomeController::class, 'deleteCounter']);
                        Route::patch('/home/counter/{counter}/toggle', [AdminHomeController::class, 'toggleCounter']);
                        Route::post('/home/counter/reorder', [AdminHomeController::class, 'reorderCounters'])->name('home.counters.reorder');
                        Route::delete('/home/counter/{counter}', [HomeController::class, 'destroyCounter'])->name('home.counters.destroy');

                        Route::get('/why-choose', [AdminHomeController::class, 'whyChooseIndex'])->name('why-choose.index');
                        Route::post('/why-choose', [AdminHomeController::class, 'whyChooseStore']);
                        Route::post('/why-choose/{section}', [AdminHomeController::class, 'whyChooseUpdate']);
                        Route::delete('/why-choose/{section}', [AdminHomeController::class, 'whyChooseDelete']);
                        Route::post('/why-choose/reorder', [AdminHomeController::class, 'whyChooseReorder']);
                        Route::patch('/why-choose/{section}/toggle', [AdminHomeController::class, 'whyChooseToggle']);

                    // HOW IT WORKS
                        Route::get('/how-it-works', [AdminHomeController::class, 'howItWorksIndex'])->name('how-it-works.index');
                        Route::post('/how-it-works/save', [AdminHomeController::class, 'howItWorksSave'])->name('how-it-works.save');
                            


            
                        Route::get('/home', [AdminHomeController::class, 'index'])->name('home.index');
                        Route::post('/home/counter', [AdminHomeController::class, 'storeCounter']);
                        Route::post('/home/counter/{counter}', [AdminHomeController::class, 'updateCounter']);
                        Route::delete('/home/counter/{counter}', [AdminHomeController::class, 'deleteCounter']);
                        Route::patch('/home/counter/{counter}/toggle', [AdminHomeController::class, 'toggleCounter']);
                        Route::post('/home/counter/reorder', [AdminHomeController::class, 'reorderCounters'])->name('home.counters.reorder');

                        Route::get('/why-choose', [AdminHomeController::class, 'whyChooseIndex'])->name('why-choose.index');
                        Route::post('/why-choose', [AdminHomeController::class, 'whyChooseStore']);
                        Route::post('/why-choose/{section}', [AdminHomeController::class, 'whyChooseUpdate']);
                        Route::delete('/why-choose/{section}', [AdminHomeController::class, 'whyChooseDelete']);
                        Route::post('/why-choose/reorder', [AdminHomeController::class, 'whyChooseReorder']);
                        Route::patch('/why-choose/{section}/toggle', [AdminHomeController::class, 'whyChooseToggle']);

                    // HOW IT WORKS
                        Route::get('/how-it-works', [AdminHomeController::class, 'howItWorksIndex'])->name('how-it-works.index');
                        Route::post('/how-it-works/save', [AdminHomeController::class, 'howItWorksSave'])->name('how-it-works.save');

                    //HOME KEY FEATURES
                        Route::get('/home/key-features', [AdminHomeController::class, 'keyFeaturesIndex'])->name('home.key-features.index');
                        Route::post('/home/key-features/section', [AdminHomeController::class, 'keyFeaturesUpdate'])->name('home.key-features.section');
                        Route::post('/home/key-features/item', [AdminHomeController::class, 'keyFeaturesItemStore'])->name('home.key-features.item.store');
                        Route::post('/home/key-features/reorder', [AdminHomeController::class, 'keyFeaturesReorder'])->name('home.key-features.reorder');
                        Route::delete('/home/key-features/item/{id}',[AdminHomeController::class, 'keyFeaturesItemDelete'])->name('home.key-features.item.delete');


                    //HOME KEY FEATURES
                        Route::get('/home/key-features', [AdminHomeController::class, 'keyFeaturesIndex'])->name('home.key-features.index');
                        Route::post('/home/key-features/section', [AdminHomeController::class, 'keyFeaturesUpdate'])->name('home.key-features.section');
                        Route::post('/home/key-features/item', [AdminHomeController::class, 'keyFeaturesItemStore'])->name('home.key-features.item.store');
                        Route::post('/home/key-features/reorder', [AdminHomeController::class, 'keyFeaturesReorder'])->name('home.key-features.reorder');
                        Route::delete('/home/key-features/item/{id}',[AdminHomeController::class, 'keyFeaturesItemDelete'])->name('home.key-features.item.delete');        
                        
                    // DOWNLOAD APP SECTION
                    Route::get('/home/download-app-section',[AdminHomeController::class, 'downloadAppIndex'])->name('home.download-app.index');
                    Route::post('/home/download-app-section',[AdminHomeController::class, 'downloadAppSectionStore'])->name('home.download-app.store');

                    // CONTACT DETAILS
                    Route::get('/contact-details', [ContactDetailController::class, 'index'])->name('contact.index');
                    Route::post('/contact-details', [ContactDetailController::class, 'store'])->name('contact.store');
            });
        
    });
    
            // =============================
            // ADMIN HOME POP-UP MANAGEMENT
            // =============================

            Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
            
                Route::resource('popups', PopupController::class)->except(['show']);
                Route::post('popups/{popup}/activate', [PopupController::class, 'activate'])->name('popups.activate');
                Route::post('popups/{popup}/deactivate', [PopupController::class, 'deactivate'])->name('popups.deactivate');
                
            });
  

        // Chat Routes

                // get messages from session
                Route::get('/get-messages', [ChatController::class, 'getMessages']);

                // send message (save in session + broadcast)
                Route::post('/send-message', [ChatController::class, 'sendMessage']);

                Route::middleware(['auth', 'admin'])->group(function () {    
                    Route::post('/admin/chat/send', [AdminChatController::class, 'sendMessage'])->name('admin.chat.send');
                    Route::get('/admin/chat/conversation/{userId}',[AdminChatController::class, 'getConversation'])->name('admin.chat.conversation');
                    Route::get('/admin/chat/inbox-unread', [AdminChatController::class, 'inboxWithUnread']);
                    Route::post('/admin/chat/mark-read/{userId}', [AdminChatController::class, 'markAsRead']);
                    Route::get('/admin/chat', function () {
                        return view('admin.chat.index');})->name('admin.chat');
                });


                Route::middleware(['auth'])->group(function () {
                    Route::post('/user/chat/send', [UserChatController::class, 'sendMessage'])->name('user.chat.send');
                });


            // User chat page
                Route::get('/support/chat', function () {
                    return view('user.chat');
                })->middleware('auth');

                // User send
                Route::post('/user/chat/send',
                    [UserChatController::class, 'sendMessage']
                )->middleware('auth');

                // User history
                Route::get('/user/chat/history',
                    [UserChatController::class, 'history']
                )->middleware('auth');



            // Notification Routes....
                Route::get('/admin/notifications/latest', function () {
                    return \App\Models\NotificationUser::with('notification')->where('user_id', auth()->id())->latest()->take(5)->get();
                })->middleware('auth');

                Route::post('/admin/notifications/mark-read', function () {
                    \App\Models\NotificationUser::where('user_id', auth()->id())->whereNull('read_at')->update(['read_at' => now()]);
                    return response()->json(['success' => true]);
                });



                // User Dashboard Routes.....
                Route::get('/dashboard',function(){
                    return view('UserDashboard.userdashboard');
                })->name('user.dashboard')->middleware('auth');

                Route::get('/dashboard', [UserSettingsController::class, 'dashboard'])
                    ->name('user.dashboard')
                    ->middleware('auth');


                Route::middleware(['auth'])->group(function () {
                    Route::get('/market-calls', [MarketCallController::class, 'index'])->name('marketCall.index');
                });

                Route::get('/market-calls/detail',function(){
                    return view('UserDashboard.marketCall.marketCall_detail');
                });

               


                //UserDashboard  Settings Route
                    Route::middleware(['auth'])->group(function () {
                        Route::get('/settings', [UserSettingsController::class, 'profile'])->name('user.settings.profile');
                        Route::get('/profile/edit', [UserSettingsController::class, 'edit'])->name('user.settings.edit');                        
                        Route::get('/payment-invoice-list', [PaymentInvoiceController::class, 'index'])->name('payment.invoice.list');
                        Route::get('/payment-invoice', [PaymentInvoiceController::class, 'show'])->name('payment.invoice.list');
                        Route::get('/invoice/{invoice}/download', [PaymentInvoiceController::class, 'download'])->name('invoice.download');
                    });


                    Route::prefix('settings')->group(function () {
                        Route::post('/profile/update', [UserSettingsController::class, 'updateGeneralProfile'])->name('settings.profile.update');
                        Route::post('/send-otp', [UserSettingsController::class, 'sendOtp'])->name('profile.sendOtp');
                        Route::post('/verify-otp', [UserSettingsController::class, 'verifyAndUpdate'])->name('profile.verifyOtp');
                    });


                    Route::get('/settings/kyc', [DigioKycController::class, 'index'])->name('kyc.index');
                    Route::post('/digio/start-kyc', [DigioKycController::class, 'testDirectRedirect'])->name('digio.test.redirect');
                    Route::get('/digio/callback', [DigioKycController::class, 'callback'])->name('digio.callback');
                    Route::post('/kyc/check-direct', [DigioKycController::class, 'checkKycStatusDirect'])->name('digio.check.kyc.status');

                    Route::prefix('admin')->middleware(['auth'])->group(function () {
                        Route::get('tips', [TipController::class, 'index'])->name('admin.tips.index');                   
                        Route::get('/tips/create', [TipController::class, 'EquityTips'])->name('admin.tips.create');
                        Route::post('/tips/equity/store', [TipController::class, 'storeEquityTip'])->name('tips.equity.store');
                        Route::get('/future-option', [TipController::class, 'FutureAndOption'])->name('admin.tips.future_Option');
                        Route::post('/tips/derivative/store', [TipController::class, 'storeDerivativeTip'])->name('tips.derivative.store');
                        Route::post('/tips/category/store', [TipController::class, 'storeCategory'])->name('admin.tips.category.store');
                        Route::get('/tips/{tip}/edit', [TipController::class, 'edit'])->name('admin.tips.edit');
                        Route::put('/tips/{tip}/update', [TipController::class, 'update'])->name('admin.tips.update');
                    });

                     // Tip Categories Management
                    Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
                        Route::get('tips-categories', [\App\Http\Controllers\Admin\TipCategoryController::class, 'index'])->name('tips-categories.index');
                        Route::post('tips-categories', [\App\Http\Controllers\Admin\TipCategoryController::class, 'store'])->name('tips-categories.store');
                        Route::put('tips-categories/{category}', [\App\Http\Controllers\Admin\TipCategoryController::class, 'update'])->name('tips-categories.update');
                        Route::delete('tips-categories/{category}', [\App\Http\Controllers\Admin\TipCategoryController::class, 'destroy'])->name('tips-categories.destroy');
                    });

                    // subscription Routes
                    Route::middleware('auth')->group(function () {
                        Route::get('/subscribe/confirm', [SubscriptionController::class, 'confirm'])->name('subscription.confirm');
                        Route::post('/subscribe/pay', [SubscriptionController::class, 'pay'])->name('subscription.pay');
                        Route::get('/subscribe/success', fn () => view('subscription.success'))->name('subscription.success');
                    });



                    // ==========================================
                    // ADMIN ROUTES (Policy Management)
                    // ==========================================
                    Route::prefix('admin')->name('admin.')->group(function () {
                        Route::get('/policies', [PolicyController::class, 'index'])->name('policies.index');
                        Route::get('/policies/create', [PolicyController::class, 'create'])->name('policies.create');
                        Route::post('/policies/store', [PolicyController::class, 'store'])->name('policies.store');
                        
                        // Edit & Update Routes
                        Route::get('/policies/{id}/edit', [PolicyController::class, 'edit'])->name('policies.edit');
                        Route::put('/policies/{id}/update', [PolicyController::class, 'update'])->name('policies.update');
                    });


                    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
                        Route::get('/investor-charter-policy',[InvestorCharterPolicyController::class, 'index'])->name('investor-charter-policy.index');
                        Route::get('/investor-charter-policy/create',[InvestorCharterPolicyController::class, 'create'])->name('investor-charter-policy.create');
                        Route::post('/investor-charter-policy',[InvestorCharterPolicyController::class, 'store'])->name('investor-charter-policy.store');

                    });

                    // Separate Routes for each policy
                    Route::get('/privacy-policy', [PolicyDisplayController::class, 'privacy'])->name('policy.privacy');
                    Route::get('/terms-and-conditions', [PolicyDisplayController::class, 'terms'])->name('policy.terms');
                    Route::get('/grievance-redressal-policy', [PolicyDisplayController::class, 'grievance'])->name('policy.grievance');


                    Route::get('/investor-charter', [InvestorCharterController::class, 'show'])
                        ->name('investor.charter');

                        Route::get('/banner-test', function () {
                            $banner = App\Models\HeroBanner::first();
                            return [
                                'hasMedia' => $banner->hasMedia('background'),
                                'url' => $banner->getFirstMediaUrl('background'),
                                'collections' => $banner->media->pluck('collection_name'),
                            ];
                        });

                        // Legal Pages

                        Route::get('/legal',function(){
                            return view('legal.index');
                        });


                        Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
                                Route::resource('marquees', \App\Http\Controllers\Admin\MarqueeController::class);
                                Route::post('marquees/{marquee}/toggle',[\App\Http\Controllers\Admin\MarqueeController::class, 'toggle'])->name('marquees.toggle');
                        });

                        Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
                            Route::resource('offer-banners', OfferBannerController::class);
                            Route::patch('offer-banners/{offerBanner}/toggle-status', [OfferBannerController::class, 'toggleStatus'])
                                ->name('offer-banners.toggle-status');
                        });


                        Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
                                Route::resource('message-campaigns',MessageCampaignController::class)->except(['show', 'edit', 'update']);
                                Route::patch('message-campaigns/{campaign}/toggle',[MessageCampaignController::class, 'toggle'])->name('message-campaigns.toggle');
                        });


                        Route::prefix('admin')->name('admin.')->group(function () {
                            // News Resource
                            Route::resource('news', NewsController::class);
                            
                            // Category Routes within same NewsController
                            Route::get('news-categories', [NewsController::class, 'categoryIndex'])->name('news.categories');
                            Route::post('news-categories', [NewsController::class, 'categoryStore'])->name('news.categories.store');
                            Route::put('news-categories/{id}', [NewsController::class, 'categoryUpdate'])->name('news.categories.update');
                            Route::delete('news-categories/{id}', [NewsController::class, 'categoryDestroy'])->name('news.categories.destroy');
                        });

                        // Frontend News Routes
                        Route::prefix('news')->name('news.')->group(function () {
                            Route::get('/', [FrontendNewsController::class, 'index'])->name('index');           // News Hub
                            Route::get('/all', [FrontendNewsController::class, 'archive'])->name('archive');    // Archive (Latest/Oldest)
                            Route::get('/{slug}', [FrontendNewsController::class, 'show'])->name('show');       // Single News Page
                        });

                    Route::post('/subscription/razorpay/initiate',[SubscriptionController::class, 'initiateRazorpay'])->name('subscription.razorpay.initiate');
                    Route::post('/subscription/razorpay/verify',[SubscriptionController::class, 'verifyRazorpay'])->name('subscription.razorpay.verify');                             // 4️⃣ Success page
                   
                      Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function() {
                        Route::get('/reviews', [ReviewAdminController::class, 'index'])->name('reviews.index');
                        Route::patch('/reviews/{review}/status', [ReviewAdminController::class, 'updateStatus'])->name('reviews.status');
                        Route::post('/reviews/{review}/featured', [ReviewAdminController::class, 'toggleFeatured'])->name('reviews.featured');
                    });
            

            Route::middleware(['auth'])->prefix('admin')->group(function () {

                Route::get('/risk-reward-master', [RiskRewardMasterController::class, 'index'])
                    ->name('admin.risk-reward.index');

                Route::post('/risk-reward-master', [RiskRewardMasterController::class, 'store'])
                    ->name('admin.risk-reward.store');

                Route::post('/risk-reward-master/{riskRewardMaster}/activate', [RiskRewardMasterController::class, 'activate'])
                    ->name('admin.risk-reward.activate');

            });



                Route::post('/campaign/mark-as-seen', [App\Http\Controllers\CampaignController::class, 'markAsSeen'])->middleware('auth');

		  Route::prefix('admin')->middleware(['auth'])->group(function () {
                Route::resource('employees', EmployeeController::class);
            });


	Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('certificates', CertificateController::class);
});

    Route::middleware(['auth'])->group(function () {
        Route::get('/my-certificates', [UserCertificateShowController::class, 'index'])->name('user.certificates.index');
        Route::get('/certificates/download/{certificate}', [UserCertificateShowController::class, 'download'])->name('user.certificates.download');
    });	




