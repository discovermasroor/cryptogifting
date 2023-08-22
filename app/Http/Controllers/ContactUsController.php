<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use App\Mail\ContactUsMail;

use App\Models\ContactUs;
use App\Models\User;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index (Request $request)
    {
        $data = array();
        $contact_us = ContactUs::query();

        if ($request->has('search') && $request->filled('search')) {
            $contact_us->where('email', 'LIKE', '%'.$request->search.'%')->orWhere('topic', 'LIKE', '%'.$request->search.'%')->orWhere('subject', 'LIKE', '%'.$request->search.'%');

        }

        if ($request->has('status') && $request->filled('status')) {
            if (lcfirst($request->status) == 'read') {
                $contact_us->whereRaw('`flags` & ? = ?', [ContactUs::FLAG_READ , ContactUs::FLAG_READ]);

            } else {
                $contact_us->whereRaw('`flags` & ? != ?', [ContactUs::FLAG_READ , ContactUs::FLAG_READ]);

            }
        }

        $contact_us->whereRaw('`flags` & ? = ?', [ContactUs::FLAG_CONTACT_US, ContactUs::FLAG_CONTACT_US]);
        $contact_us->orderBy('id', 'desc');
        $data['contact_us'] = $contact_us->paginate(10);
        return view('admin.contact-us.contact-index', $data);

    }

    public function index_affiliate (Request $request)
    {
        $data = array();
        $contact_us = ContactUs::query();
        
        if ($request->has('search') && $request->filled('search')) {
            $contact_us->where('email', 'LIKE', '%'.$request->search.'%')->orWhere('topic', 'LIKE', '%'.$request->search.'%')->orWhere('subject', 'LIKE', '%'.$request->search.'%');

        }

        if ($request->has('status') && $request->filled('status')) {
            if (lcfirst($request->status) == 'read') {
                $contact_us->whereRaw('`flags` & ? = ?', [ContactUs::FLAG_READ , ContactUs::FLAG_READ]);

            } else {
                $contact_us->whereRaw('`flags` & ? != ?', [ContactUs::FLAG_READ , ContactUs::FLAG_READ]);

            }
        }
        $contact_us->whereRaw('`flags` & ? = ?', [ContactUs::FLAG_AFFILIATE, ContactUs::FLAG_AFFILIATE]);
        $contact_us->orderBy('id', 'desc');
        $data['contact_us'] = $contact_us->paginate(10);
        return view('admin.contact-us.affiliate-index', $data);

    }

    public function index_loyalty (Request $request)
    {
        $data = array();
        $contact_us = ContactUs::query();
        if ($request->has('search') && $request->filled('search')) {
            $contact_us->where('email', 'LIKE', '%'.$request->search.'%')->orWhere('topic', 'LIKE', '%'.$request->search.'%')->orWhere('subject', 'LIKE', '%'.$request->search.'%');

        }

        if ($request->has('status') && $request->filled('status')) {
            if (lcfirst($request->status) == 'read') {
                $contact_us->whereRaw('`flags` & ? = ?', [ContactUs::FLAG_READ , ContactUs::FLAG_READ]);

            } else {
                $contact_us->whereRaw('`flags` & ? != ?', [ContactUs::FLAG_READ , ContactUs::FLAG_READ]);

            }
        }
        $contact_us->whereRaw('`flags` & ? = ?', [ContactUs::FLAG_LOYALTY_PROGRAM, ContactUs::FLAG_LOYALTY_PROGRAM]);
        $contact_us->orderBy('id', 'desc');
        $data['contact_us'] = $contact_us->paginate(10);
        return view('admin.contact-us.loyalty-index', $data);

    }

    public function index_feedback (Request $request)
    {
        $data = array();
        $contact_us = ContactUs::query();
        if ($request->has('search') && $request->filled('search')) {
            $contact_us->where('email', 'LIKE', '%'.$request->search.'%')->orWhere('topic', 'LIKE', '%'.$request->search.'%')->orWhere('subject', 'LIKE', '%'.$request->search.'%');

        }

        if ($request->has('status') && $request->filled('status')) {
            if (lcfirst($request->status) == 'read') {
                $contact_us->whereRaw('`flags` & ? = ?', [ContactUs::FLAG_READ , ContactUs::FLAG_READ]);

            } else {
                $contact_us->whereRaw('`flags` & ? != ?', [ContactUs::FLAG_READ , ContactUs::FLAG_READ]);

            }
        }
        $contact_us->whereRaw('`flags` & ? = ?', [ContactUs::FLAG_FEEDBACK, ContactUs::FLAG_FEEDBACK]);
        $contact_us->orderBy('id', 'desc');
        $data['contact_us'] = $contact_us->paginate(10);
        return view('admin.contact-us.feedback-index', $data);

    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'topic' => 'required',
            'subject' => 'required',
            'description' => 'required',
        ]);

        $view = '';
        $admin_view = "";
        $route = '';
        $success = '';
        $fail = '';
        $subject = '';
        $flag = '';
       

        $check_submitted_user = User::where('email', $request->email)->first();
        

		if ($request->route()->getName() == 'StoreContactUs') {
            $view = 'contact-us';
            $route = 'ContactUs';
            $success = 'We have received your message. One of our lovely customer care agents will get back to you promptly';
            $fail = 'Contact us email not send!';
            $subject = 'CryptoGifting.com Message Received';
            $flag = ContactUs::FLAG_CONTACT_US;


        } else if ($request->route()->getName() == 'StoreAffiliate') {
            $view = 'affiliates';
            $route = 'Affiliates';
            $success = 'We have received your message. One of our lovely customer care agents will get back to you promptly';
            $fail = 'Affiliate email not send!';
            $subject = 'CryptoGifting.com Affiliate Program';
            $flag = ContactUs::FLAG_AFFILIATE;

        } else if ($request->route()->getName() == 'StoreLoyaltyProgram') {
            $view = 'contact-us';
            $route = 'LoyaltyProgram';
            $success = 'We have received your message. One of our lovely customer care agents will get back to you promptly';
            $fail = 'Loyalty Program email not send!';
            $subject = 'CryptoGifting.com Loyalty Program';
            $flag = ContactUs::FLAG_LOYALTY_PROGRAM;
            
             

        } else if ($request->route()->getName() == 'StoreFeedback') {
            $view = 'contact-us';
            $route = 'GiveUsFeedback';
            $success = 'We have received your message. One of our lovely customer care agents will get back to you promptly';
            $fail = 'Feedback email not send!';
            $subject = 'CryptoGifting.com Feedback Form';
            $flag = ContactUs::FLAG_FEEDBACK;
           

        }

        $contact_us = new ContactUs;
        $contact_us->contact_us_id = (String) Str::uuid();
        
        if ($check_submitted_user && !empty($check_submitted_user->user_id) ) {
            $contact_us->submitted_user_id = $check_submitted_user->user_id;
            

        } 

        $contact_us->email = $request->email;  
        $contact_us->topic = $request->topic;
        $contact_us->subject = $request->subject;
        $contact_us->description = $request->description;
        $contact_us->addFlag($flag);

        $contact_us->removeFlag(ContactUs::FLAG_LOGIN_OR_NOT);
        if(isset(request()->user) && request()->user->user_id) {
            $contact_us->addFlag(ContactUs::FLAG_LOGIN_OR_NOT);
        }

        if ($contact_us->save()) {
            
            if ($request->hasFile('attachement')) {
                $file_name = rand(999, 9999);
                if (!file_exists(storage_path("app/public/contact-us")))
                    mkdir(storage_path("app/public/contact-us"), 0777, true);

                $request->file('attachement')->storeAs("/public/contact-us/".$contact_us->contact_us_id, $file_name.'.'.$request->file('attachement')->getClientOriginalExtension());
                $contact_us->file = $file_name.'.'.$request->file('attachement')->getClientOriginalExtension();
                $contact_us->save();
                $artisan_call_to_make_files_public = Artisan::call("storage:link", []);

            }

             if ($request->route()->getName() == 'StoreLoyaltyProgram') {
                if($request->topic == 'I am a loyal customer and would like to be whitelisted for your loyalty program') {
                    $admin_view = 'loyalty';
                }else {
                    $admin_view = 'loyalty-company';
                } 

                Mail::to($request->email)->send(new ContactUsMail($contact_us, $subject, $admin_view));
            }

           

            if ($request->has('send_me_too') && $request->filled('send_me_too')) {

                if ($request->route()->getName() == 'StoreContactUs') {
                    $admin_view = 'contact-us-admin';
                   
                }
                else if ($request->route()->getName() == 'StoreAffiliate') {
                    $admin_view = 'affiliates-admin';
                   
                }
                else if ($request->route()->getName() == 'StoreFeedback') { 
                    $admin_view = 'feedback';

                }
                
                Mail::to($request->email)->send(new ContactUsMail($contact_us, $subject, $admin_view));

            }
                Mail::to(config('credentials.admin_email_address'))->send(new ContactUsMail($contact_us, $subject, $view));


            if (count(Mail::failures()) > 0) {
                return redirect(route($route))->with(['req_error' => $fail]);

            }
            return redirect(route($route))->with(['req_success' => $success]);

        }
        return redirect(route($route))->with(['req_error' => 'There is some error!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show ($id)
    {
        $contact = ContactUs::where('contact_us_id', $id)->first();
        return view('admin.contact-us.contact-show', ['contact_us' => $contact]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $contact = ContactUs::where('contact_us_id', $id)->first();
        $contact->removeFlag(ContactUs::FLAG_READ);

        if ($request->status == "Read") {
            $contact->addFlag(ContactUs::FLAG_READ);

        }
        if ($contact->save()) {
            if ($contact->contact_us) {
                return redirect(route('ContactUsInfoAdmin', [$contact->contact_us_id]))->with(['req_success' => 'Status updated!']);

            } else if ($contact->loyalty_program) {
                return redirect(route('LoyaltyProgramInfoAdmin', [$contact->contact_us_id]))->with(['req_success' => 'Status updated!']);

            } else if ($contact->feedback) {
                return redirect(route('FeedbackInfoAdmin', [$contact->contact_us_id]))->with(['req_success' => 'Status updated!']);

            } else if ($contact->affiliates) {
                return redirect(route('AffiliateInfoAdmin', [$contact->contact_us_id]))->with(['req_success' => 'Status updated!']);

            }
        } else {
            if ($contact->contact_us) {
                return redirect(route('ContactUsInfoAdmin', [$contact->contact_us_id]))->with(['req_error' => 'There is some error!']);

            } else if ($contact->loyalty_program) {
                return redirect(route('LoyaltyProgramInfoAdmin', [$contact->contact_us_id]))->with(['req_error' => 'There is some error!']);

            } else if ($contact->feedback) {
                return redirect(route('FeedbackInfoAdmin', [$contact->contact_us_id]))->with(['req_error' => 'There is some error!']);

            } else if ($contact->affiliates) {
                return redirect(route('AffiliateInfoAdmin', [$contact->contact_us_id]))->with(['req_error' => 'There is some error!']);

            }
        }
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
