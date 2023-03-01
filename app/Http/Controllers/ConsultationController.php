<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Room;
use App\Models\Specialization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultationController extends Controller
{
    public function consultationView(Request $request): JsonResponse
    {
        $rules = [
            'consultation_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 425);
        }
        $consultation = Consultation::with('patient', 'patient.personal', 'patient.medical')->where('id', $request->consultation_id)->get();
        return response()->json($consultation);

    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $consultation = Consultation::with('patient', 'patient.personal')->where('status', 'waiting')->where('doctor_id', null)
            ->where('specialization_id', auth()->user()->specialization_id)
            ->where('status', 'waiting')->get();
        return response()->json($consultation);
    }

    public function index2(): JsonResponse
    {
        $consultation = Consultation::with('patient', 'patient.personal')->where('status', 'waiting')->where('doctor_id', auth()->user()->id)->get();
        return response()->json($consultation);
    }

    public function waitingConsultation(): JsonResponse
    {
        $consultation = Consultation::where('patient_id', auth()->user()->id)->where('status', 'waiting')->get(['id', 'title', 'created_at']);
        return response()->json([$consultation]);
    }

    public function UnderProcessingConsultation(): JsonResponse
    {
        $consultation = Consultation::where('patient_id', auth()->user()->id)->where('status', 'UnderProcessing')->get();
        return response()->json(['consultation' => $consultation]);
    }

    public function finishConsultation(): JsonResponse
    {
        $consultation = Consultation::with(['doctor:id,name,image', 'medication'])->where('patient_id', auth()->user()->id)->where('status', 'Finish')->get(['id', 'title', 'doctor_id', 'details', 'created_at']);
        $consultation->each(function ($item, $key) {
            if ($item->medication->count() === 0) {
                $item->medications = false;//(['medications'=>false]);
            } else {
                $item->medications = true;//(['medications'=> true]);
            }
        });
        return response()->json($consultation);
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
            'title' => 'required',
            'details' => 'required',
            'time' => 'required',
            'status_pain' => 'required',
            'frequency' => 'required',
            'severity_pain' => 'required',
            'type_complaint' => 'required',
            'nature_complaint' => 'required',
            'specialization_id' => 'required',
            'factors_increase_complaint' => 'required',
            'factors_reduce_complaint' => 'required',
            'place_pain' => 'required',
            'images' => 'nullable'
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
        $con = Consultation::create([
            'title' => $request->title,
            'details' => $request->details,
            'time' => $request->time,
            'status_pain' => $request->status_pain,
            'frequency' => $request->frequency,
            'severity_pain' => $request->severity_pain,
            'nature_complaint' => $request->nature_complaint,
            'factors_increase_complaint' => $request->factors_increase_complaint,
            'factors_reduce_complaint' => $request->factors_reduce_complaint,
            'place_pain' => $request->place_pain,
            'type_complaint' => $request->type_complaint,
            'images' => $request->images,
            'status' => 'waiting',
            'patient_id' => auth()->user()->id,
            'doctor_id' => $doctor_id,
            'specialization_id' => $request->specialization_id
        ]);
        if ($doctor_id != null) {
            $spe = Specialization::find($con->specialization_id);
            $doc = Doctor::find($con->doctor_id);
            $token = $doc->fireBaseToken;
            $ch = curl_init();
            //Title of the Notification.
            //Setup headers:
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key=AAAASREjVHM:APA91bFgonrrTD9y2aXhAZLGGYIGM8XgBodOI12Mbbp3wO6OHBicsbiHYSoIzEzkAxtM8AXsI-gDZ1OmRJt_tFpTH1reCXUQpMZb68DhZPAj-TGvAMfwFCTe6CWUnk4-ezUGlzc6WWft';
            //Creating the notification array.
            $notification = array('body' => ' دكتور ' . $doc->name . ' ' . ' لديك استشارة ' . $spe->name, 'title' => $con->title);
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
        }
        return response()->json('success');
    }

    public function consultationUnderProcessing(Request $request): JsonResponse
    {
        $rules = [
            'consultation_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 425);
        }
        $consultation = Consultation::find($request->consultation_id);
        $consultation->status = 'UnderProcessing';
        $consultation->doctor_id = auth()->user()->id;
        $consultation->save();
        Room::create([
            'consultation_id' => $consultation->id,
            'patient_id' => $consultation->patient_id,
            'doctor_id' => auth()->user()->id,
        ]);

        $spe = Specialization::find($consultation->specialization_id);
        $doc = Doctor::find($consultation->doctor_id);
        $pit = Patient::find($consultation->patient_id);
        $token = $pit->fireBaseToken;
        $ch = curl_init();
        //Title of the Notification.
        //Setup headers:
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=AAAASREjVHM:APA91bFgonrrTD9y2aXhAZLGGYIGM8XgBodOI12Mbbp3wO6OHBicsbiHYSoIzEzkAxtM8AXsI-gDZ1OmRJt_tFpTH1reCXUQpMZb68DhZPAj-TGvAMfwFCTe6CWUnk4-ezUGlzc6WWft';
        //Creating the notification array.
        $notification = array('body' => ' مرحباً ' . $pit->name . ' يمكنك التواصل مع الدكتور ' . $doc->name . ' يقوم بمعالجة الاستشارة ذات التخصص ' . $spe->name, 'title' => ' الاستشارة الخاصة بك تحت المعالجة نتمنى لك الصحة والسلامة ');
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

    public function consultationFinish(Request $request): JsonResponse
    {
        $rules = [
            'consultation_id' => 'required',
            'notes' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 425);
        }
        $consultation = Consultation::find($request->consultation_id);
        $consultation->status = 'Finish';
        $consultation->notes = $request->notes;
        $consultation->doctor_id = auth()->user()->id;
        $consultation->save();
        $doctor = Doctor::find(auth()->user()->id);
        $doctor->num_consulting = $doctor->num_consulting + 1;
        $doctor->save();

        $spe = Specialization::find($consultation->specialization_id);
        $doc = Doctor::find($consultation->doctor_id);
        $pit = Patient::find($consultation->patient_id);
        $token = $pit->fireBaseToken;
        $ch = curl_init();
        //Title of the Notification.
        //Setup headers:
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=AAAASREjVHM:APA91bFgonrrTD9y2aXhAZLGGYIGM8XgBodOI12Mbbp3wO6OHBicsbiHYSoIzEzkAxtM8AXsI-gDZ1OmRJt_tFpTH1reCXUQpMZb68DhZPAj-TGvAMfwFCTe6CWUnk4-ezUGlzc6WWft';
        //Creating the notification array.
        $notification = array('body' => ' مرحباً ' . $pit->name . ' قام الدكتور ' . $doc->name . ' بإنهاء الاستشارة الخاصة بك ذات التخصص ' . $spe->name, 'title' => 'الاستشارة الخاصة بك منتهية نتمنى لك الصحة والسلامة');
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
        return response()->json('success');

    }

}
