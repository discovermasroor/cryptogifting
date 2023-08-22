<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Beneficiar;
use App\Models\GuestList;
use App\Models\Contact;
use App\Models\ContactGuestList;

class GuestListController extends Controller
{
    public function index(Request $request)
    {
        $guest_lists = GuestList::query();
        $guest_lists->where('creator_id', request()->user->user_id);

        if ($request->has('status') && $request->filled('status')) {
            if (lcfirst($request->status) == 'active') {
                $guest_lists->whereRaw('`flags` & ? = ?', [GuestList::FLAG_ACTIVE , GuestList::FLAG_ACTIVE]);

            } else if (lcfirst($request->status) == 'pending') {
                $guest_lists->whereRaw('`flags` & ? = ?', [GuestList::FLAG_PENDING , GuestList::FLAG_PENDING]);

            } else if (lcfirst($request->status) == 'cancelled') {
                $guest_lists->whereRaw('`flags` & ? = ?', [GuestList::FLAG_CANCELLED , GuestList::FLAG_CANCELLED]);

            } else {
                $guest_lists->whereRaw('`flags` & ? = ?', [GuestList::FLAG_BLOCKED , GuestList::FLAG_BLOCKED]);

            }
        }

        if ($request->has('search') && $request->filled('search')) {
            $guest_lists->where('title', 'LIKE', '%'.$request->search.'%');

        }

        $guest_lists->orderBy('id', 'desc');
        return view('user-dashboard.guest-list.index', ['guest_lists' => $guest_lists->paginate(20)]);
    }

    public function create ()
    {
        $all_beneficiaries = Beneficiar::where('user_id', request()->user->user_id)->get();
        return view('user-dashboard.guest-list.create', ['all_beneficiaries' => $all_beneficiaries]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_description' => 'bail|required|string',
        ]);
        $guest_list = new GuestList;
        $guest_list->guest_list_id = (String) Str::uuid();
        $guest_list->creator_id = request()->user->user_id;
        if ($request->has('beneficiary') && $request->filled('beneficiary')) {
            $guest_list->beneficiary_id = $request->beneficiary;

        } else {
            $guest_list->beneficiary_id = request()->user->user_id;

        }

        $guest_list->title = $request->event_description;
        $guest_list->addFlag(GuestList::FLAG_ACTIVE);

        if(!$guest_list->save()) { 
            return redirect(route('GuestLists'))->with(['req_error' => 'There is some error!']);
            
        }else {
             $guest_list = GuestList::latest()->first();

            return redirect(route('GuestLists'))->with(['req1_success' =>'You have now created your guest list.', 'guest_list' => $guest_list]);
        }
    }

    public function edit (Request $request, $id)
    {
        $guest_list = GuestList::where('guest_list_id', $id)->with(['beneficiary'])->first();
        $all_beneficiaries = Beneficiar::where('user_id', request()->user->user_id)->get();
        return view('user-dashboard.guest-list.edit', ['guest_list' => $guest_list, 'all_beneficiaries' => $all_beneficiaries]);
    }

    public function add_contacts_in_guest_list_view (Request $request, $id)
    {
        $data = array();
        $existing_users_array = ContactGuestList::where('guest_list_id', $id)->pluck('contact_id');
        $data['all_contacts'] = Contact::where('user_id', request()->user->user_id)->whereNotIn('contact_id', $existing_users_array)->orderBy('id','DESC')->get();
        $data['existing_users'] = ContactGuestList::where('guest_list_id', $id)->with(['contact_user'])->orderBy('id','DESC')->get();
        $data['guest_list'] = GuestList::where('guest_list_id', $id)->first();
        // return $data; 
        return view('user-dashboard.guest-list.add-contacts', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'bail|required|string',
            'status' => 'bail|required|string',
        ]);
     

        $guest_list = GuestList::where('guest_list_id', $id)->first();
        if ($request->has('beneficiary') && $request->filled('beneficiary')) $guest_list->beneficiary_id = $request->beneficiary;

        $guest_list->title = $request->title;
       
        $guest_list->removeFlag(GuestList::FLAG_ACTIVE);
        $guest_list->removeFlag(GuestList::FLAG_CANCELLED);
        $guest_list->removeFlag(GuestList::FLAG_PENDING);
        $guest_list->removeFlag(GuestList::FLAG_BLOCKED);

        if ($request->status == "Published") {
              //dd($request->all());
            $guest_list->addFlag(GuestList::FLAG_ACTIVE);

        } else if ($request->status == 'Pending') {

            $guest_list->addFlag(GuestList::FLAG_PENDING);

        } else if ($request->status == 'Cancelled') {
            $guest_list->addFlag(GuestList::FLAG_CANCELLED);

        } else {
            $guest_list->addFlag(GuestList::FLAG_BLOCKED);

        }

        if(!$guest_list->save()) return redirect(route('GuestLists'))->with(['req_error' => 'There is some error!']);

        return redirect(route('GuestLists'))->with(['req_success' => 'Guest List Updated!']);
    }

    public function destroy($id)
    {
        ContactGuestList::where('guest_list_id', $id)->delete();
        GuestList::where('guest_list_id', $id)->delete();
        return redirect(route('GuestLists'))->with(['req_success' => 'Guest List Deleted!']);
    }
}
