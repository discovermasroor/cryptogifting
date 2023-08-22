<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\GuestList;
use App\Models\Contact;
use App\Models\User;
use App\Models\ContactGuestList;

class ContactGuestListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_csv(Request $request)
    {
        $request->validate([
            'contact_csv' => 'bail|required|file'
        ]);

        $guest_list = $request->guest_list;
        try {
            set_time_limit(600000);
            $response = csvToArray($request->contact_csv);

            foreach ($response as $key => $value) {
                $found = Contact::where('email', $value['email'])->first();
                if ($found) {
                    $guest_list_found = ContactGuestList::where('guest_list_id', $guest_list)->where('contact_id', $found->contact_id)->first();
                    if ($guest_list_found) {
                        continue;
                    }
                    $contact_guest_list = new ContactGuestList;
                    $contact_guest_list->contact_guest_list_id = (String) Str::uuid();
                    $contact_guest_list->guest_list_id = $guest_list;
                    $contact_guest_list->contact_id = $found->contact_id;
                    if (!$contact_guest_list->save()) {
                        return redirect(route('AddContactsInGuestListView', [$guest_list]))->with(['req_error' => 'There is some error!']);

                    }

                } else {
                    $contact = new Contact;
                    $contact->contact_id = (String) Str::uuid();
                    $contact->user_id = request()->user->user_id;
                    $contact->name = $value['name'];
                    $contact->surname = $value['surname'];
                    $contact->email = $value['email'];
                    $contact->dob = $value['date-of-birth'];
                    $contact->relation = lcfirst($value['relation']);
                    if($contact->save()) {
                        $found = User::where('email', $contact->email)->first();
                        if (!$found) {
                            $user = new User;
                            $user->user_id = $contact->contact_id;;
                            $user->username = explode('@', $contact->email)[0].rand(1000, 9999);
                            $user->email = $contact->email;
                            $user->password = Hash::make($contact->email);
                            $user->first_name = $contact->name;
                            $user->last_name = $contact->surname;
                            $user->addFlag(User::FLAG_CUSTOMER);
                            $user->addFlag(User::FLAG_EMAIL_VERIFIED);
                            $user->addFlag(User::FLAG_ADDED_BY_CONTACT);

                            if (!$user->save()) return redirect(route('AddContactsInGuestListView', [$guest_list]))->with(['req_error' => 'There is some error!']);
                        }

                        $contact_guest_list = new ContactGuestList;
                        $contact_guest_list->contact_guest_list_id = (String) Str::uuid();
                        $contact_guest_list->guest_list_id = $guest_list;
                        $contact_guest_list->contact_id = $contact->contact_id;
                        if (!$contact_guest_list->save()) {
                            return redirect(route('AddContactsInGuestListView', [$guest_list]))->with(['req_error' => 'There is some error!']);
    
                        }
                    } else {
                        return redirect(route('AddContactsInGuestListView', [$guest_list]))->with(['req_error' => 'There is some error!']);
                    }
                }
            }
            return redirect(route('AddContactsInGuestListView', [$guest_list]))->with(['req_success' => 'Filed contacts created and added in guest list!']);

        } catch (\Exception $e) {
            return redirect(route('AddContactsInGuestListView', [$guest_list]))->with(['req_error' => $e->getMessage()]);

        }
    }

    public function store_in_guest_list(Request $request, $id)
    {
        $request->validate([
            'contacts' => 'required'
        ]);
        foreach ($request->contacts  as $key => $value) {
            $contact_guest_list = new ContactGuestList;
            $contact_guest_list->contact_guest_list_id = (String) Str::uuid();
            $contact_guest_list->guest_list_id = $id;
            $contact_guest_list->contact_id = $value;
            if (!$contact_guest_list->save()) {
                return redirect(route('AddContactsInGuestListView', [$id]))->with(['req_error' => 'There is some error!']);

            }
        }
        return redirect(route('AddContactsInGuestListView', [$id]))->with(['req_success' => 'Contacts added in guest list!']);
    }

    public function delete_from_guest_list(Request $request, $id)
    {
        // return $request->all();
        $request->validate([
            'contacts' => 'required'
        ]);
        $result = ContactGuestList::whereIn('contact_guest_list_id', $request->contacts)->delete();
        if ($result) {
            return redirect(route('AddContactsInGuestListView', [$id]))->with(['req_success' => 'Contacts deleted from guest list!']);

        }
        return redirect(route('AddContactsInGuestListView', [$id]))->with(['req_error' => 'There is some error!']);
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
