<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Models\Event;
use App\Models\EventTheme;
use App\Models\EventBeneficiar;
use App\Models\GuestList;
use App\Models\EventGuestGroup;
use App\Models\Notifications;
use App\Models\NotificationUser;
use App\Models\User;
use App\Models\Contact;
use App\Models\ContactGuestList;
use App\Models\Beneficiar;
use App\Models\EventAcceptance;
use App\Models\Setting;
use App\Models\UserWallet;
use App\Mail\SendEventInvite;

class EventController extends Controller
{
    public function invited_events (Request $request)
    {
        $data['live_events'] = '';
        $all_guest_lists = ContactGuestList::where('contact_id', request()->user->user_id)->pluck('guest_list_id')->toArray();
        if (!empty($all_guest_lists)) {
            $all_events = EventGuestGroup::whereIn('guest_list_id', $all_guest_lists)->pluck('event_id')->toArray();
            if (!empty($all_events)) {
                $live_events = Event::query();
                $live_events->whereIn('event_id', $all_events);
                $live_events->whereRaw('`flags` & ? = ?', [Event::FLAG_LIVE, Event::FLAG_LIVE]);
                $live_events->orderBy('id', 'desc');
                $data['live_events'] = $live_events->paginate(10);
                return view('user-dashboard.events.invited-events', $data);
            }
        }
        return view('user-dashboard.events.invited-events', $data);
    }

    public function index()
    {
        $data = array();
        $live_events = Event::query();
        $live_events->where('creator_id', request()->user->user_id);
        $live_events->whereRaw('`flags` & ? = ?', [Event::FLAG_LIVE, Event::FLAG_LIVE]);
        $live_events->orderBy('id', 'desc');
        $data['live_events'] = $live_events->paginate(10);

        $unpublished_events = Event::query();
        $unpublished_events->where('creator_id', request()->user->user_id);
        $unpublished_events->whereRaw('`flags` & ? = ?', [Event::FLAG_UNPUBLISHED, Event::FLAG_UNPUBLISHED]);
        $unpublished_events->orderBy('id', 'desc');
        $data['unpublished_events'] = $unpublished_events->paginate(10);

        $cancelled_events = Event::query();
        $cancelled_events->where('creator_id', request()->user->user_id);
        $cancelled_events->whereRaw('`flags` & ? = ?', [Event::FLAG_CANCELLED, Event::FLAG_CANCELLED]);
        $cancelled_events->orderBy('id', 'desc');
        $data['cancelled_events'] = $cancelled_events->paginate(10);

        $past_events = Event::query();
        $past_events->where('creator_id', request()->user->user_id);
        $past_events->whereRaw('`flags` & ? = ?', [Event::FLAG_PAST, Event::FLAG_PAST]);
        $past_events->orderBy('id', 'desc');
        $data['past_events'] = $past_events->paginate(10);

        return view('user-dashboard.events.index', $data);
    }

    public function index_transaction(Request $request)
    {

        $curl = curl_init('https://api.valr.com/v1/public/marketsummary');
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.valr.com/v1/public/marketsummary',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        if (!empty($response)) {
            $btc_rate = 0;
            foreach ($response as $key => $value) {
                if ($value->currencyPair == 'BTCZAR') {
                    $btc_rate = $value->lastTradedPrice;
                    break;
                }
            }
        }
        $data = array();
        if ($request->has('search') && $request->filled('search')) {
            $benefs = Beneficiar::where('user_id', request()->user->user_id)->where('name', 'LIKE', '%'.$request->search.'%')->orWhere('surname', 'LIKE', '%'.$request->search.'%')->pluck('beneficiary_id')->toArray();

        }else {
            $benefs = Beneficiar::where('user_id', request()->user->user_id)->pluck('beneficiary_id')->toArray();

        }
        
        $date_array = array();
        $month_array = array();

        for ($i=0; $i<12; $i++) {
            $date_array[$i]['start_date'] = date('Y-m-1', strtotime('-'.$i.' month'));
            $date_array[$i]['end_date'] = date('Y-m-31', strtotime('-'.$i.' month'));
            $month_array[$i] = date('M', strtotime('-'.$i.' month'));

        }
        $all_months = array_reverse($month_array);
        $data['month_data'] = json_encode($all_months);
        $date_array = array_reverse($date_array);

        $events = EventAcceptance::query();
        $events->whereIn('beneficiary_id', $benefs);

