<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

use App\SmileIdentity\lib\SmileIdentityCore;
use App\SmileIdentity\lib\IdApi;

use App\Mail\WithdrawalVerificationCode;
use App\Mail\KYCSuccessfulEmail;
use App\Mail\KYCFailEmail;
use App\Mail\ForgotPasswordConfirmEmail;
use App\Mail\ProfileChanges;
use App\Mail\BankDetailEmail;


use App\Models\User;
use App\Models\BankDetail;
use App\Models\SIRecord;
use App\Models\Notifications;
use App\Models\NotificationUser;

class UserController extends Controller
{
    public function authenticate_selfie_upload (Request $request)
    {
        $si_record = new SIRecord();
        $si_record->si_id =  (String) Str::uuid();
        $si_record->user_id = request()->user->user_id;
        $si_record->selfie = $request->images;
        if ($si_record->save()) {
            return api_success('Selfie Uploaded!', ['sid' => $si_record->si_id]);

        }
        return api_error();
    }

    public function authenticate_user (Request $request)
    {
        $allowed_file_types = array (
            "png",
            "jpg",
            "jpeg",
            "PNG",
            "JPG",
            "JPEG",
        );
        $request->validate([
            'address_document'  => ['required', 'file',
                function($attribute, $address_document, $fail) {
                    $allowed_file_types = array (
                        "png",
                        "jpg",
                        "jpeg",
                        "PNG",
                        "JPG",
                        "JPEG",
                    );
                    if (!in_array($address_document->getClientOriginalExtension(), $allowed_file_types) ) {
                        $all_types = implode(",", $allowed_file_types);
                        $fail("Address Document must be a file of type: ".$all_types."!");
                    }
                }
            ],
            'bank_account'  => ['required', 'file',
                function($attribute, $bank_account, $fail) {
                    $allowed_file_types = array (
                        "png",
                        "jpg",
                        "jpeg",
                        "PNG",
                        "JPG",
                        "JPEG",
                    );
                    if (!in_array($bank_account->getClientOriginalExtension(), $allowed_file_types) ) {
                        $all_types = implode(",", $allowed_file_types);
                        $fail("Proof of Bank Account must be a file of type: ".$all_types."!");
                    }
                }
            ],
        ]);
        $user_id = request()->user->user_id;
        if (!$request->has('sid') || !$request->filled('sid')) {
            return redirect()->back()->with(['req_error' => 'There is some error! Kindly try again']);

        }

        $current_user = User::where('user_id', $user_id)->first();
        if ($request->has('first_name') && $request->filled('first_name') && $request->has('last_name') && $request->filled('last_name')) {
            $current_user->first_name = $request->first_name;
            $current_user->last_name = $request->last_name;

        }

        if ($request->has('first_name') && $request->filled('first_name') && $request->has('last_name') && $request->filled('last_name')) {
            $current_user->first_name = $request->first_name;
            $current_user->last_name = $request->last_name;

        }

        if ($request->has('domestic') && $request->filled('domestic') && $request->has('foreign') && $request->filled('foreign') && $request->has('over_eighteen_check') && $request->filled('over_eighteen_check')) {
            $current_user->removeFlag(User::FLAG_DOMISTIC_POLITICALLY);
            $current_user->removeFlag(User::FLAG_FOREIGN_POLITICALLY);
            $current_user->removeFlag(User::FLAG_OVER_EIGHTEEN);
            $current_user->removeFlag(User::FLAG_ANSWERED_QUESTION);
            $current_user->addFlag(User::FLAG_ANSWERED_QUESTION);
            if ($request->domestic == 'yes') {
                $current_user->addFlag(User::FLAG_DOMISTIC_POLITICALLY);

            }

            if ($request->foreign == 'yes') {
                $current_user->addFlag(User::FLAG_FOREIGN_POLITICALLY);

            }

            if ($request->over_eighteen_check == 'yes') {
                $current_user->addFlag(User::FLAG_OVER_EIGHTEEN);

            }
        }
        $current_user->save();

        $si_record = SIRecord::where('si_id', $request->sid)->first();

        $name = rand(99, 9999999);
        $filenameWithExt = $request->bank_account->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->bank_account->getClientOriginalExtension();
        $fileNameToStore = $name . '.' . $extension;
        $path = $request->bank_account->storeAs("public/smilekyc-attempts/".$si_record->si_id.'/', $fileNameToStore);
        $bank_account = $fileNameToStore;

        $name = rand(99, 9999999);
        $filenameWithExt = $request->address_document->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->address_document->getClientOriginalExtension();
        $fileNameToStore = $name . '.' . $extension;
        $path = $request->address_document->storeAs("public/smilekyc-attempts/".$si_record->si_id.'/', $fileNameToStore);
        $address_document = $fileNameToStore;

        $si_record->address_document = $address_document;
        $si_record->bank_account_document = $bank_account;

        if ($si_record->save()) {
            $artisan_call_to_make_files_public = Artisan::call("storage:link", []);
            $auth_kyc = $this->authenticate_user_smile_kyc(request()->user, $si_record);

            if ($auth_kyc == 1) {
                $notif = new Notifications;
                $notif->notification_id = (String) Str::uuid();
                $notif->user_id = $user_id;
                $notif->heading = 'Authentication Successfull on SmileKYC!';
                $notif->text = 'You have successfully authenticate your profile on SmileKYC! Now you can create request for your withdrawal.';
                if ($notif->save()) {
                    $user_notif = new NotificationUser;
                    $user_notif->notification_user_id = (String) Str::uuid();
                    $user_notif->notification_id = $notif->notification_id;
                    $user_notif->user_id = $user_id;
                    if ($user_notif->save()) {
                        return redirect(route('WithdrawBankAccountView', [$si_record->si_id]))->with(['req_success' => "You have successfully authenticate with smilekyc! Kindly proceed further!"]);

                    }
                }
                return redirect()->back()->with(['req_error' => 'There is some error!']);

            } else if ($auth_kyc == 2) {
                $notif = new Notifications;
                $notif->notification_id = (String) Str::uuid();
                $notif->user_id = $user_id;
                $notif->heading = 'Authentication is in provisional stage!';
                $notif->text = 'Your authentication request is in provisional status right now and we will let you know asap about the end result regarding your request!';
                if ($notif->save()) {
                    $user_notif = new NotificationUser;
                    $user_notif->notification_user_id = (String) Str::uuid();
                    $user_notif->notification_id = $notif->notification_id;
                    $user_notif->user_id = $user_id;
                    if ($user_notif->save()) {
                        return redirect()->back()->with(['req_success' => 'Registration is in provisional status!']);

                    }
                }
                return redirect()->back()->with(['req_error' => 'There is some error!']);

            } else {
                $notif = new Notifications;
                $notif->notification_id = (String) Str::uuid();
                $notif->user_id = $user_id;
                $notif->heading = 'Authentication failed!';
                $notif->text = 'Your request has been rejected! Kindly perform once again the process.';
                if ($notif->save()) {
                    $user_notif = new NotificationUser;
                    $user_notif->notification_user_id = (String) Str::uuid();
                    $user_notif->notification_id = $notif->notification_id;
                    $user_notif->user_id = $user_id;
                    if ($user_notif->save()) {
                        return redirect()->back()->with(['req_error' => 'Request rejected! Kindly try again.']);

                    }
                }
                return redirect()->back()->with(['req_error' => 'There is some error!']);
            }

        }
        return redirect()->back()->with(['req_error' => "There is some error!"]);
    }

