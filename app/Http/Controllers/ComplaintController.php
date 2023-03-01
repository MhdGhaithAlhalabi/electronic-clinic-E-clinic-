<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $complaint = Complaint::where('created_at', '>=', Carbon::now()->subMonth())
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->select(
                DB::raw('Date(created_at) as date'),
                DB::raw('count(IF(type = "doctor", 1, NULL)) as doctor'),
                DB::raw('count(IF(type = "other", 1, NULL)) as other'),
                DB::raw('count(IF(type = "waiting", 1, NULL)) as waiting'),
                DB::raw('COUNT(*) as "views"')
            )->get();
        $labels = $complaint->pluck('date');
        $other = $complaint->pluck('other');
        $doctor = $complaint->pluck('doctor');
        $waiting = $complaint->pluck('waiting');

        $complaints = Complaint::with('patient:id,name,status', 'doctor:id,name,status,mobile_number', 'patient.consultation:id,title,status,patient_id,doctor_id,created_at', 'patient.personal:id,mobile_number,patient_id')->get();
        return view('complaint', compact('complaints', 'labels', 'other', 'doctor', 'waiting'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $rules = [
            'type' => 'required',
            'body' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 425);
        }
        if (asset($request->doctor_id)) {
            $doctor_id = $request->doctor_id;
        } else {
            $doctor_id = null;
        }
        $doctor_id = $request->doctor_id;
        Complaint::create([
            'type' => $request->type,
            'body' => $request->body,
            'patient_id' => auth()->user()->id,
            'doctor_id' => $doctor_id,
        ]);
        return response()->json('success');
    }
}
