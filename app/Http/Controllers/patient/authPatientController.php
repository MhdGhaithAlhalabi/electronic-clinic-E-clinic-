<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class authPatientController extends Controller
{
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {

        try {
            $rules = [
                'email' => 'required',
                'password' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json( $validator->getMessageBag());
            }

            //login

            $credentials = request(['email', 'password']);

            $token = Auth::guard('patientApi')->attempt($credentials);

            if (!$token)
                return response()->json('بيانات الدخول غير صحيحة');

            // $customer = Auth::guard('customer-api')->user();
            //  $customer->api_token = $token;
            //return token
            return  response()->json(['token', $token]);

        } catch (Exception $ex) {
            return  response()->json($ex->getMessage());
        }


    }
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $rules = [
            'name' => ['required','string','max:25'],
            'email' => ['required','string','max:25'],
            'password' => ['required','string','min:6'],
            'image'=>['nullable'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->getMessageBag());
        }
        $user = Patient::create($request->all());
          $token = Auth::guard('patientApi')->login($user);
        return    response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }
    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->logout(true);
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }
}
