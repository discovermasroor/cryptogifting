<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Notification;
use App\Models\NotificationUser;

class NotificationController extends Controller
{
    public function index (Request $request)
    {
        $data['notifications'] = '';
        $notifications = NotificationUser::query();
        $notifications->where('user_id', request()->user->user_id);
        $notifications->with(['notification']);
        $notifications->orderBy('id', 'desc');
        $data['notifications'] = $notifications->paginate(20);
        return view('user-dashboard.notifications.index', $data);
    }

    public function mark_all_seen ()
    {
        NotificationUser::where('user_id', request()->user->user_id)->update(['flags' => '1']);
        return redirect(route('GetNotifications'))->with(['req_success' => 'All notifications marked as read!']);
    }

    public function mark_all_seen_admin ()
    {
        NotificationUser::where('user_id', request()->admin->user_id)->update(['flags' => '1']);
        return redirect(route('AdminNotifications'))->with(['req_success' => 'All notifications marked as read!']);
    }

    public function read_notif_admin (Request $request)
    {
        NotificationUser::where('notification_user_id', $request->notif_id)->update(['flags' => '1']);
        $unread_notifications_counter = NotificationUser::where('user_id', request()->admin->user_id)->whereRaw('`flags` & ? != ?', [NotificationUser::FLAG_READ, NotificationUser::FLAG_READ])->count();
        return api_success('Notification Status Updated!', ['notif_count' => $unread_notifications_counter]);
    }

    public function read_notif_user (Request $request)
    {
        NotificationUser::where('notification_user_id', $request->notif_id)->update(['flags' => '1']);
        $unread_notifications_counter = NotificationUser::where('user_id', request()->user->user_id)->whereRaw('`flags` & ? != ?', [NotificationUser::FLAG_READ, NotificationUser::FLAG_READ])->count();
        return api_success('Notification Status Updated!', ['notif_count' => $unread_notifications_counter]);
    }

    public function index_admin (Request $request)
    {
        $data['notifications'] = '';
        $notifications = NotificationUser::query();
        $notifications->where('user_id', request()->admin->user_id);
        $notifications->with(['notification']);
        $notifications->orderBy('id', 'desc');
        $data['notifications'] = $notifications->paginate(20);
        return view('admin.notifications.index', $data);
    }

    public function settings_view_admin (Request $request)
    {
        return view('admin.notifications.settings');
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
