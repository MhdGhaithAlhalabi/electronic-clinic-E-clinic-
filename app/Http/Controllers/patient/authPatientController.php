<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Medical;
use App\Models\Patient;
use App\Models\Personal;
use App\Models\Specialization;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class authPatientController extends Controller
{

    public function home(): JsonResponse
    {
        $Distinguished_Doctors = Doctor::where('status', '1')->orderBy('rate', 'DESC')->with('specialization:id,name')->take(10)->get(['name', 'sex', 'image', 'num_consulting', 'opening_time', 'num_post', 'rate', 'specialization_id', 'full_address']);
        $specializations = Specialization::all('id', 'name', 'image');
        return response()->json(['Distinguished_Doctors' => $Distinguished_Doctors, 'Specializations' => $specializations]);
    }

    public function patientBlock(Patient $patient): \Illuminate\Http\RedirectResponse
    {
        $patient->status = 0;
        $patient->save();
        return redirect()->back();
    }

    public function patientUnblock(Patient $patient): \Illuminate\Http\RedirectResponse
    {
        $patient->status = 1;
        $patient->save();
        return redirect()->back();
    }

    public function register(Request $request): JsonResponse
    {
        $rules = [
            'name' => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'max:25'],
            'password' => ['required', 'string', 'min:6'],
            'image' => ['nullable'],
            'city_id' => ['required'],
            'mobile_number' => ['required', 'unique:personals'],
            'age' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'sex' => 'required',
            'social_situation' => 'required',
            'address' => 'required',
            'practices' => 'required',
            'medicines' => 'required',
            'surgery' => 'required',
            'hypertension' => 'required',
            'diabetes' => 'required',
            'genetic_diseases' => 'required',
            'vaccines' => 'required',
            'sensitive' => 'required',
            'fireBaseToken' => ['required']

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 425);
        }

        $patient = Patient::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'city_id' => $request->city_id,
            'image' => $request->image,
            'status' => 1,
            'fireBaseToken' => $request->fireBaseToken

        ]);
        Personal::create([
            'mobile_number' => $request->mobile_number,
            'age' => $request->age,
            'height' => $request->height,
            'weight' => $request->weight,
            'sex' => $request->sex,
            'social_situation' => $request->social_situation,
            'address' => $request->address,
            'patient_id' => $patient->id
        ]);
        Medical::create([
            'practices' => $request->practices,
            'medicines' => $request->medicines,
            'surgery' => $request->surgery,

            'hypertension' => $request->hypertension,
            'diabetes' => $request->diabetes,
            'genetic_diseases' => $request->genetic_diseases,
            'vaccines' => $request->vaccines,
            'sensitive' => $request->sensitive,
            'patient_id' => $patient->id
        ]);
        $token = Auth::guard('patientApi')->login($patient);
        return response()->json([
            'status' => 'success',
            'message' => 'patient created successfully',
            'patient' => $patient,
            'token' => $token
        ]);

    }

    public function login(Request $request): JsonResponse
    {

        try {
            $rules = [
                'email' => 'required',
                'password' => 'required',
                'fireBaseToken' => ['nullable']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json($validator->getMessageBag());
            }

            //login

            $credentials = request(['email', 'password']);

            $token = Auth::guard('patientApi')->attempt($credentials);
            $token2 = Auth::guard('patientApi')->attempt(['email' => request('email'), 'password' => request('password'), 'status' => 1]);


            if (!$token) {
                return response()->json('بيانات الدخول غير صحيحة', 425);
            }
            if (!$token2) {
                return response()->json('لا يمكنك تسجيل الدخول ربما تم حظرك لاسائة الاستخدام', 425);

            }
            $patient = Auth::guard('patientApi')->user();
            if (asset($request->fireBaseToken)) {
                $patient->fireBaseToken = $request->fireBaseToken;
                $patient->update();
            }
            return response()->json(['token' => $token, 'patient' => $patient]);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage());
        }

    }

    public function register2(Request $request): JsonResponse
    {
        $rules = [
            'mobile_number' => ['required', 'unique:personals'],
            'age' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'sex' => 'required',
            'social_situation' => 'required',
            'address' => 'required',
            'practices' => 'required',
            'medicines' => 'required',
            'surgery' => 'required',
            'blood_thinner' => 'required',
            'hypertension' => 'required',
            'diabetes' => 'required',
            'genetic_diseases' => 'required',
            'vaccines' => 'required',
            'sensitive' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 425);
        }
        Personal::create([
            'mobile_number' => $request->mobile_number,
            'age' => $request->age,
            'height' => $request->height,
            'weight' => $request->weight,
            'sex' => $request->sex,
            'social_situation' => $request->social_situation,
            'address' => $request->address,
            'patient_id' => auth()->user()->id
        ]);
        Medical::create([
            'practices' => $request->practices,
            'medicines' => $request->medicines,
            'surgery' => $request->surgery,
            'blood_thinner' => $request->blood_thinner,
            'hypertension' => $request->hypertension,
            'diabetes' => $request->diabetes,
            'genetic_diseases' => $request->genetic_diseases,
            'vaccines' => $request->vaccines,
            'sensitive' => $request->sensitive,
            'patient_id' => auth()->user()->id
        ]);
        return response()->json('success');
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
