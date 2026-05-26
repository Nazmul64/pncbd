<?php

use App\Http\Controllers\Admin\AboutForCompanyController;
use App\Http\Controllers\Admin\AdminauthController;
use App\Http\Controllers\Admin\AdminChatController;
use App\Http\Controllers\Admin\StaffChatController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminIncompleteOrderController;
use App\Http\Controllers\Admin\AdminproductReviewController;
use App\Http\Controllers\Admin\AdminsellerregisterapprovedController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AffiliateproductController;
use App\Http\Controllers\Admin\AipromptController;
use App\Http\Controllers\Admin\AllorderController;
use App\Http\Controllers\Admin\AlltaxesController;
use App\Http\Controllers\Admin\CampaigncreateController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChildSubCategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ContactinfomationadminController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DeliveryInformationController;
use App\Http\Controllers\Admin\DuplicateordersettingController;
use App\Http\Controllers\Admin\EmpleeController;
use App\Http\Controllers\Admin\FootercategoryController;
use App\Http\Controllers\Admin\GeneralsettingController;
use App\Http\Controllers\Admin\GoogleTagmanagerController;
use App\Http\Controllers\Admin\IpblockmanageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\NagadSettingController;
use App\Http\Controllers\Admin\PaymentHistoryController;
use App\Http\Controllers\Admin\OrderAssignmentController;
use App\Http\Controllers\Admin\OrderStatusHistoryController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PathaocourierController;
use App\Http\Controllers\Admin\PathaoOrderController;
use App\Http\Controllers\Admin\PaymentgetewaymanageController;
use App\Http\Controllers\Admin\PaymentSettingController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PixelController;
use App\Http\Controllers\Admin\PosController;
use App\Http\Controllers\Admin\ProductBrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\Productsettingcontroller;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ShippingChargeController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SmsgatewaysetupController;
use App\Http\Controllers\Admin\SteadfastcourierController;
use App\Http\Controllers\Admin\SteadfastOrderController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\TremsandcondationsController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\Admin\LandingPageBuilderController;
use App\Http\Controllers\Admin\WebsitefaviconController;
use App\Http\Controllers\Admin\WithdrawPaymentController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\PurchaseReportController;
use App\Http\Controllers\Admin\PurchaseReturnController;
use App\Http\Controllers\Admin\DigitalProductController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\BkashController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\ChatController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\FrontendauthContorller;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\IncompleteOrderController;
use App\Http\Controllers\Frontend\Landingordercontroller;
use App\Http\Controllers\Frontend\OrderTrackController;
use App\Http\Controllers\Frontend\ProductReviewController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\Shurjopaycontroller;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\Saller\SellerauthController;
use App\Http\Controllers\Subadmin\SubadminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Auth::routes();


// ══════════════════════════════════════════════════════════════════════════════
// FRONTEND — PUBLIC PAGES
// ══════════════════════════════════════════════════════════════════════════════
Route::get('/', [FrontendauthContorller::class, 'frontend']         )->name('frontend');
Route::get('customer/register', [FrontendauthContorller::class, 'customerRegister'])->name('customer.register');
Route::get('customer/login', [FrontendauthContorller::class, 'customerlogin'])->name('customer.login');



// ══════════════════════════════════════════════════════════════════════════════
// FRONTEND CHAT (public — no auth)
// ══════════════════════════════════════════════════════════════════════════════
Route::prefix('chat')->name('chat.')->group(function () {
    Route::post('start',   [ChatController::class, 'start']      )->name('start');
    Route::post('send',    [ChatController::class, 'send']       )->name('send');
    Route::get ('messages',[ChatController::class, 'getMessages'])->name('messages');
    Route::post('close',   [ChatController::class, 'close']      )->name('close');
});








