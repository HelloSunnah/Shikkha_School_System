<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\Exam\ExamController;
use App\Http\Controllers\Exam\MarkController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\School\SMSController;
use App\Http\Controllers\ClassPeriodController;
use App\Http\Controllers\School\TermController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Exam\QuestionController;
use App\Http\Controllers\School\DeviceController;
use App\Http\Controllers\School\ZktecoController;
use App\Http\Controllers\School\FinanceController;
use App\Http\Controllers\School\LibraryController;
use App\Http\Controllers\School\StudentController;
use App\Http\Controllers\School\SubjectController;
use App\Http\Controllers\School\SyllabusController;
use App\Http\Controllers\OnlineAddmissionController;
use App\Http\Controllers\Notice\NoticeViewController;
use App\Http\Controllers\School\AssignFeesController;
use App\Http\Controllers\School\AttendanceController;
use App\Http\Controllers\Lib\LanguageDetectController;
use App\Http\Controllers\School\CertificateController;
use App\Http\Controllers\School\ResultController;

//test routes
Route::get('zkteco', [App\Http\Controllers\ZktecoController::class,'zkteco']);
Route::get('test', [App\Http\Controllers\ZktecoController::class,'testOnly']);


// detect language of string
Route::post("detect/language", [LanguageDetectController::class, 'detecLanguage'])->name('detect.language');

