<?php

namespace App\Http\Controllers;

use App\Models\LoginSecurity;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Enable2FA;
use App\Mail\Disable2FA;


class LoginSecurityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('sessionAuthWeb');
    }

    /**
     * Show 2FA Setting form
     */
    public function show2faForm(Request $request) {
        $user = Auth::user();
        $google2fa_url = "";
        $secret_key = "";

        if($user->loginSecurity()->exists()){
            $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());
            $google2fa_url = $google2fa->getQRCodeInline(
                'MyNotePaper Demo',
                $user->email,
                $user->loginSecurity->google2fa_secret
            );
            $secret_key = $user->loginSecurity->google2fa_secret;
        }

        $data = array(
            'user' => $user,
            'secret' => $secret_key,
            'google2fa_url' => $google2fa_url
        );
        return view('auth.2fa_settings')->with('data', $data);
    }

    public function generate2faSecret(Request $request){
        $user = request()->user;
        // Initialise the 2FA class
        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

        // Add the secret key to the registration data
         $login_security_user = LoginSecurity::where('user_id', $user->user_id)->first();
       

        if (isset($login_security_user->google2fa_enable) && $login_security_user->google2fa_enable == true) {
            return redirect()->back()->with(['req_success' => "You can disable two factor authentication", "data" => '1']);

        }else {
            $login_security =  LoginSecurity::firstOrNew(array('user_id' => $user->user_id));
            $login_security->user_id = $user->user_id;
            $login_security->google2fa_secret = $google2fa->generateSecretKey();
            $login_security->save();

            return redirect()->back()->with(['req_success' => "You can scan the code to enable two factor authentication", "data" => '0']);
        }        
    }

    /**
     * Enable 2FA
     */
    public function enable2fa(Request $request){
        $user = request()->user;
      
         $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

        $secret = $request->input('secret');
        
        $valid = $google2fa->verifyKey($user->loginSecurity->google2fa_secret, $secret);
        
        if($valid){
            if ($user->loginSecurity->google2fa_enable == 1 && $request->enable_disable == 1)  {
                $user->loginSecurity->google2fa_enable = 0;
                if($user->loginSecurity->save()) {
                    Mail::to($user->email)->send(new Disable2FA($user));
                    if (count(Mail::failures()) > 0) return redirect()->back()->with(['req_error' => '2FA confirmation email couldn\'t send!']);
                    return redirect()->back()->with('req_success',"2FA is disabled successfully.");
                }else 
                    return redirect()->back()->with('req_error',"2FA is not disabled, please try again"); 
            
            }else{
              
                $user->loginSecurity->google2fa_enable = 1;
                if($user->loginSecurity->save()) {
                    Mail::to($user->email)->send(new Enable2FA($user));
                    if (count(Mail::failures()) > 0) return redirect()->back()->with(['req_error' => '2FA confirmation email couldn\'t send!']);
                    return redirect()->back()->with('req_success',"2FA is enabled successfully.");
                }
               
            }
           
        }else{
            return redirect()->back()->with('req_error',"Invalid 2FA code. Please try again. If the issue persists, please contact us via the online chat or the the Contact Us page.");
        }
    }

    /**
     * Disable 2FA
     */
    public function disable2fa(Request $request, $id) {
        $user = User::where('user_id', $id)->with('loginSecurity')->first();
        $user->loginSecurity->google2fa_enable = 0;
        $user->loginSecurity->save();
        return redirect()->back()->with('req_success',"2FA is now disabled.");
    }
}