    public function authenticate_user_smile_kyc ($user, $smilekyc_obj)
    {
        try {
            $partner_id = '1613';
            $default_callback = route('SmileKycResponse');
            $api_key = 'LS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS0KTUlHZk1BMEdDU3FHU0liM0RRRUJBUVVBQTRHTkFEQ0JpUUtCZ1FDOGF6eDRoVFIzUndXN29zMUk1V2JUeUhjMgpqTXcwTExzTlhIdllaYzJkcklSYW5ObnpUR0xGUk5qTktmeVRDZmVJcC9HVG50N2VEbDlNTjBWQzBHTTBhS0dHCkROUmtFOVFoT3FndDVXc2Y0M3RQUTJ3UE85M2c2VHlWYWkySm12UjRFcy9PL245eGhpRWNDTy9mT3ppUkhMUlMKZitpT0tXckdMREtKUTZmV2lRSURBUUFCCi0tLS0tRU5EIFBVQkxJQyBLRVktLS0tLQo=';
            $sid_server = '0';

            $sid_core = new SmileIdentityCore(
                $partner_id,
                $default_callback,
                $api_key,
                $sid_server
            );

            $partner_params = array(
                'job_id' =>  $smilekyc_obj->si_id,
                'user_id' => $user->user_id,
                'job_type' => 2,
                'optional_info' => 'PHP Test Data',
                'signature' => '0ca81525-4cf0-4992-bfa9-f7bab43b3f6e'
            );
            $options = array(
                'optional_callback' => route('SmileKycResponse'),
                'return_job_status' => true,
                'return_history' => false,
                'return_image_links' =>true 
            );
            
            $selfie_image_detail = array(
                'image_type_id' => 2, 
                'image' => $smilekyc_obj->selfie
            );

            $document_image_detail = array(
                'image_type_id' => 1, 
                'image' => $user->user_national_document_url
            );

            $image_details = array(
                $selfie_image_detail,
                $document_image_detail
            );
            $id_info = array(
                'id_type' => 'NATIONAL_ID',
                'id_number' => '0000000000000',
                'country'=> 'ZA'
            );
            $result = $sid_core->submit_job($partner_params, $image_details, $id_info, $options);
            
            if ($result['result']['ResultCode'] == '0820' || $result['result']['ResultCode'] == '1220') {

                $si_record = SIRecord::where('si_id', $smilekyc_obj->si_id)->first();
                $si_record->response = json_encode($result);
                $si_record->addFlag(SIRecord::FLAG_PASS);
                if ($si_record->save()) {
                    return 1;
                }

            } else if ($result['result']['ResultCode'] == '0824') {
                $si_record = SIRecord::where('si_id', $smilekyc_obj->si_id)->first();
                $si_record->response = json_encode($result);
                $si_record->save();
                return 2;

            } else {
                return 3;
                
            }
        } catch (\Exception $e) {
            return 3;
        }
    }