/** --------------------Frontend Page
* =================================================================*/
Route::get("language/{local?}", [PageController::class, 'changeLanguage'])->name('change.language');
Route::post('/payment/success',[App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');


Route::middleware('language')->group(function(){
    // View Page load
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/contact', [PageController::class, 'contactPage'])->name('contact.page');
    Route::post('/contact', [PageController::class, 'contactSuppport'])->name('contact.support');
    Route::get('/feature-page', [PageController::class, 'featurePage'])->name('feature.page');
    Route::get('/feature-page/user-management', [PageController::class, 'featureU'])->name('feature.page.u');
    Route::get('/feature-page/record', [PageController::class, 'featureS'])->name('feature.page.s');
    Route::get('/feature-page/assignment-project', [PageController::class, 'featureA'])->name('feature.page.a');
    Route::get('/feature-page/sms-payroll',[PageController::class, 'featureP'])->name('feature.page.p');
    Route::get('/feature-page/online-class',[PageController::class, 'featureO'])->name('feature.page.o');
    Route::get('/feature-page/employee-management',[PageController::class, 'featureE'])->name('feature.page.e');
    Route::get('/pricing', [PageController::class, 'pricing'])->name('pricing');
    Route::get('/get/started',[PageController::class, 'getStarted'])->name('getStarted.post');
    Route::get('/signup/post/otp',[LoginController::class, 'getSignupOtp'])->name('signup.post.otp');
    Route::get('/signup',[PageController::class, 'getSignupView'])->name('signup.get');
    Route::post('/signup/post',[PageController::class, 'getSignup'])->name('signup.post');
    Route::post('/otp/send',[PageController::class, 'otpPost'])->name('otp.post');
    Route::post('/otp/resend',[PageController::class, 'otpResent'])->name('resend.otp');

    Route::get('/home',    [App\Http\Controllers\HomeController::class, 'index'])->name('user.dashboard');
    Route::view('/payment', 'amarpayment');
    Route::view('/about', 'about');
    Route::view('/privacy', 'privacy');
    Route::view('/changelog', 'changelog');
    Route::view('/feature', 'feature');
    Route::view('/term-condition', 'term_condition');
    Route::view('/videos', 'videos');
    Route::view('/blog', 'blog');
    Auth::routes();
    Route::get('/login', function(){
        return redirect()->route('school.login');
    })->name('login');

    Route::get('/login/admin', [LoginController::class, 'showAdminLoginForm']);
    Route::get('/login/school', [LoginController::class, 'showSchoolLoginForm'])->name('school.login');
    Route::get('/login/teachers', [LoginController::class, 'showTeacherLoginForm'])->name('teachers.login');
    Route::get('/register/admin', [RegisterController::class, 'showAdminRegisterForm']);
    Route::get('/register/school', [RegisterController::class, 'showSchoolRegisterForm']);
    Route::post('/login/admin', [LoginController::class, 'adminLogin']);
    Route::post('/login/schools', [LoginController::class, 'schoolLogin']);
    Route::post('/login/teachers', [LoginController::class, 'teacherLogin']);
    Route::post('/register/admin', [RegisterController::class, 'createAdmin']);
    Route::get('logout', [LoginController::class, 'logout']);

    Route::group(['middleware' => 'auth:schools'], function () {

        Route::get('school', function(){
            return redirect(route('school.dashboard'));
        });

        //school-profile
        Route::get('/receipt/show', [App\Http\Controllers\ExpenseController::class, 'receipt'])->name('Reciept.Create');
        Route::get('/getPrice/{id}', [App\Http\Controllers\ExpenseController::class, 'getPrice'])->name('getPrice');
        
        Route::get('/receipt/Show', [App\Http\Controllers\ExpenseController::class, 'receiptShow'])->name('receipt.Show')->middleware('language');

        Route::get('/accesories/create', [App\Http\Controllers\ExpenseController::class, 'accesoriesType'])->name('accesoriesType')->middleware('language');
        Route::post('/accesories/create/post', [App\Http\Controllers\ExpenseController::class, 'accesoriesTypePost'])->name('accesoriesType.post')->middleware('language');
        Route::get('/accesories/list', [App\Http\Controllers\ExpenseController::class, 'accesoriesTypeList'])->name('accesoriesType.list')->middleware('language');

        Route::get("school/profile/", [SettingsController::class, 'school_profile'])->name('school.profile');
        Route::get("school/profileEdit/{id}", [SettingsController::class, 'school_profileEdit'])->name('school.profileEdit');
        Route::put("school/profileUpdate/{id}", [SettingsController::class, 'school_profile_Update'])->name('school.profile.Update');
        Route::put("school/Password /{id}", [SettingsController::class, 'school_Password'])->name('school.Password');

        Route::get('/school/dashboard',    [App\Http\Controllers\SchoolController::class, 'school'])->name('school.dashboard');
        Route::get('/school/checkout/package',    [App\Http\Controllers\SchoolController::class, 'schoolPackageAfter'])->name('school.package.after');
        Route::post('/school/checkout/package/post',    [App\Http\Controllers\SchoolController::class, 'schoolPackageAfterPost'])->name('school.package.after.post');
        Route::get('/school/message/package',    [App\Http\Controllers\SchoolController::class, 'schoolMessage'])->name('school.message');
        Route::post('/school/message/package/post',    [App\Http\Controllers\SchoolController::class, 'schoolMessagePost'])->name('school.message.post');
        // Route::post('/school/message/package/post/checkout',    [App\Http\Controllers\SchoolController::class, 'schoolMessagePostCheckout'])->name('school.message.post.checkout');
        Route::post('/school/message/package/post/checkout',    [App\Http\Controllers\PaymentController::class, 'paymentindex'])->name('school.message.post.checkout');
        Route::get('/school/message/statement/show',    [App\Http\Controllers\SchoolController::class, 'StatementShow'])->name('school.message.post.checkout.show');
        Route::get('/school/message/usage/show',    [App\Http\Controllers\SchoolController::class, 'smsUsagesData'])->name('school.message.usage.show');
        Route::get('/pdf/statement/{id}', [App\Http\Controllers\SchoolController::class, 'StatementShowMessage'])->name('pdf.show.statement');
        Route::get('/otp',    [App\Http\Controllers\SchoolController::class, 'otpLogin'])->name('otp.login');
        Route::post('/otp/post',    [App\Http\Controllers\SchoolController::class, 'otpPostLogin'])->name('otp.login.post');
        Route::get('/acquisition',    [App\Http\Controllers\SchoolController::class, 'acquisition'])->name('acquisition');
        Route::post('/acquisition/post',    [App\Http\Controllers\SchoolController::class, 'acquisitionPost'])->name('acquisition.post');

        Route::post('/select/price/post',    [App\Http\Controllers\SchoolController::class, 'selectPricePost'])->name('selectPrice.post');
        Route::get('/price/suggest/{id}',    [App\Http\Controllers\SchoolController::class, 'priceSuggest'])->name('price.suggest');
        Route::post('/color/change',    [App\Http\Controllers\SchoolController::class, 'UserColor'])->name('user.update.post.color');

        Route::get('/StudentIdCard',[CardController::class,'idCard'])->name('id.Card');

        Route::post('/idCardPost',[CardController::class,'store'])->name('id.Card.post');
    
        Route::prefix('school')->group(function () {

            // send sms for result
            Route::get('sms/result', [SMSController::class, 'index'])->name('sms.result');
            Route::post('sms/result', [SMSController::class, 'resultSendToSms'])->name('send.sms.result');
            // ## send sms for result

            // fingerprint device
            Route::get('device', [DeviceController::class, 'index'])->name('device.index');
            Route::post('device/update', [DeviceController::class, 'update'])->name('device.update');
            Route::get("get/attendance", [AttendanceController::class, 'getAttendanceFromDevice'])->name('get.attendance.device');

            //syllabus part
            Route::get('/ajax', [AjaxController::class, 'ajaxLoaderSubject'])->name('ajax.load.subject');
            Route::get('/ajax/students', [AjaxController::class, 'ajaxLoadStudents'])->name('ajax.load.students');
            Route::post('/ajax/accesories/transaction', [AjaxController::class, 'ajaxAccesorisTransaction'])->name('ajax.load.accesories.transaction');
            Route::get('syllabus/create', [SyllabusController::class, 'SyllabusCreate'])->name('syllabus.create');
            Route::post('/create/post', [SyllabusController::class, 'SyllabusCreatePost'])->name('syllabus.create.post');
            Route::get('/ShowData', [SyllabusController::class, 'SyllabusDataShow'])->name('syllabus.data.show');
            
            Route::get('syllabus/FormShow', [SyllabusController::class, 'SyllabusFormShow'])->name('syllabus.form.show');
            Route::post('/FormShowPost', [SyllabusController::class, 'SyllabusFormPost'])->name('syllabus.form.post');

            Route::get('/edit/{id}', [SyllabusController::class, 'syllabusEdit'])->name('syllabus.edit');
            Route::PUT('/editPost/{id}', [SyllabusController::class, 'syllabusEditPost'])->name('syllabus.edit.post');
            Route::get('/delete/{id}', [SyllabusController::class, 'syllabusDelete'])->name('syllabus.delete');

            // library
            Route::get("booksCategory", [LibraryController::class, 'booksType'])->name('books.type.create');
            Route::post("booksCategory/Post", [LibraryController::class, 'booksTypePost'])->name('books.type.post');
            Route::get("booksCategoryList", [LibraryController::class, 'booksTypeList'])->name('books.type.list');


            Route::get("booksCreate", [LibraryController::class, 'booksCreate'])->name('books.create');
            Route::post("booksCreate/post", [LibraryController::class, 'booksCreatePost'])->name('books.create.post');
            Route::get("booksEdit/{id}", [LibraryController::class, 'booksEdit'])->name('books.edit');
            Route::put("booksCreatePost/{id}", [LibraryController::class, 'booksEditPost'])->name('books.edit.post');
            Route::get("booksDelete/{id}", [LibraryController::class, 'booksDelete'])->name('books.delete');
            Route::get("booksTypeDelete/{id}", [LibraryController::class, 'bookstypeDelete'])->name('books.type.delete');
            

            //borrowrer
            Route::get('borrowerinfo', [LibraryController::class, 'borrowerinfo'])->name('borrowerinfo');
            Route::get('borrowerCreate', [LibraryController::class, 'borrowerCreate'])->name('borrower.Create');
            Route::post('borrowerstore', [LibraryController::class, 'borrower_store'])->name('borrower.store');
            Route::get('borrowerdelete/{id}', [LibraryController::class, 'borrower_delete'])->name('borrower.delete');
            Route::get('borrowerEdit/{id}', [LibraryController::class, 'borrower_Edit'])->name('borrower.Edit');
            Route::put('borrowerUpdate/{id}', [LibraryController::class, 'borrower_Update'])->name('borrower.Update');

            // settings
            Route::get("setttings", [SettingsController::class, 'index'])->name('settings');
            Route::post("setttings/store", [SettingsController::class, 'store'])->name('settings.store');

            //  school period
            Route::resource('period', ClassPeriodController::class);
            Route::get('period/create/{shift?}',[ClassPeriodController::class, 'create'])->name('period.create');
            Route::get('/delete/period/{id}',[ClassPeriodController::class, 'periodDelete'])->name('period.delete');
            //  routine
            Route::resource('routine', RoutineController::class);
            Route::get('routine/show', [RoutineController::class, 'show'])->name('routine.show');
            Route::get('routine/class/edit', [RoutineController::class, 'editRoutine']);

            //class section for school start...
            Route::get('/pdf/{student_id}/{class_id}/{month}/{amount}', [App\Http\Controllers\SchoolController::class, 'pdfShow'])->name('pdf.show');
            
            Route::get('/payment/details', [App\Http\Controllers\SchoolController::class, 'schoolPaymentShow'])->name('school.payment.info');
            Route::get('/payment/statement/details', [App\Http\Controllers\SchoolController::class, 'schoolPaymentStatementShow'])->name('school.payment.status');
            Route::post('/payment/details/checkout/post', [App\Http\Controllers\PaymentController::class, 'paymentindex'])->name('school.payment.info.school.checkout');
            // Route::post('/payment/details/checkout/post/create', [App\Http\Controllers\PaymentController::class, 'schoolPaymentShowCheckout'])->name('school.payment.info.school.checkout.post.create');
            Route::get('/pdf/statement/{id}', [App\Http\Controllers\SchoolController::class, 'StatementShowSchoolCheckout'])->name('pdf.show.statement.schoolCheckout');

            //Amar pay payment
            // Route::get('/payment','paymentController@paymentindex');
            // Route::post('/payment/success',[App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
            // Route::post('/fail','paymentController@fail')->name('fail');



            Route::prefix('class')->group(function () {
                Route::get('/create', [App\Http\Controllers\SchoolController::class, 'classCreate'])->name('class.create');
                Route::post('/create/post', [App\Http\Controllers\SchoolController::class, 'classCreatePost'])->name('class.create.post');
                Route::get('/show', [App\Http\Controllers\SchoolController::class, 'classShow'])->name('class.show');
                Route::get('/edit/{id}', [App\Http\Controllers\SchoolController::class, 'classEdit'])->name('class.edit');
                Route::post('/update/post/{id}', [App\Http\Controllers\SchoolController::class, 'classUpdatePost'])->name('class.update.post');
                Route::get('/delete/{id}', [App\Http\Controllers\SchoolController::class, 'classDelete'])->name('class.delete');
            });

            //class section for school end...

            //term section for school start...
            Route::prefix('term')->group(function () {
                Route::get('/create', [TermController::class, 'create'])->name('term.create');
                Route::post('/store', [TermController::class, 'store'])->name('term.store');
                Route::get('/index', [TermController::class, 'index'])->name('term.index');
                Route::get('/edit/{id}', [TermController::class, 'edit'])->name('term.edit');
                Route::post('/update/{id}', [TermController::class, 'update'])->name('term.update');
                Route::get('/delete/{id}', [TermController::class, 'destroy'])->name('term.delete');
            });
            //term section for school end...

            //Section section for school start...
            Route::prefix('section')->group(function () {
                Route::get('/create', [App\Http\Controllers\SchoolController::class, 'sectionCreate'])->name('section.create');
                Route::post('/create/post', [App\Http\Controllers\SchoolController::class, 'sectionCreatePost'])->name('section.create.post');
                Route::get('/show', [App\Http\Controllers\SchoolController::class, 'sectionShow'])->name('section.show');
                Route::get('/edit/{id}', [App\Http\Controllers\SchoolController::class, 'sectionEdit'])->name('section.edit');
                Route::post('/update/post/{id}', [App\Http\Controllers\SchoolController::class, 'sectionUpdatePost'])->name('section.update.post');
                Route::get('/delete/{id}', [App\Http\Controllers\SchoolController::class, 'sectionDelete'])->name('section.delete');
            });

            //Section section for school end...

            //group section for school start...
            Route::prefix('group')->group(function () {
                Route::get('/create', [App\Http\Controllers\SchoolController::class, 'groupCreate'])->name('group.create');
                Route::post('/create/post', [App\Http\Controllers\SchoolController::class, 'groupCreatePost'])->name('group.create.post');
                Route::get('/show', [App\Http\Controllers\SchoolController::class, 'groupShow'])->name('group.show');
                Route::get('/edit/{id}', [App\Http\Controllers\SchoolController::class, 'groupEdit'])->name('group.edit');
                Route::post('/update/post/{id}', [App\Http\Controllers\SchoolController::class, 'groupUpdatePost'])->name('group.update.post');
                Route::get('/delete/{id}', [App\Http\Controllers\SchoolController::class, 'groupDelete'])->name('group.delete');
                Route::post('/onchange/section/name', [App\Http\Controllers\SchoolController::class, 'showAjaxSection'])->name('admin.show.section');
            });

            //group section for school end...

                /**-------------    Route for bank add
            * ========================================================*/    
        
            Route::prefix('bankadd')->group(function () {
                Route::get('/list',[App\Http\Controllers\BankController::class, 'show'])->name('bankadd');
                Route::get('/create', [App\Http\Controllers\BankController::class, 'create'])->name('bankadd.create');
                Route::post('/store', [App\Http\Controllers\BankController::class, 'store'])->name('bankadd.store');
                Route::get('/{key}', [App\Http\Controllers\BankController::class, 'edit'])->name('bankadd.edit');
                Route::post('/update/{key}', [App\Http\Controllers\BankController::class, 'update'])->name('bankadd.update');
                Route::get('/delete/{key}', [App\Http\Controllers\BankController::class, 'destroy'])->name('bankadd.delete');
            });

            //subject for school start...
            Route::get("subject", [SubjectController::class, 'index'])->name('subject.index');
            Route::get("subject/show", [SubjectController::class, 'show'])->name('subject.show');

            Route::prefix('subject')->group(function () {

                Route::get('/show/{class_id}',[App\Http\Controllers\SchoolController::class, 'subjectShow'])->name('subject.subjectShow');
                Route::get('/create/show',[App\Http\Controllers\SchoolController::class, 'subjectCreateShow'])->name('subject.create.show');
                Route::get('/create/show/post',[App\Http\Controllers\SchoolController::class, 'subjectCreateShowPost'])->name('subject.create.show.post');
                Route::post('/create/post',[App\Http\Controllers\SchoolController::class, 'subjectCreatePost'])->name('subject.create.post');
                Route::get('/edit/subject/{id}',[App\Http\Controllers\SchoolController::class, 'subjectEditPost'])->name('subject.edit');
                Route::post('/update/subject/{id}',[App\Http\Controllers\SchoolController::class, 'subjectUpdatePost'])->name('subject.create.update');
                Route::get('/delete/subject/{id}/{class_id}',[App\Http\Controllers\SchoolController::class, 'subjectDeletePost'])->name('subject.delete');
                Route::post('/onchange/group/name', [App\Http\Controllers\SchoolController::class, 'showAjaxGroup'])->name('admin.show.group');
                Route::post('/onchange/subject/name', [App\Http\Controllers\SchoolController::class, 'showAjaxSubject'])->name('admin.show.subject');
            });

            //subject for school end...

            //department section for school start...

            Route::prefix('department')->group(function () {

                Route::get('/create', [App\Http\Controllers\SchoolController::class, 'departmentCreate'])->name('department.create');
                Route::post('/create/post', [App\Http\Controllers\SchoolController::class, 'departmentCreatePost'])->name('department.create.post');
                Route::get('/show', [App\Http\Controllers\SchoolController::class, 'departmentShow'])->name('department.show');
                Route::get('/edit/{id}', [App\Http\Controllers\SchoolController::class, 'departmentEdit'])->name('department.edit');
                Route::post('/update/post/{id}', [App\Http\Controllers\SchoolController::class, 'departmentUpdatePost'])->name('department.update.post');
                Route::get('/delete/{id}', [App\Http\Controllers\SchoolController::class, 'departmentDelete'])->name('department.delete');
            });

            //department section for school start...


            //teacher for school start...

            Route::prefix('teacher')->group(function () {
                Route::post('/active/{id}', [App\Http\Controllers\SchoolController::class, 'teacherActiveInactive'])->name('teacher.active');
                Route::get('/show', [App\Http\Controllers\SchoolController::class, 'teacherShow'])->name('teacher.Show');
                Route::get('/SingleView/{id}', [App\Http\Controllers\SchoolController::class, 'singleView'])->name('single.view');

                Route::get('/delete/{id}', [App\Http\Controllers\SchoolController::class, 'teacherDelete'])->name('teacher.delete');
                Route::get('/edit/{id}', [App\Http\Controllers\SchoolController::class, 'teacherEdit'])->name('teacher.edit');
                Route::post('/update/{id}', [App\Http\Controllers\SchoolController::class, 'teacherUpdate'])->name('teacher.update');
                Route::get('/create', [App\Http\Controllers\SchoolController::class, 'teacherCreate'])->name('teacher.create');
                Route::post('/create/post', [App\Http\Controllers\SchoolController::class, 'teacherCreatePost'])->name('teacher.create.post');
            
                Route::post('/show/subject/teacher', [App\Http\Controllers\SchoolController::class, 'getSubjectTeacher'])->name('subject.teacher.show');
                Route::post('teacher/Pass/Edit]', [App\Http\Controllers\SchoolController::class, 'teacherPassChange'])->name('change.teacher.pass');

            });


            //teacher for school end...

            Route::prefix('assign/teacher')->group(function () {
                Route::get('/show', [App\Http\Controllers\SchoolController::class, 'teacherShow'])->name('teacher.Show');
                Route::get('/create/show', [App\Http\Controllers\SchoolController::class, 'assignCreateShow'])->name('assign.teacher.create.show');
                Route::post('/create/show/post', [App\Http\Controllers\SchoolController::class, 'assignCreateShowPost'])->name('assign.teacher.create.show.post');
                Route::get('/create/show/post/new', [App\Http\Controllers\SchoolController::class, 'assignCreateShowPostNew'])->name('assign.teacher.create.show.post.new');
                Route::post('/create/show/post/data', [App\Http\Controllers\SchoolController::class, 'assignCreateShowPostData'])->name('assign.teacher.create.show.post.data');
                Route::get('/show/{class_id}/{section_id}/{group_id}', [App\Http\Controllers\SchoolController::class, 'assignTeacherDataShow'])->name('assign.teacher.dataShow');
                Route::get('/edit/{id}', [App\Http\Controllers\SchoolController::class, 'assignTeacherEditShow'])->name('edit.assign.teacher');
                Route::get('/online/class/{id}', [App\Http\Controllers\SchoolController::class, 'onlineClass'])->name('online.class.join');
                Route::post('/onchange/sbject/name', [App\Http\Controllers\SchoolController::class, 'showAjaxSubjects'])->name('admin.show.subjects');
            });

            //staff .....
            Route::prefix('staff')->group(function () {
                Route::get('/show', [App\Http\Controllers\SchoolController::class, 'schoolStaffShow'])->name('school.staff.show');
                Route::get('/create', [App\Http\Controllers\SchoolController::class, 'schoolStaffCreate'])->name('school.staff.create');
                Route::get('/edit/{id}', [App\Http\Controllers\SchoolController::class, 'schoolStaffEdit'])->name('school.staff.edit');
                Route::post('/update/{id}', [App\Http\Controllers\SchoolController::class, 'schoolStaffUpdate'])->name('school.staff.update');
                Route::get('/delete/{id}', [App\Http\Controllers\SchoolController::class, 'schoolStaffDelete'])->name('school.staff.delete');
                Route::get('/delete/{id}', [App\Http\Controllers\SchoolController::class, 'StaffDelete'])->name('school.single.staff.delete');

                Route::post('/create/post', [App\Http\Controllers\SchoolController::class, 'schoolStaffCreatePost'])->name('school.staff.create.post');

                Route::get('/list', [App\Http\Controllers\SchoolController::class, 'schoolStaffList'])->name('school.staff.List');
                Route::get('/list/edit/{id}', [App\Http\Controllers\SchoolController::class, 'schoolStaffListEdit'])->name('edit.staff.List.school');
                Route::get('/list/create', [App\Http\Controllers\SchoolController::class, 'schoolStaffListCreate'])->name('school.staff.List.create');
                Route::post('/list/create/post', [App\Http\Controllers\SchoolController::class, 'schoolStaffAddData'])->name('school.staff.List.create.post');
                Route::get('/view/create/{id}', [App\Http\Controllers\SchoolController::class, 'staffview'])->name('staff.view');

                Route::post('/list/create/update/{id}', [App\Http\Controllers\SchoolController::class, 'schoolStaffListCreateUpdate'])->name('school.staff.List.create.update');
            });

            Route::prefix('staff-salary')->group(function () {
                Route::get('/list', [App\Http\Controllers\SchoolController::class, 'schoolStaffList'])->name('school.staff.salary.List');
                Route::get('teacher/show', [App\Http\Controllers\SchoolController::class, 'teacherShow'])->name('teacher.salary.Show');

                Route::get('/add/salary/{id}', [App\Http\Controllers\SchoolController::class, 'schoolStaffAdd'])->name('school.staff.salary.Add');
                Route::get('/edit/salary/{id}', [App\Http\Controllers\SchoolController::class, 'schoolStaffSalaryEdit'])->name('school.staff.salary.edit');
                Route::post('/update/salary/{id}', [App\Http\Controllers\SchoolController::class, 'schoolStaffSalaryUpdate'])->name('school.staff.salary.update');

                Route::get('teacher/add/salary/{id}', [App\Http\Controllers\SchoolController::class, 'schoolTeacherAdd'])->name('school.teacher.salary.Add');
                Route::get('teacher/edit/salary/{id}', [App\Http\Controllers\SchoolController::class, 'schoolTeacherSalaryEdit'])->name('school.teacher.salary.edit');
                Route::post('teacher/update/salary/{id}', [App\Http\Controllers\SchoolController::class, 'schoolTeacherSalaryUpdate'])->name('school.teacher.salary.update');
            });

            //teacher for school start...

            Route::post('/send/sms/due/fees',[App\Http\Controllers\SchoolController::class, 'sendFeesDueSms'])->name('send.fees.due.sms');
            Route::get('/send/sms/teacher',[App\Http\Controllers\SchoolController::class, 'sendSmsToTeacher'])->name('send.sms.teacher');
            Route::post('/send/sms/teacher/post',[App\Http\Controllers\SchoolController::class, 'sendSmsToTeacherPost'])->name('send.sms.teacher.post');
            Route::get('/send/sms/employee',[App\Http\Controllers\SchoolController::class, 'sendSmsToEmployee'])->name('send.sms.employee');
            Route::post('/send/sms/employee/post',[App\Http\Controllers\SchoolController::class, 'sendSmsToEmployeePost'])->name('send.sms.employee.post');
            Route::get('/send/sms/student',[App\Http\Controllers\SchoolController::class, 'sendSmsToStudent'])->name('send.sms.student');
            Route::post('/send/sms/student/post',[App\Http\Controllers\SchoolController::class, 'sendSmsToStudentPost'])->name('send.sms.student.post');
            Route::get('/send/sms/purchase',[App\Http\Controllers\SchoolController::class, 'smsPurchase'])->name('send.sms.purchase');
            
            Route::prefix('student')->group(function(){
                Route::get('/create/show',[App\Http\Controllers\SchoolController::class, 'studentCreateShow'])->name('student.teacher.create.show');
                Route::get('show',[App\Http\Controllers\SchoolController::class, 'findStudents'])->name('student.find');
                Route::get('assign/subject/delete/{id}',[App\Http\Controllers\SchoolController::class, 'assignSubjectDelete'])->name('assign.subject.delete');
                Route::get('data/show/{class_id}/{section_id}/{group_id}',[App\Http\Controllers\SchoolController::class, 'assignStudentDataShow'])->name('assign.student.dataShow');

                // Route::get('/show',[App\Http\Controllers\SchoolController::class, 'studentShow'])->name('student.Show');
                Route::get('/create',[App\Http\Controllers\SchoolController::class, 'studentCreate'])->name('student.create');
                Route::post('/create/post',[App\Http\Controllers\SchoolController::class, 'studentCreatePost'])->name('student.create.post');
                Route::get('/edit/{id}',[App\Http\Controllers\SchoolController::class, 'studentEdit'])->name('student.edit');
                Route::post('/update/post/{id}',[App\Http\Controllers\SchoolController::class, 'studentUpdatePost'])->name('student.update.post');
                Route::get('/delete/{id}',[App\Http\Controllers\SchoolController::class, 'studentDelete'])->name('student.delete');
                
                Route::get('/upload',[App\Http\Controllers\SchoolController::class, 'studentUpload'])->name('student.upload');
                Route::post('/upload/post',[App\Http\Controllers\SchoolController::class, 'studentUploadPost'])->name('student.upload.post');
                Route::get('student/singleShow/{id}',[App\Http\Controllers\SchoolController::class, 'singleShow'])->name('student.singleShow');
                Route::put('student/singlePassword/{id}',[App\Http\Controllers\SchoolController::class, 'singlePassword'])->name('student.Password');
                
                //Attendance
                Route::get('/student/attendance/show/date/all', [App\Http\Controllers\SchoolController::class, 'studentAttendanceShowDateAll'])->name('student.attendance.show.date.all');
                Route::get('/student/attendance/show/date', [App\Http\Controllers\SchoolController::class, 'studentAttendanceShowDate'])->name('student.attendance.show.date');

                Route::get('/create/show/post/date/all', [App\Http\Controllers\SchoolController::class, 'studentAttendanceShowPostDateAll'])->name('student.attendance.create.show.post.date.all');
                Route::get('/create/show/post/date', [App\Http\Controllers\SchoolController::class, 'studentAttendanceShowPostDate'])->name('student.attendance.create.show.post.date');
                Route::get('/attendanceshow/{class_id}/{section_id}/{group_id}/{date}', [App\Http\Controllers\SchoolController::class, 'attendanceShowDate'])->name('student.attendanceShowDate');
                Route::get('/all/attendanceshow/{class_id}/{section_id}/{group_id}/{date}', [App\Http\Controllers\SchoolController::class, 'attendanceShowDateAll'])->name('student.attendanceShowDateAll');
                Route::get('/download/pdf/attendance/{class_id}/{section_id}/{group_id}/{date}', [App\Http\Controllers\SchoolController::class, 'exportPdfAttendance'])->name('export.pdf.attendance');
                Route::get('/report/export/attendance/{class_id}/{section_id}/{group_id}/{date}', [App\Http\Controllers\SchoolController::class, 'exportCSVAttendance'])->name('export.report.attendance_data');
                Route::get('/attendance/show', [App\Http\Controllers\SchoolController::class, 'studentAttendanceShow'])->name('student.attendance.show');
                Route::get('/show/{class_id}/{section_id}/{group_id}', [App\Http\Controllers\SchoolController::class, 'attendanceShow'])->name('student.attendanceShow');
                Route::get('/create/show/post', [App\Http\Controllers\SchoolController::class, 'studentAttendanceShowPost'])->name('student.attendance.create.show.post');
                Route::post('/attendance/post', [App\Http\Controllers\SchoolController::class, 'attendanceCreatePost'])->name('student.attendance.create.post');
                Route::post('/confirm/absent/present/{id}', [App\Http\Controllers\SchoolController::class, 'confirmAbsentPresent'])->name('confirm.absent.present');

                //Fees
                
                Route::get('fees/show', [App\Http\Controllers\SchoolController::class, 'studentFeesShow'])->name('student.fees.show');
                Route::get('fees/create', [App\Http\Controllers\SchoolController::class, 'studentFeesCreate'])->name('student.fees.create');
                Route::get('fees/edit/{id}', [App\Http\Controllers\SchoolController::class, 'studentFeesEdit'])->name('student.fees.edit');
                Route::post('fees/update/{id}', [App\Http\Controllers\SchoolController::class, 'studentFeesUpdate'])->name('student.fees.update');
                Route::get('fees/delete/{id}', [App\Http\Controllers\SchoolController::class, 'studentFeesDelete'])->name('student.fees.delete');
                Route::post('fees/create/post', [App\Http\Controllers\SchoolController::class, 'studentFeesCreatePost'])->name('student.fees.create.post');

                //finance

                Route::prefix('finance')->group(function () {
                    Route::get('/create/show', [App\Http\Controllers\SchoolController::class, 'studentFinanceCreateShow'])->name('student.finance.create.show');
                    Route::get('/show', [App\Http\Controllers\SchoolController::class, 'studentFinanceCreateShowNew'])->name('student.finance.create.show.new');
                    Route::get('/data/financeshow/{class_id}/{section_id}/{group_id}', [App\Http\Controllers\SchoolController::class, 'assignStudentFinanceDataShow'])->name('assign.student.finance.dataShow');
                    Route::get('/data/financeshow/{class_id}/{section_id}/{group_id}/{month_name}', [App\Http\Controllers\SchoolController::class, 'assignStudentFinanceDataShowNew'])->name('assign.student.finance.dataShow.new');
                    Route::get('/add/fees/{id}/{class_id}/{section_id}/{group_id}', [App\Http\Controllers\SchoolController::class, 'studentFinanceAddFees'])->name('add.fees.show');
                    Route::get('/edit/fees/{id}/{student_id}/{class_id}/{section_id}/{group_id}', [App\Http\Controllers\SchoolController::class, 'studentFinanceEditFees'])->name('edit.fees.show');
                    Route::post('/update/fees/{id}', [App\Http\Controllers\SchoolController::class, 'studentFinanceUpdateFees'])->name('update.fees.show');

                    //expenses

                    Route::get('/expense/show', [App\Http\Controllers\ExpenseController::class, 'expenselist'])->name('expense.show');
                    Route::get('/expense/create', [App\Http\Controllers\ExpenseController::class, 'expensecreate'])->name('expense.create');
                    Route::post('/expense/store', [App\Http\Controllers\ExpenseController::class, 'expensestore'])->name('expense.store');
                    Route::get('/expense/{key}', [App\Http\Controllers\ExpenseController::class, 'expenseedit'])->name('expense.edit');
                    Route::post('/expense/update', [App\Http\Controllers\ExpenseController::class, 'expenseupdate'])->name('expense.update');
                    Route::get('/expense/delete/{key}', [App\Http\Controllers\ExpenseController::class, 'expensedestroy'])->name('expense.delete');

                    //fund
                    Route::get('/fund/show', [App\Http\Controllers\ExpenseController::class, 'fundlist'])->name('fund.show');
                });


                Route::get('result/create/show',[App\Http\Controllers\SchoolController::class, 'resultCreateShow'])->name('result.school.admin.create.show');
                Route::get('result/create/show/all',[App\Http\Controllers\SchoolController::class, 'resultCreateShow'])->name('result.school.admin.create.show.all');
                Route::get('result/create/show/post',[App\Http\Controllers\SchoolController::class, 'resultCreateShowPost'])->name('result.school.create.show.post');
                Route::get('result/data/show/{class_id}/{section_id}/{subject_id}/{term_id}',[App\Http\Controllers\SchoolController::class, 'resultStudentDataShow'])->name('school.result.dataShow');
                Route::get('all/result/data/show/{class_id}/{section_id}/{term_id}',[App\Http\Controllers\SchoolController::class, 'resultStudentDataShowAll'])->name('school.result.dataShowAll');
                Route::post('result/create/post',[App\Http\Controllers\SchoolController::class, 'resultCreatePost'])->name('result.create.post');
                Route::post('result/create/update/post/{id}',[App\Http\Controllers\SchoolController::class, 'resultUpdatePost'])->name('result.update.post');

                //Notice Route Start
                Route::get('notice/delete/{id}',[App\Http\Controllers\SchoolController::class, 'noticeCreateDelete'])->name('notice.delete');
                Route::get('notice',[App\Http\Controllers\SchoolController::class, 'noticeCreateShow'])->name('notice.school.admin.create.show');
                Route::get('notice/create',[App\Http\Controllers\SchoolController::class, 'noticeCreate'])->name('notice.school.admin.create');
                Route::post('notice/post',[App\Http\Controllers\SchoolController::class, 'noticeCreatePost'])->name('notice.school.admin.create.post');
                //Notice Route End

                //Mark Types Start Saj
                Route::get('/mark/type/create/show', [MarkController::class, 'index'])->name('show.mark.type');
                Route::post('/mark/type/store', [MarkController::class, 'store'])->name('mark.type.store');
                //Mark Types End

                //Start Class and Student Wise Result
                Route::get('/class/wise/result', [ResultController::class, 'classWiseResult'])->name('class.wise.result');
                Route::post('show/class/wise/result', [ResultController::class, 'showClassWiseResult'])->name('show.class.wise.result');
                Route::post('/class/wise/user', [ResultController::class, 'classWiseUser'])->name('class.wise.user');
                //End Class and Student Wise Result

                //School Exam Route Start
                Route::get('/exam/routine/create', [ExamController::class, 'examRoutine'])->name('exam.routine.create');
                //Start Ajax for exam Controller
                Route::get('get/subjet/{id}', [ExamController::class, 'getSubject']);
                Route::get('get/routine/{id}/{term_id}', [ExamController::class, 'getRoutine']);
                Route::post('store/exam/routine', [ExamController::class, 'storeExamRoutine']);
                Route::get('delete/exam/routine/{id}', [ExamController::class, 'deleteExamRoutine']);
                //End Ajax for exam Controller
                Route::get('/create/exam/routine/pdf/{id}/{term_id}', [ExamController::class, 'generatePdf']);
                //School Exam Route End

                //Mcqinput

                //Notice Route Start
                    Route::get('mcq/index',[QuestionController::class,'mcq_index'])->name('mcq.index');
                    Route::get('notice/delete/{id}', [App\Http\Controllers\SchoolController::class, 'noticeCreateDelete'])->name('notice.delete');
                    Route::get('notice', [App\Http\Controllers\SchoolController::class, 'noticeCreateShow'])->name('notice.school.admin.create.show');
                    Route::get('notice/create', [App\Http\Controllers\SchoolController::class, 'noticeCreate'])->name('notice.school.admin.create');
                    Route::post('notice/post', [App\Http\Controllers\SchoolController::class, 'noticeCreatePost'])->name('notice.school.admin.create.post');
                //Notice Route End
            });

            //----------------Question Route Start----------------

                Route::get('/create/question/index', [QuestionController::class, 'index'])->name('create.question.show');
                Route::post('ckeditor/image_upload', [QuestionController::class, 'imageUpload'])->name('ckeditor.image.upload');
                Route::post('/create/question/store', [QuestionController::class, 'questionStore'])->name('question.store');
                Route::get('/show/question', [QuestionController::class, 'showQuestion'])->name('show.question');
            
                //Ajax
                Route::get('/view/single/question/{id}', [QuestionController::class, 'viewSingleQuestion'])->name('view.single.question');
                Route::get('/term/wiese/question/{id}', [QuestionController::class, 'termWiseQuestion'])->name('term.wise.question');
                Route::get('/ajax/delete/question/{id}', [QuestionController::class, 'ajaxDeleteQuestion'])->name('term.wise.question');
                Route::post('/ajax/question/store', [QuestionController::class, 'ajaxQuestionStore']);
                //Ajax
                
                Route::get('/view/mcq/creative/question/{id}', [QuestionController::class, 'viewMcqCreativeQuestion'])->name('view.mcq.creative.question');
                Route::get('/edit/question/{id}', [QuestionController::class, 'editQuestion'])->name('edit.question');
                Route::post('/update/question/{id}', [QuestionController::class, 'updateQuestion'])->name('update.question');
                Route::get('/delete/question/{id}', [QuestionController::class, 'deleteQuestion'])->name('delete.question');
                Route::get('/pdf/question/{id}', [QuestionController::class, 'pdfQuestion'])->name('pdf.question');

            //----------------Question Route End------------------
            
            Route::get('/notice/view', [NoticeViewController::class, 'index'])->name('show.notice'); //Ofcourse need this route sajjad
        });

        #// prefix school end here
        
        //Notice Route Start
        Route::get('/notice/view', [NoticeViewController::class, 'index'])->name('show.notice');
        Route::post('/student/login', [NoticeViewController::class, 'studentLoginController'])->name('student.login');
        //Notice Route End
    });

    //Notice Route Start
    Route::post('/term/wise/result', [NoticeViewController::class, 'termWiseResult'])->name('show.term.wise.result');
    Route::post('/notice/by/student/logged', [NoticeViewController::class, 'studentLoginController'])->name('student.login');
    // Route::get('/student/otp', [NoticeViewController::class, 'otpView']);
    //Notice Route End

    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('/admin',[AdminPageController::class, 'admin'])->name('admin');
        //Route::view('/admin', 'admin');

        Route::prefix('admin')->group(function () {

            Route::prefix('contact-us')->group(function () {
                Route::get('/index',             [App\Http\Controllers\AdminPageController::class, 'contactusIndex'])->name('contactus.index');
                Route::get('/edit/{id}',         [App\Http\Controllers\AdminPageController::class, 'contactusEdit'])->name('contactus.edit');
                Route::post('/update/{id}',     [App\Http\Controllers\AdminPageController::class, 'contactusUpdate'])->name('contactus.update');
                Route::get('/destroy/{id}',     [App\Http\Controllers\AdminPageController::class, 'contactusDestroy'])->name('contactus.destroy');
            });

            Route::prefix('pricing')->group(function () {
                Route::get('/index',             [App\Http\Controllers\AdminPageController::class, 'pricingIndex'])->name('pricing.index');
                Route::get('/create',             [App\Http\Controllers\AdminPageController::class, 'pricingCreate'])->name('pricing.create');
                Route::post('/store',             [App\Http\Controllers\AdminPageController::class, 'pricingStore'])->name('pricing.store');
                Route::get('/edit/{id}',         [App\Http\Controllers\AdminPageController::class, 'pricingEdit'])->name('pricing.edit');
                Route::post('/update/{id}',     [App\Http\Controllers\AdminPageController::class, 'pricingUpdate'])->name('pricing.update');
                Route::get('/destroy/{id}',     [App\Http\Controllers\AdminPageController::class, 'pricingDestroy'])->name('pricing.destroy');
            });

            Route::prefix('tutorial')->group(function () {
                Route::get('/index',             [App\Http\Controllers\AdminPageController::class, 'tutorialIndex'])->name('tutorial.index');
                Route::get('/create',             [App\Http\Controllers\AdminPageController::class, 'tutorialCreate'])->name('tutorial.create');
                Route::post('/store',             [App\Http\Controllers\AdminPageController::class, 'tutorialStore'])->name('tutorial.store');
                Route::get('/edit/{id}',         [App\Http\Controllers\AdminPageController::class, 'tutorialEdit'])->name('tutorial.edit');
                Route::post('/update/{id}',     [App\Http\Controllers\AdminPageController::class, 'tutorialUpdate'])->name('tutorial.update');
                Route::get('/destroy/{id}',     [App\Http\Controllers\AdminPageController::class, 'tutorialDestroy'])->name('tutorial.destroy');
            });

            Route::prefix('message-package')->group(function () {
                Route::get('/index',             [App\Http\Controllers\AdminPageController::class, 'messagePackageIndex'])->name('messagePackage.index');
                Route::get('/create',             [App\Http\Controllers\AdminPageController::class, 'messagePackageCreate'])->name('messagePackage.create');
                Route::post('/store',             [App\Http\Controllers\AdminPageController::class, 'messagePackageStore'])->name('messagePackage.store');
                Route::get('/edit/{id}',         [App\Http\Controllers\AdminPageController::class, 'messagePackageEdit'])->name('messagePackage.edit');
                Route::post('/update/{id}',     [App\Http\Controllers\AdminPageController::class, 'messagePackageUpdate'])->name('messagePackage.update');
                Route::get('/destroy/{id}',     [App\Http\Controllers\AdminPageController::class, 'messagePackageDestroy'])->name('messagePackage.destroy');
            });

            Route::prefix('checkout-sell')->group(function () {
                Route::get('/all',             [App\Http\Controllers\AdminPageController::class, 'confirmMessagePaymentIndex'])->name('confirm.message.payment.index');
                Route::post('/message/{id}',     [App\Http\Controllers\AdminPageController::class, 'confirmMessagePayment'])->name('confirm.message.payment');
            });

            Route::prefix('school-payment')->group(function () {
                Route::get('/all',             [App\Http\Controllers\AdminPageController::class, 'showallSchoolForPayment'])->name('show.all.School.ForPayment');
                Route::get('/details/{id}', [App\Http\Controllers\AdminPageController::class, 'showallSchoolForPaymentDetails'])->name('show.all.School.ForPayment.Details');
                Route::get('/details/send/{id}', [App\Http\Controllers\AdminPageController::class, 'showallSchoolForPaymentSendDetails'])->name('show.all.School.ForPayment.send.checkout');
                Route::post('checkout/school/fess/update/{id}', [App\Http\Controllers\AdminPageController::class, 'checkoutSchoolFessUpdate'])->name('checkout.schoolFess.update');
                Route::post('checkout/school/checkout/update/{id}', [App\Http\Controllers\AdminPageController::class, 'checkoutSchoolCheckoutUpdate'])->name('checkout.schoolCheckout.update');
            });

            Route::prefix('school')->group(function () {
                Route::get('/all',             [App\Http\Controllers\AdminPageController::class, 'showAllSchool'])->name('show.all.School');
                Route::post('/status/update/{id}', [App\Http\Controllers\AdminPageController::class, 'SchoolStatusUpdate'])->name('status.school.update');
            });

            Route::prefix('feature-page')->group(function () {
                Route::get('/create',             [App\Http\Controllers\AdminPageController::class, 'featurePageCreate'])->name('featurePage.create');
                Route::post('/store',             [App\Http\Controllers\AdminPageController::class, 'featurePageStore'])->name('featurePage.store');
                Route::post('/store/details',             [App\Http\Controllers\AdminPageController::class, 'featureDetailsPageStore'])->name('featureDetailsPage.store');
                Route::get('/edit/{id}',         [App\Http\Controllers\AdminPageController::class, 'featurePageEdit'])->name('featurePage.edit');
                Route::post('/update/{id}',     [App\Http\Controllers\AdminPageController::class, 'featurePageUpdate'])->name('featurePage.update');
                Route::get('/destroy/{id}',     [App\Http\Controllers\AdminPageController::class, 'featurePageDestroy'])->name('featurePage.destroy');
                Route::get('/index',             [App\Http\Controllers\AdminPageController::class, 'featurePageIndex'])->name('featurePage.index');

                Route::get('/details/create',             [App\Http\Controllers\AdminPageController::class, 'featureDetailsInput'])->name('featurePage.details.input');
            });
        });
    });

    // student ......
    Route::prefix('student')->group(function () {
        Route::get('/online-class/{id}', [\App\Http\Controllers\UserController::class, 'onlineClass'])->name('user.online class');
        Route::get('/profile', [\App\Http\Controllers\UserController::class, 'profile'])->name('user.account.Information');
        Route::get('/vaccine', [\App\Http\Controllers\UserController::class, 'accountVaccine'])->name('user.account.vaccine');
        Route::post('/vaccine/update/{id}', [\App\Http\Controllers\UserController::class, 'vaccineUpdate'])->name('user.vaccine.update');
        Route::get('/notice', [\App\Http\Controllers\UserController::class, 'notice'])->name('user.account.notice');
        Route::post('/profile/update/{id}', [\App\Http\Controllers\UserController::class, 'profileUpdate'])->name('user.account.update');
        Route::post('/change-password', [\App\Http\Controllers\UserController::class, 'changePassword'])->name('user.change password');

        Route::get('/show/assignment/all/{subject_id}/{tearcher_id}', [\App\Http\Controllers\UserController::class, 'assignmentAll'])->name('show.all.assignment');
        Route::get('/assignment/all/{subject_id}', [\App\Http\Controllers\UserController::class, 'getAssignmentBySubject'])->name('all.assignment');
        Route::get('/user/upload/assignment/all/{id}', [\App\Http\Controllers\UserController::class, 'userUploadAssignment'])->name('user.upload.assignment');
        Route::get('/user/assignment/file/{id}', [UserController::class, 'userAssignmentFile'])->name('user.assignment.file');
        Route::post('/upload/assignment', [\App\Http\Controllers\UserController::class, 'userTeacherUploadAssignment'])->name('user.teacher.assignment.upload');
        Route::get('/student/fee/info', [\App\Http\Controllers\UserController::class, 'FeesShow'])->name('student.panel.salary.show');

        Route::get('/attendance', [\App\Http\Controllers\UserController::class, 'attendanceUserShow'])->name('user.attendance.show');

        Route::get('/attendance/show/class/{class_id}/{section_id}/{group_id}', [\App\Http\Controllers\UserController::class, 'classAttendanceShow'])->name('allAttendance.show.all.user');
        Route::get('/subject/show', [\App\Http\Controllers\UserController::class, 'allSubjectShow'])->name('allSubject.show.all.user');
        Route::get('/result/show', [\App\Http\Controllers\UserController::class, 'allResultShow'])->name('allResult.show.all.user');
        // DevelSajjad 
        Route::get('/notice/show', [UserController::class, 'showNotice'])->name('user.show.notice');
        Route::get('/routine/show', [UserController::class, 'showRoutine'])->name('student.show.routine');
        Route::get('/show/payment', [UserController::class, 'showPayment'])->name('show.student.payment');
    });

    Route::group(['middleware' => 'auth:teachers'], function () {
        Route::prefix('teachers')->group(function () {
            Route::get('/', [\App\Http\Controllers\TeacherController::class, 'teacherDashboard'])->name('teacher.dashboard');
            Route::get('/class-room', [\App\Http\Controllers\TeacherController::class, 'myClassRoom'])->name('teacher.myClass.show');
            Route::get('/profile', [\App\Http\Controllers\TeacherController::class, 'profile'])->name('teacher.account.Information');
            Route::post('/profile/update/{id}', [\App\Http\Controllers\TeacherController::class, 'profileUpdate'])->name('teacher.account.update');
            Route::get('/vaccine', [\App\Http\Controllers\TeacherController::class, 'accountVaccine'])->name('teacher.account.vaccine');
            Route::post('/vaccine/update/{id}', [\App\Http\Controllers\TeacherController::class, 'vaccineUpdate'])->name('teacher.vaccine.update');
            Route::post('/change-password', [\App\Http\Controllers\TeacherController::class, 'changePassword'])->name('teacher.change password');
            Route::get('/online-class', [\App\Http\Controllers\TeacherController::class, 'onlineClass'])->name('teacher.online class');

            Route::get('/result-upload/{subject_id}/{class_id}/{section_id}/{group_id}', [\App\Http\Controllers\TeacherController::class, 'resultUpload'])->name('teacher.result.upload');
            Route::post('/result/create/post', [\App\Http\Controllers\TeacherController::class, 'resultCreatePost'])->name('teacher.result.create.post');
            Route::get('/attendance/{class_id}/{section_id}/{group_id}', [\App\Http\Controllers\TeacherController::class, 'attendanceUpload'])->name('teacher.attendance.upload');
            Route::post('/attendance/post', [\App\Http\Controllers\TeacherController::class, 'attendanceCreatePost'])->name('teacher.attendance.create.post');
            Route::get('/assignment/{class_id}/{section_id}/{group_id}/{subject_id}', [\App\Http\Controllers\TeacherController::class, 'attendanceUploadShow'])->name('teacher.assignment.upload.show');
            Route::post('/post/assignment', [\App\Http\Controllers\TeacherController::class, 'assignmentUploadPost'])->name('post.teacher.assignment.upload');
            Route::get('/details/assignment/{id}', [\App\Http\Controllers\TeacherController::class, 'attendanceDetailsShow'])->name('details.teacher.assignment.show');
            Route::get('/teacher/student/show/{class_id}/{section_id}/{group_id}', [\App\Http\Controllers\TeacherController::class, 'studentShow'])->name('teacher.class.student.show');

            Route::get('/teacher/salary/info', [\App\Http\Controllers\TeacherController::class, 'salaryShow'])->name('teacher.panel.salary.show');


            Route::get('/attendance/show', [\App\Http\Controllers\TeacherController::class, 'teacherAttendanceShow'])->name('all.teachers.attendance.show');
            Route::get('/attendance/show/class/{class_id}/{section_id}/{group_id}', [\App\Http\Controllers\TeacherController::class, 'classAttendanceShow'])->name('allAttendance.show.all.teacher');
            Route::get('/result/show', [\App\Http\Controllers\TeacherController::class, 'teacherResultShow'])->name('all.teachers.result.show');
            Route::get('/result/show/class/{subject_id}', [\App\Http\Controllers\TeacherController::class, 'teacherResultDataShow'])->name('allResult.show.all.teacher');

            Route::get('/student/show', [\App\Http\Controllers\TeacherController::class, 'teacherStudentShow'])->name('all.teachers.student.show');
            Route::get('/student/show/class/{class_id}/{section_id}/{group_id}', [\App\Http\Controllers\TeacherController::class, 'classStudentShow'])->name('allStudent.show.all.teacher');

            Route::get('/assignment/show', [\App\Http\Controllers\TeacherController::class, 'assignmentStudentShow'])->name('all.assignment.student.show');
            Route::post('/status/update/{id}', [\App\Http\Controllers\TeacherController::class, 'statusUpdateAssignment'])->name('status.update.assignment');

            Route::get('/Routine/show', [\App\Http\Controllers\TeacherController::class, 'teacherRoutineShow'])->name('all.teachers.routine.show');

            Route::post('/confirm/absent/present/{id}', [App\Http\Controllers\TeacherController::class, 'confirmAbsentPresent'])->name('teacher.confirm.absent.present');
            Route::post('/to-do-list/show', [\App\Http\Controllers\TeacherController::class, 'toDolistAdd'])->name('add.todolist.teacher');
            Route::get('/todolist/delete/{key}', [\App\Http\Controllers\TeacherController::class, 'tododestroy'])->name('todolist.delete');
        });
    });
});

