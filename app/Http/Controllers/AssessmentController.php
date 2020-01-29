<?php

namespace App\Http\Controllers;

use App\Models\Assessment\AssessmentList;
use App\Models\Assessment\AssessmentListUser;
use App\Models\Assessment\AssessmentPeriodicity;
use App\Models\Role;
use App\Models\Statuses;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Date\Date;

class AssessmentController extends Controller
{
    private $nowDate;
    private $semestr;
    private $currSem;
    private $path;

    public function __construct()
    {
        $this->nowDate = Date::now();
//        $this->nowDate = Date::create(2019, 12, 10, 23, 55, 00);
        $this->semestr = [
            'first_sem' => [
                Date::create($this->nowDate->year, 9, 1, 00, 00, 00),
                Date::create($this->nowDate->year, 12, 31, 23, 59, 00)
            ],
            'second_sem' => [
                Date::create($this->nowDate->year, 1, 1, 00, 00, 00),
                Date::create($this->nowDate->year, 6, 30, 23, 59, 59)
            ]
        ];
        if ($this->nowDate->between($this->semestr['first_sem'][0], $this->semestr['first_sem'][1]))
            $this->currSem = $this->semestr['first_sem'];
        else
            $this->currSem = $this->semestr['second_sem'];

        $this->path = public_path() . '/assessments/';
    }

    private function hasRole(User $user, Role $role)
    {
        if ($user->roles->contains($role)) return true;
        return false;
    }

    private function generateDocumentName($extension)
    {
        return time() . '.' . $extension;
    }

    /**
     * @param $image
     * @param bool $imageName
     */
    private function uploadFile($document)
    {
        $extension = $document->getClientOriginalExtension();
        $documentName = null;
        $documentName = $this->generateDocumentName($extension);
        $document->move($this->path, $documentName);
        return '/assessments/' . $documentName;
    }

    private function addStatusName(Collection $collection)
    {
        return $collection->transform(function ($item) {
            if ($item->status->short_name === 'success') $item['status_color'] = "success";
            elseif ($item->status->short_name === 'denied') $item['status_color'] = "danger";
            return $item;
        });
    }

    /**
     * Получение отчетного периода для выборки данных
     * @return array
     */
    private function getPeriod(): array
    {
        $dates = [];
        if ($this->nowDate->month == 12) { // если декаберь месяц, то особый период
            if ($this->nowDate->day <= 1 && $this->nowDate->day >= 6) {
                $dates[0] = Date::create($this->nowDate->year, $this->nowDate->month - 1, 6, 00, 00, 00);
                $dates[1] = Date::create($this->nowDate->year, $this->nowDate->month, 5, 23, 59, 00);
            } else {
                $dates[0] = Date::create($this->nowDate->year, 12, 6, 00, 00, 00);
                $dates[1] = Date::create($this->nowDate->year, 12, 20, 23, 59, 00);
            }
        } else if ($this->nowDate->month == 1) {
            $dates[0] = Date::create($this->nowDate->year, $this->nowDate->month, 6, 00, 00, 00);
            $dates[1] = Date::create($this->nowDate->year, $this->nowDate->month + 1, 5, 23, 00, 00);
        } else { //обычный период
            if ($this->nowDate->day >= 1 && $this->nowDate->day <= 5) {
                $dates[0] = Date::create($this->nowDate->year, $this->nowDate->month - 1, 6, 00, 00, 00);
                $dates[1] = Date::create($this->nowDate->year, $this->nowDate->month, 5, 23, 59, 00);
            } else {
                $dates[0] = Date::create($this->nowDate->year, $this->nowDate->month, 6, 00, 00, 00);
                $dates[1] = Date::create($this->nowDate->year, $this->nowDate->month + 1, 5, 23, 59, 00);
            }
        }
        return $dates;
    }

