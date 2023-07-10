<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $languages = new Language();
            $limit = 100;
            $offset = 0;
            $search = [];
            $where = [];
            $with = ['country'];
            $join = [];
            $orderBy = [];
            if ($request->input('length')) {
                $limit = $request->input('length');
            }
            if ($request->input('order')[0]['column'] != 0) {
                $column_name = $request->input('columns')[$request->input('order')[0]['column']]['name'];
                $sort = $request->input('order')[0]['dir'];
                $orderBy[$column_name] = $sort;
            }
            if ($request->input('start')) {
                $offset = $request->input('start');
            }
            if ($request->input('search') && $request->input('search')['value'] != "") {
                $search['name'] = $request->input('search')['value'];
                $search['code'] = $request->input('search')['value'];
            }
            if ($request->input('where')) {
                $where = $request->input('where');
            }

            $where['languages.code NOTEQ and'] = 'master';
            $languages = $languages->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($languages);
        }
        return view('languages.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('languages.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required|unique:languages',
            'code' => 'bail|required|unique:languages',
            'country_id' => 'bail|required|min:1'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $name = strtolower($request->name);
        $code = strtolower($request->code);
        if ($code == 'master') {
            return back()->withErrors(['code' => 'Master is not an language name. Try another one']);
        }

        $language_dir = resource_path() . DIRECTORY_SEPARATOR . 'lang';
        $languages_path = $language_dir . DIRECTORY_SEPARATOR . $code;

        DB::beginTransaction();
        try {

            // copy folder and past it on language folder
            $copy_dir = $language_dir . DIRECTORY_SEPARATOR . 'master';
            File::copyDirectory($copy_dir, $languages_path);

            $store_data = [
                'code' => $code,
                'name' => $name,
                'country_id' => $request->country_id,
                'status' => $request->status
            ];

            if($request->status == 2){
                setEnv('LOCALE', $code);
                Language::whereStatus(2)->update(['status' => 1]);
            }

            Language::create($store_data);

            DB::commit();
            return redirect()
                ->route('languages.index')
                ->with(['flashMsg' => ['msg' => 'Languages successfully added.', 'type' => 'success']]);
        } catch (\PDOException $e) {
            // if created dir then delete it
            if (File::isDirectory($languages_path)) {
                File::deleteDirectory($languages_path);
            }
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with(['flashMsg' => ['msg' => $this->getMessage($e), 'type' => 'error']]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function show(Language $language)
    {
        //
    }

    /**
     * This function 
     *
     * @author      Md. Al-Mahmud <mamun120520@gmail.com>
     * @version     1.0
     * @see         
     * @since       06/30/2022
     * Time         16:40:17
     * @param       
     * @return      
     */
    public function language_change(Language $language)
    {
        // file read 
        $countries = Country::all();
        return view('languages.language', compact('countries', 'language'));
    }
    #end

    /**
     * This function language update
     *
     * @author      Md. Al-Mahmud <mamun120520@gmail.com>
     * @version     1.0
     * @see         
     * @since       06/30/2022
     * Time         16:43:38
     * @param       
     * @return      
     */
    public function language_update(Request $request, Language $language)
    {
        # code...   
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required|unique:languages,name,' . $language->id,
            'code' => 'bail|required|unique:languages,code,' . $language->id,
            'country_id' => 'bail|required|min:1'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $name = strtolower($request->name);
        $code = strtolower($request->code);
        if ($code == 'master') {
            return back()->withErrors(['code' => 'Master is not an language name. Try another one']);
        }
        
        $language_dir = resource_path() . DIRECTORY_SEPARATOR . 'lang';

        $new_path = $language_dir . DIRECTORY_SEPARATOR . $code;
        $old_path = $language_dir . DIRECTORY_SEPARATOR . $language->code;

        DB::beginTransaction();
        try {

           
            if ($old_path != $new_path) {
                rename($old_path, $new_path);
            }

            $store_data = [
                'code' => $code,
                'name' => $name,
                'country_id' => $request->country_id,
                'status' => $request->status
            ];

            if($request->status == 2){
                setEnv('LOCALE', $code);
                Language::whereStatus(2)->update(['status' => 1]);
            }
            elseif($language->status == 2 && $request->status < 2){
                Language::whereStatus(1)->take(1)->update(['status' => 2]);
            }

            $language->update($store_data);

            DB::commit();
            return redirect()
                ->route('languages.index')
                ->with(['flashMsg' => ['msg' => 'Languages successfully updated.', 'type' => 'success']]);
        } catch (\PDOException $e) {

            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with(['flashMsg' => ['msg' => $this->getMessage($e), 'type' => 'error']]);
        }
    }
    #end



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language)
    {
        // file read 
        $code = strtolower($language->code);
        $language_dir = resource_path() . DIRECTORY_SEPARATOR . 'lang';
        $languages_path = $language_dir . DIRECTORY_SEPARATOR . $code;
        $languages_file_path = $languages_path . DIRECTORY_SEPARATOR . 'application.php';

        $master_path = $language_dir . DIRECTORY_SEPARATOR . 'master';
        $master_file_path = $master_path . DIRECTORY_SEPARATOR . 'application.php';
        if (file_exists($languages_file_path)) {
            $items = require($languages_file_path);
            $master = require($master_file_path);
            ksort($master);
            return view('languages.edit', compact('items', 'language', 'master'));
        } else {
            return redirect()
                ->route('languages.index')
                ->with(['flashMsg' => ['msg' => 'Something is wrong.', 'type' => 'errors']]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Language $language)
    {
        $request->validate([
            '*' => 'required',
        ]);

        $code = strtolower($language->code);
        $language_dir = resource_path() . DIRECTORY_SEPARATOR . 'lang';
        $languages_path = $language_dir . DIRECTORY_SEPARATOR . $code;
        $languages_file_path = $languages_path . DIRECTORY_SEPARATOR . 'application.php';

        $text_upload = "<?php".PHP_EOL."return[".PHP_EOL;

        foreach($request->all() as $index => $lang){
            
            if($index == '_method' || $index == '_token'){
                continue;
            }
            else{
                $ind = strpos($index, '_');
                $index[$ind] = '.';
                $text_upload .= $lang == NULL ? "'$index' => null,".PHP_EOL : "'$index' => '$lang',".PHP_EOL;
            }
        }

        try {

          $text_upload .= "];".PHP_EOL."?>";
          
            file_put_contents($languages_file_path, $text_upload);
            return redirect()
                ->route('languages.index')
                ->with(['flashMsg' => ['msg' => 'Languages successfully configured.', 'type' => 'success']]);
        } catch (\Exception $e) {
            return redirect()
                ->route('languages.index')
                ->with(['flashMsg' => ['msg' => $e->getMessage(), 'type' => 'errors']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
        $code = $language->code;
        if ($code != 'master') {
            if($language->status == 2){
                $languageOld = Language::whereStatus(1)->first();
                $languageOld->update(['status' => 2]);
                setEnv('LOCALE', $languageOld->code);
            }
            
            $language_dir = resource_path() . DIRECTORY_SEPARATOR . 'lang';
            $languages_path = $language_dir . DIRECTORY_SEPARATOR . $code;
            if ($language->delete()) {
                if (File::isDirectory($languages_path)) {
                    File::deleteDirectory($languages_path);
                }
            }
        }
    }

    /**
     * This function work for setting language
     *
     * @author      Md. Al-Mahmud <mamun120520@gmail.com>
     * @version     1.0
     * @see         
     * @since       06/30/2022
     * Time         10:27:35
     * @param       
     * @return      
     */
    public function set_languages(Request $request, Language $language)
    {
        # code...
        $user = auth()->user();
        $user->language_id = $language->id;
        $user->save();
    }
    #end

}
