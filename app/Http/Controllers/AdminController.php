<?php

namespace App\Http\Controllers;

use App\Models\AdditionalInformationTeacher;
use App\Models\CollegeDepartment;
use App\Models\CollegeGroup;
use App\Models\CollegeSpecialty;
use App\Models\Role;
use App\Service\IntegrationOneC;
use App\User;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Service\FileStorage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    private $filesSave;
    private $integration;

    public function __construct(FileStorage $filesSave)
    {
        $this->filesSave = $filesSave;
        $this->integration = new IntegrationOneC();
    }

    public function index()
    {
        $user = auth()->user();
        $usersCount = User::all('id')->count();
        return view('admin.index', ['user' => $user, 'usersCount' => $usersCount]);
    }

    public function showSlider()
    {
        $slider = Slider::orderBy('created_at', 'desc')->where('status', 1)->get();
        return view('admin.sliders', compact('slider'));
    }

    public function addSlider(Request $request)
    {
        $slider = new Slider();
        $slider->status = 1;
        if ($request->addFile) {
            $image = $request->file('addFile');
            $img = $this->filesSave->imageSave($image, 'news');
            if ($img) {
                $slider->link = $img;
            } else {
                return redirect()->back()->with('message', 'Неверный формат изображения');
            }
        } else {
            $slider->link = $request->link;
        }
        $slider->save();
        return redirect('admin/sliders');
    }

    public function removeSlider(Request $request)
    {

        if ($request->addFile) {
            $image = $request->file('file_img');
            $img = $this->filesSave->imageSave($image, 'news');
            if ($img) {
                Slider::where('link', $request->link)->update([
                    'link' => $img,
                    'status' => 2,
                ]);
            } else {
                return redirect()->back()->with('message', 'Неверный формат изображения');
            }
        } else {
            Slider::where('link', $request->link)->update([
                'link' => $request->link,
                'status' => 2,
            ]);
        }
        return redirect('admin/sliders');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed'
        ]);
        if ($validator->fails()) return redirect()->back()->withErrors($validator->errors());
        $user = User::find($id);
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->back()->with('success', 'Ваш пароль успешно изменен!');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function synchronizeTeachers(Request $request)
    { // получение списка преподов из 1с и добавление в базу
        $data = $this->integration->getTeachers();
        $roleTeacher = Role::where('short_name', 'teacher')->first();
        foreach ($data->employees as $item) {
            $contains = User::where('email', $item->Email)->first();
            if (empty($contains)) {
                $user = new User();
                $user->login = $item->Login;
                $user->email = $item->Email;
                $user->password = bcrypt($item->Password);
                $FIO = explode(" ", $item->additionalInformation->FIO);
                $user->name = $FIO[1];
                $user->surname = $FIO[0];
                $user->patronymic = $FIO[2];
                $user->full_name = $item->additionalInformation->FIO;
                $user->timestamps;
                $additional = new AdditionalInformationTeacher();
                $additional->birthday = $item->additionalInformation->DateBirthday;
                $additional->sex = $item->additionalInformation->Sex;
                $additional->ref_key = $item->Ref_Key;
                $additional->address = $item->additionalInformation->Adress;
                $additional->save();
                $user->additional_information = $additional->id;
                $user->save();
                $user->roles()->attach($roleTeacher->id);
            }
        }
        return redirect()->back()->with('success', 'Синхронизация пользователей прошла успешно!');
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function syncDepartments() {
        $data = $this->integration->getDepartments()->departments;
        $departments = CollegeDepartment::all();
        foreach($data as $value) {
            $item = $departments->where('ref_key', $value->Ref_Key)->first();
            if(!empty($item)) { // если был найден добалвенный элемент
                if($item->name != $value->Name) // если название отделения было переименованов в 1с
                    CollegeDepartment::where('ref_key', $value->Ref_Key)->update(['name' => $value->Name]);
            }else { // если нет такого отделения
                CollegeDepartment::create(['ref_key' => $value->Ref_Key, 'name' => $value->Name]);
            }
        }
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function syncSpecialties() {
        $data = $this->integration->getSpecialties()->specialties;
        $specialties = CollegeSpecialty::all();
        foreach($data as $value) {
            $item = $specialties->where('ref_key', $value->Ref_Key)->first();
            if(!empty($item)) {
                if($item->name != $value->Name)
                    CollegeSpecialty::where('ref_key', $value->Ref_Key)->update(['name' => $value->Ref_Key]);
            }else {
                CollegeSpecialty::create(['ref_key' => $value->Ref_Key, 'code' => $value->Code, 'name' => $value->Name]);
            }
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function syncGroups()
    {
        $this->syncDepartments();
        $this->syncSpecialties();

        $data = $this->integration->getGroups()->groups;
        $groups = CollegeGroup::all();
        foreach ($data as $value) {
            $item = $groups->where('ref_key', $value->Ref_Key)->first();
            if(!empty($item)) {
                if(
                    $item->name != $value->Name ||
                    $item->department_ref_key != $value->Department->Ref_Key ||
                    $item->specialty_ref_key != $value->Specialty->Ref_Key ||
                    $item->status != $value->Status ||
                    $item->form_training != $value->Form_Training
                ) // если были изменения в 1с
                CollegeGroup::where('ref_key', $value->Ref_Key)->update([
                    'department_ref_key' => $value->Department->Ref_Key,
                    'specialty_ref_key' => $value->Specialty->Ref_Key,
                    'name' => $value->Name,
                    'status' => $value->Status,
                    'form_training' => $value->Form_Training]);
            }else { // если нет в базе группы
                CollegeGroup::create([
                    'ref_key' => $value->Ref_Key,
                    'department_ref_key' => $value->Department->Ref_Key,
                    'specialty_ref_key' => $value->Specialty->Ref_Key,
                    'name' => $value->Name,
                    'status' => $value->Status,
                    'form_training' => $value->Form_Training]);
            }
        }

        return redirect()->back()->with('success', 'Синхронизация прошла успешно!');

    }
}
