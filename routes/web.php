<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BeneficiarController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactGuestListController;
use App\Http\Controllers\EventAcceptanceController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventGuestGroupController;
use App\Http\Controllers\EventThemeController;
use App\Http\Controllers\GuestListController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\UserWalletController;
use App\Http\Controllers\ViewsController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\LoginSecurityController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SendGridController;
use App\Http\Controllers\GifterEventController;
use App\Http\Controllers\SmileKYCRecordsController;


Route::middleware('sessionAuthWeb')->prefix('/')->group(function () {
    // All Views
        Route::get('/', [ViewsController::class, 'home'])->name('Index');
        Route::get('contact-us', [ViewsController::class, 'contact_us'])->name('ContactUs');
        Route::get('our-fees', [ViewsController::class, 'our_fees'])->name('OurFees');
        Route::get('earn-interest', [ViewsController::class, 'earn_interest'])->name('EarnInterest');
        Route::get('loyalty-program', [ViewsController::class, 'loyalty_program'])->name('LoyaltyProgram');
        Route::get('give-us-feedback', [ViewsController::class, 'give_us_feedback'])->name('GiveUsFeedback');
        Route::get('terms-of-use', [ViewsController::class, 'terms_of_use'])->name('TermOfUSe');
        Route::get('affiliates', [ViewsController::class, 'affiliates'])->name('Affiliates');
        Route::get('privacy-policy', [ViewsController::class, 'privacy_policy'])->name('PrivacyPolicy');
        Route::get('sign-in', [ViewsController::class, 'sign_in'])->name('SignIn');
        Route::get('sign-in/two-factor/{id}', [ViewsController::class, 'sign_in_two_factor'])->name('TwoFactorAuthView');
        Route::get('contact-user-verification/{id}', [AccountController::class, 'contact_user_verification'])->name('ContactUserVerification');
        Route::get('sign-up', [ViewsController::class, 'sign_up'])->name('SignUp');
        Route::get('help', [ViewsController::class, 'help'])->name('Help');
        Route::get('cookies-settings', [ViewsController::class, 'cookies_settings'])->name('CookiesSettings');
        Route::get('forget-password', [ViewsController::class, 'forget_password'])->name('ForgetPassword');
    // All Views

    // Gifter Events Controller
        Route::post('gift-card', [GifterEventController::class, 'gift_card'])->name('giftCard');
        Route::post('gift-theme-selected', [GifterEventController::class, 'gift_card_selected'])->name('giftCardSelected');
        Route::post('gift-flow/preview', [GifterEventController::class, 'preview_gift'])->name('previewGift');
        Route::post('get-crypto/user-link', [GifterEventController::class, 'get_crypto_email'])->name('getCryptoEmail');
        Route::get('get-crypto', [GifterEventController::class, 'get_crypto'])->name('getNewCrypto');
        Route::get('allocate/{email}', [GifterEventController::class, 'amount_allocation'])->name('Allocate');
        Route::get('email-gift/{event_id}', [GifterEventController::class, 'gift_preview_event_id'])->name('previewGiftEventId');
        Route::get('send', [GifterEventController::class, 'gifter_email'])->name('gifterEmail');
        Route::get('choose-theme-for-gift', [GifterEventController::class, 'choose_theme_for_gift'])->name('ChooseThemeForGift');
        Route::get('add-gift-details', [GifterEventController::class, 'add_gift_details_view'])->name('AddGiftDetailsView');
    // Gifter Events Controller

    //Contact US
        Route::post('contact-us', [ContactUsController::class, 'store'])->name('StoreContactUs');
        Route::post('affiliate', [ContactUsController::class, 'store'])->name('StoreAffiliate');
        Route::post('feedback', [ContactUsController::class, 'store'])->name('StoreFeedback');
        Route::post('loyalty-program', [ContactUsController::class, 'store'])->name('StoreLoyaltyProgram');
    //Contact US

    //Account Controller
        Route::post('login', [AccountController::class, 'login'])->name('StoreSignIn');
        Route::post('verify-email-for-forget-password', [AccountController::class, 'verify_email_for_forget_password'])->name('VerifyEmailForForgetPassword');
        Route::post('register', [AccountController::class, 'store'])->name('StoreSignUp');
        Route::post('update-password/{token}', [AccountController::class, 'update_password'])->name('UpdatePassword');
        Route::get('reset-password/{token}', [AccountController::class, 'reset_password'])->name('ResetPassword');
        Route::get('verify-email/{token}', [AccountController::class, 'verify_email'])->name('VerifyEmail');
        Route::get('pay-user/{id}', [AccountController::class, 'pay_user'])->name('PayUser');
        Route::get('thank-you-for-gift', [AccountController::class, 'thank_you_for_gift'])->name('ThankYouAfterPay');
        Route::get('fail-payment', [AccountController::class, 'fail_payment'])->name('FailPayment');
        Route::post('pay-amount', [AccountController::class, 'gift_amount'])->name('giftAmount');        
        Route::post('resend-email-token', [AccountController::class, 'resend_email_token'])->name('ResendEmailToken');
        Route::get('logout', [AccountController::class, 'logout'])->name('Logout');
        Route::post('2faVerify', [AccountController::class, 'two_factor_authentication'])->name('2faVerify');
        Route::get('register-account/{id}', [AccountController::class, 'register_account_gifter_view'])->name('RegisterGiftUserView');
        Route::get('register-gifter-account/{id}', [AccountController::class, 'register_account_gifter'])->name('RegisterGiftUser');
        Route::post('register-gifter-account-add/{id}', [AccountController::class, 'register_account_gifter_add'])->name('RegisterGiftUser2');
        Route::post('pay-amount-for-event', [AccountController::class, 'gift_amount_dashboard'])->name('GiftAmountDashboard22');
    //Account Controller

    //Event Controller
        Route::get('event-preview/{event_id}', [EventController::class, 'event_preview_for_guest'])->name('EventPreviewForGuest');
        Route::post('event-pay-user/{event_id}', [EventController::class, 'contact_event_pay'])->name('ContactEventPay');
        Route::get('event-pay-user/{event_id}/{contact_id}', [EventController::class, 'contact_event_pay_view'])->name('ContactEventPayView');
        Route::get('thank-you/{id}', [EventAcceptanceController::class, 'view_thank_you_contact'])->name('ThankYouViewContact');
    //Event Controller

    // Transaction Controller
        Route::get('store-transaction/{user_id}/{amount}', [TransactionController::class, 'store_transaction_guest'])->name('StoreTransactionGuest');
        Route::get('store-email-gift-transaction/{gift_id}', [TransactionController::class, 'store_email_gift_transaction_guest'])->name('StoreEmailGiftTransaction');
        Route::get('transaction-history', [TransactionController::class, 'transaction_history'])->name('TransactionHistory');
        Route::get('withdrawal-history', [WithdrawalController::class, 'withdrawal_cron'])->name('WithdrawalHistory');
        Route::get('update-orders', [TransactionController::class, 'update_orders'])->name('UpdateOrders');
        Route::get('test2', [TransactionController::class, 'test'])->name('GetAllOrders');
    // Transaction Controller

    Route::get('holding-page', [SendGridController::class, 'index'])->name('HoldingPage');
    Route::get('update-withdrawals', [WithdrawalController::class, 'update_withdrawals'])->name('UpdateWithdrawals');
    Route::post('send-grid', [SendGridController::class, 'sendGird'])->name('mailSendGrid');
    //end holding 
});

