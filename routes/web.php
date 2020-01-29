<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/admin/delefile/journal/send','JournalController@send');
Route::post('/admin/delefile/journal/save', 'JournalController@save');
Route::get('/admin/delefile/journal/save', 'JournalController@callName');


Route::get('/admin/delefile/journal/bringOut','JournalController@bringOut');
Route::post('/admin/delefile/journal/bringOut','JournalController@bringOutSend');
Route::get('/admin/delefile/journal/export','JournalController@export');








//Auth::routes();
Route::get('/', 'MainController@showMain')->name('main');
Route::get('news/slug', 'Admin\NewsController@addSlug');
Route::get('pages/slug', 'Admin\PageController@addSlug');

/*Auth routes*/
Route::get('login', 'College\CollegeAuthController@showLogin')->name('1c_login');
Route::post('login', 'College\CollegeAuthController@login')->name('login_post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register/step/1', 'College\RegisterController@showForm_step_1')->name('register_1');
Route::get('register/step/2', 'College\RegisterController@showForm_step_2')->name('register_2');
Route::post('register/step/1/post', 'College\RegisterController@register_step_1')->name('register_1_post');
Route::post('register/step/2/post', 'College\RegisterController@register_step_2')->name('register_2_post');
/*End auth routes*/

Route::get('ostavit-zayavku-na-postuplenie', 'College\EnrolleeController@show');

Route::prefix('admin')->middleware(['auth', 'checkAdmin'])->group(function() {
    Route::get('/', "AdminController@index");
    Route::post('/users/{id}/change-password', 'AdminController@changePassword')->name('users.change_password');
    Route::post('add_img', 'Admin\NewsController@addImg');
    Route::post('news/{news}', 'Admin\NewsController@update')->name('news.update');
    Route::resource('banners', 'Admin\BannerController');
    Route::resource('news', 'Admin\NewsController')->except(['update']);
    Route::resource('page', 'Admin\PageController');
    Route::resource('courses', 'Admin\CourseController');
    Route::resource('events', 'Admin\EventController');
    Route::resource('url', 'Admin\UrlController');
    Route::resource('users', 'Admin\UsersController')->middleware('checkAdmin');
    Route::get('history', 'Admin\SiteLogController@index')->name('logs');
    Route::get('sliders', "AdminController@showSlider")->name('sliders');
    Route::post('sliders/create', "AdminController@addSlider")->name('add_slider');
    Route::post('sliders/remove', "AdminController@removeSlider")->name('remove_slider');
    Route::post('deletefile/{id}', 'Admin\NewsController@deleteFile')->name('delete_file');
    Route::get('/sync-teachers', 'AdminController@synchronizeTeachers')->name('sync.teachers');
    Route::get('/sync-groups', 'AdminController@syncGroups')->name('sync.groups');
    Route::resource('assessment/evalution', 'Admin\Assessment\AssessmentCriterionPointsController', ['as' => 'assessment']);
    Route::resource('assessment/frequency-of-payment', 'Admin\Assessment\AssessmentFrequencyOfPaymentController', ['as' => 'assessment']);
    Route::resource('assessment/summary-periodicity', 'Admin\Assessment\AssessmentPeriodicityController', ['as' => 'assessment']);
    Route::resource('assessment', 'Admin\AssessmentController'); // CRUD assessment list
    Route::resource('college/department', 'Admin\CollegeDepartmentController', ['as' => 'college']);
    Route::resource('college/specialty', 'Admin\CollegeSpecialtyController', ['as' => 'college']);
    Route::resource('college/group', 'Admin\CollegeGroupController', ['as' => 'college']);
});


Route::prefix('profile')->middleware(['auth', 'isStudent'])->group(function() {
    Route::get('/', 'College\ProfileController@showProfile')->name('profile');
    Route::get('/ocenki', 'College\ProfileController@showAssessments')->name('assessments');
    Route::get('/schedule_for_semester', 'College\ProfileController@getScheduleForSemester')->name('semester');
    Route::get('schedule', 'College\ProfileController@showSchedule');
    Route::get('getweek', 'College\ProfileController@getCurrentWeek');
    Route::get('getrate', 'College\ProfileController@getAssessments');
    Route::get('getmonthdata', 'College\ProfileController@getMonthData');
});

Route::prefix('teacher')->middleware(['auth','isTeacher'])->group(function(){
    Route::get('/', 'TeacherController@index')->name('teacher.profile');
    Route::prefix('assessment')->group(function(){
        Route::get('/', 'AssessmentController@index')->name('teacher.assessment.index');
        Route::delete('/delete-criterion/{assessmentListUser}', 'AssessmentController@deleteCriterion')->name('teacher.assessment.delete');
        Route::get('/create', 'AssessmentController@create')->name('teacher.assessment.create');
        Route::get('/create/init-data', 'AssessmentController@initData');
        Route::post('/create/store', 'AssessmentController@store')->name('teacher.assessment.store');
        Route::get('/check', 'AssessmentController@checkCriterion')->name('teacher.assessment.check')->middleware('assessment-manager');
        Route::post('/check/change-status/{id}/{status_name}', 'AssessmentController@changeStatus')->name('teacher.assessment.change-status')->middleware('assessment-manager');
        Route::get('/check/change/{id}/{status_name}', 'AssessmentController@change')->name('teacher.assessment.change')->middleware('assessment-manager');
        Route::prefix('archive')->group(function(){
            Route::get('/', 'AssessmentController@archiveShow')->name('teacher.assessment.archive');
            Route::get('/get-data', 'AssessmentController@archiveData')->name('teacher.assessment.archive.data');
        });
        Route::prefix('report')->group(function(){
            Route::get('/', 'AssessmentController@reportShow')->name('teacher.assessment.report');
            Route::get('accountant', 'AssessmentController@reportAccountant')->name('teacher.assessment.report.accountant');
            Route::get('get-criterion', 'AssessmentController@getAllCriterion');
            Route::get('assessment-manager', 'AssessmentController@reportAssessmentManager')->name('teacher.assessment.report.manager');
            Route::get('teacher/init-data', 'AssessmentController@initDataByTeacher');
            Route::get('teacher', 'AssessmentController@reportByTeacher');
        });
    });
    Route::prefix('journal')->group(function(){




        Route::get('/create','JournalController@send');
        Route::get('/get-concepts', 'JournalController@callName');
        Route::post('/store', 'JournalController@save');

        Route::get('/','JournalController@bringOut');
        Route::post('/bringOut','JournalController@bringOutSend');
        Route::get('/export','JournalController@export');
    });
});

Route::get('getSpec', 'College\EnrolleeController@getSpeciality');
Route::post('sendEnrollee', 'College\EnrolleeController@sendData')->name('sendData');

Route::prefix('novosti')->group(function(){
    Route::get('/', 'NewsController@index')->name('index_news');
    Route::get('/{slug}', 'NewsController@show')->name('show_news');
});
Route::prefix('kursy')->group(function(){
   Route::get('/', 'CourseController@index')->name('index_courses');
   Route::get('/{slug}', 'CourseController@show')->name('show_course');
   Route::post('/send', 'CourseController@sendEmail')->name('send_mail');
});

Route::prefix('eventi')->group(function(){
    Route::get('/', 'EventController@index')->name('index_events');
    Route::get('/{slug}', 'EventController@show')->name('show_event');
    Route::post('/send', 'EventController@sendEmail')->name('send_mail');
});

//Route::get('/1c/', 'College\IntegrationController@getSchedule');

Route::get('/{slug}', 'MainController@view')->name('show_page');

Route::get('/home', 'HomeController@index')->name('home');

