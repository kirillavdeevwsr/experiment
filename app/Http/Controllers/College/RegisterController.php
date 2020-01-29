<?php

namespace App\Http\Controllers\College;

use App\Models\College\AdditionalStudent;
use App\Models\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rules\Captcha;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Service\IntegrationOneC;

class RegisterController extends Controller
{
    public function __construct(IntegrationOneC $int)
    {
        $this->integration = $int;
    }

    public function showForm_step_1(Request $request)
    {
        if(!$request->session()->has('informationFrom1C'))
            return view('college.register_1');
        else return redirect()->route('register_2');
    }

    public function showForm_step_2(Request $request)
    {
        if (!$request->session()->has('informationFrom1C')) {
            return redirect()->route('register_1')->withErrors("Для начала необходимо пройти первый шаг!");
        }
        return view('college.register_2');
    }

    public function register_step_1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'serial' => 'required|numeric|digits:4',
            'number' => 'required|numeric|digits:6',
            'g-recaptcha-response' => new Captcha()
        ]);

        if ($validator->fails()) return redirect()->back()->withErrors($validator->errors());
        $result = $this->integration->getStudentByPassport($request->serial, $request->number);
        if (!empty($result->error))
            return redirect()->back()->withErrors("К сожалению нам не удалось вас найти. Если вы сменили паспорт, то укажите старую серию и номер (найти можно на странице 19).");
        $request->session()->put('informationFrom1C', $result);
        return redirect()->route('register_2');
    }

    public function register_step_2(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6'
        ]);
        if($validator->fails()) return redirect()->back()->withErrors($validator->errors());
        $user = User::where('email', $request->email)->first();
        if(!empty($user)) {
            $request->session()->forget('informationFrom1C');
            return redirect()->route('1c_login')->withErrors('У вас уже существует аккаунт!');
        }
        $informationStudent = $request->session()->pull('informationFrom1C');
        $additional = AdditionalStudent::create([
            'ref_key_profile' => $informationStudent->Ref_Key_Profile,
            'ref_key_student' => $informationStudent->Ref_Key_Student,
            'ref_key_department' => $informationStudent->Department->Ref_Key,
            'ref_key_specialty' => $informationStudent->Specialty->Ref_Key,
            'ref_key_group' => $informationStudent->Group->Ref_Key,
            'birthday' => $informationStudent->Birthday_Date,
        ]);
        $user = new User();
        $user->name = $informationStudent->Name;
        $user->surname = $informationStudent->Surname;
        $user->patronymic = $informationStudent->Patronymic;
        $user->full_name = $informationStudent->Full_Name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->timestamps;
        $user->additional_student = $additional->id;
        $user->save();

        $studentRole = Role::where('short_name', 'student')->first();
        $user->roles()->attach($studentRole->id);

        Auth::login($user);
        return redirect()->route('profile');
    }
}
