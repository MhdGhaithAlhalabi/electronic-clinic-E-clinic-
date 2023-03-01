<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\JsonResponse;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $room = Room::where('patient_id', auth()->user()->id)->with('doctor:id,name,image', 'consultation:id,title')->get(['id', 'consultation_id', 'doctor_id', 'created_at']);
        return response()->json($room);
    }

    public function index2()
    {
        $room = Room::where('doctor_id', auth()->user()->id)->with('patient:id,name,image', 'patient.personal:id,age,sex', 'consultation:id,title,status')->get(['id', 'patient_id', 'consultation_id', 'created_at'])->where('consultation.status', 'UnderProcessing');
        return response()->json($room);
    }

}
