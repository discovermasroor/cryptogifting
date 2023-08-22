<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Models\Event;
use App\Models\Beneficiar;
use App\Models\Contact;
use App\Models\EventAcceptance;
use App\Models\Notifications;
use App\Models\NotificationUser;


class EventAcceptanceController extends Controller
{
    public function gift_details(Request $request, $id)
    {
         $gift_details = EventAcceptance::where('event_acceptance_id', $id)->with(['transaction_details', 'event_info', 'event_info.event_theme', 'gift_event_info.recipient', 'gift_event_info.sender', 'gift_event_info.event_theme'])->first();
         return view('user-dashboard.reports.gift-details', ['gift' => $gift_details]);
    }

    public function gift_details_admin(Request $request, $id)
    {
        $gift_details = EventAcceptance::where('event_acceptance_id', $id)->with(['transaction_details', 'event_info', 'event_info.event_theme', 'gift_event_info.recipient', 'gift_event_info.sender', 'gift_event_info.event_theme'])->first();
        return view('admin.reports.gift-details', ['gift' => $gift_details]);
    }

    public function public_link_gifts_admin (Request $request)
    {
        $benefs = Beneficiar::get();
        $gifts = EventAcceptance::where('event_id', '=', NULL)->where('gifter_event_id', '=', NULL)->with(['transaction_details'])->orderBy('id', 'Desc');
        return view('admin.reports.link-gifts', ['gifts' => $gifts->paginate(20), 'beneficiaries' => $benefs]);
    }

    public function link_gifts (Request $request)
    {
        $all_benef = Beneficiar::where('user_id', request()->user->user_id)->pluck('beneficiary_id')->toArray();
        $benefs = Beneficiar::where('user_id', request()->user->user_id)->get();
        $gifts = EventAcceptance::where('event_id', '=', NULL)->whereIn('beneficiary_id', $all_benef)->with(['transaction_details'])->orderBy('id', 'Desc');
        return view('user-dashboard.reports.link-gifts', ['gifts' => $gifts->paginate(20), 'beneficiaries' => $benefs]);

    }

    public function store(Request $request, $id)
    {
        $event_info = Event::where('event_id', $id)->first();
        $rsvp = session()->get('rsvp');
        if ($request->has('gift_type_allocation') && $request->filled('gift_type_allocation')) {
            $event_acc = new EventAcceptance;
            if ($request->gift_type_allocation == 'own_gift') $event_acc->addFlag(EventAcceptance::FLAG_OWN_GIFT);
            else $event_acc->addFlag(EventAcceptance::FLAG_NO_GIFT);

            $event_acc->event_acceptance_id = (String) Str::uuid();
            $event_acc->event_id = $id;
            $event_acc->contact_id = $request->contact_id;
            $event_acc->beneficiary_id = $event_info->beneficiary_id;
            $event_acc->rsvp = $rsvp;
          

            if ($event_acc->save()) {
                $notif = new Notifications;
                $notif->notification_id = (String) Str::uuid();
                $notif->event_id = $id;
                $notif->heading = 'Someone just respond to your event!';
                $notif->text = get_user_name().' has just respond to your event! kindly check it out';

                if ($notif->save()) {
                    $user_notif = new NotificationUser;
                    $user_notif->notification_user_id = (String) Str::uuid();
                    $user_notif->notification_id = $notif->notification_id;
                    $user_notif->user_id = $event_info->creator_id;
                    $user_notif->save();

                }
                session()->forget('rsvp');
              
                return redirect(route('ThankYouViewContact', [$event_acc->event_acceptance_id]))->with(['req_success' => 'Thank you so much!']);
            }
        }
        return redirect()->back()->with(['req_error' => 'There is some error!']);
    }

    public function view_thank_you_contact (Request $request, $id)
    {
        $event_acc = EventAcceptance::where('event_acceptance_id', $id)->with(['event_info.event_creator', 'gifter'])->first();
        return view('thank-you', ['event_acc' => $event_acc]);
    }

    public function view_thank_you (Request $request, $id)
    {
        $event_acc = EventAcceptance::where('event_acceptance_id', $id)->with(['event_info.event_creator', 'gifter'])->first();
        return view('user-dashboard.events.thank-you-no-amount', ['event_acc' => $event_acc]);
    }

    public function view_fail_payment (Request $request)
    {
        return view('user-dashboard.events.fail-payment');
    }

    public function check_transactions_benef (Request $request)
    {
        $request->validate([
            'transactions' => 'bail|required|array'
        ]);
        $all_benefs = EventAcceptance::whereIn('event_acceptance_id', $request->transactions)->pluck('beneficiary_id')->toArray();
        if ($all_benefs) {
            $all_benefs = array_unique($all_benefs);
            $count = Beneficiar::whereIn('beneficiary_id', $all_benefs)->where('reference_id', NULL)->count();
            if ($count > 0) {
                return api_error('One of the beneficiary doesn\'t have reference ID! Kindly fill that up and try again');

            }
            return api_success1('All beneficiaries are good!');
        }
    }
}
