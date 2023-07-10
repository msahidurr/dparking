<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SiteController extends Controller
{

	public function generalSettings(Request $request){
		$oldSetting = Setting::first();
		return view('content.settings', ['settings' => $oldSetting]);
	}
	
	public function storeGeneralSettings(Request $request){
		$request->validate([
			'site_title' => 'required|min:2',
			'logo' => 'bail|nullable|mimes:jpeg,jpg,png|dimensions:width=150,height=40|max:50',
			'favicon' => 'bail|nullable|mimes:ico,png|dimensions:width=64,height=64|max:500',
			'login_image' => 'bail|nullable|mimes:jpeg,jpg,png|dimensions:width=1366,height=768|max:1024',
		]);

		$data['site_title'] = $request->site_title;
		$data['date_format'] = $request->date_format;
		$data['date_format_sql'] = $request->date_format_sql;
		$data['app_timezone'] = $request->app_timezone;

		if($request->hasFile('logo')){
			$fileName = $this->imageName($request->logo->getClientOriginalName(), 1, 'logo');
			$data['logo'] = $request->file('logo')->storeAs('uploads', $fileName);
		}
		
		if($request->hasFile('favicon')){
			$fileName = $this->imageName($request->favicon->getClientOriginalName(), 1, 'favicon');
			$data['favicon'] = $request->file('favicon')->storeAs('uploads', $fileName);
		}

		if($request->hasFile('login_image')){			
			$data['login_image'] = $request->file('login_image')->storeAs('img', 'login-bg.jpg');
		}

		$setting = Setting::first();
		$old_app_timezone = $setting->app_timezone;
		$setting->update($data);

		cache()->forget('settings');
		cache()->remember('settings', now()->addHours(2), function () {
            return Setting::first();
        });
        
        Artisan::call('config:clear');
        overWriteEnvFile('APP_TIMEZONE',$request->input('app_timezone'),$old_app_timezone);        
        Artisan::call('config:cache');
        
		return back()->with(['flashMsg' => ['msg' => 'Settings successfully updated.', 'type' => 'success']]);
	}

	function imageName($name, $withExt = 1, $prefix = NULL, $suffix = NULL)
	{
		$extension = pathinfo($name, PATHINFO_EXTENSION);
		$name = preg_replace("/[\s]|\#|\$|\&|\@/", "_", pathinfo($name, PATHINFO_FILENAME));
		$name = $prefix . '_' . $name . '_' . $suffix;
		if ($prefix == NULL) {
			$name = substr($name, -170);
		} else {
			$name = substr($name, 0, 170);
		}

		$name .= ('_' . time());

		if ($withExt) {
			$name .= ('.' . $extension);
		}

		return $name;
	}	
}