/** ----------- Online Admission Form (SUNNAH)
 * ================================================================*/
Route::get('/online/admission/form/{unique_id}', [OnlineAddmissionController::class, 'onlineAdmissionForm'])->name('online.Admission.Form')->middleware('language');
Route::post('/online/admission/form/post', [OnlineAddmissionController::class, 'onlineAdmissionFormPost'])->name('online.Admission.Form.Post');

Route::middleware(['auth:schools', 'language'])
->prefix('school')
->group(function(){
    Route::get('/online/admission/formList', [OnlineAddmissionController::class, 'onlineAdmissionFormList'])->name('online.Admission.Form.list')->middleware('language');
    Route::get('/online/admission/singleShow/{id}', [OnlineAddmissionController::class, 'onlineAdmissionSingleShow'])->name('online.Admission.Single.Show');
    Route::get('/online/admission/edit/{id}', [OnlineAddmissionController::class, 'onlineAdmissionEdit'])->name('online.Admission.Edit');
    Route::put('/online/admission/editPost/{id}', [OnlineAddmissionController::class, 'onlineAdmissionEditPost'])->name('online.Admission.Edit.Post');
    Route::get('/online/admission/delete/{id}', [OnlineAddmissionController::class, 'onlineAdmissionDelete'])->name('online.Admission.Delete');
});
//** ====================== Online Admission end here  ======================*/