    /**
     *  Получение отчетного периода для проверки критериев
     * @return array
     */
    private function getPeriodForCheck(): array
    {
        $dates = [];
        if ($this->nowDate->month == 12) {
            if ($this->nowDate->day >= 1 && $this->nowDate->day <= 10) {
                $dates[0] = Date::create($this->nowDate->year, $this->nowDate->month - 1, 6, 00, 00, 00);
                $dates[1] = Date::create($this->nowDate->year, 12, 10, 23, 59, 00);
            } else {
                $dates[0] = Date::create($this->nowDate->year, 12, 6, 00, 00, 00);
                $dates[1] = Date::create($this->nowDate->year, 12, 23, 23, 59, 00);
            }
        } else if ($this->nowDate->month == 1) {
            $dates[0] = Date::create($this->nowDate->year, $this->nowDate->month, 6, 00, 00, 00);
            $dates[1] = Date::create($this->nowDate->year, $this->nowDate->month + 1, 10, 23, 59, 00);
        } else {
            if ($this->nowDate->day >= 1 && $this->nowDate->day <= 10) {
                $dates[0] = Date::create($this->nowDate->year, $this->nowDate->month - 1, 6, 00, 00, 00);
                $dates[1] = Date::create($this->nowDate->year, $this->nowDate->month, 10, 23, 59, 00);
            } else {
                $dates[0] = Date::create($this->nowDate->year, $this->nowDate->month, 6, 00, 00, 00);
                $dates[1] = Date::create($this->nowDate->year, $this->nowDate->month + 1, 10, 23, 59, 00);
            }
        }
        return $dates;
    }

    private function getDiffDate($date): string
    {
        if ($date->diffInDays($this->nowDate) == 0) {
            if ($date->diffInHours($this->nowDate) == 0) {
                $reportingPeriod = $date->diffInMinutes($this->nowDate) . ' м.';
            } else {
                $reportingPeriod = $date->diffInHours($this->nowDate) . ' ч.';
            }
        } else {
            $reportingPeriod = $date->diffInDays($this->nowDate) . ' д.';
        }

        return $reportingPeriod;
    }

    /**
     * Получение отчетного периода для отображения преподавателю
     * @return string
     */
    private function getPeriodForTeacher(): string
    {
        $textPre = "Отчетный период заканчивается через ";
        if ($this->nowDate->month == 12) { // ограничение для декабря месяца
            if ($this->nowDate->day > 20) {
                $textPre = "Лист самооценки на текующий семестр закрыт.";
                $reportingPeriod = "";
            } else if($this->nowDate->day >= 1 && $this->nowDate->day <= 5) {
                $date = Date::create($this->nowDate->year, $this->nowDate->month, 5,23,59,59);
                $reportingPeriod = $this->getDiffDate($date);
            }else {
                $date = Date::create($this->nowDate->year, 12, 20, 23, 59, 00);
                $reportingPeriod = $this->getDiffDate($date);
            }
        } else if ($this->nowDate->month == 1) {
            if ($this->nowDate->day >= 1 && $this->nowDate->day <= 5) {
                $reportingPeriod = "";
                $textPre = "Отчетный период еще не начался.";
            } else {
                $date = Date::create($this->nowDate->year, $this->nowDate->month + 1, 5, 23, 59, 00);
                $reportingPeriod = $this->getDiffDate($date);
            }
        } else { // если не конец месяца, то обычный период
            if ($this->nowDate->day <= 5 ?? $this->nowDate->day >= 1) {
                $date = Date::create($this->nowDate->year, $this->nowDate->month, 5, 23, 59, 00);
                $reportingPeriod = $this->getDiffDate($date);
            } else {
                $date = Date::create($this->nowDate->year, $this->nowDate->month + 1, 5, 23, 59, 00);
                $reportingPeriod = $this->getDiffDate($date);
            }
        }

        return $textPre . $reportingPeriod;
    }

    private function getUserAssessments() //заполненные критерии преподом за отчетный период
    {
        $dates = $this->getPeriod();
        return $this->addStatusName(auth()->user()->assessments()->whereBetween('created_at', $dates)->orderBy('updated_at', 'DESC')->get()->toBase());
    }

