<?php

namespace App\Http\Middleware;

use App\Models\LoginAttempt;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Session;

class SessionAuthWeb
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $sessionNotRequired = ['Index', 'ContactUs', 'OurFees', 'EarnInterest', 'LoyaltyProgram', 'GiveUsFeedback', 'TermOfUSe', 'Affiliates', 'PrivacyPolicy', 'StoreContactUs', 'StoreAffiliate', 'StoreLoyaltyProgram', 'StoreFeedback', 'SignIn', 'SignUp', 'StoreSignIn', 'StoreSignUp', 'VerifyEmail', 'CheckEmailVerification', 'AddPhone', 'VerifyPhone', 'ResendPhoneToken', 'ResendEmailToken', 'Help', 'CookiesSettings', 'EventPreview', 'ContactUserVerification', 'ForgetPassword', 'VerifyEmailForForgetPassword', 'ResetPassword', 'UpdatePassword', 'EventPreviewForGuest', 'PayUser', 'StoreGuestPayment', 'ThankYouAfterPay', '2faVerify', 'giftAmount', 'StoreTransactionGuest', 'FailPayment' ,'HoldingPage','mailSendGrid','GetSignature','getNewCrypto','getCrytoUserLink','subAccount','giftCard','giftCardSelected','Allocate','previewGift','previewGiftEventId', 'RegisterGiftUserView', 'RegisterGiftUser', 'ChooseThemeForGift', 'AddGiftDetailsView','RegisterGiftUser2','TwoFactorAuthView', 'TransactionHistory','WithdrawalHistory' , 'GetAllOrders', 'StoreEmailGiftTransaction', 'TestWebhook', 'UpdateOrders', 'UpdateWithdrawals', 'ContactEventPay','ContactEventPayView', 'StoreTransaction', 'StoreEventInvitation', 'ThankYouViewContact', 'GiftAmountDashboard22'];

        if ($this->is_valid_token($request)) {
            $user = User::where('user_id', $request->login_attempt->id)->first();
			if ($user) {
				if ($user->admin) {
					$request->admin = $user;
					return $next($request);

				} else if ($user->customer) {
					$request->user = $user;
					return $next($request);

				}

			}

        } else if (in_array($request->route()->getName(), $sessionNotRequired)) {
            return $next($request);

        }
        return redirect(route('Index'))->with(['req_error' => 'Invalid Credentials']);
    }

    public function is_valid_token(&$request) {
        $token = getTokenWeb();
        if (!$token) {
            return false;
        }

        $request->login_attempt = LoginAttempt::where("access_token", $token)->get()->first();
        $is_expired = "is_access_expired";

        return $request->login_attempt && !($request->login_attempt->toArray())[$is_expired];
    }
}
