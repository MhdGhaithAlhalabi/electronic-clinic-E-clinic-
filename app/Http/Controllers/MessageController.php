<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\Message;
use App\Models\Patient;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $rules = [
            'room_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 425);
        }
        $messages = Message::where('room_id', $request->room_id)->get();
        return response()->json($messages);

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
            'room_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 425);
        }

        Message::create([
            'body' => $request->body,
            'room_id' => $request->room_id,
            'user_id' => 0,
        ]);
        $room = Room::find('id', $request->room_id);
        $consultation = Consultation::find('id', $room->consultation_id);
        $doc = Doctor::find($consultation->doctor_id);
        $pit = Patient::find(auth()->user()->id);
        $token = $doc->fireBaseToken;
        $ch = curl_init();
        //Title of the Notification.
        //Setup headers:
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=AAAASREjVHM:APA91bFgonrrTD9y2aXhAZLGGYIGM8XgBodOI12Mbbp3wO6OHBicsbiHYSoIzEzkAxtM8AXsI-gDZ1OmRJt_tFpTH1reCXUQpMZb68DhZPAj-TGvAMfwFCTe6CWUnk4-ezUGlzc6WWft';
        //Creating the notification array.
        $notification = array('body' => ' مرحباً دكتور ' . $doc->name . ' قام المريض  ' . $pit->name . ' بارسال رسالة لك تحقق من الرسائل', 'title' => 'لديك رسالة جديدة ' . $request->body);
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
        return response()->json('success');
    }

    public function store2(Request $request): JsonResponse
    {
        $rules = [
            'body' => 'required',
            'room_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 425);
        }
        Message::create([
            'body' => $request->body,
            'room_id' => $request->room_id,
            'user_id' => 1,
        ]);
        $room = Room::find('id', $request->room_id);
        $consultation = Consultation::find('id', $room->consultation_id);
        $doc = Doctor::find(auth()->user()->id);
        $pit = Patient::find($consultation->patient_id);
        $token = $pit->fireBaseToken;
        $ch = curl_init();
        //Title of the Notification.
        //Setup headers:
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=AAAASREjVHM:APA91bFgonrrTD9y2aXhAZLGGYIGM8XgBodOI12Mbbp3wO6OHBicsbiHYSoIzEzkAxtM8AXsI-gDZ1OmRJt_tFpTH1reCXUQpMZb68DhZPAj-TGvAMfwFCTe6CWUnk4-ezUGlzc6WWft';
        //Creating the notification array.
        $notification = array('body' => ' مرحباً ' . $pit->name . ' قام الدكتور ' . $doc->name . ' بارسال رسالة لك تحقق من الرسائل ', 'title' => 'لديك رسالة جديدة ' . $request->body);
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
        return response()->json('success');
    }

}