        if ($request->has('gift_type') && $request->filled('gift_type')) {
            $gift_type = urldecode($request->gift_type);
            if ($gift_type == 'Create Event') {
                $events->where('event_id', '!=', NULL)->where('gifter_event_id', '=', NULL);
                foreach ($date_array as $key => $value) {
                    $amounts[] = EventAcceptance::whereIn('beneficiary_id', $benefs)->where('event_id', '!=', NULL)->where('gifter_event_id', '=', NULL)->whereBetween('created_at', [$value['start_date'].' 00:00:00', $value['end_date'].' 23:59:59'])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->sum('amount');
        
                }
                $data['graph_data'] = json_encode($amounts);

            } else if ($gift_type == 'Email to Email') {
                $events->where('event_id', '=', NULL)->where('gifter_event_id', '!=', NULL);
                foreach ($date_array as $key => $value) {
                    $amounts[] = EventAcceptance::whereIn('beneficiary_id', $benefs)->where('event_id', '=', NULL)->where('gifter_event_id', '!=', NULL)->whereBetween('created_at', [$value['start_date'].' 00:00:00', $value['end_date'].' 23:59:59'])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->sum('amount');
        
                }
                $data['graph_data'] = json_encode($amounts);

            } else {
                $events->where('event_id', '=', NULL)->where('gifter_event_id', '=', NULL);
                foreach ($date_array as $key => $value) {
                    $amounts[] = EventAcceptance::whereIn('beneficiary_id', $benefs)->where('event_id', '=', NULL)->where('gifter_event_id', '=', NULL)->whereBetween('created_at', [$value['start_date'].' 00:00:00', $value['end_date'].' 23:59:59'])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->sum('amount');
        
                }
                $data['graph_data'] = json_encode($amounts);

            }
            // $events->where('name', 'LIKE', '%'.$request->search.'%')->orWhere('hosted_by', 'LIKE', '%'.$request->search.'%')->orWhere('description', 'LIKE', '%'.$request->search.'%')->orWhere('attire', 'LIKE', '%'.$request->search.'%')->orWhere('location', 'LIKE', '%'.$request->search.'%');

        } else {
            foreach ($date_array as $key => $value) {
                $amounts[] = EventAcceptance::whereIn('beneficiary_id', $benefs)->whereBetween('created_at', [$value['start_date'].' 00:00:00', $value['end_date'].' 23:59:59'])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->sum('amount');
    
            }
            $data['graph_data'] = json_encode($amounts);
        }

