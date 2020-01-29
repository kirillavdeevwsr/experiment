<?php

namespace App\Http\Controllers\College;

use App\Models\Schedule;
use App\Models\ScheduleFix;
use Carbon\CarbonInterval;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\IntegrationOneC;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Date\Date;

class ProfileController extends Controller
{
    private $integration;

    public function __construct(IntegrationOneC $integration)
    {
        $this->integration = $integration;
    }

    public function showProfile(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::now(new \DateTimeZone('Asia/Yekaterinburg'));
        $day = Date::parse($today)->format('d F Y');
        $weekTypeAsKey = $this->getWeekType($today);
        $weekType = $this->integration::WEEKTYPES[$weekTypeAsKey];
        return view('college.profile', compact(['user']));
    }


    private function getWeekType($day)
    {
        $day = Carbon::parse($day);
        $start = Carbon::createFromDate($day->year, 9, 1, 'Asia/Yekaterinburg');
//        return dd($day->diffInWeeks($start));
        if ($day->diffInWeeks($start) % 2 == 0) {
            return 2;
        } else {
            return 1;
        }
    }

    public function showSchedule(Request $request)
    {
        $day = Carbon::parse($request->data);
        $weekType = $this->getWeekType($day);
        $sche['lessons'] = [0, 1, 2, 3, 4, 5, 6];
        $sche['day'] = $day->dayOfWeek;
        if ($day->month < 8) {
            $curSemester = 2;
        } else {
            $curSemester = 1;
        }
//        if (session()->get('user')['isStudent']===true){
        $sche['isStudent'] = 1;
        if (ScheduleFix::where('date', $day)->where('group', auth()->user()->additionalStudent->group->name)->first()) {
            $scheduleForDate = ScheduleFix::whereDate('date', $day->format('Y-m-d'))
                ->where('group', auth()->user()->additionalStudent->group->name)->get();
        } else {
            $scheduleForDate = Schedule::where('week_day', $day->dayOfWeek)
                ->where('group', auth()->user()->additionalStudent->group->name)->where('semester', $curSemester)->get();
        }
//        }else{
//            $sche['isStudent']=0;
//            if(ScheduleFix::where('date', $day)->where('teacher', session()->get('user')['fullname'])->first()){
//                $scheduleForDate = ScheduleFix::where('teacher', session()->get('user')['fullname'])
//                    ->whereDate('date', $day->format('Y-m-d'))->get();
//            }
//            else{
//                $scheduleForDate = Schedule::where('week_day', $day->dayOfWeek)->where('semester', $curSemester)
//                    ->where('teacher', session()->get('user')['fullname'])->get();
//            }
//        }

        foreach ($scheduleForDate as $lesson) {
            if ($lesson->week_type !== $weekType and $lesson->week_type !== 0) {
                continue;
            }
            if ((int)$lesson->subgroup !== 0) {
                if (is_array($sche['lessons'][(int)$lesson->lesson_position])) {
                    $sche['lessons'][(int)$lesson->lesson_position][$lesson->subgroup] = $lesson;
                } else {
                    $sche['lessons'][(int)$lesson->lesson_position] = array($lesson->subgroup => $lesson);
                }

            } else {
                $sche['lessons'][(int)$lesson->lesson_position] = $lesson;
            }
        }
        return new JsonResponse ($sche);
    }


    public function getCurrentWeek(Request $request)
    {
        $today = Carbon::parse($request->data);
        $period = CarbonPeriod::create($today, 7);
        $week = [];
        foreach ($period as $day) {
            $week[$day->dayOfWeek] = [];
            $weekTypeAsString = $this->integration::WEEKTYPES[$this->getWeekType($day)];
            if ($day->dayOfWeek === 0) {
                continue;
            } else {
                $week[$day->dayOfWeek] = [Date::parse($day)->format('d F Y')];
                array_push($week[$day->dayOfWeek], $day->format('d F Y'));
                array_push($week[$day->dayOfWeek], $this->integration::WEEKDAYS[$day->dayOfWeek]);
                array_push($week[$day->dayOfWeek], $day->dayOfWeek);
                array_push($week[$day->dayOfWeek], $weekTypeAsString . " неделя");
            }
        }
        return new JsonResponse ($week);
    }


    public function showAssessments()
    {
        return view('college.assessments');
    }

    public function getScheduleForSemester()
    {
        $this->integration->getSchedule();
        return redirect('/');
    }

    public function getAssessments(Request $request)
    {
        $year = Carbon::now()->year;
        $ref_key = auth()->user()->additionalStudent->ref_key_student;
        $month = Carbon::createFromDate($year, $request->data)->format('Y-m');
//        $month = '2018-01';
        $data = $this->integration->getStudentAssesssments($ref_key, $month);;
        $assessments = [];
        foreach ($data['rating'] as $number => $values) {
            $name = $values['discipline']['fullName'];
            $date = Carbon::parse($values['date'])->day;
            if (array_key_exists($name, $assessments) === false) {
                $assessments[$name] = [];
            }
            if ($values['presence'] === false) {
                $assessments[$name][$date][] = [
                    'rate' => 'нб',
                    'type' => $values['type'],
                    'presence' => $values['presence']
                ];
            } else if ($values['rate'] == 0) {
                $assessments[$name][$date][] = [
                    'rate' => '',
                    'type' => $values['type'],
                    'presence' => $values['presence']
                ];
            } else {
                $assessments[$name][$date][] = [
                    'rate' => $values['rate'],
                    'type' => $values['type'],
                    'presence' => $values['presence']
                ];
            }
        }
        return new JsonResponse($assessments);

    }

    public function getMonthData(Request $request)
    {
        $month = $request->data + 1;
        $year = Carbon::now()->year;
        $month2 = Carbon::createFromDate($year, $month);
        $days = $month2->daysInMonth;
        $name = Date::parse($month2)->format(' F ');
        return new JsonResponse($days);

    }

}