/** ----------- School Accesories Type (SUNNAH)
 * ================================================================*/
Route::middleware(['auth:schools', 'language'])
->group(function(){
    Route::get('/receipt/show', [App\Http\Controllers\ExpenseController::class, 'receipt'])->name('reciept.create');
    Route::get('/receipt/delete/{id}', [App\Http\Controllers\ExpenseController::class, 'receiptDelete'])->name('receipt.delete');

    Route::get('/getPrice/{id}', [App\Http\Controllers\ExpenseController::class, 'getPrice'])->name('getPrice');
    Route::post('/ajax/accesories/', [AjaxController::class, 'ajaxLoaderaccesories'])->name('ajax.load.accesories');

    Route::get('/accesories/create', [App\Http\Controllers\ExpenseController::class, 'accesoriesType'])->name('accesoriesType');
    Route::post('/accesories/create/post', [App\Http\Controllers\ExpenseController::class, 'accesoriesTypePost'])->name('accesoriesType.post');
    Route::get('/accesories/list', [App\Http\Controllers\ExpenseController::class, 'accesoriesTypeList'])->name('accesoriesType.list');

    Route::get('/ajax/section', [AjaxController::class, 'ajaxLoaderSection'])->name('ajax.load.section');
});
//** ====================== School Accesories Type end here  ======================*/


