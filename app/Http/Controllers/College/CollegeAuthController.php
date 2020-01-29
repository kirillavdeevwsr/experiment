<?php

namespace App\Http\Controllers\College;

use App\Models\Role;
use App\Service\IntegrationOneC;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CollegeAuthController extends Controller
{


    public function __construct(IntegrationOneC $integration)
    {
        $this->integration = $integration;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLogin()
    {
        return view('college.login');
    }

    /**
     * @param $string
     * @return String
     */
    private function emailValidate($string): String
    {
        $res = filter_var($string, FILTER_VALIDATE_EMAIL) ? 'email' : 'login';
        return $res;
    }

    /**
     * @param $user
     * @param Role $role
     * @return bool
     */
    private function hasRole($user, Role $role)
    {
        if ($user->roles->contains($role->id)) {
            return true;
        }
        return false;
    }

    /**
     * @param string $authField поле по которому авторизовываем
     * @param string $loginOrEmail login или email
     * @param string $password пароль
     * @return bool|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    private function attemptUser(string $authField, string $loginOrEmail, string $password)
    {
        $auth = Auth::attempt([$authField => $loginOrEmail, 'password' => $password]);
        if ($auth) {
            return Auth::user();
        } else {
            return false;
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse\
     */
    public function login(Request $request)
    {
        $user = $this->attemptUser($this->emailValidate($request->name), $request->name, $request->password);
        if ($user != false) {
            $roleStudent = Role::where('short_name', 'student')->first();
            if ($this->hasRole($user, $roleStudent)) {
                return redirect()->route('profile');
            } else {
                return redirect()->route('teacher.profile');
            }
        } else {
            return redirect()->back()->withErrors('Неверный логин или пароль');
        }

//        if ($this->emailValidate($request->name) === 'login') { // авторизация по login
//
//        } else { // авторизация по email
//            $user = $this->attemptUser('email', $request->name, $request->password);
//            if ($user != false) {
//                $roleStudent = Role::where('short_name', 'student')->first();
//                if ($this->hasRole($user, $roleStudent)) {
//                    return redirect()->route('profile');
//                } else {
//                    return redirect()->route('teacher.profile');
//                }
//            } else {
//                return redirect()->back()->withErrors('Неверный логин или пароль');
//            }
//        }
    }
}