    public function upload_selfie (Request $request)
    {
        $user = User::where('user_id', request()->user->user_id)->first();
        $user->selfie = $request->images;
        if ($user->save()) {
            return api_success1('Selfie Uploaded Successfully!');

        }
        return api_error('There is some error!');
    }

    public function upload_other_info (Request $request)
    {
        //dd($request->all());
        $user = User::where('user_id', request()->user->user_id)->first();
        if (empty($user->date_of_birth) && empty($user->national_id_number) && $request->has('date_of_birth') && $request->has('national_id_number')) {
            $user->date_of_birth = $request->date_of_birth;
            $user->national_id_number = $request->national_id_number;


        }

        if ($request->has('first_name') && $request->filled('first_name') && $request->has('last_name') && $request->filled('last_name')) {
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;

        }

        if ($request->has('domestic') && $request->filled('domestic') && $request->has('foreign') && $request->filled('foreign') && $request->has('over_eighteen_check') && $request->filled('over_eighteen_check')) {
            $user->removeFlag(User::FLAG_DOMISTIC_POLITICALLY);
            $user->removeFlag(User::FLAG_FOREIGN_POLITICALLY);
            $user->removeFlag(User::FLAG_OVER_EIGHTEEN);
            $user->removeFlag(User::FLAG_ANSWERED_QUESTION);
            $user->addFlag(User::FLAG_ANSWERED_QUESTION);
            if ($request->domestic == 'yes') {
                $user->addFlag(User::FLAG_DOMISTIC_POLITICALLY);

            }

            if ($request->foreign == 'yes') {
                $user->addFlag(User::FLAG_FOREIGN_POLITICALLY);

            }

            if ($request->over_eighteen_check == 'yes') {
                $user->addFlag(User::FLAG_OVER_EIGHTEEN);

            }
        }
        $user->save();

        
        $name = rand(99, 9999999);
        $filenameWithExt = $request->bank_account->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->bank_account->getClientOriginalExtension();
        $fileNameToStore = $name . '.' . $extension;
        $path = $request->bank_account->storeAs("public/users/".$user->user_id.'/', $fileNameToStore);
        $bank_account = $fileNameToStore;

        $name = rand(99, 9999999);
        $filenameWithExt = $request->address_document->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->address_document->getClientOriginalExtension();
        $fileNameToStore = $name . '.' . $extension;
        $path = $request->address_document->storeAs("public/users/".$user->user_id.'/', $fileNameToStore);
        $address_document = $fileNameToStore;

        $user->address_document = $address_document;
        $user->bank_account_document = $bank_account;

        if ($user->save()) {
            $name = rand(99, 9999999);
            $filenameWithExt = $request->id_document->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->id_document->getClientOriginalExtension();
            $fileNameToStore = $name . '.' . $extension;
            $path = $request->id_document->storeAs("public/users/".$user->user_id.'/', $fileNameToStore);
            
            $id_document = $fileNameToStore;
            $user->national_id_card = $id_document;
            $user->save();
           

            $result = $this->selfie_authentication($user);
            if ($result == 1) {
                $notif = new Notifications;
                $notif->notification_id = (String) Str::uuid();
                $notif->user_id = $user->user_id;
                $notif->heading = 'Registration Successfull on SmileKYC!';
                $notif->text = 'You have been successfully registered! Now you can perform authentication while withdrawing.';
                if ($notif->save()) {
                    $user_notif = new NotificationUser;
                    $user_notif->notification_user_id = (String) Str::uuid();
                    $user_notif->notification_id = $notif->notification_id;
                    $user_notif->user_id = $user->user_id;
                    if ($user_notif->save()) {
                        return redirect(route('Security'))->with(['req_success' => 'Registration Successfull!']);

                    }
                }
                return redirect()->back()->with(['req_error' => 'There is some error!']);

            } else if ($result == 2) {
                $notif = new Notifications;
                $notif->notification_id = (String) Str::uuid();
                $notif->user_id = $user->user_id;
                $notif->heading = 'Registration is in provisional stage!';
                $notif->text = 'Your request is in provisional status right now and we will let you know asap about the end result regarding your request!';
                if ($notif->save()) {
                    $user_notif = new NotificationUser;
                    $user_notif->notification_user_id = (String) Str::uuid();
                    $user_notif->notification_id = $notif->notification_id;
                    $user_notif->user_id = $user->user_id;
                    if ($user_notif->save()) {
                        return redirect(route('Security'))->with(['req_success' => 'Registration is in provisional status!']);

                    }
                }
                return redirect()->back()->with(['req_error' => 'There is some error!']);

            } else {
                $notif = new Notifications;
                $notif->notification_id = (String) Str::uuid();
                $notif->user_id = $user->user_id;
                $notif->heading = 'Request for Smilekyc got rejected!';
                $notif->text = 'Your request has been rejected! Kindly perform once again the process.';
                if ($notif->save()) {
                    $user_notif = new NotificationUser;
                    $user_notif->notification_user_id = (String) Str::uuid();
                    $user_notif->notification_id = $notif->notification_id;
                    $user_notif->user_id = $user->user_id;
                    if ($user_notif->save()) {
                        return redirect(route('Security'))->with(['req_error' => 'Request rejected! Kindly try again.']);

                    }
                }
                return redirect(route('Security'))->with(['req_error' => 'There is some error!']);
            }
        }
    }