/** ----------- Finance ===> School Panel (SHAHIDUL)
 * ================================================================*/
Route::middleware(['auth:schools', 'language'])
->name('school.finance.')
->group(function(){
    Route::get('/school/finance/dashboard', [FinanceController::class, 'dashboard'])->name('dashoboard');
    Route::resource('/school/finance/fees', FinanceController::class)->names(['as'=>'fees']);
    Route::post('/school/finance/fees/update', [FinanceController::class, 'update'])->name('fees.update');
    
    // assign fees
    Route::get("school/assign/fees", [AssignFeesController::class, 'index'])->name('assign.fees.index');
    Route::post("school/assign/fees", [AssignFeesController::class, 'store'])->name('assign.fees.store');
    
    // students list
    Route::get('/school/finance/students', [FinanceController::class, 'students'])->name('students');
    Route::get('/school/finance/student/{sid}/{month?}/fee', [FinanceController::class, 'findStudent'])->name('find.student.fee');

    // received student fees
    Route::post('/school/finance/payment/receive', [FinanceController::class, 'receivedFees'])->name('fees.received');

});
//** ====================== Finance end here  ======================*/


/** ---------- upload attendance (SHAHIDUL)
 * =========================================================*/
Route::middleware(['auth:schools', 'language'])
->name('school.attendance.')
->group(function(){

    Route::post("school/attendance/file/uplaod", [AttendanceController::class, 'uploadAttendance'])->name('upload');

});

