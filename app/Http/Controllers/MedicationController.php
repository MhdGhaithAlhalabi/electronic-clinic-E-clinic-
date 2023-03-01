<?php

namespace App\Http\Controllers;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\Medication;
use App\Models\Patient;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
      $medications =  Medication::with('doctor:id,name','consultation:id,title')->where('patient_id',auth()->user()->id)->get();
        return response()->json($medications);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $rules = [
                'medicationList' => 'required',
                'consultation_id' => 'required',
                'patient_id' => 'required',
                'notes' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                return response()->json($validator->getMessageBag(),425);
            }

        $medicationList = $request->medicationList ;
        $consultation_id = $request->consultation_id;
        $doctor_id = auth()->user()->id;
        $patient_id = $request->patient_id;
               $medication = json_decode($medicationList, true);
                $collection = collect($medication);
        for ($i = 0; $i < $collection->count(); $i++) {
            $name = $collection[$i]['name'];
            $dose = $collection[$i]['dose'];
            $duration = $collection[$i]['duration'];
            $notes = $collection[$i]['notes'];

                Medication::create(
                    [
                        'name' => $name,
                        'dose' => $dose,
                        'duration' => $duration,
                        'notes' => $notes,
                        'consultation_id' => $consultation_id,
                        'doctor_id' => $doctor_id,
                        'patient_id' => $patient_id,
                    ]
                );

        }
            $consultation =  Consultation::find($request->consultation_id);
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
            $notification = array('body' => ' مرحباً '.$pit->name.'قام الدكتور '.$doc->name.' بوصف الدواء لك و إنهاء الاستشارة الخاصة بك ذات التخصص '.$spe->name, 'title' => 'الاستشارة الخاصة بك منتهية تم وصف دواء نتمنى لك الصحة والسلامة');
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
        } catch (\Exception $e){
            return response()->json($e);

        }
          return response()->json('success');
    }

}
