<?php

namespace App\Http\Controllers\Admin;

use App\Models\CollegeGroup;
use App\Models\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = null;
        if(isset($reqest->q)) {
            $users = User::paginate(20);
        }else {
            $users = User::where('full_name', 'like', '%'.$request->q.'%')->paginate(20)->appends(['q' => $request->q]);
        }
        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $groups = CollegeGroup::all()->sortByDesc("name");
        return view('admin.users.create', ['roles' => $roles, 'groups' => $groups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'surname' => 'required',
            'peopleName' => 'required',
            'patronymic' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'role.*' => 'required',
        ]);
        if($validator->fails()) return redirect()->back()->withErrors($validator->errors());

        $user = new User();
        $user->name = $request->peopleName;
        $user->surname = $request->surname;
        $user->patronymic = $request->patronymic;
        $user->full_name = $request->surname . ' '. $request->peopleName . ' '. $request->patronymic;
        $user->timestamps;
        $user->email = $request->email;
        if(trim($request->login) !== '') $user->login = $request->login;
        $user->password = bcrypt($request->password);
        $user->save();
        $user->roles()->attach($request->role);
        return redirect()->back()->with('success', 'Пользователь успешно добавлен!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Role::all();
        $user = User::find($id);
        $groups = CollegeGroup::all();
        return view('admin.users.update',['roles' => $roles, 'user'=>$user, 'groups' => $groups]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $rules = [
            'surname' => 'required',
            'peopleName' => 'required',
            'patronymic' => 'required',
            'email' => 'required|email',
            'role.*' => 'required',
        ];
        $user->name == $request->peopleName ?: $user->name = $request->peopleName;
        $user->surname == $request->surname ?: $user->surname = $request->surname;
        $user->patronymic == $request->patronymic ?: $user->patronymic = $request->patronymic;
        $user->email == $request->email ?: $user->email = $request->email;
        $user->updated_at = \Carbon\Carbon::now();
        if($request->password != "") {
            $rules['password'] = 'required|min:6';
            $user->password = bcrypt($request->password);
        }
        $user->login = $request->login;
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        $user->roles()->detach();
        $user->roles()->attach($request->role);
        $user->save();
        return redirect()->route('users.index')->with('success', 'Данные пользователя успешно изменены!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->roles()->detach();
        $user->additional()->delete();
        $user->delete();
        return redirect()->back()->with('success', 'Пользователь удален!');
    }
}
