<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\EventTheme;
use App\Models\Event;
use App\Models\Setting;


class EventThemeController extends Controller
{
    public function user_index ($id)
    {
        $all_themes = EventTheme::whereRaw('`flags` & ? = ?', [EventTheme::FLAG_ACTIVE , EventTheme::FLAG_ACTIVE])->get();
        $setting = Setting::where('keys', 'maximum_events')->first();
        $user = request()->user;
        $event = Event::where('creator_id', $user->user_id)->count();

        if ($setting->values == $event) {
            return redirect()->back()->with('req_error','You have already created maximum number of events in this calender year!');

        }else{
            return view('user-dashboard.events.theme-selection', ['themes' => $all_themes, 'user_id' => $id]);

        }
    }

    
    public function index ()
    {
        $all_themes = EventTheme::orderBy('id', 'DESC')->get();
        return view('admin.themes.index', ['all_themes' => $all_themes]);
    }

    public function create ()
    {
        return view('admin.themes.create');
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
            'title' => 'required|bail|string',
            'create_event_image' => 'required|bail|file',
            'gifter_event_image' => 'required|bail|file',
            'color_code' => 'required|bail|string',
        ]);

        $theme_id = (String) Str::uuid();
        $theme = new EventTheme;
        $theme->theme_id = $theme_id;
        $theme->title = $request->title;
        $theme->color_code = $request->color_code;
        $theme->addFlag(EventTheme::FLAG_ACTIVE);


        if (!file_exists(storage_path("app/public/themes")))
            mkdir(storage_path("app/public/themes"), 0777, true);
               
        $name = rand(99, 9999999) . '.' . $request->file('create_event_image')->extension();
        $gifter_event_image = rand(99, 9999999) . '.' . $request->file('gifter_event_image')->extension();

        $request->file('create_event_image')->storeAs("/public/themes/".$theme_id, $name);
        $theme->front_image = $name;

        $request->file('gifter_event_image')->storeAs("/public/themes/".$theme_id, $name);
        $theme->gifter_image = $gifter_event_image;

        $artisan_call_to_make_files_public = Artisan::call("storage:link", []);

        if ($theme->save())
            return redirect(route('Themes'))->with(['req_success' => 'Theme added successfully!']);

        return redirect(route('Themes'))->with(['req_error' => 'There is some error!']);
    }

    public function edit($id)
    {
        $theme = EventTheme::where('theme_id', $id)->first();
        return view('admin.themes.edit', ['theme' => $theme]);
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
       
        $request->validate([
            'title' => 'required|bail|string',
            'status' => 'required|bail|string',
            'color_code' => 'required|bail|string',
          
        ]);
       

        $theme = EventTheme::where('theme_id', $id)->first();
        $theme->title = $request->title;
        $theme->color_code = $request->color_code;
        $theme->removeFlag(EventTheme::FLAG_ACTIVE);
        $theme->removeFlag(EventTheme::FLAG_GIFTER_CARD);
        $theme->removeFlag(EventTheme::FLAG_EVENT_CARD);


        if ($request->status == 'active' || $request->status == 'Active') {
            $theme->addFlag(EventTheme::FLAG_ACTIVE);

        }


        if ($request->hasFile('cover_image')) {
            if ($theme->front_image) {
               // unlink(storage_path("app/public/themes/".$theme->theme_id.'/'.$theme->front_image));

            }
            
            
            $name = rand(99, 9999999) . '.' . $request->file('cover_image')->extension();
            $request->file('cover_image')->storeAs("/public/themes/".$theme->theme_id, $name);
            $theme->front_image = $name;
        }

        if ($request->hasFile('gifter_event_image')) {
            if ($theme->gifter_image) {
             //   unlink(storage_path("app/public/themes/".$theme->theme_id.'/'.$theme->gifter_image));

            }
            
            
            $name = rand(99, 9999999) . '.' . $request->file('gifter_event_image')->extension();
            $request->file('gifter_event_image')->storeAs("/public/themes/".$theme->theme_id, $name);
            $theme->gifter_image = $name;
        }

        $artisan_call_to_make_files_public = Artisan::call("storage:link", []);

        if ($theme->save())
            return redirect(route('Themes'))->with(['req_success' => 'Theme updated successfully!']);

        return redirect(route('Themes'))->with(['req_error' => 'There is some error!']);
    }
}
