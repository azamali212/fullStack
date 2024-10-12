<?php

namespace App\Http\Controllers\Nurses;

use App\Http\Controllers\Controller;
use App\Http\Requests\NursesRequest;
use App\Http\Resources\NursesResource;
use App\Repositories\NursesRepo\NursesRepositoryInterface;
use Illuminate\Http\Request;

class NursesController extends Controller
{

    protected $nursesRepository;
    public function __construct(NursesRepositoryInterface $nursesRepository)
    {
        $this->nursesRepository = $nursesRepository;
        $this->middleware('auth:api');
        $this->middleware('permission:Nurses.index', ['only' => ['index']]);
        $this->middleware('permission:Nurses.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:nurses.show', ['only' => ['show']]);
        $this->middleware('permission:Nurses.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:nurses.destroy', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $nurses = $this->nursesRepository->getAllNurses($request);

        return response()->json(
            NursesResource::collection($nurses)
                ->additional([
                    'status' => 'success',
                    'message' => 'Nurses retrieved successfully'
                ])
        );
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NursesRequest $request)
    {
        $nurses = $this->nursesRepository->createNurses($request);

        return response()->json([
            'status' => 'success',
            'message' => 'Verification email sent. Please verify your email before proceeding.',
        ], 201);
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
    public function update(NursesRequest $request, $id)
    {
        $nurses = $this->nursesRepository->updateNurses($request,$id);

        return response()->json([
            'status' => 'success',
            'message' => 'Nurses updated successfully',
            'hospital' => new NursesResource($nurses)
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
