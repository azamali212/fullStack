<?php

namespace App\Http\Controllers\Nurses;

use App\Http\Controllers\Controller;
use App\Models\Nurse;
use Illuminate\Http\Request;

class NursesProfileController extends Controller
{

    public function __construct()
    {
        //$this->ambulanceDriverRepository = $ambulanceDriverRepository;
        $this->middleware('auth:api');
        //$this->middleware('permission:AmbulanceDriver.index', ['only' => ['index']]);
        //$this->middleware('permission:AmbulanceDriver.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:Nurse.profile.show', ['only' => ['show']]);
        $this->middleware('permission:Nurse.profile.update', ['only' => ['edit', 'update']]);
        //$this->middleware('permission:AmbulanceDriver.destroy', ['only' => ['destroy']]);
        //$this->middleware('permission:hospitals.profileSetting', ['only' => ['profileSetting']]);
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
        $nurse = Nurse::findOrFail($id);

        return response()->json([
            'name' => $nurse->name,
            'email' => $nurse->email,
            'phone_no' => $nurse->phone_no,
            'city' => $nurse->city,
            'state' => $nurse->state,
            'postal_code' => $nurse->postal_code,
            'country' => $nurse->country,
            'contact_person_name' => $nurse->contact_person_name,
            'profile_picture' => $nurse->profile_picture,
        ]);
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
        // Find the nurse by ID
        $nurse = Nurse::findOrFail($id);

        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:nurses,email,' . $nurse->id,
            'phone_no' => 'nullable|string|max:15',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'contact_person_name' => 'nullable|string|max:255',
            //'profile_picture' => 'nullable|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update the nurse's attributes
        $nurse->update($validated);


        $nurse->save();

        // Return a JSON response with the updated nurse data
        return response()->json([
            'success' => true,
            'data' => [
                'nurse' => $nurse
            ]
        ]);
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