Route::middleware('sessionAuthWeb')->prefix('/user/')->group(function () {
    // View Controller 
        Route::get('me', [ViewsController::class, 'me'])->name('Me');
        Route::post('read-notification-user', [NotificationController::class, 'read_notif_user'])->name('ReadNotificationUser');
        Route::get('dashboard', [ViewsController::class, 'dashboard'])->name('UserDashboard');
        Route::get('wallet', [ViewsController::class, 'wallet'])->name('UserWallet');
        Route::get('notifications-settings', [ViewsController::class, 'notifications'])->name('Notifications');
        Route::get('profile', [ViewsController::class, 'profile'])->name('Profile');
        Route::get('security', [ViewsController::class, 'security'])->name('Security');
        Route::get('register-first', [ViewsController::class, 'register_first'])->name('RegisterFirstSmileKYC');
        Route::get('create-bank-account', [ViewsController::class, 'create_bank_account'])->name('CreateBankAccount');
        Route::get('settings', [ViewsController::class, 'settings'])->name('Settings');
        Route::get('bank-detail', [ViewsController::class, 'bank_information'])->name('BankInformation');
        Route::get('search', [ViewsController::class, 'search_user'])->name('UserSearch');
    // View Controller 

    // User Controller 
        Route::post('update-notifications', [UserController::class, 'update_notifications_status'])->name('UpdateNotificationStatus');
        Route::post('update-profile', [UserController::class, 'update'])->name('UpdateProfile');
        Route::post('selfie-updated', [UserController::class, 'smileKyc'])->name('smileKyc');
        Route::post('upload-auth', [UserController::class, 'selfie_authentication'])->name('selfieAuth');
        Route::post('upload-selfie', [UserController::class, 'upload_selfie'])->name('UploadSelfieUser');
        Route::post('upload-other-info', [UserController::class, 'upload_other_info'])->name('UploadOtherInfo');
        Route::get('user-link/{id}', [UserController::class, 'user_link_view'])->name('UserLink');
        Route::post('would-you-link-to', [UserController::class, 'create_link_or_theme'])->name('CreateEventSelect');
        Route::post('/callpay-auth', [UserController::class, 'call_pay_authentication'])->name('CallPayAuth');
        Route::post('/generateSecret',[LoginSecurityController::class,'generate2faSecret'])->name('generate2faSecret');
        Route::post('/enable2fa', [LoginSecurityController::class, 'enable2fa'])->name('enable2fa');
        Route::get('disable2fa/{id}', [LoginSecurityController::class, 'disable2fa'])->name('disable2fa');
        Route::post('authenticate-selfie-upload', [UserController::class, 'authenticate_selfie_upload'])->name('AuthenticateSelfieUpload');
        Route::post('authenticate-user', [UserController::class, 'authenticate_user'])->name('AuthenticationSmielKYC');
        Route::post('password/verify', [UserController::class, 'current_password_check'])->name('currentPasswordCheck');
        Route::post('settings/bank-detail/store', [UserController::class, 'store_bank_detail'])->name('StoreBankDetail');
        Route::post('store-new-bank', [UserController::class, 'store_bank_detail_ajax'])->name('StoreBankDetailAjax');
        Route::post('send-wd-vc-code', [UserController::class, 'send_wd_vc_code'])->name('SendWithdrawalVerificationCode');

    // User Controller

    // Beneficiary Controller
        Route::get('beneficiaries', [BeneficiarController::class, 'index'])->name('Beneficiaries');
        Route::get('add-beneficiary', [BeneficiarController::class, 'create'])->name('AddBeneficiary');
        Route::post('beneficiary', [BeneficiarController::class, 'store'])->name('StoreBeneficiary');
        Route::get('edit-beneficiary/{id}', [BeneficiarController::class, 'edit'])->name('EditBeneficiary');
        Route::post('update-beneficiary/{id}', [BeneficiarController::class, 'update'])->name('UpdateBeneficiary');
        Route::get('choose-beneficiaries', [BeneficiarController::class, 'choose_beneficiaries'])->name('SelectBeneficiariesForEvent');
    // Beneficiary Controller

    // Contact Controller
        Route::get('contacts', [ContactController::class, 'index'])->name('Contacts');
        Route::get('add-contact', [ContactController::class, 'create'])->name('AddContact');
        Route::post('contact', [ContactController::class, 'store'])->name('StoreContact');
        Route::get('edit-contact/{id}', [ContactController::class, 'edit'])->name('EditContact');
        Route::post('add-contacts-using-csv-only-contacts', [ContactController::class, 'store_csv_only_contacts'])->name('AddContactsUsingCsvOnlyContacts');
        Route::post('update-contact/{id}', [ContactController::class, 'update'])->name('UpdateContact');
    // Contact Controller
    
    //Account Controller
        Route::post('get-address', [AccountController::class, 'get_address'])->name('GetAddress');
    //Account Controller

    // Guest List Controller
        Route::get('guest-list', [GuestListController::class, 'index'])->name('GuestLists');
        Route::get('add-guest-list', [GuestListController::class, 'create'])->name('AddGuestList');
        Route::post('guest-list', [GuestListController::class, 'store'])->name('StoreGuestList');
        Route::get('edit-guest-list/{id}', [GuestListController::class, 'edit'])->name('EditGuestList');
        Route::get('add-contacts-in-guest-list/{id}', [GuestListController::class, 'add_contacts_in_guest_list_view'])->name('AddContactsInGuestListView');
        Route::post('update-guest-list/{id}', [GuestListController::class, 'update'])->name('UpdateGuestList');
        Route::get('delete-guest-list/{id}', [GuestListController::class, 'destroy'])->name('DeleteGuestList');
    // Guest List Controller

    // Contact Guest List Controller
        Route::post('add-contacts-using-csv', [ContactGuestListController::class, 'store_csv'])->name('AddContactsUsingCsv');
        Route::post('add-contacts-in-guest-list/{id}', [ContactGuestListController::class, 'store_in_guest_list'])->name('AddContactsInGuestList');
        Route::post('delete-contacts-in-guest-list/{id}', [ContactGuestListController::class, 'delete_from_guest_list'])->name('DeleteContactsInGuestList');
    // Contact Guest List Controller

    // Event Controller
        Route::get('events', [EventController::class, 'index'])->name('Events');
        Route::get('event-gifts', [EventController::class, 'index_transaction'])->name('EventsTransactions');
        Route::get('view-event/{id}', [EventController::class, 'event_details'])->name('EventsDetails');
        Route::get('invited-events', [EventController::class, 'invited_events'])->name('InvitedEvents');
        Route::get('edit-event/{id}', [EventController::class, 'edit'])->name('EditEvent');
        Route::get('create-event/{id}', [EventController::class, 'create'])->name('CreateEvent');
        Route::get('add-event-details/{id}', [EventController::class, 'add_details'])->name('AddDetailsForEvent');
        Route::get('allocate-event-amount/{id}', [EventController::class, 'allocate_amount_view'])->name('AllocateAmountView');
        Route::get('share-event/{id}', [EventController::class, 'share_event_view'])->name('ShareEventView');
        Route::get('self-event-preview/{id}', [EventController::class, 'self_event_preview'])->name('EventPreviewSelf');
        Route::get('event-preview/{id}', [EventController::class, 'event_preview'])->name('EventPreview');
        Route::post('save-event', [EventController::class, 'save_event'])->name('SaveEvent');
        Route::get('event-link/{id}', [EventController::class, 'event_link_view'])->name('EventLink');
        Route::get('event-cancel/{id}', [EventController::class, 'cancel_event'])->name('CancelEvent');
        Route::get('event-publish/{id}', [EventController::class, 'publish_event'])->name('PublishEvent');
        Route::get('give-gift/{id}', [EventController::class, 'give_gift_view'])->name('GiveGiftView');
        Route::post('give-gift/{id}', [EventController::class, 'give_gift'])->name('GiveGift');
        Route::post('share-event/{id}', [EventController::class, 'store_guest_lists_for_event'])->name('StoreGuestListForEvent');
        Route::post('share-event-new/{id}', [EventController::class, 'store_guest_lists_for_event_new'])->name('StoreGuestListForEventNew');
        Route::post('allocate-event-amount/{id}', [EventController::class, 'allocate_event_amount'])->name('AllocateEventAmount');
        Route::post('add-beneficiaries-new', [EventController::class, 'add_beneficiaries'])->name('AddBeneficiariesForEventNew');
        Route::post('edit-event/{id}', [EventController::class, 'update'])->name('UpdateEvent');
        Route::post('add-event-details', [EventController::class, 'store_details'])->name('StoreDetailsForEvent');
        Route::post('theme-selection', [EventController::class, 'select_theme'])->name('SelectThemeForEvent');
        Route::get('move-events-to-past', [EventController::class, 'move_events_to_past'])->name('MoveEventsToPast');
    // Event Controller

    // Event Theme Controller
        Route::get('theme-selection/{id}', [EventThemeController::class, 'user_index'])->name('ThemeSelection');
    // Event Theme Controller

    // Event Acceptance Theme Controller
        Route::post('event-invitation/{id}', [EventAcceptanceController::class, 'store'])->name('StoreEventInvitation');
        Route::get('thank-you/{id}', [EventAcceptanceController::class, 'view_thank_you'])->name('ThankYouView');
        Route::get('fail-payment', [EventAcceptanceController::class, 'view_fail_payment'])->name('FailPaymentDashboard');
        Route::get('gift-details/{id}', [EventAcceptanceController::class, 'gift_details'])->name('GiftDetails');
        Route::post('check-beneficiaries-payment-reference', [EventAcceptanceController::class, 'check_transactions_benef'])->name('CheckTransactionsBenef');
        Route::get('funds-withdrawn', [WithdrawalController::class, 'user_funds_withdrawn'])->name('LinkGifts');
        Route::get('funds-withdrawn-dedtail/{id}', [WithdrawalController::class, 'user_funds_withdrawn_detail'])->name('withdrawInfoUser');

    // Event Acceptance Theme Controller
    
    // Notifications Controller
        Route::get('notifications', [NotificationController::class, 'index'])->name('GetNotifications');
        Route::get('mark-all-seen', [NotificationController::class, 'mark_all_seen'])->name('MarkAllSeen');
    // Notifications Controller
    
    // Transaction Controller
        Route::get('history', [TransactionController::class, 'index'])->name('ShowHistory');
        Route::get('etherium-wallet', [TransactionController::class, 'etherium_wallet'])->name('EtheriumWallet');
        Route::get('bitcoin-wallet', [TransactionController::class, 'bitcoin_wallet'])->name('BitcoinWallet');
        Route::get('zar-wallet', [TransactionController::class, 'zar_wallet'])->name('ZarWallet');
        Route::get('withdraw-with-bank-account/{id}', [TransactionController::class, 'withdraw_bank_account_view'])->name('WithdrawBankAccountView');
        Route::get('bitcoin-with-bank-account', [TransactionController::class, 'bitcoin_withdraw_bank_account_view'])->name('BitcoinWithdrawWithAddBank');
        Route::get('etherium-with-bank-account', [TransactionController::class, 'etherium_withdraw_bank_account_view'])->name('EtheriumWithdrawWithAddBank');
        Route::get('etherium-wallet-yield', [TransactionController::class, 'etherium_wallet_yield_view'])->name('EtheriumWalletYield');
        Route::get('saving-wallet-terms-for-etherium', [TransactionController::class, 'saving_wallet_terms_view_etherium'])->name('SavingWalletTermsEtherium');
        Route::get('create-etherium-wallet', [TransactionController::class, 'create_etherium_wallet_view'])->name('CreateEtheriumWallet');
        Route::get('ready-etherium-wallet', [TransactionController::class, 'ready_etherium_wallet_view'])->name('ReadyEtheriumWallet');
        Route::get('etherium-transfer-in', [TransactionController::class, 'etherium_transfer_in_view'])->name('EtheriumTransferInView');
        Route::get('etherium-transfer-out', [TransactionController::class, 'etherium_transfer_out_view'])->name('EtheriumTransferOutView');
        Route::get('bitcoin-wallet-yield', [TransactionController::class, 'bitcoin_wallet_yield_view'])->name('BitcoinWalletYield');
        Route::get('saving-wallet-terms-for-bitcoin', [TransactionController::class, 'saving_wallet_terms_view_bitcoin'])->name('SavingWalletTermsBitcoin');
        Route::get('create-bitcoin-wallet', [TransactionController::class, 'create_bitcoin_wallet_view'])->name('CreateBitcoinWallet');
        Route::get('ready-bitcoin-wallet', [TransactionController::class, 'ready_bitcoin_wallet_view'])->name('ReadyBitcoinWallet');
        Route::get('bitcoin-transfer-in', [TransactionController::class, 'bitcoin_transfer_in_view'])->name('BitcoinTransferInView');
        Route::get('bitcoin-transfer-out', [TransactionController::class, 'bitcoin_transfer_out_view'])->name('BitcoinTransferOutView');
        Route::get('store-transaction-dashboard/{event_id}/{amount}/{contact_id}', [TransactionController::class, 'store_transaction'])->name('StoreTransaction');
    // Transaction Controller

    // Withdrawal Controller
        Route::post('withdrawal-request', [WithdrawalController::class, 'store'])->name('WithdrawalRequest');
        Route::get('withdrawal-test', [WithdrawalController::class, 'test_webhook'])->name('TestWebhook');
        Route::post('get-beneficiary-wallet-amount', [WithdrawalController::class, 'get_beneficiary_wallet_amount'])->name('GetBeneficiaryWalletAmount');
      
    // End Withdrawal Controller
});
Route::middleware('sessionAuthWeb')->prefix('/admin/')->group(function () {
    // View Controller 
        Route::get('dashboard', [ViewsController::class, 'admin_dashboard'])->name('AdminDashboard');
        Route::get('search', [ViewsController::class, 'search_admin'])->name('AdminSearch');
        Route::get('mark-all-seen-admin', [NotificationController::class, 'mark_all_seen_admin'])->name('MarkAllSeenAdmin');
        // View Controller
    
    // Event Theme Controller
        Route::get('themes', [EventThemeController::class, 'index'])->name('Themes');
        Route::get('add-theme', [EventThemeController::class, 'create'])->name('AddTheme');
        Route::post('add-theme', [EventThemeController::class, 'store'])->name('StoreTheme');
        Route::get('edit-theme/{id}', [EventThemeController::class, 'edit'])->name('EditTheme');
        Route::post('update-theme/{id}', [EventThemeController::class, 'update'])->name('UpdateTheme');
    // Event Theme Controller

    // Event Acceptance 
        Route::get('gift-details/{id}', [EventAcceptanceController::class, 'gift_details_admin'])->name('GiftDetailsAdmin');
        Route::get('public-link-gifts', [EventAcceptanceController::class, 'public_link_gifts_admin'])->name('PublicLinkGiftsAdmin');
    // Event Acceptance Controller

    // User Controller
        Route::get('users', [UserController::class, 'index_admin'])->name('AllUsersAdmin');
        Route::get('user/{id}', [UserController::class, 'show'])->name('UserInfoAdmin');
        Route::post('notification-settings', [UserController::class, 'update_notifications_status'])->name('AdminNotificationsSettingsUpdate');
    // User Controller

    // Event Controller
        Route::get('events', [EventController::class, 'index_admin'])->name('AllEventsAdmin');
        Route::get('event/{id}', [EventController::class, 'show_admin'])->name('EventInfoAdmin');
        Route::get('transactions', [EventController::class, 'index_transaction_admin'])->name('EventsTransactionsAdmin');
        Route::get('view-event/{id}', [EventController::class, 'event_details_admin'])->name('EventsDetailsAdmin');
    // Event Controller

    // Notification Controller
        Route::get('notifications', [NotificationController::class, 'index_admin'])->name('AdminNotifications');
        Route::post('read-notification', [NotificationController::class, 'read_notif_admin'])->name('ReadNotificationAdmin');
        Route::get('notification-settings', [NotificationController::class, 'settings_view_admin'])->name('AdminNotificationsSettings');
    // Notification Controller

    // Setting Controller
        Route::get('settings', [SettingController::class, 'index'])->name('adminSettings');
        Route::post('settings/add', [SettingController::class, 'store'])->name('settingStore');
        Route::get('valr-setting', [SettingController::class, 'valr_setting'])->name('ValrSetting');
        Route::post('valr-setting/update', [SettingController::class, 'valr_store'])->name('valrSettingStore');
        
    // End Setting Controller

    // Contact Us Controller
        Route::get('contact-us', [ContactUsController::class, 'index'])->name('ContactUsAdmin');
        Route::get('affiliates', [ContactUsController::class, 'index_affiliate'])->name('AffiliatesAdmin');
        Route::get('loyalty-programs', [ContactUsController::class, 'index_loyalty'])->name('LoyaltyAdmin');
        Route::get('feedbacks', [ContactUsController::class, 'index_feedback'])->name('FeedbacksAdmin');
        Route::get('contact-us/{id}', [ContactUsController::class, 'show'])->name('ContactUsInfoAdmin');
        Route::post('contact-us/{id}', [ContactUsController::class, 'update'])->name('ContactUsInfoUpdateAdmin');
        Route::get('affiliates/{id}', [ContactUsController::class, 'show'])->name('AffiliateInfoAdmin');
        Route::get('loyalty-program/{id}', [ContactUsController::class, 'show'])->name('LoyaltyProgramInfoAdmin');
        Route::get('feedback/{id}', [ContactUsController::class, 'show'])->name('FeedbackInfoAdmin');
    // Contact Us Controller

    // Transaction Controller
        Route::get('history', [TransactionController::class, 'index_admin'])->name('ShowHistoryAdmin');
    // Transaction Controller

    // WithDrawal Controller
        Route::get('withdrawal-history', [WithdrawalController::class, 'index'])->name('WithdrawalRequestAdmin');
        Route::get('withdrawal-history/{id}', [WithdrawalController::class, 'withdraw_info_admin'])->name('withdrawInfoAdmin');
    // WithDrawal Controller

    // Beneficiary Controller
        Route::get('beneficiaries', [BeneficiarController::class, 'index_admin'])->name('AllBeneficiarysAdmin');
        Route::get('beneficiary/{id}', [BeneficiarController::class, 'show_admin'])->name('BeneficiaryInfoAdmin');
        Route::post('beneficiary/{id}', [BeneficiarController::class, 'update_admin'])->name('UpdateBeneficiaryInfoAdmin');
    // Beneficiary Controller

    // SmileKYC Records Controller
        Route::get('smilekyc-attempts', [SmileKYCRecordsController::class, 'index'])->name('AllSmileKYCRecordsAdmin');
    // SmileKYC Records Controller

    // Get Gift Event Controller
        Route::get('get-gift-crypto', [GifterEventController::class, 'index'])->name('AllGetGfitCryptoAdmin');
        Route::get('get-gift-crypto/{id}', [GifterEventController::class, 'show'])->name('ShowGetGfitCryptoAdmin');
    // Get Gift Event Controller

    
});