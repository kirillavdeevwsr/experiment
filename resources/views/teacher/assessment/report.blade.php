@extends('layouts.index')
@section('title') отчет по листу самооценки @endsection
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="card mb-3 mt-3 w-100">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @can('is-admin', auth()->user())
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#assessmentReportAccountant" role="tab" aria-controls="assessmentReportAccountant" aria-selected="true">Отчет бухгалтерии</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#assessmentReportManager" role="tab" aria-controls="assessmentReportManager" aria-selected="false">Отчет менеджера</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#assessmentReportByTeacher" role="tab" aria-controls="assessmentReportByTeacher" aria-selected="false">Отчет по преподавателю</a>
                        </li>
                    @else
                        @can('is-accountant', auth()->user())
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#assessmentReportAccountant" role="tab" aria-controls="assessmentReportAccountant" aria-selected="true">Отчет бухгалтерии</a>
                            </li>
                        @endcan

                        @can('is-assessment-manager', auth()->user())
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#assessmentReportManager" role="tab" aria-controls="assessmentReportManager" aria-selected="false">Отчет менеджера</a>
                            </li>
                        @endcan

                        @can('is-assessment-manager', auth()->user())
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#assessmentReportByTeacher" role="tab" aria-controls="assessmentReportByTeacher" aria-selected="false">Отчет по преподавателю</a>
                            </li>
                        @endcan
                    @endcan
                </ul>

                <div class="tab-content" id="myTabContent">
                    @can('is-admin', auth()->user())
                        <div class="tab-pane fade show active" id="assessmentReportAccountant" role="tabpanel" aria-labelledby="assessmentReportAccountant-tab">
                            <div class="card-body" id="assessmentReportAccountant">
                                <assessment-report-accountant></assessment-report-accountant>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="assessmentReportManager" role="tabpanel" aria-labelledby="assessmentReportManager-tab">
                            <div class="card-body" id="assessmentReportManager">
                                <assessment-report-manager></assessment-report-manager>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="assessmentReportByTeacher" role="tabpanel" aria-labelledby="assessmentReportByTeacher-tab">
                            <div class="card-body" id="assessmentReportByTeacher">
                                <assessment-report-by-teacher></assessment-report-by-teacher>
                            </div>
                        </div>
                    @else
                        @can('is-accountant', auth()->user())
                            <div class="tab-pane fade show active" id="assessmentReportAccountant" role="tabpanel" aria-labelledby="assessmentReportAccountant-tab">
                                <div class="card-body" id="assessmentReportAccountant">
                                    <assessment-report-accountant></assessment-report-accountant>
                                </div>
                            </div>
                        @endcan
                        @can('is-assessment-manager', auth()->user())
                            <div class="tab-pane fade" id="assessmentReportManager" role="tabpanel" aria-labelledby="assessmentReportManager-tab">
                                <div class="card-body" id="assessmentReportManager">
                                    <assessment-report-manager></assessment-report-manager>
                                </div>
                            </div>
                        @endcan

                        @can('is-assessment-manager', auth()->user())
                            <div class="tab-pane fade" id="assessmentReportByTeacher" role="tabpanel" aria-labelledby="assessmentReportByTeacher-tab">
                                <div class="card-body" id="assessmentReportByTeacher">
                                    <assessment-report-by-teacher></assessment-report-by-teacher>
                                </div>
                            </div>
                        @endcan
                    @endcan
                </div>
            </div>
        </div>
    </div>

@endsection