    public function selfie_authentication($user)
    {
        try {
            $partner_id = '1613';
            $default_callback = route('SmileKycResponse');
            $api_key = 'LS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS0KTUlHZk1BMEdDU3FHU0liM0RRRUJBUVVBQTRHTkFEQ0JpUUtCZ1FDOGF6eDRoVFIzUndXN29zMUk1V2JUeUhjMgpqTXcwTExzTlhIdllaYzJkcklSYW5ObnpUR0xGUk5qTktmeVRDZmVJcC9HVG50N2VEbDlNTjBWQzBHTTBhS0dHCkROUmtFOVFoT3FndDVXc2Y0M3RQUTJ3UE85M2c2VHlWYWkySm12UjRFcy9PL245eGhpRWNDTy9mT3ppUkhMUlMKZitpT0tXckdMREtKUTZmV2lRSURBUUFCCi0tLS0tRU5EIFBVQkxJQyBLRVktLS0tLQo=';
            $sid_server = '0';

            $sid_core = new SmileIdentityCore(
                $partner_id,
                $default_callback,
                $api_key,
                $sid_server
            );

            $job_id = (String) Str::uuid();
            $partner_params = array(
                'job_id' =>  $job_id,
                'user_id' =>$user->user_id,
                'job_type' => 4,
                'optional_info' => 'PHP Test Data',
                'signature' => '0ca81525-4cf0-4992-bfa9-f7bab43b3f6e'
            );
            $options = array(
                'optional_callback' => route('SmileKycResponse'),
                'return_job_status' => true,
                'return_history' => false,
                'return_image_links' =>true 
            );
            
            $selfie_image_detail = array(
                'image_type_id' => 2, 
                'image' => $user->selfie
            );

            $document_image_detail = array(
                'image_type_id' => 1, 
                'image' => $user->user_national_document_url
            );

            $image_details = array(
                $selfie_image_detail,
                $document_image_detail
           
            );
            $id_info = array(
                'id_type' => 'NATIONAL_ID',
                'id_number' => $user->national_id_number,
                'country' => 'ZA'
              
            );
            $result = $sid_core->submit_job($partner_params, $image_details, $id_info, $options);

            if ($result['result']['ResultCode'] == '0840' || $result['result']['ResultCode'] == '1240') {
                $user->removeFlag(User::FLAG_APPROVED_SELFIE);
                $user->addFlag(User::FLAG_APPROVED_SELFIE);
                $user->save();
                // Mail::to($user->email)->send(new KYCSuccessfulEmail($user));
                // if (count(Mail::failures()) > 0) return redirect()->back()->with(['req_error' => 'KYC email couldn\'t send!']);
                return 1;

            } else if ($result['result']['ResultCode'] == '0844') {
                $user->removeFlag(User::FLAG_PROVISIONAL_APPROVAL);
                $user->addFlag(User::FLAG_PROVISIONAL_APPROVAL);
                $user->save();
                return 2;

            } else {
                $user->removeFlag(User::FLAG_APPROVED_SELFIE);
                $user->save();
                return 0;
                // Mail::to($user->email)->send(new KYCFailEmail($user));
                // if (count(Mail::failures()) > 0) return redirect()->back()->with(['req_error' => 'KYC email couldn\'t send!']);

            }
        } catch (\Exception $e) {
            return 0;

        }
    }

