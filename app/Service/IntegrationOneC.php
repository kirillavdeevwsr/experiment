<?php

namespace App\Service;

use App\Models\Specialty;
use App\Models\Schedule;
use App\Models\ScheduleFix;
use Carbon\Carbon;
use GuzzleHttp\Client;


class IntegrationOneC
{

    const WEEKDAYS = [
        0 => 'Воскресение',
        1 => 'Понедельник',
        2 => 'Вторник',
        3 => 'Среда',
        4 => 'Четверг',
        5 => 'Пятница',
        6 => 'Суббота',
    ];

    const WEEKTYPES = [
        0 => '',
        1 => 'Нечетная',
        2 => 'Четная',
    ];


    const API = 'http://1capi.uksivt.ru/api/';
//    const API = '172.17.5.10/api/';


    /**
     * Aвторизация на 1capi.uksivt.ru
     * @return string
     */
    private function getAuthSequencia()
    {
        if (isset($_COOKIE['token1cApi'])) {
            return $_COOKIE['token1cApi'];
        } else {
            $data = [
                'login' => 'АгарковОВ',
                'password' => 'qzwxec123'
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, self::API . 'auth?' . http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            $res = json_decode(curl_exec($ch), true);
            $token = $res['data']['token'];
            setcookie('token1cApi', $token, time() + 900); // токен на 15 мин
            return $token;
        }
    }

    /**
     * Получение шаблона расписания из базы 1с
     * @return bool
     */
    public function getSchedule()
    {

        $ch = curl_init();
        $token = $this->getAuthSequencia();
        curl_setopt($ch, CURLOPT_URL, self::API . 'schedule?token=' . $token);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $res = json_decode(curl_exec($ch), true);
        $sche = $res['data']['schedule'];
        //записть расписания на месяц в бд
        if ($sche) {
            DB::table('schedules')->delete();
        }
        foreach ($sche as $key => $value) {
            for ($i = 0; $i < count($value['schedule']); $i++) {
                $schedule = new Schedule();
                $schedule->period = $value['period']['name'];
                $schedule->semester = $value['period']['name'][0];
                $schedule->branch = $value['branch']['name'];
                $schedule->group = $value["schedule"][$i]['group']['name'];
                $schedule->subgroup = $value["schedule"][$i]['subgroup'];
                $schedule->week_type = array_search($value["schedule"][$i]['weekType'], self::WEEKTYPES);
                $schedule->lesson_position = $value["schedule"][$i]['lessonPosition'];
                $schedule->discipline = $value["schedule"][$i]['discipline']['shortName'];
                $schedule->teacher = $value["schedule"][$i]['teacher']['name'];
                $schedule->room = $value["schedule"][$i]['room']['name'];
                $schedule->week_day = array_search($value["schedule"][$i]['weekDay'], self::WEEKDAYS);
                $schedule->save();
            }
        }
        return true;
    }


    /**
     *
     */
    public function getScheduleForDate()
    {
        $date = Carbon::tomorrow()->format('Y-m-d');
        $dateLast = Carbon::today()->subDays(7)->format('Y-m-d');
        DB::table('schedule_fixes')->whereDate('date', '<', $dateLast)->delete();
        $ch = curl_init();
        $token = $this->getAuthSequencia();
        curl_setopt($ch, CURLOPT_URL, self::API . 'dschedule?token=' . $token . "&date=" . $date);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $res = json_decode(curl_exec($ch), true);
//                return dd($fix);
        if ($res['status_code'] === 200) {
            foreach ($res['data']['schedule'] as $key => $value) {
                $sche = $value['schedule'];
                if ($sche === []) {
                    continue;
                } else {
                    foreach ($sche as $k => $v) {
                        $fix = new ScheduleFix();
                        $fix->period = $value['period']['name'];
                        $fix->branch = $value['branch']['name'];
                        $fix->week_type = array_search($value['weekType'], self::WEEKTYPES);
                        $fix->subgroup = $v['subgroup'];
                        $fix->week_day = array_search($value['weekDay'], self::WEEKDAYS);
                        $fix->lesson_position = $v['lessonPosition'];
                        $fix->teacher = $v['teacher']['name'];
                        $fix->room = $v['room']['name'];
                        $fix->group = $v['group']['name'];
                        $fix->discipline = $v['discipline']['shortName'];
                        $fix->date = $date;
                        $fix->save();
                    }
                }
            }
        } else {
            return abort(500);
        }
    }


    public function getSpec()
    {
        $ch = curl_init();
        $token = $this->getAuthSequencia();
        curl_setopt($ch, CURLOPT_URL, self::API . 'specialities?token=' . $token);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $res = json_decode(curl_exec($ch), true);

        if ($res['data']['specialities']) {
            foreach ($res['data']['specialities'] as $specialty) {
                if (empty(Specialty::where('ref_key', $specialty['ref_key'])->first())) {
                    $spec = new Specialty();
                    $spec->fill($specialty);
                    $spec->save();
                }
            }
        } else {
            return abort(500);
        }

    }


    public function getUser($data)
    {
        $ch = curl_init();
        $token = $this->getAuthSequencia();
        if ($token) {
            curl_setopt($ch, CURLOPT_URL, self::API . 'user?token=' . $token . "&" . http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            $user = json_decode(curl_exec($ch), true);
            return $user['data'];
        }
    }

    public function getStudentAssesssments($key, $month)
    {
        $ch = curl_init();
        $token = $this->getAuthSequencia();
        curl_setopt($ch, CURLOPT_URL, self::API . 'rating?token=' . $token . '&student_ref_key=' . $key . '&period=' . $month);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $res = json_decode(curl_exec($ch), true);
        return $res['data'];
    }

    public function sendEnrollee($data)
    {
        $ch = curl_init();
        $token = $this->getAuthSequencia();
        $data['token'] = $token;
        curl_setopt($ch, CURLOPT_URL, self::API . 'enrollee');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $res = json_decode(curl_exec($ch), true);
//        return dd($res);
//        die();
        if ($res['status_code'] != 200) {
            return false;
        } else {
            return $res['data'];
        }


    }

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTeachers()
    {
        $client = new Client();
        $token = $this->getAuthSequencia();
        $result = $client->request('GET', self::API . "getEmployees", ['query' => [
            'token' => $token
        ]]);
        $result = json_decode($result->getBody()->getContents());
        if ($result->status_code != 200)
            return false;
        return $result->data;
    }

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDepartments()
    {
        $client = new Client();
        $token = $this->getAuthSequencia();
        $result = $client->request('GET', self::API . "getDepartments", ['query' => [
            'token' => $token
        ]]);
        $result = json_decode($result->getBody()->getContents());
        if ($result->status_code != 200)
            return false;
        return $result->data;
    }

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSpecialties()
    {
        $client = new Client();
        $token = $this->getAuthSequencia();
        $result = $client->request('GET', self::API . 'getSpec', ['query' => [
            'token' => $token
        ]]);
        $result = json_decode($result->getBody()->getContents());
        if ($result->status_code != 200)
            return false;
        return $result->data;
    }

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getGroups()
    {
        $client = new Client();
        $token = $this->getAuthSequencia();
        $result = $client->request('GET', self::API . 'getGroups', ['query' => [
            'token' => $token
        ]]);
        $result = json_decode($result->getBody()->getContents());
        if ($result->status_code != 200)
            return false;
        return $result->data;
    }

    public function getStudentByPassport(string $serial, string $number)
    {
        $client = new Client();
        $token = $this->getAuthSequencia();
        $result = $client->request('POST', self::API . 'getStudentByPassport?token=' . $token, ['form_params' => [
            "serial" => $serial,
            "number" => $number
        ]]);
        $result = json_decode($result->getBody()->getContents());
        if ($result->status_code == 200) {
            $data['error'] = null;
            return $result->data;
        } else if ($result->status_code == 404 && $result->data == "Not found")
            return ['error' => ['code' => 404, 'message' => "Not found"]];
    }
}