// ══════════════════════════════════════════════════════════════════════════════
// GENERAL AUTH
// ══════════════════════════════════════════════════════════════════════════════
Route::get ('/login',    [AuthController::class, 'showLogin']   )->name('login');
Route::post('/login',    [AuthController::class, 'login']       )->name('login.post');
Route::get ('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']    )->name('register.post');
Route::post('/logout',   [AuthController::class, 'logout']      )->name('logout');

// ══════════════════════════════════════════════════════════════════════════════
// CUSTOMER AUTH & DASHBOARD
// ══════════════════════════════════════════════════════════════════════════════
Route::get ('customer/register',        [FrontendauthContorller::class, 'customerregister']          )->name('customer.register');
Route::post('customer/login/submit', [FrontendauthContorller::class, 'customer_login_submit']   )->name('customer.login.submit');
Route::get ('customer/register',     [FrontendauthContorller::class, 'customer_register']       )->name('customer.register');
Route::post('customer/register',     [FrontendauthContorller::class, 'customer_register_submit'])->name('customer.register.submit');
Route::post('customer/logout',       [FrontendauthContorller::class, 'customer_logout']         )->name('customer.logout');

Route::middleware(['customer'])->group(function () {
    Route::get('customer/dashboard', [FrontendauthContorller::class, 'user_dashboard'])->name('customer.dashboard');
    Route::get('customer/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('customer.profile.index');
    Route::post('customer/profile/update', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('customer.profile.update');
    Route::post('customer/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('customer.profile.password');

    // Customer Information routes
    Route::get('customer/information', [\App\Http\Controllers\Frontend\UserInformationController::class, 'create'])->name('customer.information.create');
    Route::post('customer/information', [\App\Http\Controllers\Frontend\UserInformationController::class, 'store'])->name('customer.information.store');

    // Member Card route
    Route::get('customer/card', [FrontendauthContorller::class, 'user_card'])->name('customer.card');

    // Customer Loan details & payment screenshot verification routes
    Route::get('customer/loan/active-details', [App\Http\Controllers\Frontend\LoanController::class, 'activeLoanDetails'])->name('loan.active-details');
    Route::get('customer/bank-details', [App\Http\Controllers\Frontend\LoanController::class, 'bankDetails'])->name('loan.bank-details');
    Route::get('customer/loans/{id}/details', [App\Http\Controllers\Frontend\LoanController::class, 'details'])->name('loan.details');
    Route::post('customer/loans/{id}/screenshot', [App\Http\Controllers\Frontend\LoanController::class, 'uploadScreenshot'])->name('loan.screenshot.upload');

    // Real database-backed loan application flow
    Route::prefix('loan')->name('loan.')->group(function () {
        Route::get('apply/step1', [App\Http\Controllers\Frontend\LoanController::class, 'step1'])->name('step1');
        Route::post('apply/step1', [App\Http\Controllers\Frontend\LoanController::class, 'postStep1'])->name('step1.post');
        Route::get('apply/step2', [App\Http\Controllers\Frontend\LoanController::class, 'step2'])->name('step2');
        Route::post('apply/step2', [App\Http\Controllers\Frontend\LoanController::class, 'postStep2'])->name('step2.post');
        Route::get('apply/step3', [App\Http\Controllers\Frontend\LoanController::class, 'step3'])->name('step3');
        Route::post('apply/submit', [App\Http\Controllers\Frontend\LoanController::class, 'submit'])->name('submit');
        Route::get('apply/success', [App\Http\Controllers\Frontend\LoanController::class, 'success'])->name('success');
    });
});

// ══════════════════════════════════════════════════════════════════════════════
// ADMIN AUTH (public — outside admin middleware)
// ══════════════════════════════════════════════════════════════════════════════
Route::get ('/admin/login',  [AdminauthController::class, 'admin_login']       )->name('admin.login');
Route::post('/admin/login',  [AdminauthController::class, 'admin_login_submit'])->name('admin.login.submit');
Route::get ('/admin/logout', [AdminauthController::class, 'admin_logout']      )->name('admin.logout');
Route::post('/admin/logout', [AdminauthController::class, 'admin_logout_confirm'])->name('admin.logout.confirm');

// ══════════════════════════════════════════════════════════════════════════════
// STEADFAST WEBHOOK (public — outside admin auth)
// ══════════════════════════════════════════════════════════════════════════════
Route::post('webhook/steadfast', [SteadfastOrderController::class, 'webhook'])->name('steadfast.webhook');

// ══════════════════════════════════════════════════════════════════════════════
// CUSTOMER RESOURCE — ADMIN middleware, NO admin. prefix
// (পুরানো code compatibility রক্ষায় prefix ছাড়া রাখা হয়েছে)
// ══════════════════════════════════════════════════════════════════════════════
Route::middleware(['admin'])->group(function () {
    Route::resource('customer', CustomerController::class);
    Route::post('customer/{id}/status',      [CustomerController::class, 'updateStatus'])->name('customer.status');
    Route::post('customer/{id}/make-vendor', [CustomerController::class, 'makeVendor']  )->name('customer.makeVendor');
});

// ══════════════════════════════════════════════════════════════════════════════
// ADMIN — ALL PROTECTED ROUTES
// URL prefix  : /admin/
// Route prefix: admin.
// ══════════════════════════════════════════════════════════════════════════════
Route::middleware(['admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // ── Dashboard ─────────────────────────────────────────────────────────────
    Route::get('dashboard', [AdminController::class, 'admin_dashboard'])->name('dashboard');



    // Profile Routes — inside admin. name group, so just 'profile.*' needed
    Route::get ('profile',          [App\Http\Controllers\ProfileController::class, 'index']         )->name('profile.index');
    Route::post('profile/update',   [App\Http\Controllers\ProfileController::class, 'updateProfile'] )->name('profile.update');
    Route::post('profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');





    // ──────────────────────────────────────────────────────────────────────────
    // ROLES & PERMISSIONS
    // name: admin.roles.*  |  admin.permissions.*
    // ⚠️ Custom routes BEFORE resource — noinlè {role} wildcard match korbe
    // ──────────────────────────────────────────────────────────────────────────
    Route::get ('roles/{role}/assign-permission',        [RoleController::class, 'assignPermission']      )->name('roles.assignPermission');
    Route::put ('roles/{role}/save-assigned-permission', [RoleController::class, 'saveAssignedPermission'])->name('roles.saveAssignedPermission');
    Route::resource('roles', RoleController::class);

    Route::post('permissions/bulk-create', [PermissionController::class, 'bulkCreate'])->name('permissions.bulkCreate');
    Route::resource('permissions', PermissionController::class);

    // ──────────────────────────────────────────────────────────────────────────
    // USERS
    // name: admin.users.*
    // AdminUserController aliased to avoid collision with root UserController
    // ──────────────────────────────────────────────────────────────────────────
    Route::patch('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::resource('users', AdminUserController::class);

    // ──────────────────────────────────────────────────────────────────────────
    // GENERAL SETTINGS
    // ──────────────────────────────────────────────────────────────────────────
    Route::post('Generalsettings/reset',       [GeneralsettingController::class, 'resetTheme'])->name('Generalsettings.reset');
    Route::post('Generalsettings/upload-logo', [GeneralsettingController::class, 'uploadLogo'])->name('Generalsettings.upload-logo');
    Route::post('Generalsettings/delete-logo', [GeneralsettingController::class, 'deleteLogo'])->name('Generalsettings.delete-logo');
    Route::resource('Generalsettings', GeneralsettingController::class);

    // ──────────────────────────────────────────────────────────────────────────
    // WEBSITE FAVICON
    // ──────────────────────────────────────────────────────────────────────────
    Route::post('websitefavicon/upload-logo', [WebsitefaviconController::class, 'uploadLogo'])->name('websitefavicon.upload-logo');
    Route::post('websitefavicon/delete-logo', [WebsitefaviconController::class, 'deleteLogo'])->name('websitefavicon.delete-logo');
    Route::resource('websitefavicon', WebsitefaviconController::class);

    // ── Footer Settings ──────────────────────────────────────────────────────
    Route::get ('footer-settings',        [App\Http\Controllers\Admin\FooterSettingController::class, 'index'] )->name('footer-settings.index');
    Route::put ('footer-settings/update', [App\Http\Controllers\Admin\FooterSettingController::class, 'update'])->name('footer-settings.update');






    // ──────────────────────────────────────────────────────────────────────────
    // PRIVACY POLICY
    // ──────────────────────────────────────────────────────────────────────────
    Route::resource('privacy-policy', \App\Http\Controllers\Admin\PrivacyPolicyController::class);



    // ──────────────────────────────────────────────────────────────────────────
    // ADMIN CHAT PANEL (customer chat)
    // prefix: admin/chat  |  name: admin.chat.*
    // ──────────────────────────────────────────────────────────────────────────
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get ('/',                       [AdminChatController::class, 'index']      )->name('index');
        Route::get ('/unread-count',           [AdminChatController::class, 'unreadCount'])->name('unread');
        Route::get ('/{chatSession}',          [AdminChatController::class, 'show']       )->name('show');
        Route::post('/{chatSession}/reply',    [AdminChatController::class, 'reply']      )->name('reply');
        Route::get ('/{chatSession}/messages', [AdminChatController::class, 'getMessages'])->name('messages');
        Route::post('/{chatSession}/close',    [AdminChatController::class, 'close']      )->name('close');
    });

    // ──────────────────────────────────────────────────────────────────────────
    // ADMIN ↔ STAFF PRIVATE CHAT
    // prefix: admin/staff-chat  |  name: admin.staff-chat.*
    // Only admin can see all staff threads (A-Z sorted by name/staff_id)
    // ──────────────────────────────────────────────────────────────────────────
    Route::prefix('staff-chat')->name('staff-chat.')->group(function () {
        Route::get ('/',                        [StaffChatController::class, 'index']          )->name('index');
        Route::get ('/unread-count',            [StaffChatController::class, 'adminUnreadCount'])->name('unread');
        Route::get ('/{staffId}',               [StaffChatController::class, 'show']           )->name('show');
        Route::post('/{staffId}/reply',         [StaffChatController::class, 'reply']          )->name('reply');
        Route::get ('/{staffId}/messages',      [StaffChatController::class, 'getMessages']    )->name('messages');
    });



    // ──────────────────────────────────────────────────────────────────────────
    // OTHER RESOURCES
    // ──────────────────────────────────────────────────────────────────────────
    Route::resource('contact',                ContactController::class);

    Route::resource('contactinfomationadmins',ContactinfomationadminController::class);
    Route::resource('aboutcompany',           AboutForCompanyController::class);
    Route::resource('tremsandcondation',      TremsandcondationsController::class);
    Route::resource('pages',                  PageController::class);
    Route::resource('footercategory',         FootercategoryController::class);




    Route::get ('mail-setting',        [App\Http\Controllers\Admin\MailsettingController::class, 'index'] )->name('mail.index');
    Route::post('mail-setting/update', [App\Http\Controllers\Admin\MailsettingController::class, 'update'])->name('mail.update');
    Route::post('mail-setting/test',   [App\Http\Controllers\Admin\MailsettingController::class, 'sendTestMail'])->name('mail.test');

    // Customer documentation (KYC uploads after registration)
    Route::get('documentation', [\App\Http\Controllers\Admin\AdminUserInformationController::class, 'index'])->name('documentation.index');
    Route::get('documentation/{id}', [\App\Http\Controllers\Admin\AdminUserInformationController::class, 'show'])->name('documentation.show');
    Route::resource('user-informations', \App\Http\Controllers\Admin\AdminUserInformationController::class)->only(['index', 'show', 'destroy']);


    Route::middleware(['emplee'])->group(function () {
        Route::get('emplee/dashboard', [EmpleeController::class, 'emplee_dashboard'])->name('emplee.dashboard');
        Route::get('emplee/stamp',     [EmpleeController::class, 'stampPage']       )->name('emplee.stamp');
        Route::post('emplee/loans/{id}/status', [EmpleeController::class, 'updateLoanStatus'])->name('emplee.loans.updateStatus');

        // Employee ID Card Generator Routes
        Route::get('emplee/id-card', [\App\Http\Controllers\Admin\HrmEmployeeController::class, 'idCard'])->name('emplee.id-card');
        Route::post('emplee/id-card/upload', [\App\Http\Controllers\Admin\HrmEmployeeController::class, 'uploadIdCard'])->name('emplee.id-card.upload');

        // Profile Routes
        Route::get('emplee/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('emplee.profile.index');
        Route::post('emplee/profile/update', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('emplee.profile.update');
        Route::post('emplee/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('emplee.profile.password');
        
        // Staff Customer Management endpoints
        Route::post('emplee/customer/{id}/update-profile', [EmpleeController::class, 'updateCustomerProfile'])->name('emplee.customer.updateProfile');
        Route::post('emplee/customer/{id}/change-password', [EmpleeController::class, 'changeCustomerPassword'])->name('emplee.customer.changePassword');

        // ── Customer Chat (emplee sees customer chat) ─────────────────────────────
        Route::prefix('emplee/chat')->name('emplee.chat.')->group(function () {
            Route::get ('/',                       [App\Http\Controllers\Admin\AdminChatController::class, 'index']      )->name('index');
            Route::get ('/unread-count',           [App\Http\Controllers\Admin\AdminChatController::class, 'unreadCount'])->name('unread');
            Route::get ('/{chatSession}',          [App\Http\Controllers\Admin\AdminChatController::class, 'show']       )->name('show');
            Route::post('/{chatSession}/reply',    [App\Http\Controllers\Admin\AdminChatController::class, 'reply']      )->name('reply');
            Route::get ('/{chatSession}/messages', [App\Http\Controllers\Admin\AdminChatController::class, 'getMessages'])->name('messages');
            Route::post('/{chatSession}/close',    [App\Http\Controllers\Admin\AdminChatController::class, 'close']      )->name('close');
        });

        // ── Admin ↔ Staff Private Chat (staff নিজের chat দেখে) ───────────────────
        Route::prefix('emplee/staff-chat')->name('emplee.staff-chat.')->group(function () {
            Route::get ('/',           [StaffChatController::class, 'staffIndex']     )->name('index');
            Route::post('/reply',      [StaffChatController::class, 'staffReply']     )->name('reply');
            Route::get ('/messages',   [StaffChatController::class, 'staffGetMessages'])->name('messages');
            Route::get ('/unread-count',[StaffChatController::class, 'staffUnreadCount'])->name('unread');
        });
    });

// ══════════════════════════════════════════════════════════════════════════════
// MANAGER
// ══════════════════════════════════════════════════════════════════════════════
Route::get ('manager/login',        [ManagerController::class, 'manager_login']       )->name('manager.login');
Route::post('manager/login/submit', [ManagerController::class, 'manager_login_submit'])->name('manager.login.submit');
Route::post('manager/logout',       [ManagerController::class, 'manager_logout']      )->name('manager.logout');

Route::middleware(['manager'])->group(function () {
    Route::get('manager/dashboard', [ManagerController::class, 'manager_dashboard'])->name('manager.dashboard');

    // Profile Routes
    Route::get('manager/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('manager.profile.index');
    Route::post('manager/profile/update', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('manager.profile.update');
    Route::post('manager/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('manager.profile.password');





    // ── Chat ──────────────────────────────────────────────────────────────────
    Route::prefix('manager/chat')->name('manager.chat.')->group(function () {
        Route::get ('/',                       [App\Http\Controllers\Admin\AdminChatController::class, 'index']      )->name('index');
        Route::get ('/unread-count',           [App\Http\Controllers\Admin\AdminChatController::class, 'unreadCount'])->name('unread');
        Route::get ('/{chatSession}',          [App\Http\Controllers\Admin\AdminChatController::class, 'show']       )->name('show');
        Route::post('/{chatSession}/reply',    [App\Http\Controllers\Admin\AdminChatController::class, 'reply']      )->name('reply');
        Route::get ('/{chatSession}/messages', [App\Http\Controllers\Admin\AdminChatController::class, 'getMessages'])->name('messages');
        Route::post('/{chatSession}/close',    [App\Http\Controllers\Admin\AdminChatController::class, 'close']      )->name('close');
    });




});

// ══════════════════════════════════════════════════════════════════════════════
// SUB-ADMIN
// ══════════════════════════════════════════════════════════════════════════════
Route::get ('subadmin/login',        [SubadminController::class, 'subadmin_login']       )->name('subadmin.login');
Route::post('subadmin/login/submit', [SubadminController::class, 'subadmin_login_submit'])->name('subadmin.login.submit');
Route::get ('subadmin/logout',       [SubadminController::class, 'subadmin_logout']      )->name('subadmin.logout');

Route::middleware(['subadmin'])->group(function () {
    Route::get('subadmin/dashboard', [SubadminController::class, 'subadmin_dashboard'])->name('subadmin.dashboard');
});


    // ── Withdraw Payment Setup ──────────────────────────────────────────────
    Route::get   ('withdraw-payment-setup',               [WithdrawPaymentController::class, 'index'  ])->name('withdraw-payment.index');
    Route::post  ('withdraw-payment-setup/store',         [WithdrawPaymentController::class, 'store'  ])->name('withdraw-payment.store');
    Route::post  ('withdraw-payment-setup/{id}/update',   [WithdrawPaymentController::class, 'update' ])->name('withdraw-payment.update');
    Route::post  ('withdraw-payment-setup/{id}/toggle',   [WithdrawPaymentController::class, 'toggle' ])->name('withdraw-payment.toggle');
    Route::delete('withdraw-payment-setup/{id}',          [WithdrawPaymentController::class, 'destroy'])->name('withdraw-payment.destroy');

    // Admin Bank Setup
    Route::resource('banks', \App\Http\Controllers\Admin\AdminBankController::class);
    Route::patch('banks/{bank}/toggle-status', [\App\Http\Controllers\Admin\AdminBankController::class, 'toggleStatus'])->name('banks.toggle-status');

    // Admin loan management
    Route::get('withdraw-screenshots', [\App\Http\Controllers\Admin\AdminLoanController::class, 'withdrawScreenshots'])->name('loans.withdraw-screenshots');
    Route::resource('loans', \App\Http\Controllers\Admin\AdminLoanController::class)->only(['index', 'show']);
    Route::put('loans/{loan}/status', [\App\Http\Controllers\Admin\AdminLoanController::class, 'updateStatus'])->name('loans.updateStatus');

    // Loan Applications (pending loans)
    Route::get('loan-applications', [\App\Http\Controllers\Admin\AdminLoanController::class, 'loanApplications'])->name('loan-applications');

    // Loan Approvals (approved loans)
    Route::get('loan-approvals', [\App\Http\Controllers\Admin\AdminLoanController::class, 'loanApprovals'])->name('loan-approvals');

    // Bank Check Approvals
    Route::get('bank-check-approvals', [\App\Http\Controllers\Admin\AdminLoanController::class, 'bankCheckApprovals'])->name('bank-check-approvals');
    // Loan Contract Stamp page
    Route::get('loan-contract-stamp', [\App\Http\Controllers\Admin\LoanContractStampController::class, 'index'])
        ->name('loan-contract-stamp');
    Route::post('loan-contract-stamp/upload', [\App\Http\Controllers\Admin\LoanContractStampController::class, 'upload'])
        ->name('loan-contract-stamp.upload');
    Route::delete('loan-contract-stamp/delete/{filename}', [App\Http\Controllers\Admin\LoanContractStampController::class, 'delete'])->name('loan-contract-stamp.delete');
    Route::post('loan-contract-stamp/replace/{filename}', [App\Http\Controllers\Admin\LoanContractStampController::class, 'replace'])->name('loan-contract-stamp.replace');
    Route::get('loan-contract-stamp/list', [App\Http\Controllers\Admin\LoanContractStampController::class, 'list'])->name('loan-contract-stamp.list');

    // Loan Approval Certificate Stamp settings
    Route::get('certificate-stamp', [\App\Http\Controllers\Admin\CertificateStampController::class, 'index'])
        ->name('certificate-stamp');
    Route::post('certificate-stamp/upload', [\App\Http\Controllers\Admin\CertificateStampController::class, 'upload'])
        ->name('certificate-stamp.upload');
    Route::delete('certificate-stamp/delete/{sealType}', [\App\Http\Controllers\Admin\CertificateStampController::class, 'delete'])
        ->name('certificate-stamp.delete');
    Route::post('certificate-stamp/upload-info-assets', [\App\Http\Controllers\Admin\CertificateStampController::class, 'uploadInfoAssets'])
        ->name('certificate-stamp.upload-info-assets');
    Route::delete('certificate-stamp/delete-info-asset/{type}', [\App\Http\Controllers\Admin\CertificateStampController::class, 'deleteInfoAsset'])
        ->name('certificate-stamp.delete-info-asset');

    // Admin HRM Module routes
    Route::prefix('hrm')->name('hrm.')->group(function () {
        Route::patch('employees/{employee}/toggle-status', [\App\Http\Controllers\Admin\HrmEmployeeController::class, 'toggleStatus'])->name('employees.toggle-status');
        Route::get('employees/id-card', [\App\Http\Controllers\Admin\HrmEmployeeController::class, 'idCard'])->name('employees.id-card');
        Route::post('employees/id-card/upload', [\App\Http\Controllers\Admin\HrmEmployeeController::class, 'uploadIdCard'])->name('employees.id-card.upload');
        Route::resource('employees', \App\Http\Controllers\Admin\HrmEmployeeController::class);
        Route::resource('attendance', \App\Http\Controllers\Admin\HrmAttendanceController::class);
        Route::resource('leaves', \App\Http\Controllers\Admin\HrmLeaveController::class);
        Route::resource('advance-salaries', \App\Http\Controllers\Admin\HrmSalaryAdvanceController::class);
        
        Route::post('payslips/generate', [\App\Http\Controllers\Admin\HrmPayslipController::class, 'generate'])->name('payslips.generate');
        Route::post('payslips/{id}/pay', [\App\Http\Controllers\Admin\HrmPayslipController::class, 'pay'])->name('payslips.pay');
        Route::get('payslips/{id}/print', [\App\Http\Controllers\Admin\HrmPayslipController::class, 'print'])->name('payslips.print');
        Route::resource('payslips', \App\Http\Controllers\Admin\HrmPayslipController::class);
        
        Route::resource('expenses', \App\Http\Controllers\Admin\HrmExpenseController::class);
    });
});

// ══════════════════════════════════════════════════════════════════════════════
Route::get ('admin/staff/login',        [EmpleeController::class, 'emplee']       )->name('emplee.login');
Route::get ('staff/login',              [EmpleeController::class, 'emplee']       );
Route::post('admin/staff/login/submit', [EmpleeController::class, 'loginSubmit']  )->name('emplee.login.submit');
Route::post('staff/login/submit',       [EmpleeController::class, 'loginSubmit']  );
Route::post('admin/staff/logout',       [EmpleeController::class, 'emplee_logout'])->name('emplee.logout');
Route::post('staff/logout',             [EmpleeController::class, 'emplee_logout']);
