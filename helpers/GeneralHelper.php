<?php
use Illuminate\Support\Str;
use Twilio\Rest\Client;

if (!function_exists('api_success')) {
	function api_success($message, $data, $response = 200) {
		$data = response()->json(['status' => true, 'response' => array('message' => $message, 'detail' => $data)], $response);
		return $data;
	}
}
if (!function_exists('api_success1')) {
	function api_success1($message) {
		$data = response()->json(['status' => true, 'response' => array('message' => $message)]);
		return $data;
	}
}

if (!function_exists('api_error')) {
	function api_error($message = 'There is some error!', $error_code = 500) {
		$data = response()->json(['status' => false, 'error' => array('message' => $message)], $error_code);
		return $data;
	}
}

if (!function_exists('api_validation_error')) {
	function api_validation_error($message, $data) {
		$data = response()->json(['status' => false, 'error' => array('message' => $message, 'detail' => $data)]);
		return $data;
	}
}

if (!function_exists('getTokenWeb')) {
    function getTokenWeb() {
        $token  = Session::get('usertoken');
        if($token){
            return $token;
        }
        return false;
    }
}

if (!function_exists('getToken')) {
	function getToken($request) {
		if (preg_match('/Bearer\s(\S+)/', $request->header('Authorization'), $matches)) {
			return $matches[1];
		}
		return false;
	}
}

if (!function_exists('addFile')) {
	function addFile($file, $path, $width = '1000', $height = '1000', $resize = false) {
		$destinationPath = $path;
		$file = $file;
		$name = rand(99, 9999999) . '.' . $file->extension();
		$background = \Image::canvas($width, $height);
		//$img = \Image::make($file)->fit($width, $height);
		   $img = \Image::make($file)->resize($width, $height, function ($c) {
             $c->aspectRatio();
             $c->upsize();
         });
		$background->insert($img, 'center');
		$background->save($destinationPath . '/' . $name);
		return $name;
	}
}

if (!function_exists('generate_token')) {
	function generate_token($customer) {
		$token_params = [
			time(),
			$customer->email,
			"access_token",
		];
		return base64_encode(md5(\implode("_", $token_params)));
	}
}

if (!function_exists('admin_create_notification')) {
	function admin_create_notification ($event = false, $event_id = '', $user = false, $user_id, $beneficiary = false, $beneficiary_id = '', $heading, $text) {
		$notif = new \App\Models\Notifications;
        $notif->notification_id = (String) Str::uuid();
		if ($event) {
			$notif->event_id = $event_id;

		} else if ($user) {
			$notif->user_id = $user_id;

		} else if ($beneficiary) {
			$notif->beneficiary_id = $beneficiary_id;

		}
        $notif->heading = $heading;
        $notif->text = $text;
		if ($notif->save()) {
			$admins = \App\Models\User::whereRaw('`flags` & ? = ?', [\App\Models\User::FLAG_ADMIN, \App\Models\User::FLAG_ADMIN])->get();
			foreach ($admins as $key => $value) {
				$user_notif = new \App\Models\NotificationUser;
				$user_notif->notification_user_id = (String) Str::uuid();
				$user_notif->notification_id = $notif->notification_id;
				$user_notif->user_id = $value->user_id;
				$user_notif->save();
			}
		}
		return true;
	}
}

if (!function_exists('user_and_create_notification')) {
	function user_and_create_notification ($event = false, $event_id = '', $user = false, $user_id = '', $heading, $text) {
		$notif = new \App\Models\Notifications;
        $notif->notification_id = (String) Str::uuid();
		if ($event) {
			$notif->event_id = $event_id;

		} else if ($user) {
			$notif->user_id = $user_id;

		}
        $notif->heading = $heading;
        $notif->text = $text;
		if ($notif->save()) {

			$admins = \App\Models\User::whereRaw('`flags` & ? = ?', [\App\Models\User::FLAG_ADMIN, \App\Models\User::FLAG_ADMIN])->get();
			foreach ($admins as $key => $value) {
				$user_notif = new \App\Models\NotificationUser;
				$user_notif->notification_user_id = (String) Str::uuid();
				$user_notif->notification_id = $notif->notification_id;
				$user_notif->user_id = $value->user_id;
				$user_notif->save();

			}
			if ($user) {
				$user_notif = new \App\Models\NotificationUser;
				$user_notif->notification_user_id = (String) Str::uuid();
				$user_notif->notification_id = $notif->notification_id;
				$user_notif->user_id = $user_id;
				$user_notif->save();

			}
		}
		return true;
	}
}

