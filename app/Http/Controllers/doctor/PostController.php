<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $posts = Post::with(['doctor:id,name,image', 'specialization:id,name'])->get(['doctor_id', 'image', 'body', 'specialization_id', 'created_at']);
        return response()->json($posts);
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
            'image' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 425);
        }
        Post::create([
            'body' => $request->body,
            'image' => $request->image,
            'specialization_id' => auth()->user()->specialization_id,
            'doctor_id' => auth()->user()->id,
        ]);
        $doctor = Doctor::find(auth()->user()->id);
        $doctor->num_post = $doctor->num_post + 1;
        $doctor->save();
        return response()->json('success');
    }
}
