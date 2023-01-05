<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultationController extends Controller
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
            'title' => 'required',
            'details' => 'required',
            'time' => 'required',
            'status_pain' => 'required',
            'frequency' => 'required',
            'severity_pain' => 'required',
            'severity_complaint' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->getMessageBag());
        }
        if(asset($request->doctor_id)){
            $doctor_id = $request->doctor_id;
        }
        else {
            $doctor_id = null;
        }
        Consultation::create( [
            'title' => $request->title,
            'details' => $request->details,
            'time' => $request->time,
            'status_pain' => $request->status_pain,
            'frequency' => $request->frequency,
            'severity_pain' => $request->severity_pain,
            'severity_complaint' => $request->severity_complaint,
            'status' => 'wanting' ,
            'patient_id'=> auth()->user()->id,
            'doctor_id'=> $doctor_id
        ]);
        return response()->json('success');
    }
    public function consultationApprove(Request $request): \Illuminate\Http\JsonResponse
    {
        $rules = [
            'consultation_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->getMessageBag());
        }
        $consultation =  Consultation::find($request->consultation_id);
        $consultation->status = 'approve';
        $consultation->save();
        return response()->json('success');

    }
    public function consultationFinish(Request $request): \Illuminate\Http\JsonResponse
    {
        $rules = [
            'consultation_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->getMessageBag());
        }
        $consultation =  Consultation::find($request->consultation_id);
        $consultation->status = 'Finish';
        $consultation->save();
        $doctor = Doctor::find(auth()->user()->id);
        $doctor->num_consulting = $doctor->num_consulting + 1;
        $doctor->save();
        return response()->json('success');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consultation  $consolution
     * @return \Illuminate\Http\Response
     */
    public function show(Consultation $consolution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consultation  $consolution
     * @return \Illuminate\Http\Response
     */
    public function edit(Consultation $consolution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consultation  $consolution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Consultation $consolution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consultation  $consolution
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consultation $consolution)
    {
        //
    }
}
