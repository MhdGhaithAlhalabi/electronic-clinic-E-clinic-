<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $questions = DB::table('questions')
            ->join('patients', 'patients.id', '=', 'questions.patient_id')
            ->leftJoin('replies', 'replies.question_id', 'questions.id')
            ->leftJoin('doctors', 'doctors.id', 'replies.doctor_id')
            ->leftJoin('specializations', 'specializations.id', 'questions.specialization_id')
            ->select('questions.*', 'patients.name', 'patients.image', 'specializations.id as specializations_id', 'specializations.name as specializations_name', 'replies.id as replies_id', 'replies.body as replies_body', 'replies.body as replies_body', 'doctors.id as doctor_id', 'doctors.name as doctor_name', 'doctors.image as doctor_image', 'doctors.image as doctor_image', 'doctors.image as doctor_image')
            ->get();
        $questions->each(function ($item, $key) {
            if ($item->anonymous == 1)
                $item->name = 'anonymous';
            $item->image = 'https://icon-library.com/images/anonymous-icon/anonymous-icon-28.jpg';
        });
        return response()->json($questions);
    }

    public function index2(): JsonResponse
    {
        $question = Question::where('answered', 0)->with(['patient:id,name,image', 'reply:id,body,question_id,doctor_id', 'reply.doctor:id,image,name', 'specialization:id,name'])->get();
        return response()->json($question);
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
            'body' => 'required',
            'specialization_id' => 'required',
            'anonymous' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 425);
        }
        Question::create([
            'body' => $request->body,
            'patient_id' => auth()->user()->id,
            'answered' => 0,
            'anonymous' => $request->anonymous,
            'specialization_id' => $request->specialization_id
        ]);
        return response()->json('success');
    }
}
