<?php

namespace App\Http\Controllers\College;

use App\Models\Specialty;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\IntegrationOneC;
use Illuminate\Support\Facades\Validator;
class EnrolleeController extends Controller
{
    public function __construct(IntegrationOneC $integration)
    {
        $this->integration = $integration;
    }

    public function show(){
        $specialities = Specialty::all();
        return view('college.enrollee.form', compact(['specialities']));
    }

    public function getSpeciality(){;
       $data = $this->integration->getSpec();
       return redirect('/');
    }

    public function sendData(Request $request){
//        return dd($request);
        $specialityRequest = [$request->speciality, $request->speciality1,$request->speciality2 ];
        $speciality=[];
        foreach ($specialityRequest as $spec){
            if ($spec!=0){
                $specialityModel = Specialty::find($spec);
                array_push($speciality, $specialityModel->getSpecialityData());
            }
        }
        if(empty($speciality)){
            return redirect()->back()->with('mess', 'Вы не выбрали специальность');
        }
        $captcha = $this->googleCapcha($request);
        if($captcha !== true)
            return $captcha;
        $house = 'дом № '.$request->house;
        $firstAddressArray = [$request->index, $request->state, $request->city, $request->street, $house];
        $firstAddress = join(', ', $firstAddressArray);
        if ($request->sub){
            $firstAddress = $firstAddress .'/'.$request->sub;
        }
        if ($request->flat){
            $firstAddress = $firstAddress . ', квартира '. $request->flat;
        }
        $house1 = 'дом № '.$request->house1;
        $lastAddressArray = [$request->index1, $request->state1, $request->city1, $request->street1, $house1];
        $lastAddress = join(', ', $lastAddressArray);
        if ($request->sub1){
            $lastAddress = $lastAddress .'/'.$request->sub1;
        }
        if ($request->flat1){
            $lastAddress = $lastAddress . ', квартира '. $request->flat1;
        }

        $sendData =[
            'firstname'=>$request->firstname,
            'lastname'=>$request->lastname,
            'secondname'=>$request->secondname,
            'sex'=>$request->sex,
            'birthday'=>Carbon::parse($request->birthday)->format('Y-m-d'),
            'education'=>$request->education,
            'speciality'=>$speciality,
            'documentType'=>$request->documentType,
            'documentSerial'=>$request->documentSerial,
            'documentNumber'=>$request->documentNumber,
            'documentEx'=>$request->documentEx,
            'documentDate'=>Carbon::parse($request->documentDate)->format('Y-m-d'),
            'documentCode'=>$request->documentCode,
            'firstAddress'=> $firstAddress,
            'lastAddress'=>$lastAddress,
            'phone'=>$request->phone,
            'checkbox' => $request->checkbox

        ];
        $send = $this->integration->sendEnrollee($sendData);
        if($send){
            return redirect('/')->with('status', $send['enrollee']['number']);
        }else{
            return abort(500);
        }
    }

    private function googleCapcha($request){
        $secret_key='6LftgWMUAAAAAHzmdkNS7W5UilF6vF65HuMsPbhg';
//        $secret_key2 = '6LeYfWMUAAAAANVqSr45PpR4lGRi5MvTB40L4cKk';
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => $secret_key,
            'response' => $request->input(["g-recaptcha-response"]),
        );
        $options = array(
            'http' => array (
                'method' => 'POST',
                'content' => http_build_query($data),
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            )
        );
        $context  = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        $captcha_success=json_decode($verify);
        if ($captcha_success->success==false) {
            return redirect()->back()->with( "message", "You are a bot! Go away!");
        } else if ($captcha_success->success==true) {
            return true;
        }

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'checkbox' => 'required|in:1',


        ]);
    }

}
