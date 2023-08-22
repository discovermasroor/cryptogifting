<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Contact;
use App\Models\User;
use App\Models\Beneficiar;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::query();
        if ($request->has('relation') && $request->filled('relation')) {
            $contacts->where('relation', lcfirst($request->relation));
        }

        if ($request->has('search') && $request->filled('search')) {
            $contacts->where('name', 'LIKE', '%'.$request->search.'%')->orWhere('surname', 'LIKE', '%'.$request->search.'%');

        }
        if ($request->has('end_date') && $request->filled('end_date') ) {
            $contacts->where('created_at', 'LIKE', '%'.$request->end_date.'%');

        }
        $contacts->where('user_id', request()->user->user_id);
        $contacts->orderBy('id', 'desc');

        if(isset($request->export) && $request->export) {

            $request->validate([
                'contact_list' => 'required',
            ]);

            $contacts = Contact::whereIn('contact_id',$request->contact_list)->get();
            

            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=CG-contact.csv",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );


            $columns = array('Name', 'Surname', 'Email', 'Date of Birth', 'Relationship', 'Date Added');

            $callback = function() use($contacts, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                foreach ($contacts as $contact) {
                    $row['Name']  = $contact->name;
                    $row['Surname']  = $contact->surname;
                    $row['Email'] = $contact->email;
                    $row['Date of Birth'] = $contact->dob;
                    $row['Relationship'] =  $contact->relation;
                    $row['Date Added'] = $contact->created_at;

                    fputcsv($file, array($row['Name'], $row['Surname'], $row['Email'], $row['Date of Birth'], $row['Relationship'], $row['Date Added']));
                }
                fclose($file);
             };

           
        
            return response()->stream($callback, 200, $headers);
           
        }
        return view('user-dashboard.contacts.index', ['contacts' => $contacts->paginate(20)]);
    }

    public function create ()
    {
        return view('user-dashboard.contacts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|string',
            'email' => 'bail|required|email|unique:contacts|unique:users',
            'relation' => 'bail|required|string',
        ]);
        $contact = new Contact;
        $contact->contact_id = (String) Str::uuid();
        $contact->user_id = request()->user->user_id;
        $contact->name = $request->name;
        $contact->surname = $request->surname;
        $contact->email = $request->email;
        if ($request->has('dob') && $request->filled('dob')) $contact->dob = $request->dob;

        $contact->relation = lcfirst($request->relation);
        
        if (!$contact->save()) {
            return redirect(route('Contacts'))->with(['req_error' => 'There is some error!']);

        }
        return redirect(route('Contacts'))->with(['req_success' => 'Contact Added!']);
    }

    public function edit (Request $request, $id)
    {
        $contact = Contact::where('contact_id', $id)->first();
        return view('user-dashboard.contacts.edit', ['contact' => $contact]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'bail|required|string',
            'relation' => 'bail|required|string',
        ]);
        
        $contact = Contact::where('contact_id', $id)->first();
        $contact->name = $request->name;
        $contact->surname = $request->surname;
        if ($request->has('dob') && $request->filled('dob')) $contact->dob = $request->dob;

        $contact->relation = lcfirst($request->relation);
        if(!$contact->save()) return redirect(route('Contacts'))->with(['req_error' => 'There is some error!']);

        return redirect(route('Contacts'))->with(['req_success' => 'Contact Updated!']);
    }

    public function store_csv_only_contacts (Request $request)
    {
        $request->validate([
            'contact_csv' => 'bail|required|file'
        ]);

        try {
            set_time_limit(600000);
            $response = csvToArray($request->contact_csv);

            foreach ($response as $key => $value) {
                if (!isset($value['email']) || empty($value['email'])) continue;

                $contact = Contact::where('email', $value['email'])->first();
                if (!$contact) {
                    $contact = new Contact;
                    $contact->contact_id = (String) Str::uuid();
                    $contact->user_id = request()->user->user_id;
                    $contact->email = $value['email'];

                }

                if (isset($value['name']) && !empty($value['name'])) $contact->name = $value['name'];
                if (isset($value['surname']) && !empty($value['surname'])) $contact->surname = $value['surname'];
                if (isset($value['relationship']) && !empty($value['relationship'])) $contact->relation = lcfirst($value['relationship']);
                if (isset($value['date-of-birth']) && !empty($value['date-of-birth'])) $contact->dob = date('Y-m-d', strtotime($value['date-of-birth']));
                $contact->save();

            }
            return redirect(route('Contacts'))->with(['req_success' => 'Filed contacts created!']);

        } catch (\Exception $e) {
            return redirect(route('Contacts'))->with(['req_error' => $e->getMessage()]);

        }
    }
}