    public function smile_kyc_response(Request $request)
    {
        if ($request->ResultCode && $request->ResultCode) {
            $user_id = '';
            $job_id = '';
            $job_type = '';
            foreach ($request->PartnerParams as $key => $value) {
                if ($key == 'user_id') {
                    $user_id = $value;

                } else if ($key == 'job_id') {
                    $job_id = $value;

                } else if ($key == 'job_type') {
                    $job_type = $value;

                }
            }
            $user = User::where('user_id', $user_id)->first();
            if ($user) {
                if ($job_type == '2') {

                    if (!$user->approved_selfie) {
                        $user->removeFlag(User::FLAG_APPROVED_SELFIE);
                        $user->removeFlag(User::FLAG_PROVISIONAL_APPROVAL);
                        $user->save();
                        return 1;
    
                    }
                    $si_record = SIRecord::where('si_id', $job_id)->first();
                    if ($si_record) {

                        $si_record->removeFlag(SIRecord::FLAG_PASS);
                        $si_record->removeFlag(SIRecord::FLAG_AVAILED);
    
                        if ($request->ResultCode == '0820' || $request->ResultCode == '1220') {
                            $si_record->addFlag(SIRecord::FLAG_PASS);
                            $si_record->save();
   
                            $notif = new Notifications;
                            $notif->notification_id = (String) Str::uuid();
                            $notif->user_id = $user->user_id;
                            $notif->heading = 'Authentication successfull on SmileKYC!';
                            $notif->text = 'You have successfully authenticated your profile on SmileYC! Now you can proceed further on withdrawal process.';
                            $notif->save();
            
                            $user_notif = new NotificationUser;
                            $user_notif->notification_user_id = (String) Str::uuid();
                            $user_notif->notification_id = $notif->notification_id;
                            $user_notif->user_id = $user->user_id;
                            $user_notif->save();
                        } else {
                            $notif = new Notifications;
                            $notif->notification_id = (String) Str::uuid();
                            $notif->user_id = $user->user_id;
                            $notif->heading = 'Authentication Request for Smilekyc got rejected!';
                            $notif->text = 'Your request has been rejected! Kindly perform once again the process';
                            $notif->save();
            
                            $user_notif = new NotificationUser;
                            $user_notif->notification_user_id = (String) Str::uuid();
                            $user_notif->notification_id = $notif->notification_id;
                            $user_notif->user_id = $user->user_id;
                            $user_notif->save();
                        }
                    }
    
                } else if ($job_type == '4') {
                    if ($user->approved_selfie) {
                        return 1;
    
                    }
                    $user->removeFlag(User::FLAG_APPROVED_SELFIE);
                    $user->removeFlag(User::FLAG_PROVISIONAL_APPROVAL);
                        
                    if ($request->ResultCode == '0840' || $request->ResultCode == '1240') {

                       
    
                        $notif = new Notifications;
                        $notif->notification_id = (String) Str::uuid();
                        $notif->user_id = $user->user_id;
                        $notif->heading = 'Registration Successfull on SmileKYC!';
                        $notif->text = 'You have been successfully registered! Now you can perform authentication while withdrawing.';
                        $notif->save();
        
                        $user_notif = new NotificationUser;
                        $user_notif->notification_user_id = (String) Str::uuid();
                        $user_notif->notification_id = $notif->notification_id;
                        $user_notif->user_id = $user->user_id;
                        $user_notif->save();
    
                        $user->addFlag(User::FLAG_APPROVED_SELFIE);
                        $user->save();

                        // Mail::to($user->email)->send(new KYCSuccessfulEmail($user));
                        // if (count(Mail::failures()) > 0) return redirect()->back()->with(['req_error' => 'KYC email couldn\'t send!']);
    
    
                    } else {
                        $notif = new Notifications;
                        $notif->notification_id = (String) Str::uuid();
                        $notif->user_id = $user->user_id;
                        $notif->heading = 'Authentication on Smilekyc got rejected!';
                        $notif->text = 'Your authentication request has been rejected on SmileKYC! Kindly perform once again.';
                        $notif->save();

                       
        
                        $user_notif = new NotificationUser;
                        $user_notif->notification_user_id = (String) Str::uuid();
                        $user_notif->notification_id = $notif->notification_id;
                        $user_notif->user_id = $user->user_id;
                        $user_notif->save();
                        $user->save();

                        // Mail::to($user->email)->send(new KYCFailEmail($user));
                        // if (count(Mail::failures()) > 0) return redirect()->back()->with(['req_error' => 'KYC email couldn\'t send!']);
                    }
                }
            }
        }
        return 1;
    }


