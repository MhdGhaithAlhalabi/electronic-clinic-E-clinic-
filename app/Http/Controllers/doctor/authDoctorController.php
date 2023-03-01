<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class authDoctorController extends Controller
{
    public function doctorView(Request $request): JsonResponse
    {
        $Doctor = Doctor::where('id', $request->doctor_id)->with('specialization:id,name')->get(['name', 'mobile_number', 'clinic_number', 'sex', 'image', 'num_consulting', 'main_title', 'title', 'opening_time', 'num_post', 'rate', 'specialization_id', 'full_address', 'lon', 'lat']);
        return response()->json($Doctor);
    }

    public function allDoctors(): JsonResponse
    {
        $Doctors = Doctor::where('status', '1')->with(['specialization:id,name', 'city:id,name'])->get(['id', 'name', 'mobile_number', 'clinic_number', 'sex', 'image', 'num_consulting', 'main_title', 'title', 'opening_time', 'num_post', 'rate', 'specialization_id', 'full_address', 'lon', 'lat', 'city_id']);
        return response()->json($Doctors);
    }

    public function doctorByS(Request $request): JsonResponse
    {
        $rules = [
            'specialization_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag());
        }
        $Doctors = Doctor::where('specialization_id', $request->specialization_id)->where('status', '1')->with(['specialization:id,name', 'city:id,name'])->get(['id', 'name', 'mobile_number', 'clinic_number', 'sex', 'image', 'num_consulting', 'main_title', 'title', 'opening_time', 'num_post', 'rate', 'specialization_id', 'full_address', 'lon', 'lat', 'city_id']);
        return response()->json($Doctors);
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $rules = [
                'email' => 'required',
                'password' => 'required',
                'fireBaseToken' => ['required']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json($validator->getMessageBag());
            }
            //login

            $credentials = request(['email', 'password']);

            $token = Auth::guard('doctorApi')->attempt($credentials);
            $token2 = Auth::guard('doctorApi')->attempt(['email' => request('email'), 'password' => request('password'), 'status' => 1]);

            if (!$token) {
                return response()->json('بيانات الدخول غير صحيحة', 425);
            }
            if (!$token2) {
                return response()->json('لم يتم تأكيد حسابك بعد', 425);
            }
            $doctror = Auth::guard('doctorApi')->user();
            if (asset($request->fireBaseToken)) {
                $doctror->fireBaseToken = $request->fireBaseToken;
                $doctror->update();
            }
            return response()->json(['token' => $token, 'doctor' => $doctror]);

        } catch (Exception $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function register(Request $request): JsonResponse
    {
        $rules = [
            'email' => 'required',
            'password' => 'required',
            'name' => 'required',
            'mobile_number' => 'required',
            'clinic_number' => 'required',
            'city_id' => 'required',
            'specialization_id' => 'required',
            'main_title' => 'required',
            'title' => 'required',
            'certificate_image' => ['required'],
            'image' => ['required'],
            'opening_time' => 'required',
            'full_address' => 'required',
            'sex' => 'required',
            'lon' => 'required',
            'lat' => 'required',
            'certificate_number' => 'required',
            'fireBaseToken' => ['nullable']
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 425);
        }

        /*       // Handle File Upload
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
               }*/
        $doctor = Doctor::create([
            'email' => $request->email,
            'password' => $request->password,
            'name' => $request->name,
            'mobile_number' => $request->mobile_number,
            'clinic_number' => $request->clinic_number,
            'city_id' => $request->city_id,
            'specialization_id' => $request->specialization_id,
            'main_title' => $request->main_title,
            'title' => $request->title,
            'image' => $request->image,//$fileNameToStore2,
            'certificate_image' => $request->certificate_image,//$fileNameToStore,
            'opening_time' => $request->opening_time,
            'certificate_number' => $request->certificate_number,
            'full_address' => $request->full_address,
            'sex' => $request->sex,
            'lon' => $request->lon,
            'lat' => $request->lat,
            'num_consulting' => 0,
            'rate' => 0,
            'num_post' => 0,
            'status' => 0,
            'fireBaseToken' => $request->fireBaseToken
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'doctor created successfully',
            'doctor' => $doctor,
        ]);
    }

    public function logout(): JsonResponse
    {
        auth()->logout(true);
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }
}
