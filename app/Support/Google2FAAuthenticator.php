<?php

namespace App\Support;
use PragmaRX\Google2FALaravel\Support\Authenticator;


class Google2FAAuthenticator extends Authenticator
{
    protected function canPassWithoutCheckingOTP()
    {
      
        if(request()->user->loginSecurity != null)
            return true;
        return
            !request()->user->loginSecurity->google2fa_enable ||
            !$this->isEnabled() ||
            $this->noUserIsAuthenticated() ||
            $this->twoFactorAuthStillValid();
    }

    protected function getGoogle2FASecretKey()
    {
        $secret = request()->user->loginSecurity->{$this->config('otp_secret_column')};
print_r($secret);
die;
        if (is_null($secret) || empty($secret)) {
            throw new InvalidSecretKey('Secret key cannot be empty.');
        }

        return $secret;
    }

}