if (!function_exists('get_user_name')) {
	function get_user_name ($id = NULL) {
		if ($id) {
			$user = \App\Models\User::where('user_id', $id)->first();
			if ($user) {
				if ($user->first_name && $user->last_name) {
					return ucfirst($user->first_name).' '.ucfirst($user->last_name);
	
				} else {
					return $user->username;
	
				}
			} else {
				$benef = \App\Models\Beneficiar::where('beneficiary_id', $id)->first();
				if ($benef) {
					return ucfirst($benef->name).' '.ucfirst($benef->surname);

				} else {
					
					$contact = \App\Models\Contact::where('contact_id', $id)->first();
					if ($contact) {
						return ucfirst($contact->name).' '.ucfirst($contact->surname);

					}

				}

			}
		} else if (request()->user) {
			if (request()->user->first_name && request()->user->last_name) {
				return request()->user->first_name.' '.request()->user->last_name;

			} else {
				return request()->user->username;

			}
		}
		return '';
	}
}


if (!function_exists('sub_accounts')) {
	function sub_accounts ($name, $id) {
        date_default_timezone_set('Africa/Johannesburg');
        $apiKey = 'f2c2d2c60a5e80a6e450809c1f42e19cd57c2912ea7b4f1ad42f7ae1d2b10e01';
        $apiSecret = '71b6fa7a39d765288abefc8bd785e2d4d5ce82aa1c7c2746593ae1894279a802';
        $method = "POST";
        $url = "https://api.valr.com/v1/account/subaccount";
        $timestamp = time() * 1000;
        $body = array (
			"label" => $name ."-". $id

        );
        $sig = generateSignature($apiSecret, $method, $url, $timestamp, $body);
        
        $curl = curl_init('https://api.valr.com/v1/account/subaccount');
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.valr.com/v1/account/subaccount',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>json_encode($body),
            CURLOPT_HTTPHEADER => array(
                'X-VALR-API-KEY: '.$apiKey,
                'X-VALR-SIGNATURE: '.$sig,
                'X-VALR-TIMESTAMP: '.$timestamp),
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);
		$benef = \App\Models\Beneficiar::where('beneficiary_id', $id)->first();
		$benef->valr_account_name =  $name ."-". $id;
		$benef->save();
        return json_decode($response);
	}
}

if (!function_exists('generateSignature')) {
    function generateSignature($apiSecret, $method, $url, $timestamp, $body = []) {
        $parsedUrl = parse_url($url);
        $uri = $parsedUrl['path'] ?? '';
        if (isset($parsedUrl['query'])) {
            $uri .= '?' . $parsedUrl['query'];
        }
        $data = $timestamp . $method . $uri;
        if (!empty($body)) {
            $data .= json_encode($body);
        }
        $hmac = hash_hmac('sha512', $data, $apiSecret);
        return $hmac;
	}
}


if (!function_exists('csvToArray')) {
	function csvToArray($filename = '', $delimiter = ',') {
		if (!file_exists($filename) || !is_readable($filename)) return [];

		$header = null;
		$data = array();
		$counter = 0;
		if (($handle = fopen($filename, 'r')) !== false)
		{
			while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
			{
				$counter++;

				if (!$header)
				{
					if ($counter == 2) {
						return $header = $row;

					}
					$header = $row;

				} else {
					$data[] = array_combine($header, $row);

				}
			}
			fclose($handle);
		}
		return $data;
	}
}

if (!function_exists('create_call_pay_user')) {
	function create_call_pay_user($user) {
		$user_data = "User[username]=$user->username&User[role]=agent&User[name]=".$user->first_name."&lastname=".$user->last_name;
		$service_url = 'https://services.callpay.com/api/v1/user';
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, "CryptoGiftingSandboxAdmin:eRxg6Q8zXGg2AayY");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $user_data);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$curl_response = curl_exec($curl);
		$response = json_decode($curl_response);
		curl_close($curl);
		return $response;
	}
}