    public function index()
    {
        $period = $this->getPeriod();
        $statuses = Statuses::all();
        $dates = collect([
            'now' => $this->nowDate->format('d F Y'),
            'reporting_period' => $this->getPeriodForTeacher()]);
        $summary_periodicity = AssessmentPeriodicity::where('name', 'like', '%1 раз в семестр%')->get()->pluck('id');
        $assessmentsOneOfSem = AssessmentList::whereIn('summary_periodicity', $summary_periodicity)->get(); // критерии, которые заполняются раз в семестр
        $userAssessmentOneOfSem = auth()->user()->assessments()
            ->whereBetween('created_at', [$this->currSem[0], $period[1]])
            ->whereIn('assessment_id', $assessmentsOneOfSem->pluck('id'))
            ->where('status_id', $statuses->firstWhere('short_name', 'success')->id)
            ->get();

        $userAssessment = $this->getUserAssessments();
        $checking = AssessmentList::where('responsible_id', auth()->user()->id)->get();
        $periodForCheck = $this->getPeriodForCheck();
        if ($this->nowDate->month == 12 && $this->nowDate->day > 23) {
            $checking = 0;
        } else {
            $checking = DB::table('assessment_list_user') // получаем сколько критериев надо проверить
            ->join('assessment_list', 'assessment_list_user.assessment_id', '=', 'assessment_list.id')
                ->where('status_id', '=', $statuses->firstWhere('short_name', 'new')->id)
                ->where('responsible_id', auth()->user()->id)
                ->whereBetween('created_at', $periodForCheck)->count();
        }
        $assessmentSumPoint = $userAssessment->where('status_id', $statuses->firstWhere('short_name', 'success')->id)->pluck('point')->sum();
        $assessmentSumPoint += $userAssessmentOneOfSem->sum('point');

        return view('teacher.assessment.index', [
            'dates' => $dates,
            'assessment' => [
                'assessments' => $userAssessment->sortBy('criterion'),
                'assessmentsSumPoint' => $assessmentSumPoint
            ],
            'checking' => $checking,
        ]);
    }

    public function create()
    {
        if ($this->nowDate->month == 12 && $this->nowDate->day > 20) {
            return redirect()->back()->withErrors('Лист самооценки на текущий семестр закрыт.');
        }
        return view('teacher.assessment.create');
    }

    public function initData()
    {
        $period = $this->getPeriod();
        $user = auth()->user();
        $statuses = Statuses::all();
        $summary_periodicity = AssessmentPeriodicity::where('name', 'like', '%Ежемесячно%')->first()->id;
        $assessmentsOneOfMonth = AssessmentList::where('summary_periodicity', $summary_periodicity)
            ->with('periodicity', 'frequencyPayment', 'criterions')->get();// все критерии, которые заполняются раз в месяц

        $assessmentsUser = new Collection(); // каждый последний заполненный критерий со статусом новый или подтвержденный
        foreach ($assessmentsOneOfMonth as $item) {
            $tmp = AssessmentListUser::where('user_id', $user->id)
                ->whereBetween('created_at', $period)
                ->where('assessment_id', $item->id)
                ->get()->last();
            if (empty($tmp)) {//если не нашелся заполненный критерий преподом, то возвращаем критерий
                $assessmentsUser->push($item);
            } else {
                if ($item->multi_add) { //если заполняется несколько раз за отчетный период, то возвращаем критерий
                    $assessmentsUser->push($item);
                } else { // если статус заполненного критерия не новый или не подтвержденный, то возвращаем критерий
                    if ($tmp->status_id != $statuses->firstWhere('short_name', 'new')->id && $tmp->status_id != $statuses->firstWhere('short_name', 'success')->id)
                        $assessmentsUser->push($item);
                }

            }
        }
        $summary_periodicity = AssessmentPeriodicity::where('name', 'like', '%1 раз в семестр%')->get()->pluck('id');
        $assessmentsOneOfSem = AssessmentList::whereIn('summary_periodicity', $summary_periodicity)
            ->with('periodicity', 'frequencyPayment', 'criterions')->get(); // критерии, которые заполняются раз в семестр
        $assessments = new Collection();
        foreach ($assessmentsOneOfSem as $item) {
            $tmp = AssessmentListUser::where('user_id', $user->id)
                ->whereBetween('created_at', $this->currSem)
                ->where('assessment_id', $item->id)
                ->get()->last();
            if (empty($tmp)) { //если не был найден заполненный критерий, то возвращаем этот критерий
                $assessments->push($item);
            } else { // если статус заполненного критерия не новый или не подтвержденный, то возвращаем критерий
                if ($tmp->status_id != $statuses->firstWhere('short_name', 'new')->id && $tmp->status_id != $statuses->firstWhere('short_name', 'success')->id)
                    $assessments->push([$tmp->status_id != $statuses->firstWhere('short_name', 'new')->id, $tmp->status_id != $statuses->firstWhere('short_name', 'success')->id]);
            }
        }

        $assessments = $assessmentsUser->concat($assessments)->sortBy("criterion", SORT_NATURAL)->values();

        return response($assessments, 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'criterion' => 'required',
            'file' => 'required',
            'file.*' => 'mimes:png, jpg, jpeg, pdf, docx, doc, xlsx, xls',
            'points' => 'required'
        ]);

