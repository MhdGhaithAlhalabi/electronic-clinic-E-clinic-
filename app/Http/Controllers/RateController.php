<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function store(Request $request)
    {
        $rate = $request->rate;
        $r1 = Rate::where('patient_id', '=', auth()->user()->id)->where('doctor_id', '=', $request->doctor_id)->first();
        if ($r1 == NULL) {
            Rate::create(
                [
                    'patient_id' => auth()->user()->id,
                    'doctor_id' => $request->doctor_id,
                    'rate' => $rate,
                ]
            );
        } else {
            $this_rate = Rate::find($r1->id);
            $this_rate->rate = $rate;
            $this_rate->save();
        }
        $the_rate = Rate::all()->where('doctor_id', '=', $request->doctor_id)->average('rate');
        $doctor = Doctor::find($request->doctor_id);
        $doctor->rate = $the_rate;
        $doctor->save();
        return response()->json('success');
    }
}
