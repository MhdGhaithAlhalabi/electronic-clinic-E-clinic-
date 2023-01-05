<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use App\Models\Medical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicalController extends Controller
{
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'sensitive' => 'required',
            'vaccines' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->getMessageBag());
        }
        Medical::create([
            'sensitive' => $request->sensitive,
            'vaccines' => $request->vaccines,
            'patient_id'=> auth()->user()->id
        ]);
        return response()->json('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Medical  $medical
     * @return \Illuminate\Http\Response
     */
    public function show(Medical $medical)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Medical  $medical
     * @return \Illuminate\Http\Response
     */
    public function edit(Medical $medical)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Medical  $medical
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Medical $medical)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Medical  $medical
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medical $medical)
    {
        //
    }
}
