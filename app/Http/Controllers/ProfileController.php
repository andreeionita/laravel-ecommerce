<?php

namespace App\Http\Controllers;

use App\Country;
use App\Profile;
use App\Role;
use App\User;
use App\State;
use App\City;
use App\Http\Requests\StoreUserProfile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('role' , 'profile')->paginate(3);
        
        // dd($user);
        return view('admin.users.index' , compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $countries = Country::all();
        return view('admin.users.create',compact('roles','countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserProfile $request)
    {
        if($request->hasFile('thumbnail')){ 
            $image = $request->file('thumbnail');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move('admin/upload/', $new_name);
            $thumbnail = 'admin/upload/'.$new_name;
    
        }else{
            $thumbnail = null;
        }

      
 
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => $request->status
        ]);
        if($user){
            $profile = Profile::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'phone' => $request->phone,
                'slug' => $request->slug,
                'address' => $request->address,
                'thumbnail'=> $thumbnail
            ]);
        }

        if($user && $profile)
            return redirect(route('admin.profile.index'))->with('message' , 'User Added Succesfully');
        else
            return back()->with('message','Error Adding User Please Try Again');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit($profile)
    {
        $user = Profile::where('slug' , '=' , $profile)->get();
        $roles = Role::all();
        return view('admin.users.create',compact('user','roles'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        if($profile->forceDelete()){
            return back()->with('message','Profile Successfully Trashed!');
        }else{
            return back()->with('message','Error Deleting Product');
        }
    }

    public function getStates(Request $request)
    {
        $data['states'] = State::where("country_id",$request->country_id)->get(["name", "id"]);
        return response()->json($data);
    }
    public function getCities(Request $request)
    {
        $data['cities'] = City::where("state_id",$request->state_id)->get(["name", "id"]);
        return response()->json($data);
        
        // if($request()->ajax())
        //     return City::where('state_id', $request->id)->get();
        // else
        //     return 0;
    }

    public function recover($id)
    {
        $profile = Profile::with('categories')->onlyTrashed()->findOrFail($id);
        if($profile->restore())
            return back()->with('message','Profile Successfully Restored!');
        else
            return back()->with('message','Error Restoring Product');
    }

    public function remove(Profile $profile)
    {
        if($profile->delete()){
            return back()->with('message','Product Successfully Trashed!');
        }else{
            return back()->with('message','Error Deleting Product');
        }
    }

}