    public function current_password_check(Request $request)
    {
        $user = request()->user;
        $user = User::where('user_id', $user->user_id)->first();
        if (HASH::check($request->current_pass, $user->password)) {
            return 1;

        } else {
            return 0;

        }
    }

    public function index_admin(Request $request)
    {
        $user = User::query();
        if ($request->has('status') && $request->filled('status')) {
            if (lcfirst($request->status) == 'active') {
                $user->whereRaw('`flags` & ? = ?', [User::FLAG_ACTIVE , User::FLAG_ACTIVE]);

            } else {
                $user->whereRaw('`flags` & ? != ?', [User::FLAG_ACTIVE , User::FLAG_ACTIVE]);

            }
        }

        if ($request->has('search') && $request->filled('search')) {
           
            $user->where('first_name', 'LIKE', '%'.$request->search.'%')->orWhere('last_name', 'LIKE', '%'.$request->search.'%')->orWhere('username', 'LIKE', '%'.$request->search.'%')->orWhere('email', 'LIKE', '%'.$request->search.'%');

        }

        $user->whereRaw('`flags` & ? = ?', [User::FLAG_CUSTOMER, User::FLAG_CUSTOMER]);
        $user->with('loginSecurity');
        $user->orderBy('id', 'desc');
        return view('admin.users.index', ['users' => $user->paginate(20)]);
    }

    public function user_link_view(Request $request, $id)
    {
        return view('user-dashboard.events.link', ['user_id' => $id]);
    }

