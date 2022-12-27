<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class authDoctorController extends Controller
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

            $token = Auth::guard('doctorApi')->attempt($credentials);

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
            'email' => 'required',
            'password' => 'required',
            'name' => 'required',
            'mobile_number' => 'required',
            'clinic_number' => 'required',
            'city_id' => 'required',
            'region_id' => 'required',
            'specialization_id' => 'required',
            'main_title' => 'required',
            'title' => 'required',
            'certificate_image' => ['required','image'],
            'image' => ['required','image'],
            'opening_time' => 'required',
            'full_address' => 'required',
            'sex' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->getMessageBag());
        }
        // Handle File Upload
        if($request->hasFile('certificate_image')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('certificate_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('certificate_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('certificate_image')->storeAs('public/certificate doctor images', $fileNameToStore);
        }
        // Handle File Upload
        if($request->hasFile('image')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore2 = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('image')->storeAs('public/doctor images', $fileNameToStore2);
        }
        $doctor = Doctor::create([
            'email' => $request->email,
            'password' =>$request->password ,
            'name' =>$request->name ,
            'mobile_number' =>$request->mobile_number ,
            'clinic_number' =>$request->clinic_number ,
            'city_id' =>$request->city_id ,
            'region_id' =>$request->region_id ,
            'specialization_id' =>$request->specialization_id ,
            'main_title' =>$request->main_title ,
            'title' =>$request->title ,
            'image' => $fileNameToStore2,
            'certificate_image' =>$fileNameToStore,
            'opening_time' =>$request->opening_time ,
            'full_address' =>$request->full_address ,
            'sex' =>$request->sex ,
            'status' => 0 ,
            ]);
        return response()->json([
            'status' => 'success',
            'message' => 'doctor created successfully',
            'doctor' => $doctor,
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