        if ($request->has('month') && $request->filled('month')) {
            $events->where('created_at', 'LIKE', '%'.$request->month.'%');

        }

        
        $events->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID]);
        $data['zar_sum'] = array_sum($amounts);
        $data['total_gifts'] = EventAcceptance::whereIn('beneficiary_id', $benefs)->whereRaw('`flags` & ? = ? ', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ? = ? ', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->count();
        $data['recieved_till_date_zar_sum'] = EventAcceptance::whereIn('beneficiary_id', $benefs)->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->sum('amount');
       
        $data['average_amount_per_gift'] = EventAcceptance::whereIn('beneficiary_id', $benefs)->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT])->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID])->average('amount');
        $data['recieved_till_date_btc_sum'] = 0;
        if ($data['recieved_till_date_zar_sum'] > 0) {
            $data['recieved_till_date_btc_sum'] = $data['recieved_till_date_zar_sum'] / $btc_rate;

        }

        $amount_in_btc = 0;
        $amount_in_zar = 0;
        $data['user_wallet_btc'] = 0;
        $data['user_wallet_zar'] = 0;

        $wallet_found = false;
        $wallet_withdrawal_found = false;
        
        $withdrawal_amount_in_btc = 0;
        $withdrawal_amount_in_zar = 0;
            $wallets = UserWallet::where('beneficiary_id', request()->user->user_id)->where('mode','add')->get();
            foreach ($wallets as $wallet) { 
                if ($wallet) {
                    $amount_in_btc += $wallet->final_amount;
                    $amount_in_zar += $wallet->paid_amount;
                    $wallet_found = true;
                }
            }

            $wallet_withdrawals = UserWallet::where('beneficiary_id', request()->user->user_id)->where('mode','withdrawal')->get();
            foreach ($wallet_withdrawals as $wallet_withdrawal) { 
                if ($wallet_withdrawal) {
                    $withdrawal_amount_in_btc += $wallet_withdrawal->final_amount;
                    $withdrawal_amount_in_zar += $wallet_withdrawal->paid_amount;
                    $wallet_withdrawal_found = true;
                }
            }
            
       
        if ($wallet_found) {
              $data['user_wallet_btc'] = $amount_in_btc;
              $data['user_wallet_zar'] = $amount_in_zar;
                    
        }else if($wallet_withdrawal_found) {
            $data['user_wallet_btc'] = $data['user_wallet_btc'] - $withdrawal_amount_in_btc;
            $data['user_wallet_zar'] = $data['user_wallet_zar'] - $withdrawal_amount_in_zar;
        }
       
        $events->orderBy('id', 'desc');
        $events->with(['event_info', 'transaction_details']);
        $data['events'] = $events->paginate(20);
        // return $data;
        return view('user-dashboard.reports.transactions', $data);
    }

    public function index_transaction_admin (Request $request)
    {
        $data = array();
        $events_acceptance = EventAcceptance::query();
        $events_acceptance->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_AMOUNT_GIFT, EventAcceptance::FLAG_AMOUNT_GIFT]);

        if ($request->has('start_date') && $request->filled('start_date') && $request->has('end_date') && $request->filled('end_date') ) {
            $events_acceptance->whereBetween('created_at', [$request->start_date.' 00:00:00', $request->end_date.' 23:59:59']);

        }

        if ($request->has('filter_status') && $request->filled('filter_status')) {
            if ($request->filter_status == 'Yes') {
                $events_acceptance->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_SENT_TO_EXCHANGE, EventAcceptance::FLAG_SENT_TO_EXCHANGE]);

            } else {
                $events_acceptance->whereRaw('`flags` & ?!=?', [EventAcceptance::FLAG_SENT_TO_EXCHANGE, EventAcceptance::FLAG_SENT_TO_EXCHANGE]);

            }
        }
        
        if ($request->has('transaction_id') && $request->filled('transaction_id')) {
            $events_acceptance->where('event_acceptance_id', $request->transaction_id);

        }
        if ($request->has('export') && $request->filled('export') && $request->export == '1' && $request->has('transactions_list') && $request->filled('transactions_list')) {
            $events_acceptance->whereIn('event_acceptance_id', $request->transactions_list);
            $events_acceptance->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_PAID, EventAcceptance::FLAG_PAID]);
            $events_acceptance->with(['beneficiary','transaction_details']);
            foreach ($events_acceptance->get() as $gift) {
                $event_acc = EventAcceptance::where('event_acceptance_id', $gift->event_acceptance_id)->first();
                $event_acc->removeFlag(EventAcceptance::FLAG_SENT_TO_EXCHANGE);
                $event_acc->addFlag(EventAcceptance::FLAG_SENT_TO_EXCHANGE);
                $event_acc->save();

            }

            $events_acceptance->whereRaw('`flags` & ?=?', [EventAcceptance::FLAG_SENT_TO_EXCHANGE, EventAcceptance::FLAG_SENT_TO_EXCHANGE]);
            $events_acceptance->whereRaw('`flags` & ?!=?', [EventAcceptance::FLAG_COMPLETE_TRANSACTION, EventAcceptance::FLAG_COMPLETE_TRANSACTION]);

            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=CG-transaction-".$request->start_date."_".$request->end_date.".csv",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );

            //$columns = array('beneficiary_id', 'valr_account_id', 'amount', 'date');
            $columns = array();
            $valr_branch_code = Setting::where('keys','valr_branch_code')->first();
            $valr_account = Setting::where('keys','valr_account_number')->first();

            $callback = function() use($events_acceptance, $columns, $request, $valr_branch_code, $valr_account) {
                $file = fopen('php://output', 'w');

                foreach ($events_acceptance->get() as $task) {
                    // $str = sprintf($task->beneficiary->valr_account_id."%c", 9);
                    if (empty($task->beneficiary->reference_id)) continue;

                    $row['valr_branch_code']  = $valr_branch_code->values;
                    $row['valr_account']  = $valr_account->values;
                    $row['amount'] = $task->amount_tax;
                    $row['beneficiary_id'] = $task->beneficiary->beneficiary_id;
                    $row['benef_payment_ref'] = $task->beneficiary->reference_id;
                    $row['valr_name'] = 'VALR';

                    fputcsv($file, array($row['valr_branch_code'], $row['valr_account'], $row['amount'], $row['benef_payment_ref'], $row['beneficiary_id'], $row['valr_name']));
                }

                fclose($file);
            };
            return response()->stream($callback, 200, $headers);

        } else if ($request->has('transactions_list') && $request->filled('transactions_list') && !empty($request->transactions_list) && $request->has('status') && $request->filled('status') && ($request->status == 'Yes' || $request->status == 'No')) {
            $requested_events = EventAcceptance::whereIn('event_acceptance_id', $request->transactions_list)->get();
            foreach ($requested_events as $gift) {
                $event_acc = EventAcceptance::where('event_acceptance_id', $gift->event_acceptance_id)->first();
                $event_acc->removeFlag(EventAcceptance::FLAG_SENT_TO_EXCHANGE);
                if ($request->status == 'Yes') {
                    $event_acc->addFlag(EventAcceptance::FLAG_SENT_TO_EXCHANGE);

                }
                $event_acc->save();
            }
        }

        $events_acceptance->with(['event_info','beneficiary','gift_event_info']);
        $data['transactions'] = $events_acceptance->orderBy('id','DESC')->paginate(30);

        return view('admin.reports.transactions', $data);
    }

    public function event_details(Request $request, $id)
    {
        $event = Event::where('event_id', $id)->first();
        if ($event) {
            $gifts = EventAcceptance::where('event_id', $event->event_id)->with(['transaction_details'])->paginate(20);
            return view('user-dashboard.reports.event-info', ['event' => $event, 'gifts' => $gifts]);

        }
        return redirect(route('EventsTransactions'))->with(['req_error' => 'No event found against given id']);
    }

    public function event_details_admin(Request $request, $id)
    {
        $event = Event::where('event_id', $id)->first();
        if ($event) {
            $gifts = EventAcceptance::where('event_id', $event->event_id)->paginate(20);
            return view('admin.reports.event-info', ['event' => $event, 'gifts' => $gifts]);
        }
        return redirect(route('EventsTransactionsAdmin'))->with(['req_error' => 'No event found against given id']);
    }
    
    public function index_admin(Request $request)
    {
        $data = array();
        $events = Event::query();
        if ($request->has('status') && $request->filled('status')) {
            if (lcfirst($request->status) == 'live') {
                $events->whereRaw('`flags` & ? = ?', [Event::FLAG_LIVE , Event::FLAG_LIVE]);

            } else if (lcfirst($request->status) == 'unpublished') {
                $events->whereRaw('`flags` & ? = ?', [Event::FLAG_UNPUBLISHED , Event::FLAG_UNPUBLISHED]);

            } else if (lcfirst($request->status) == 'cancelled') {
                $events->whereRaw('`flags` & ? = ?', [Event::FLAG_CANCELLED , Event::FLAG_CANCELLED]);

            } else {
                $events->whereRaw('`flags` & ? = ?', [Event::FLAG_PAST , Event::FLAG_PAST]);

            }
        }

        if ($request->has('search') && $request->filled('search')) {
            $events->where('name', 'LIKE', '%'.$request->search.'%')->orWhere('hosted_by', 'LIKE', '%'.$request->search.'%')->orWhere('description', 'LIKE', '%'.$request->search.'%')->orWhere('attire', 'LIKE', '%'.$request->search.'%')->orWhere('location', 'LIKE', '%'.$request->search.'%');

        }

        if ($request->has('month') && $request->filled('month')) {
            $events->whereBetween('event_date', [date('Y', time()).'-'.$request->month.'-1', date('Y', time()).'-'.$request->month.'-31']);

        }
        if ($request->has('event_type') && $request->filled('event_type')) {
            if (urldecode($request->event_type) == 'No Event') {
                $events->where('type', 'no_event');

            } else {
                $events->where('type', lcfirst($request->event_type));

            }
        }
        $events->orderBy('id', 'desc');
        $data['events'] = $events->paginate(20);
        return view('admin.events.index', $data);
    }

    public function create ()
    {
        return view('user-dashboard.events.create');
    }

    public function event_link_view ($id)
    {
        if ($id == request()->user->user_id) {
            return view('user-dashboard.events.link', ['user' => request()->user->user_id, 'beneficiary' => '']);

        } else {
            $benef = Beneficiar::where('beneficiary_id', $id)->first();
            return view('user-dashboard.events.link', ['user' => '', 'beneficiary' => $benef]);

        }
    }

    public function add_beneficiaries (Request $request)
    {
        $request->validate([
            'users' => 'bail|required',
        ]);
        session(['event_beneficiars'=> $request->users]);
        return redirect(route('CreateEvent', [$request->users]))->with(['req_success' => 'You have selected a beneficiary for your event']);
    }

    public function select_theme (Request $request)
    {
        $request->validate([
            'theme' => 'bail|required|string',
            'user_id' => 'bail|required|string'
        ]);
        session(['event_theme'=> $request->theme]);
        return redirect(route('AddDetailsForEvent', [$request->theme]))->with(['req_success' => 'Theme card selected']);
    }
     
    public function add_details (Request $request, $id)
    {
        $theme = EventTheme::where('theme_id', $id)->first();
        return view('user-dashboard.events.add-event-details', ['theme' => $theme]);
    }

    public function store_details(Request $request)
    {
        $request->validate([
            'event_theme' => 'bail|required|string',
            'event_name' => 'bail|required|string',
            'hosted_by' => 'bail|required|string',
            'event_date' => 'bail|required|date',
            'event_details' => 'bail|required|string',
            'location' => 'bail|required|string',
            'event_type' => 'bail|required|string',
            'attire_name' => 'bail|required|string',
        ]);
        $beneficiary_id = session()->get('event_beneficiars');
      
        $event = new Event;
        $event->event_id = (String) Str::uuid();
        $event->creator_id = request()->user->user_id;
        $event->theme_id = $request->event_theme;
        $event->name = $request->event_name;
        $event->hosted_by = $request->hosted_by;
        $event->beneficiary_id = $beneficiary_id;
        $event->event_date = $request->event_date;
        $event->description = $request->event_details;
        $event->location = $request->location;
        $event->type = $request->event_type;
        $event->attire = $request->attire_name;
        $event->addFLag(Event::FLAG_UNPUBLISHED);

        if(!$event->save()) {
            return redirect(route('AddDetailsForEvent'))->with(['req_error' => 'There is some error!']);

        }

        $notif = new Notifications;
        $notif->notification_id = (String) Str::uuid();
        $notif->event_id = $event->event_id;
        $notif->heading = 'Event is created!';
        $notif->text = 'A new event is created by '.$request->hosted_by.'. Kindly click and check it out!';
        $notif->save();

       
        return redirect(route('ShareEventView', [$event->event_id]))->with(['req_success' => 'Your event information has been successfully saved']);
    }

    public function allocate_amount_view (Request $request, $id)
    {
        return view('user-dashboard.events.allocate-event-amount', ['id' => $id]);
    }

    public function allocate_event_amount(Request $request, $id)
    {
        $request->validate([
            'bitcoin_allocation' => 'bail|required',
            'ethirium_allocation' => 'bail|required',
        ]);

        $event = Event::where('event_id', $id)->first();
        $event->bitcoin_allocation = $request->bitcoin_allocation;
        $event->ethirium_allocation = $request->ethirium_allocation;
        if (!$event->save()) return redirect(route('AllocateAmountView', [$event->event_id]))->with(['req_error' => 'There is some error!']);

        return redirect(route('ShareEventView', [$id]))->with(['req_success' => 'Bitcoin and Eherium allocation percentage saved! Now lets move to step 3.']);
    }

    public function share_event_view ($id)
    {
        $event = Event::where('event_id', $id)->first();
        if ($event->beneficiary_id) {
            $guest_lists = GuestList::where('beneficiary_id', $event->beneficiary_id)->get();

        } else {
            $guest_lists = GuestList::where('beneficiary_id', $event->creator_id)->where('beneficiary_id', '=', NULL)->get();

        }
        return view('user-dashboard.events.share-event', ['event_id' => $id, 'guest_lists' => $guest_lists]);
    }

    public function event_preview_for_guest (Request $request, $event_id)
    {
        $event = Event::where('event_id', $event_id)->with(['event_theme'])->first();
        return view('event-preview', ['event' => $event]);
    }

    public function store_guest_lists_for_event (Request $request, $id)
    {
        $request->validate([
            'guest_lists' => 'bail|required|array'
        ]);

        session()->forget('event_beneficiars');
        session()->forget('event_theme');

        $event = Event::where('event_id', $id)->with(['event_creator'])->first();
        $event->removeFlag(Event::FLAG_LIVE);
        $event->removeFlag(Event::FLAG_UNPUBLISHED);
        $event->removeFlag(Event::FLAG_CANCELLED);
        $event->removeFlag(Event::FLAG_PAST);
        $event->addFlag(Event::FLAG_LIVE);
        $event->save();

        $notif = Notifications::where('event_id', $event->event_id)->first();
        NotificationUser::where('notification_id', $notif->notification_id)->delete();
        EventGuestGroup::where('event_id', $id)->delete();

        foreach ($request->guest_lists as $key => $value) {
            $event_gl = new EventGuestGroup;
            $event_gl->event_guest_group_id = (String) Str::uuid();
            $event_gl->event_id = $id;
            $event_gl->guest_list_id = $value;
            if (!$event_gl->save()) return redirect(route('ShareEventView', [$id]))->with(['req_error' => 'There is some error!']);

        }
        $contact_ids = ContactGuestList::whereIn('guest_list_id', $request->guest_lists)->pluck('contact_id')->toArray();
        if (!empty($contact_ids)) {
            $all_user_ids = User::whereIn('user_id', $contact_ids)->pluck('user_id')->toArray();

            if (!empty($all_user_ids)) {
                foreach($all_user_ids as $key => $value) {
                    $user_notif = new NotificationUser;
                    $user_notif->notification_user_id = (String) Str::uuid();
                    $user_notif->notification_id = $notif->notification_id;
                    $user_notif->user_id = $value;
                    $user_notif->save();

                }
                $users = User::whereRaw('`flags` & ? = ?', [User::FLAG_ADMIN, User::FLAG_ADMIN])->get();
                foreach ($users as $key => $value) {
                    $user_notif = new NotificationUser;
                    $user_notif->notification_user_id = (String) Str::uuid();
                    $user_notif->notification_id = $notif->notification_id;
                    $user_notif->user_id = $value->user_id;
                    $user_notif->save();
                }

                $all_user_emails = User::whereIn('user_id', $contact_ids)->pluck('email');
                $first_email = $all_user_emails[0];
                unset($all_user_emails[0]);
                Mail::to($first_email)->cc($all_user_emails)->send(new SendEventInvite($event));

            }
            return redirect(route('EventPreviewSelf', [$id]))->with(['req_success' => 'Event Successfully Created!']);
        }
        return redirect(route('EventPreviewSelf', [$id]))->with(['req_success' => 'Event Successfully Created. Guest list added for event!']);
    }

    public function store_guest_lists_for_event_new (Request $request, $id)
    {
        $request->validate([
            'guest_lists' => 'required|array'
        ]);

         $event = Event::where('event_id', $id)->with(['event_creator'])->first();

        $notif = Notifications::where('event_id', $event->event_id)->first();
       
        EventGuestGroup::where('event_id', $id)->delete();
        
        if ($request->has('guest_lists') && !empty($request->guest_lists)) {
            foreach ($request->guest_lists as $key => $value) {
                $event_gl = new EventGuestGroup;
                $event_gl->event_guest_group_id = (String) Str::uuid();
                $event_gl->event_id = $id;
                $event_gl->guest_list_id = $value;
                if (!$event_gl->save()) return redirect(route('ShareEventView', [$id]))->with(['req_error' => 'There is some error!']);
    
            }
            
        }
        return redirect(route('EventPreviewSelf', [$id]))->with(['req_success' => 'You have selected your guest list for this event']);
    }

    public function save_event(Request $request) {
        $event = Event::where('event_id', $request->id)->with(['event_creator'])->first();
        $event->removeFlag(Event::FLAG_LIVE);
        $event->removeFlag(Event::FLAG_UNPUBLISHED);
        $event->removeFlag(Event::FLAG_CANCELLED);
        $event->removeFlag(Event::FLAG_PAST);
        $event->addFlag(Event::FLAG_LIVE);
        $event->save();

        $notif = Notifications::where('event_id', $event->event_id)->first();
        NotificationUser::where('notification_id', $notif->notification_id)->delete();
         $guest_lists = EventGuestGroup::where('event_id', $request->id)->get()->pluck('guest_list_id');

        if ($guest_lists && !empty($guest_lists)) {
            
            $contact_ids = ContactGuestList::whereIn('guest_list_id', $guest_lists)->pluck('contact_id')->toArray();
            if (!empty($contact_ids)) {
                 $all_user_ids = User::whereIn('user_id', $contact_ids)->pluck('user_id')->toArray();
    
                if (!empty($all_user_ids)) {
                    foreach($all_user_ids as $key => $value) {
                        $user_notif = new NotificationUser;
                        $user_notif->notification_user_id = (String) Str::uuid();
                        $user_notif->notification_id = $notif->notification_id;
                        $user_notif->user_id = $value;
                        $user_notif->save();
    
                    }
                    $users = User::whereRaw('`flags` & ? = ?', [User::FLAG_ADMIN, User::FLAG_ADMIN])->get();
                    foreach ($users as $key => $value) {
                        $user_notif = new NotificationUser;
                        $user_notif->notification_user_id = (String) Str::uuid();
                        $user_notif->notification_id = $notif->notification_id;
                        $user_notif->user_id = $value->user_id;
                        $user_notif->save();
                    }
    
                    $all_user_emails = User::whereIn('user_id', $contact_ids)->pluck('email');
                    
                    foreach ($all_user_emails as $all_user_email) { 
                        Mail::to($all_user_email)->send(new SendEventInvite($event));

                    }

                }
            }
        }
        return api_success1('Mails');
    }

    public function self_event_preview(Request $request, $id)
    {
        $event = Event::where('event_id', $id)->with(['event_theme'])->first();    
        return view('user-dashboard.events.preview', ['event' => $event, 'id' => $id]);
    }

    public function event_preview(Request $request, $id)
    {
        $event = Event::where('event_id', $id)->with(['event_theme'])->first();
        if (request()->user) {
            return view('user-dashboard.events.preview-contact', ['event' => $event]);

        }
        session(['event_preview_id' => $id]);
        return redirect(route('SignIn'))->with(['req_error' => 'Kindly signin first to see the event!']);
    }

    public function contact_event_pay (Request $request, $event_id)
    {
        $request->validate([
            'rsvp' => 'bail|required|string',
            'contact_email' => 'bail|required|string',
            'contact_name' => 'bail|required|string'
        ]);
        $event = Event::where('event_id', $event_id)->first();
        $contact = Contact::where('email', $request->contact_email)->where('user_id', $event->creator_id)->first();

        if (!$contact) {
            return redirect()->back()->with(['req_error' => 'We didn\'t find your email in our records!']);

        }
        session()->put('contact_name', $request->contact_name);

        $all_guest_lists = EventGuestGroup::where('event_id', $event->event_id)->pluck('guest_list_id')->toArray();
        if (empty($all_guest_lists)) {
            return redirect()->back()->with(['req_error' => 'You are not invited in this event!']);

        }
        $found = ContactGuestList::whereIn('guest_list_id', $all_guest_lists)->where('contact_id', $contact->contact_id)->first();
        if ($found) {
            return redirect(route('ContactEventPayView', [$event->event_id, $contact->contact_id]));

        }
        return redirect()->back()->with(['req_error' => 'There is some error!']);
    }

    public function contact_event_pay_view ($event_id, $contact_id)
    {
        $platform_fee_gift = Setting::where('keys', 'platform_fee_gift')->first();
        $platform_fee_gift_type = Setting::where('keys', 'platform_fee_gift_type')->first();
        $valr_maker_gifter = Setting::where('keys', 'valr_maker_gifter')->first();
        $valr_maker_gifter_type = Setting::where('keys', 'valr_maker_gifter_type')->first();
        $callpay_handling_fee_gifter = Setting::where('keys', 'callpay_handling_fee_gifter')->first();
        $callpay_handling_fee_gifter_type = Setting::where('keys', 'callpay_handling_fee_gifter_type')->first();
        $callpay_contigency_fee_gifter = Setting::where('keys', 'callpay_contigency_fee_gifter')->first();
        $callpay_contigency_fee_gifter_type = Setting::where('keys', 'callpay_contigency_fee_gifter_type')->first();
        $vat_tax_gift = Setting::where('keys', 'vat_tax_gift')->first();
        $vat_tax_gift_type = Setting::where('keys', 'vat_tax_gift_type')->first();

        $event = Event::where('event_id', $event_id)->first();
        $curl = curl_init('https://api.valr.com/v1/public/marketsummary');
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.valr.com/v1/public/marketsummary',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        if (!empty($response)) {
            $btc_rate = 0;
            foreach ($response as $key => $value) {
                if ($value->currencyPair == 'BTCZAR') {
                    $btc_rate = $value->lastTradedPrice;
                    break;
                }
            }
        }

        return view('event-pay-user', ['event' => $event, 'btc_rate' => $btc_rate, 'contact_id' => $contact_id, 'platform_fee_gift' => $platform_fee_gift->values, 'platform_fee_gift_type' => $platform_fee_gift_type->values, 'valr_maker_gifter' => $valr_maker_gifter->values, 'valr_maker_gifter_type' => $valr_maker_gifter_type->values, 'callpay_handling_fee_gifter' => $callpay_handling_fee_gifter->values, 'callpay_handling_fee_gifter_type' => $callpay_handling_fee_gifter_type->values, 'callpay_contigency_fee_gifter' => $callpay_contigency_fee_gifter->values, 'callpay_contigency_fee_gifter_type' => $callpay_contigency_fee_gifter_type->values, 'vat_tax_gift' => $vat_tax_gift->values, 'vat_tax_gift_type' => $vat_tax_gift_type->values]);

    }
    public function edit($id)
    {
        $event = Event::where('event_id', $id)->first();
        return view('user-dashboard.events.edit', ['event' => $event]);
    }

    public function show_admin($id)
    {
        $event = Event::where('event_id', $id)->with(['event_creator'])->first();
        if ($event) {
            $gifts = EventAcceptance::where('event_id', $event->event_id)->paginate(20);
            return view('admin.events.show', ['event' => $event, 'gifts' => $gifts]);
        }
        return redirect(route('AllEventsAdmin'))->with(['req_error' => 'No event found against given id']);
    }

    public function cancel_event ($id)
    {
        $event = Event::where('event_id', $id)->first();
        $event->removeFlag(Event::FLAG_LIVE);
        $event->removeFlag(Event::FLAG_UNPUBLISHED);
        $event->removeFlag(Event::FLAG_CANCELLED);
        $event->removeFlag(Event::FLAG_PAST);
        $event->addFlag(Event::FLAG_CANCELLED);
        if (!$event->save()) return redirect(route('EditEvent', [$id]))->with(['req_error' => 'There is some error!']);

        return redirect(route('Events'))->with(['req_success' => 'Event cancelled successfully!']);
    }

    public function publish_event ($id)
    {
        $event = Event::where('event_id', $id)->first();
        $event->removeFlag(Event::FLAG_LIVE);
        $event->removeFlag(Event::FLAG_UNPUBLISHED);
        $event->removeFlag(Event::FLAG_CANCELLED);
        $event->removeFlag(Event::FLAG_PAST);
        $event->addFlag(Event::FLAG_LIVE);
        if (!$event->save()) return redirect(route('EditEvent', [$id]))->with(['req_error' => 'There is some error!']);

        return redirect(route('Events'))->with(['req_success' => 'Event published successfully!']);
    }

    public function update (Request $request, $id)
    {
        $request->validate([
            'event_name' => 'bail|required|string',
            'hosted_by' => 'bail|required|string',
            'event_type' => 'bail|required|string',
        ]);
        $event = Event::where('event_id', $id)->first();
        $event->name = $request->event_name;
        $event->hosted_by = $request->hosted_by;
        $event->type = $request->event_type;
        if (!$event->save()) return redirect(route('EditEvent', [$id]))->with(['req_error' => 'There is some error!']);

        return redirect(route('Events'))->with(['req_success' => 'Event edited successfully!']);
    }

    public function give_gift (Request $request, $id)
    {
        $request->validate([
            'rsvp' => 'bail|required|string'
        ]);
        session(['rsvp'=> lcfirst($request->rsvp)]);
        return redirect(route('GiveGiftView', $id))->with(['req_success' => 'Thank you! Now allocate your gift.']);
    }

    public function give_gift_view (Request $request, $id)
    {
        $curl = curl_init('https://api.valr.com/v1/public/marketsummary');
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.valr.com/v1/public/marketsummary',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        if (!empty($response)) {
            $btc_rate = 0;
            foreach ($response as $key => $value) {
                if ($value->currencyPair == 'BTCZAR') {
                    $btc_rate = $value->lastTradedPrice;
                    break;
                }
            }
            if ($btc_rate > 0) {
                
                $event = Event::where('event_id', $id)->first();
                return view('user-dashboard.events.give-gift', ['event' => $event, 'btc_rate' => $btc_rate]);
            }
        }
        return redirect()->back()->with(['req_error' => 'There is some error!']);
    }

    public function move_events_to_past ()
    {
        $today_date = date('Y-m-d', strtotime('-1 day'));
        $all_events = Event::where('event_date', '<', $today_date)->whereRaw('`flags` & ? = ?', [Event::FLAG_LIVE, Event::FLAG_LIVE])->get();
        foreach ($all_events as $key => $value) {
            $single_event = Event::where('event_id', $value->event_id)->first();
            $single_event->removeFlag(Event::FLAG_LIVE);
            $single_event->removeFlag(Event::FLAG_PAST);
            $single_event->addFlag(Event::FLAG_PAST);
            $single_event->save();
        }
        return '1';
    }
}
