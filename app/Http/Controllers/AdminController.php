<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\ApiSetting;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    // show all api settings
    public function index(Request $request)
    {
        if(request()->ajax()) {
            return datatables()->of(ApiSetting::select([
                'id', 'user_id', 'api_url' , 'execute_duration_min', 'created_at', 'active'
            ])->orderBy('created_at', 'desc'))
            ->addIndexColumn()
            ->addColumn('action', function($data){

                   $editUrl = url('admin/edit/'.$data->id);
                   $btn = '<a href="'.$editUrl.'" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</a>';

                   $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->id.'" data-original-title="Delete" class="btn btn-danger btn-sm remove">Delete</a>';

                    return $btn;
            })
            ->addColumn('user_name', function($data){
                $user = User::find($data->user_id);
                return $user->name;
            })
            ->addColumn('duration', function($data){
                return ApiSetting::executeDurationForHuman($data->execute_duration_min);
            })
            ->rawColumns(['action', 'user_name', 'duration'])
            ->make(true);
        }
        return view('admin.panel');
    }

    // add feed api url for users
    public function addApiUrl(Request $request)
    {
        if ($request->method() == 'GET') {
            $users = User::all();
            return view('admin.add-api-url', compact('users'));
        }

        if ($request->method() == 'POST') {
            $data = request()->validate([
                'user_id' => 'required|integer',
                'api_url' => 'required|url',
                'execute_duration_min' => 'required|integer',
                'active' => 'required|boolean',
            ]);

            $setting = new ApiSetting;
            if(self::update($setting, $data))
                return redirect()->route('admin')->with('success', 'Great! The API URL has been saved.');
        }

        return redirect()->route('admin')->with('error', "Invalid URL. The page you were trying to load doesn't exist.");
    }

    // edit api url for a user
    public function editApiUrl(Request $request, $id = null)
    {
        if ($request->method() == 'GET') {
            $data = ApiSetting::find($id);
            return view('admin.edit-api-url', compact('data'));
        }

        if ($request->method() == 'POST') {
            $data = request()->validate([
                'api_url' => 'required|url',
                'execute_duration_min' => 'required|integer',
                'active' => 'required|boolean',
            ]);

            if(!$request->input('id')){
                return redirect()->route('admin')->with('error', 'Please specify the setting you want to edit.');
            }

            $setting = ApiSetting::find($request->input('id'));
            if (self::update($setting, $data))
                return redirect()->route('admin')->with('success', 'Great! The API URL has been updated');
        }

        return redirect()->route('admin')->with('error', "Invalid URL. The page you were trying to load doesn't exist.");
    }

    // remove api url for a user
    public function removeApiUrl($id)
    {
        try {
            $setting = ApiSetting::where('id', $id)->delete();
            return response()->json($setting);
        } catch (QueryException $e){
            return redirect()->route('admin')->with('error', $e->getMessage());
        }

    }

    private static function update($setting, $data)
    {
        if (!$setting)
            return false;

        foreach($data as $key=>$val) {
            $setting->$key = $val;
        }

        try {
            $setting->save();
        } catch (QueryException $e){
            $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                return redirect()->route('admin')->with('error','Ops, there are duplicate records for this entry.');
            }
            return redirect()->route('admin')->with('error', $e->getMessage());
        }

        return true;
    }
}
