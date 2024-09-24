<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Http\Requests\HospitalProfileRequest;
use App\Models\Hospital;
use App\Models\HospitalProfile;
use Illuminate\Http\Request;

class HospitalProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:hospitals.profileSetting', ['only' => ['profileSetting']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
    //Add Some pusher notification reminder if i forget when hospital change profile and afetr notifiy it super admin///////
    
    public function update(HospitalProfileRequest $request, $id)
    {
        $profile = HospitalProfile::where('hospital_id', $id)->first();
        //dd($profile);

        if (!$profile) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hospital profile not found'
            ], 404);
        }


        $hospital = Hospital::find($id);
        //dd($hospital);

        if (!$hospital) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hospital not found'
            ], 404);
        }
        $profile->update($request->validated());

        $hospital->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
        ]);

        return response()->json([
            'status' => 'success',
            'data' => [
                'profile' => $profile,
                'hospital' => $hospital,
            ],
            'message' => 'Hospital profile and hospital updated successfully'
        ], 200);
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
