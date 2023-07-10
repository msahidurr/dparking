<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ActivationController extends Controller
{
	
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function activeLicense()
    {
        return view('activation');
    }
   
	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function active(Request $request)
    {
		$validated = $request->validate([
			'domain' => 'bail|required|url',
			'code' => 'bail|required',
		]);
        
		$response = Http::asForm()->post('https://systechprojects.com/licenseM/codeCanyon/activation', $validated);

		echo $response->body();
    }

}
