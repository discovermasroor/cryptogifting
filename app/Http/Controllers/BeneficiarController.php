<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Beneficiar;
use App\Models\Contact;
use App\Mail\BeneficiaryMail;
use App\Mail\ConfirmBeneficiaryMail;
use App\Models\User;
use App\Models\GuestList;



class BeneficiarController extends Controller
{
    public function index()
    {
        $beneficiaries = Beneficiar::query();
        $beneficiaries->where('user_id', request()->user->user_id);
        $beneficiaries->orderBy('id', 'desc');
        return view('user-dashboard.beneficiaries.index', ['beneficiaries' => $beneficiaries->paginate(20)]);
    }

    public function index_admin(Request $request)
    {
        $beneficiaries = Beneficiar::query();

        if ($request->has('search') && $request->filled('search')) {
            $beneficiaries->where('name', 'LIKE', '%'.$request->search.'%')->orWhere('surname', 'LIKE', '%'.$request->search.'%')->orWhere('relation', 'LIKE', '%'.$request->search.'%')->orWhere('email', 'LIKE', '%'.$request->search.'%');
        
        }

        if ($request->has('status') && $request->filled('status')) {
           if($request->status == 'Empty') {
                $beneficiaries->where('reference_id', '=', NULL);
                
           }else {
                $beneficiaries->where('reference_id', '!=', NULL);

           }
        
        }
        $beneficiaries->orderBy('id', 'desc');
        return view('admin.beneficiaries.index', ['beneficiaries' => $beneficiaries->paginate(20)]);
    }

    public function choose_beneficiaries()
    {
        $beneficiaries = Beneficiar::query();
        $beneficiaries->where('user_id', request()->user->user_id);
        $beneficiaries->orderBy('id', 'asc');
        $guest_list = GuestList::where('creator_id', request()->user->user_id)->count();
        $req_guestlist = '0';
        if ($guest_list > 0) { 
            $req_guestlist = '1';
        }
        $check_contacts = Contact::where('user_id',request()->user->user_id)->get()->toArray();
        $check_contact = '0';
        if (count($check_contacts) == 0) 
        $check_contact = '1';

        return view('user-dashboard.events.beneficiaries-list', ['beneficiaries' => $beneficiaries->get(), 'req_guestlist' => $req_guestlist, 'check_contact' => $check_contact ]);
    }

    public function create ()
    {
        return view('user-dashboard.beneficiaries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|string',
            'surname' => 'bail|required|string',
            'email' => 'bail|required|email',
            'relation' => 'bail|required|string',
        ]);
        $user_info = request()->user;
        $check_beneficiar = Beneficiar::where('user_id',$user_info->user_id)->where('email',$request->email)->first();

        if ($check_beneficiar)
            return redirect()->back()->with('req_error','This beneficiar already exist! Try again with a new email.');

        $beneficiar = new Beneficiar;
        $beneficiar->beneficiary_id = (String) Str::uuid();
        $beneficiar->user_id = request()->user->user_id;
        $beneficiar->name = $request->name;
        $beneficiar->surname = $request->surname;
        $beneficiar->email = $request->email;
        if ($request->has('dob') && $request->filled('dob')) {
            $dob = date("Y-m-d", strtotime($request->dob));
            $beneficiar->dob = $dob;
        } 
        
        $beneficiar->relation = lcfirst($request->relation);
        
        if($beneficiar->save()) {
            $name = $beneficiar->name.' '.$beneficiar->surname;
             $result = sub_accounts($name, $beneficiar->beneficiary_id);
             $user = request()->user;
           
             if (isset($result->id) && !empty($result->id) ) {
                admin_create_notification(false, '', false, '', true, $beneficiar->beneficiary_id, 'User has created a beneficiary in our platform', 'A beneficiary named '.$name.' has been created in platform. Click to update his Valr Payment Reference ID');
                $beneficiar->valr_account_id = $result->id;
                Mail::to($user->email)->send(new  BeneficiaryMail($user, $beneficiar));
                //Mail::to($user->email)->send(new ConfirmBeneficiaryMail($user, $beneficiar));
                $beneficiar->save();
                return redirect(route('Beneficiaries'))->with(['req_success' => 'Beneficiary Added!']);

            } else {
                Beneficiar::where('beneficiary_id', $beneficiar->beneficiary_id)->delete();
                return redirect(route('Beneficiaries'))->with(['req_error' => 'Beneficiary can not be created, try again later.']);

             }
        } else {
            return redirect(route('Beneficiaries'))->with(['req_error' => 'There is some error!']);
        }
    }


    public function edit (Request $request, $id)
    {
        $beneficiar = Beneficiar::where('beneficiary_id', $id)->first();
        return view('user-dashboard.beneficiaries.edit', ['beneficiar' => $beneficiar]);
    }

    public function show_admin (Request $request, $id)
    {
        $beneficiar = Beneficiar::where('beneficiary_id', $id)->first();
        return view('admin.beneficiaries.show', ['beneficiary' => $beneficiar]);
    }

    public function update_admin (Request $request, $id)
    {
        $request->validate([
            'reference_id' => 'bail|required|string',
        ]);

        $beneficiar = Beneficiar::where('beneficiary_id', $id)->first();
        $beneficiar->reference_id = $request->reference_id;
        if(!$beneficiar->save()) return redirect(route('BeneficiaryInfoAdmin', $beneficiar->beneficiary_id))->with(['req_error' => 'There is some error!']);

        return redirect(route('AllBeneficiarysAdmin'))->with(['req_success' => 'Beneficiary Updated!']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'bail|required|string',
            'surname' => 'bail|required|string',
            'relation' => 'bail|required|string',
        ]);
        
        $beneficiar = Beneficiar::where('beneficiary_id', $id)->first();
        $beneficiar->name = $request->name;
        $beneficiar->surname = $request->surname;
        if ($request->has('dob') && $request->filled('dob')) {
            $beneficiar->dob = $request->dob;

        }
        $beneficiar->relation = lcfirst($request->relation);
        if(!$beneficiar->save()) return redirect(route('Beneficiaries'))->with(['req_error' => 'There is some error!']);

        return redirect(route('Beneficiaries'))->with(['req_success' => 'Beneficiary Updated!']);
    }
}