/** ========================= upload attendance ==================== */



/** ----------- Transfer and testimonial certificate (LIZA)
 * ================================================================*/
Route::middleware('auth:schools')
->prefix('school/student/')
->group(function(){
    Route::get('example/{id}',[CertificateController::class,'example'])->name('example');
});
//** ====================== Transfer and testimonial certificate end here  ======================*/





/** --------------  Super Admin Panel (LIZA)
 * =================================================================*/
Route::middleware('auth:admin')
->prefix('admin')
->group(function(){

    Route::get('schools/view',[App\Http\Controllers\AdminPageController::class, 'school_view'])->name('Schools.list');

    Route::get('/SchoolListsearch',[AdminPageController::class,'SchoolListsearch'])->name('SchoolListsearch');
    Route::get('/SchoolRegisterPage',[App\Http\Controllers\AdminPageController::class,'SchoolRegisterPage'])->name('SchoolRegisterPage');
    
    Route::post('school/Register',[AdminPageController::class, 'school_Register'])->name('Schools.Register');
    Route::get('school/SingleView/{id}',[AdminPageController::class, 'school_SingleView'])->name('School.SingleView');
    
    Route::get('changestatus/{id}',[AdminPageController::class, 'changestatus'])->name('changestatus');

     Route::get('AppReleased',[AdminPageController::class,'AppReleased'])->name('AppReleased');
     Route::post('AppReleased/store',[AdminPageController::class,'AppReleased_store'])->name('AppReleased.store');
     Route::get('AppReleased/List',[AdminPageController::class,'AppReleased_List'])->name('AppReleased.List');
     Route::get('AppReleased/Delete/{id}',[AdminPageController::class,'AppReleased_Delete'])->name('AppReleased.Delete');
     Route::get('AppReleased/Edit/{id}',[AdminPageController::class,'AppReleased_Edit'])->name('AppReleased.Edit');
     Route::put('AppReleased/Update/{id}',[AdminPageController::class,'AppReleased_Update'])->name('AppReleased.Update');

});
//** ====================== Finance end here  ======================*/


//Cache Clear (sazzad)
Route::get('/cache-clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    toast("All Cache Clear", "success");
    return redirect()->back();
});