    public function create_link_or_theme(Request $request) {

        $request->validate([
            'create_event' => 'bail|required|',

        ]);

        if ($request->create_event == 1) {
            return redirect()->route('UserLink', [session()->get('event_beneficiars')])->with(['req_success' => 'Event has been created, Copy the link']);

        }else if ($request->create_event == 2) {
            return redirect()->route('ThemeSelection', [session()->get('event_beneficiars')])->with(['req_success' => 'Select the theme card for event']);

        }
    }

    public function show($id)
    {
        $user = User::where('user_id', $id)->first();
        return view('admin.users.show', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $route = 'Settings';
        $message = 'Settings Updated!';

        if ($request->has('page') && $request->page == 'security') {
            $route = 'Security';
            $message = 'Security Updated!';

        }

        $user = User::where('user_id', request()->user->user_id)->first();
        
        $user->date_of_birth = $request->input('date_of_birth', $user->date_of_birth);
        $user->first_name = $request->input('first_name', $user->first_name);
        $user->last_name = $request->input('last_name', $user->last_name);

        if($request->first_name && $request->last_name) {
            Mail::to($user->email)->send(new ProfileChanges($user));
            if (count(Mail::failures()) > 0) return redirect(route('SignIn'))->with(['req_error' => 'update profile email couldn\'t send!']);
        }

        if ($request->has('current_password') && $request->filled('current_password') && $request->has('new_password') && $request->filled('new_password')) {
            if (HASH::check($request->current_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
                Mail::to($user->email)->send(new ForgotPasswordConfirmEmail($user));
                if (count(Mail::failures()) > 0) return redirect(route('SignIn'))->with(['req_error' => 'Current password email couldn\'t send!']);
            } else {
                return redirect(route($route))->with(['req_error' => 'Incorrect Password!']);

            }
        }

        

        if ($user->save()) {
            
            return redirect(route($route))->with(['req_success' => $message]);

        } else {
            return redirect(route($route))->with(['req_error' => 'There is some error!']);

        }

    }

    public function update_notifications_status (Request $request)
    {
        $view = 'admin';
        if (request()->user) {
            $user_id = request()->user->user_id;
            $view = 'user';

        } else if (request()->admin) {
            $user_id = request()->admin->user_id;

        }

        $user = User::where('user_id', $user_id)->first();
        $user->removeFlag(User::FLAG_DAILY_SUMMARY);
        $user->removeFlag(User::FLAG_WEEKLY_SUMMARY);
        $user->removeFlag(User::FLAG_MONTHLY_SUMMARY);
        $user->removeFlag(User::FLAG_PROMOTIONS);
        $user->removeFlag(User::FLAG_NEWSLETTERS);
        $user->removeFlag(User::FLAG_OPENS_AN_INVITE);
        $user->removeFlag(User::FLAG_RESP_FOR_MY_EVENT);
        $user->removeFlag(User::FLAG_PROCESS_A_GIFT);
        $user->removeFlag(User::FLAG_RESEND_CARD);
        $user->removeFlag(User::FLAG_SENDS_REMINDER_OF_EVENT);
        $user->removeFlag(User::FLAG_SENDS_THANKYOU_CARD);

        if ($request->has('daily_summary') && $request->filled('daily_summary')) {
            $user->addFlag(User::FLAG_DAILY_SUMMARY);

        }

        if ($request->has('weekly_summary') && $request->filled('weekly_summary')) {
            $user->addFlag(User::FLAG_WEEKLY_SUMMARY);

        }

        if ($request->has('monthly_summary') && $request->filled('monthly_summary')) {
            $user->addFlag(User::FLAG_MONTHLY_SUMMARY);

        }

        if ($request->has('promotions') && $request->filled('promotions')) {
            $user->addFlag(User::FLAG_PROMOTIONS);

        }

        if ($request->has('newsletters') && $request->filled('newsletters')) {
            $user->addFlag(User::FLAG_NEWSLETTERS);

        }

        if ($request->has('opens_an_invite') && $request->filled('opens_an_invite')) {
            $user->addFlag(User::FLAG_OPENS_AN_INVITE);

        }

        if ($request->has('rsvp_for_my_event') && $request->filled('rsvp_for_my_event')) {
            $user->addFlag(User::FLAG_RESP_FOR_MY_EVENT);

        }

        if ($request->has('process_a_gift') && $request->filled('process_a_gift')) {
            $user->addFlag(User::FLAG_PROCESS_A_GIFT);

        }

        if ($request->has('resend_card') && $request->filled('resend_card')) {
            $user->addFlag(User::FLAG_RESEND_CARD);

        }

        if ($request->has('sends_reminder_of_event') && $request->filled('sends_reminder_of_event')) {
            $user->addFlag(User::FLAG_SENDS_REMINDER_OF_EVENT);

        }

        if ($request->has('send_thank_you_card') && $request->filled('send_thank_you_card')) {
            $user->addFlag(User::FLAG_SENDS_THANKYOU_CARD);

        }

        if ($user->save()) {
            if ($view == 'admin') {
                return redirect(route('AdminNotificationsSettings'))->with(['req_success' => 'Notifications Settings Updated!']);

            }
            return redirect(route('Notifications'))->with(['req_success' => 'Notifications Settings Updated!']);
        } else {
            if ($view == 'admin') {
                return redirect(route('AdminNotificationsSettings'))->with(['req_error' => 'There is some error!']);

            }
            return redirect(route('Notifications'))->with(['req_error' => 'There is some error!']);
        }
    }

    public function store_bank_detail(Request $request)
    {
        $request->validate([
            'bank' => 'bail|required|string',
            'account_type' => 'bail|required|string',
            'account_number' => 'bail|required',
            'branch_code' => 'bail|required'
        ]);

        $bank_detail = BankDetail::where('user_id',request()->user->user_id)->first();

        if ($bank_detail) {
            BankDetail::where('user_id', request()->user->user_id)->delete();

        }
        $bank_detail = new BankDetail();
        $bank_detail->bank_detail_id = (string) Str::uuid();
        $bank_detail->bank = $request->bank;
        $bank_detail->user_id = request()->user->user_id;
        $bank_detail->account_type = $request->account_type;
        $bank_detail->account_number = $request->account_number;
        $bank_detail->branch_code = $request->branch_code;

        $user = request()->user;

        if ($bank_detail->save()) {
            Mail::to($user->email)->send(new BankDetailEmail($user));
            if (count(Mail::failures()) > 0) return redirect(route('SignIn'))->with(['req_error' => 'Bank details email couldn\'t send!']);
            return redirect(route('Settings'))->with('req_success','Bank details added successfully!');

        }

        return redirect()->back()->with(['req_error' => 'There is some error!']);
    }

    public function store_bank_detail_ajax(Request $request)
    {
        $request->validate([
            'bank' => 'bail|required|string',
            'account_type' => 'bail|required|string',
            'account_number' => 'bail|required',
            'branch_code' => 'bail|required'
        ]);

        $bank_detail = BankDetail::where('user_id',request()->user->user_id)->first();

        if ($bank_detail) {
            BankDetail::where('user_id', request()->user->user_id)->delete();

        }
        $bank_detail = new BankDetail();
        $bank_detail->bank_detail_id = (string) Str::uuid();
        $bank_detail->bank = $request->bank;
        $bank_detail->user_id = request()->user->user_id;
        $bank_detail->account_type = $request->account_type;
        $bank_detail->account_number = $request->account_number;
        $bank_detail->branch_code = $request->branch_code;

        if ($bank_detail->save()) {

            $user = request()->user;
            Mail::to($user->email)->send(new BankDetailEmail($user));
            if (count(Mail::failures()) > 0) return redirect(route('SignIn'))->with(['req_error' => 'Bank details email couldn\'t send!']);
            return api_success1('Bank Details Updated Successfully!');

        }
        return api_error();
    }

    public function send_wd_vc_code (Request $request)
    {
        $user = User::where('user_id', request()->user->user_id)->first();
        $user->withdrawal_verification_code = rand(1000, 9999);
        $user->save();

        //Mail::to($user->email)->send(new WithdrawalVerificationCode($user));
       // if (count(Mail::failures()) > 0) return api_error();

        return api_success1('We have sent you a code on your email. Kindly enter 4 Digit code! '. $user->withdrawal_verification_code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
