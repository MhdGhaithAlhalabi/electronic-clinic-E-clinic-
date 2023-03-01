<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $doctors = Doctor::with('city', 'specialization')->get();
        return view('doctorApprove', compact('doctors'));
    }

    public function specializationDoctor(Request $request): JsonResponse
    {
        $Doctors = Doctor::where('status', '1')->where('specialization_id', $request->specialization_id)->with(['specialization:id,name', 'city:id,name'])->get(['name', 'mobile_number', 'clinic_number', 'sex', 'image', 'num_consulting', 'main_title', 'title', 'opening_time', 'num_post', 'rate', 'specialization_id', 'full_address', 'lon', 'lat', 'city_id']);
        return response()->json($Doctors);
    }

    public function doctorBlock(Doctor $doctor): \Illuminate\Http\RedirectResponse
    {
        $doctor->status = 0;
        $doctor->save();
        return redirect()->back();
    }

    public function doctorApprove(Doctor $doctor): \Illuminate\Http\RedirectResponse
    {
        $doctor->status = 1;
        $doctor->save();
        $doc = Doctor::find($doctor->id);
        $token = $doc->fireBaseToken;
        $ch = curl_init();
        //Title of the Notification.
        //Setup headers:
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=AAAASREjVHM:APA91bFgonrrTD9y2aXhAZLGGYIGM8XgBodOI12Mbbp3wO6OHBicsbiHYSoIzEzkAxtM8AXsI-gDZ1OmRJt_tFpTH1reCXUQpMZb68DhZPAj-TGvAMfwFCTe6CWUnk4-ezUGlzc6WWft';
        //Creating the notification array.
        $notification = array('body' => 'مرحباً دكتور ' . $doc->name . 'قام الادمن الطبي بالتحقق من معلوماتك وتفعيل الحساب ', 'title' => 'تم تفعيل الحساب الخاص بك شكراَ للانتظار ');
        /*            $data = array(
                        'order_id' => "order id test in data",
                        'type' => "tye test in data",
                    );*/
        //This array contains, the token and the notification. The 'to' attribute stores the token.
        // 'data' => $data,
        $arrayToSend = array('to' => $token, 'notification' => $notification, 'priority' => 'high');
        //Generating JSON encoded string form the above array.
        $json = json_encode($arrayToSend);
        //Setup curl, add headers and post parameters.
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //Send the request
        $result = curl_exec($ch);
        //Close request
        curl_close($ch);
        //return $result;
        //return response()->json('success');
        return redirect()->back();
    }
}