        if ($validator->fails())
            return response($validator->errors()->all(), 400);

        $file = $request->file('file');
        $points = json_decode($request->points);
        $req = new AssessmentListUser();
        $req->user_id = auth()->user()->id;
        $req->assessment_id = $request->criterion;
        $req->status_id = Statuses::where('short_name', 'new')->first()->id;
        $req->timestamps;
        $req->point = $points->point;
        $req->point_id = $points->id_point;
        $req->attachment = $this->uploadFile($file);
        $req->save();
        return response(['Критерий успешно отправлен на проверку!'], 200);
    }

    private function addPeriodForCheckCriterion(Collection $data): Collection {

        $data = $data->transform(function($item){
            $dateCrit = Date::parse($item->created_at);
            $item['forPeriod'] = $dateCrit->day >= 1 && $dateCrit->day <= 5 ? $dateCrit->subMonth(1)->englishMonth : $dateCrit->englishMonth;
            return $item;
        });
        return $data;
    }

    public function checkCriterion()
    {
        $periodForCheck = $this->getPeriodForCheck();
        $statuses = Statuses::all();
        $asssessments = new Collection();
        AssessmentList::where('responsible_id', auth()->user()->id)->get()->filter(function ($item) use ($statuses, $periodForCheck, $asssessments) {
            $crit = $item->assessments()
                ->whereBetween('created_at', $periodForCheck)
                ->where('status_id', $statuses->firstWhere('short_name', 'new')->id)->get();
            $crit = $this->addPeriodForCheckCriterion($crit);
            $asssessments->push($crit);
        });
        if ($this->nowDate->month == 12 && $this->nowDate->day > 23) {
            $asssessments = null;
        } else {
            $asssessments = $asssessments->collapse();
        }
        return view('teacher.assessment.check', ['assessments' => $asssessments]);
    }

    public function changeStatus(Request $request, $id, $status)
    {
        if ($status == 'danger') $status = 'denied';
        $assessment = AssessmentListUser::find($id);
        $assessment->status_id = Statuses::where('short_name', $status)->first()->id;
        if ($request->description)
            $assessment->description = $request->description;
        else
            $assessment->description = null;
        $assessment->updated_at = Carbon::now();
        $assessment->save();
        return redirect()->route('teacher.assessment.check')->with('success', 'Успешно изменено!');
    }

    public function change($id, $status)
    {
        $assessment = AssessmentListUser::find($id);
        return view('teacher.assessment.changeStatus', ['assessment' => $assessment, 'status' => $status]);
    }

    public function archiveShow()
    {
        return view('teacher.assessment.archive');
    }

    public function archiveData(Request $request)
    {
        $period = Date::parse($request->period);
        $dates = [
            Date::create($period->year, $period->month, 6, 00, 00, 00),
            $period->month != 12
                ? Date::create($period->year, $period->month + 1, 5, 23, 59, 59)
                : Date::create($period->year + 1, 1, 5, 23, 59, 59)
        ];
        $summaryPeriodicity = AssessmentPeriodicity::where('name', 'like', '%Ежемесячно%')->first();
        /*Критерии заполняемые раз в месяц*/
        $userAssessments = auth()->user()->assessments()->whereBetween('created_at', $dates)->whereHas('assessment', function ($q) use ($summaryPeriodicity) {
            $q->where('summary_periodicity', $summaryPeriodicity->id);
        })->with('assessment')->get();
        $userAssessments = $this->addStatusName($userAssessments);
        $summaryPeriodicity = AssessmentPeriodicity::where('name', 'like', '%1 раз в семестр%')->get()->pluck('id');
        if ($period->between($this->currSem[0], $this->currSem[1])) {

            $userAssessmentsOneOfSem = auth()->user()->assessments()->whereBetween('created_at', [$this->currSem[0], $dates[1]])->whereHas('assessment', function ($q) use ($summaryPeriodicity) {
                $q->whereIn('summary_periodicity', $summaryPeriodicity);
            })->with('assessment')->get();
            $userAssessmentsOneOfSem = $this->addStatusName($userAssessmentsOneOfSem);
        }

        $statuses = Statuses::all();
        $data = [
            'data' => $userAssessments,
            'dataSem' => $userAssessmentsOneOfSem,
            'acceptedPoint' => $userAssessments->where('status_id', $statuses->firstWhere('short_name', 'success')->id)->sum('point')
                + $userAssessmentsOneOfSem->where('status_id', $statuses->firstWhere('short_name', 'success')->id)->sum('point'),
            'notAcceptedPoint' => $userAssessments->where('status_id', $statuses->firstWhere('short_name', 'new')->id)->sum('point')
                + $userAssessmentsOneOfSem->where('status_id', $statuses->firstWhere('short_name', 'new')->id)->sum('point'),
            'declinedPoint' => $userAssessments->where('status_id', $statuses->firstWhere('short_name', 'denied')->id)->sum('point')
                + $userAssessmentsOneOfSem->where('status_id', $statuses->firstWhere('short_name', 'denied')->id)->sum('point'),

        ];
        if (!$userAssessments->isEmpty() || !$userAssessmentsOneOfSem->isEmpty())
            return response($data, 200);
        return response("Not found", 400);
    }

    public function reportShow()
    {
        return view('teacher.assessment.report');
    }

    public function reportAccountant(Request $request) //отчет для бухгалтерии
    {
        $month = Date::parse($request->month);
        $dates = [
            Date::create($month->year, $month->month, 6, 00, 00, 00),
            Date::create($month->year, $month->month + 1, 5, 23, 59, 00)
        ];
        $users = User::all();
        $roleTeacher = Role::where('short_name', 'teacher')->first();
        $statusAccept = Statuses::where('short_name', 'success')->first()->id;
        $assessments = new Collection();
        foreach ($users as $user) {
            if ($this->hasRole($user, $roleTeacher)) {
                $data = [];
                $data['full_name'] = $user->full_name;
                $assessmentsUserPoints = AssessmentListUser::whereHas('assessment', function ($q) { // получаем все подтвержденные критерии, которые заполняются раз в месяц и суммируем баллы
                    return $q->where('summary_periodicity', AssessmentPeriodicity::where('name', 'like', '%Ежемесячно%')->first()->id);
                })->where('user_id', $user->id)
                    ->whereBetween('created_at', $dates)
                    ->where('status_id', $statusAccept)->get()->pluck('point')->sum();
                $data['points'] = $assessmentsUserPoints;
                if ($month->between($this->currSem[0], $this->currSem[1])) {
                    $assessmentsUserPoints = AssessmentListUser::whereHas('assessment', function ($q) { // получаем все подтвержденные критерии, которые заполняются раз в семестр и суммируем баллы
                        return $q->whereIn('summary_periodicity', AssessmentPeriodicity::where('name', 'like', '%1 раз в семестр%')->get()->pluck('id'));
                    })->where('user_id', $user->id)
                        ->whereBetween('created_at', [$this->currSem[0], $dates[1]])
                        ->where('status_id', $statusAccept)->get()->pluck('point')->sum();
                    $data['points'] += $assessmentsUserPoints;
                }
                $assessments->push($data);
            }
        }
        if ($assessments->isEmpty())
            return response("Not found", 400);
        $summaryPoints = $assessments->pluck('points')->sum();
        $assessments = collect(['data' => $assessments->sortBy('full_name')->values(), 'summary_points' => $summaryPoints]);
        return response($assessments, 200);
    }

    public function initDataByTeacher() {
        $roleTeacher = Role::where('short_name', 'teacher')->first()->id;
        $users = User::whereHas('roles', function($q) use ($roleTeacher){
            $q->where('role_id', $roleTeacher);
        })->orderBy('full_name')->get();
        if(!$users->isEmpty())
            return response($users, 200);
        return response("Not found", 404);
    }

    public function reportByTeacher(Request $request) {
        $date = Date::parse($request->date);
        $statuses = Statuses::all();
        $period = [
            Date::create($date->year, $date->month, 6,00,00,00),
            $date->month == 12 ?
                Date::create($date->year, $date->month, 20,23,59,00) :
                Date::create($date->year, $date->month + 1, 5,23,59,00)
        ];
        $teacher = User::find($request->teacherId);
        $assessments = $teacher ->assessments()
                                ->with(['assessment', 'users', 'assessment.responsible', 'assessment.periodicity', 'assessment.frequencyPayment', 'assessment.criterions'])
                                ->whereBetween('created_at', $period)
                                ->get();
        $assessments = $this->addPeriodForCheckCriterion($assessments);
        $assessments = $this->addStatusName($assessments);
        if($assessments->isEmpty())
            return response("Not found!", 404);
        $data = [
            'assessments' => $assessments,
            'point_accepted' => $assessments->where('status_id', $statuses->firstWhere('short_name', 'success')->id)->sum('point'),
            'point_new' => $assessments->where('status_id', $statuses->firstWhere('short_name', 'new')->id)->sum('point'),
            'point_denied' => $assessments->where('status_id', $statuses->firstWhere('short_name', 'denied')->id)->sum('point')
        ];
        return response($data, 200);
    }

    public function getAllCriterion()
    {
        $resp = AssessmentList::select(['id', 'criterion'])->get();
        return response()->json($resp);
    }

    public function reportAssessmentManager(Request $request)
    {
        $first_date = Date::parse($request->first_date)->firstOfMonth();
        $last_date = Date::parse($request->last_date)->lastOfMonth();
        $criterion = $request->criterion;
        $status = Statuses::where('short_name', 'success')->first()->id;
        $assessments = AssessmentList::find($criterion)->assessments()->whereBetween('created_at', [$first_date, $last_date])->where('status_id', $status)->get()
            ->map(function ($item) {
                $data = [];
                $assessment = $item->assessment;
                $data['full_name'] = $item->users->full_name;
                $data['criterion'] = $assessment->criterion;
                $data['criterion_assessment'] = $assessment->criterion_assessment;
                $data['responsible'] = $assessment->user->full_name;
                $data['unit_of_measure'] = $assessment->unit_of_measure;
                $data['data_source'] = $assessment->data_source;
                $data['summary_periodicity'] = $assessment->periodicity->name;
                $data['frequency_of_payment'] = $assessment->frequencyPayment->name;
                $data['points'] = $item->point;
                $data['attachment'] = $item->attachment;
                return $data;
            });
        $counts = ['summary_points' => $assessments->pluck('points')->sum(), 'count_assessment' => $assessments->count()];
        return response()->json(['data' => $assessments, 'counts' => $counts]);
    }

    public function deleteCriterion(Request $request, AssessmentListUser $assessmentListUser)
    {
        $assessmentListUser->delete();
        return redirect()->back()->with('success', 'Успешно удалено!');
    }
}