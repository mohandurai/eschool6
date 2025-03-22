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

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\NexmoSMSController;
use App\Http\Controllers\Master\RolesController;
use App\Http\Controllers\Master\VideoController;
use App\Http\Controllers\Master\ContentController;
use App\Http\Controllers\Student\ChapterController;
use App\Http\Controllers\Training\TtkitController;
use App\Http\Controllers\Master\QuestionController;
use App\Http\Controllers\Master\AlloctestController;
use App\Http\Controllers\Master\SubjectController;
use App\Http\Controllers\Training\CltController;
use App\Http\Controllers\Training\OlexamController;
use App\Http\Controllers\Training\ProjlabController;
use App\Http\Controllers\Training\QuestionbankController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Auth\RbacController;
use App\Http\Controllers\Reports\GradereportController;
use App\Http\Controllers\Training\HomeworkController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\Master\QnbankController;

use App\Http\Controllers\PdfController;
// use App\Http\Controllers\RazorpayPaymentController;

Route::get('/', function () {
    return view('pages.auth.login');
});

Route::get('/public', function () {
    // return view('pages.auth.login');
    return Redirect::to('/auth/login');
});

Route::get('auth/login', function () {
    return view('pages.auth.login');
});

// Auth::routes();

Route::middleware('auth')->group(function() {

    Route::get('dashboard', function () {
        return view('dashboard');
    });

    Route::get('/view-pdf/{filename}', [PdfController::class, 'viewPdf'])->name('view.pdf');

    Route::get('/qnbank/index', [QnbankController::class, 'index'])->name('qnbank.index');
    Route::post('/qnbank/store', [QnbankController::class, 'store'])->name('qnbank.store');
    Route::get('/qnbank/create', [QnbankController::class, 'create'])->name('qnbank.create');
    Route::get('/qnbank/{id}/show', [QnbankController::class, 'show'])->name('qnbank.show');
    Route::get('/qnbank/{id}/edit', [QnbankController::class, 'edit'])->name('qnbank.edit');
    Route::post('/qnbank/update', [QnbankController::class, 'update'])->name('qnbank.update');
    Route::get('/qnbank/{id}/destroy', [QnbankController::class, 'destroy'])->name('qnbank.destroy');
    Route::get('/qnbanklist', [QnbankController::class, 'qnbanklist'])->name('qnbanklist');
    Route::get('/qnbankview', [QnbankController::class, 'qnbankview'])->name('qnbankview');

    Route::get('/asset/index', [AssetController::class, 'index'])->name('asset.index');
    Route::post('/asset/store', [AssetController::class, 'store'])->name('asset.store');
    Route::get('/asset/create', [AssetController::class, 'create'])->name('asset.create');
    Route::get('/asset/{id}/show', [AssetController::class, 'show'])->name('asset.show');
    Route::get('/asset/{id}/edit', [AssetController::class, 'edit'])->name('asset.edit');
    Route::post('/asset/update', [AssetController::class, 'update'])->name('asset.update');
    Route::get('/asset/{id}/destroy', [AssetController::class, 'destroy'])->name('asset.destroy');
    Route::get('/assetlist', [AssetController::class, 'assetlist'])->name('assetlist');

    Route::get('/homework/index', [HomeworkController::class, 'index'])->name('homework.index');
    Route::post('/homework/store', [HomeworkController::class, 'store'])->name('homework.store');
    Route::get('/homework/create', [HomeworkController::class, 'create'])->name('homework.create');
    Route::get('/homework/{id}/show', [HomeworkController::class, 'show'])->name('homework.show');
    Route::get('/homework/{id}/homeworkview', [HomeworkController::class, 'homeworkview'])->name('homework.homeworkview');
    Route::get('/homework/homeworkindex', [HomeworkController::class, 'homeworkindex'])->name('homework.homeworkindex');
    Route::post('/homework/homeworkfinish', [HomeworkController::class, 'homeworkfinish'])->name('homework.homeworkfinish');
    Route::get('/homework/{id}/homeworksubmit', [HomeworkController::class, 'homeworksubmit'])->name('homework.homeworksubmit');
    Route::get('/homework/{id}/destroy', [HomeworkController::class, 'destroy'])->name('homework.destroy');
    Route::get('/homework/homeworkevaln', [HomeworkController::class, 'homeworkevaln'])->name('homework.homeworkevaln');
    Route::get('/getStudents3/{id}', [HomeworkController::class, 'getStudents3'])->name('getStudents3');
    Route::get('/homework/{id}/evaluate', [HomeworkController::class, 'evaluate'])->name('homework.evaluate');
    Route::post('/homework/evaluatefinish', [HomeworkController::class, 'evaluatefinish'])->name('homework.evaluatefinish');
    Route::get('/homework/{id}/homeworksubmituser', [HomeworkController::class, 'homeworksubmituser'])->name('homeworksubmituser');
    Route::get('/getAllHw/{id}', [HomeworkController::class, 'getAllHw'])->name('getAllHw');

    Route::post('/homework/printreport', [HomeworkController::class, 'printreport'])->name('homework.printreport');

    Route::get('/gradereport/report', [GradereportController::class, 'report'])->name('reports.report');
    Route::get('/getStudents/{id}', [OlexamController::class, 'getStudents'])->name('getStudents');
    Route::get('/getAllocExams/{id}', [OlexamController::class, 'getAllocExams'])->name('getAllocExams');
    Route::get('/gradereport/report', [GradereportController::class, 'report'])->name('reports.report');
    Route::get('/getAllprojLab/{id}', [ProjlabController::class, 'getAllprojLab'])->name('getAllprojLab');

    Route::get('/getStudents2/{id}', [ProjlabController::class, 'getStudents2'])->name('getStudents2');

    Route::get('/rbac/index', [RbacController::class, 'index'])->name('rbac.index');
    Route::get('/rbac/create', [RbacController::class, 'create'])->name('rbac.create');

    Route::get('/student/index', [StudentController::class, 'index'])->name('student.index');
    Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/student/store', [StudentController::class, 'store'])->name('student.store');
    Route::get('/student/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');
    Route::post('/student/update', [StudentController::class, 'update'])->name('student.update');
    Route::get('/student/{id}/show', [StudentController::class, 'show'])->name('student.show');
    Route::get('/student/{id}/destroy', [StudentController::class, 'destroy'])->name('student.destroy');

    Route::get('/questionbank/index', [QuestionbankController::class, 'index'])->name('questionbank.index');
    Route::get('/questionbank/show2', [QuestionbankController::class, 'show2'])->name('questionbank.show2');
    Route::post('/questionbank/store2', [QuestionbankController::class, 'store2'])->name('questionbank.store2');
    Route::get('/questionbank/{id}/genpdf', [QuestionbankController::class, 'genpdf']);

    Route::get('/projlab/index', [ProjlabController::class, 'index'])->name('projlab.index');
    Route::post('/projlab/store', [ProjlabController::class, 'store'])->name('projlab.store');
    Route::get('/projlab/create', [ProjlabController::class, 'create'])->name('projlab.create');
    Route::get('/projlab/{id}/show', [ProjlabController::class, 'show'])->name('projlab.show');
    Route::get('/projlab/{id}/studview', [ProjlabController::class, 'studview'])->name('projlab.studview');
    Route::get('/projlab/studprojindex', [ProjlabController::class, 'studprojindex'])->name('projlab.studprojindex');
    Route::post('/projlab/projlabfinish', [ProjlabController::class, 'projlabfinish'])->name('projlab.projlabfinish');
    Route::get('/projlab/{id}/studsubmit', [ProjlabController::class, 'studsubmit'])->name('projlab.studsubmit');
    Route::get('/projlab/{id}/destroy', [ProjlabController::class, 'destroy'])->name('projlab.destroy');
    Route::get('/projlab/projevaln', [ProjlabController::class, 'projevaln'])->name('projlab.projevaln');
    // Route::get('/projlab/eval', [ProjlabController::class, 'eval'])->name('projlab.eval');
    Route::get('/projlab/{id}/evaluate', [ProjlabController::class, 'evaluate'])->name('projlab.evaluate');
    Route::post('/projlab/evaluatefinish', [ProjlabController::class, 'evaluatefinish'])->name('projlab.evaluatefinish');
    Route::get('/projlab/{id}/projsubmituser', [ProjlabController::class, 'projsubmituser'])->name('projsubmituser');

    Route::post('/projlab/printreport', [ProjlabController::class, 'printreport'])->name('projlab.printreport');


    Route::get('/olexam/index', [OlexamController::class, 'index'])->name('olexam.index');
    Route::post('/olexam/store', [OlexamController::class, 'store'])->name('olexam.store');
    Route::get('/olexam/{id}/attendexam', [OlexamController::class, 'attendexam'])->name('olexam.attendexam');
    Route::post('/olexam/saveexam', [OlexamController::class, 'saveexam'])->name('olexam.saveexam');
    Route::get('/olexam/{id}/correctpaper', [OlexamController::class, 'correctpaper'])->name('olexam.correctpaper');
    Route::get('/olexam/{id}/view', [OlexamController::class, 'view'])->name('olexam.view');
    Route::post('/olexam/printreport', [OlexamController::class, 'printreport'])->name('olexam.printreport');

    Route::get('/olexam/correct', [OlexamController::class, 'correct'])->name('olexam.correct');
    Route::post('/olexam/savecorrected', [OlexamController::class, 'savecorrected'])->name('olexam.savecorrected');


    Route::get('/alloctest/index', [AlloctestController::class, 'index'])->name('alloctest.index');
    Route::get('/alloctest/create', [AlloctestController::class, 'create'])->name('alloctest.create');
    Route::post('/alloctest/store', [AlloctestController::class, 'store'])->name('alloctest.store');
    Route::get('/alloctest/{id}/show', [AlloctestController::class, 'show'])->name('alloctest.show');
    Route::get('/alloctest/{id}/edit', [AlloctestController::class, 'edit'])->name('alloctest.edit');

    Route::get('/question/index', [QuestionController::class, 'index'])->name('question.index');
    Route::get('/question/create', [QuestionController::class, 'create'])->name('question.create');
    Route::post('/question/store', [QuestionController::class, 'store'])->name('question.store');
    Route::post('/question/storeqns', [QuestionController::class, 'storeqns'])->name('question.storeqns');
    Route::get('/question/{id}/edit', [QuestionController::class, 'edit'])->name('question.edit');
    Route::post('/question/update', [QuestionController::class, 'update'])->name('question.update');
    Route::get('/question/{id}/show', [QuestionController::class, 'show'])->name('question.show');
    Route::get('/question/{id}/destroy', [QuestionController::class, 'destroy'])->name('question.destroy');
    Route::get('/question/{id}/generate', [QuestionController::class, 'generate'])->name('question.generate');

    Route::get('/role/index', [RolesController::class, 'index'])->name('role.index');
    Route::get('/role/create', [RolesController::class, 'create'])->name('role.create');
    Route::post('/role/store', [RolesController::class, 'store'])->name('role.store');
    Route::get('/role/{id}/edit', [RolesController::class, 'edit'])->name('role.edit');
    Route::post('/role/update', [RolesController::class, 'update'])->name('role.update');
    Route::get('/role/{id}/show', [RolesController::class, 'show'])->name('role.show');
    Route::get('/role/{id}/destroy', [RolesController::class, 'destroy'])->name('role.destroy');

    Route::get('/video/index', [VideoController::class, 'index'])->name('video.index');
    Route::get('/video/create', [VideoController::class, 'create'])->name('video.create');
    Route::post('/video/store', [VideoController::class, 'store'])->name('video.store');
    Route::get('/video/{id}/edit', [VideoController::class, 'edit'])->name('video.edit');
    Route::post('/video/update', [VideoController::class, 'update'])->name('video.update');
    Route::get('/video/{id}/show', [VideoController::class, 'show'])->name('video.show');
    Route::get('/video/{id}/destroy', [VideoController::class, 'destroy'])->name('video.destroy');

    Route::get('/subject/index', [SubjectController::class, 'index'])->name('subject.index');
    Route::get('/subject/create', [SubjectController::class, 'create'])->name('subject.create');
    Route::post('/subject/store', [SubjectController::class, 'store'])->name('subject.store');
    Route::get('/subject/{id}/edit', [SubjectController::class, 'edit'])->name('subject.edit');
    Route::post('/subject/update', [SubjectController::class, 'update'])->name('subject.update');
    Route::get('/subject/{id}/show', [SubjectController::class, 'show'])->name('subject.show');
    Route::get('/subject/{id}/destroy', [SubjectController::class, 'destroy'])->name('subject.destroy');

    Route::get('/chapter/index', [ChapterController::class, 'index'])->name('chapter.index');
    Route::get('/chapter/create', [ChapterController::class, 'create'])->name('chapter.create');
    Route::post('/chapter/store', [ChapterController::class, 'store'])->name('chapter.store');
    Route::get('/chapter/{id}/edit', [ChapterController::class, 'edit'])->name('chapter.edit');
    Route::post('/chapter/update', [ChapterController::class, 'update'])->name('chapter.update');
    Route::get('/chapter/{id}/show', [ChapterController::class, 'show'])->name('chapter.show');
    Route::get('/chapter/{id}/destroy', [ChapterController::class, 'destroy'])->name('chapter.destroy');

    Route::get('/content/index', [ContentController::class, 'index'])->name('content.index');
    Route::get('/content/create', [ContentController::class, 'create'])->name('content.create');
    Route::post('/content/store', [ContentController::class, 'store'])->name('content.store');
    Route::get('/content/{id}/edit', [ContentController::class, 'edit'])->name('content.edit');
    Route::post('/content/update', [ContentController::class, 'update'])->name('content.update');
    Route::get('/content/{id}/show', [ContentController::class, 'show'])->name('content.show');
    Route::get('/content/{id}/destroy', [ContentController::class, 'destroy'])->name('content.destroy');


    Route::get('/rolelist', [RolesController::class, 'rolelist'])->name('role.list');
    Route::get('/getvideos/{id}', [ContentController::class, 'getvideos'])->name('getvideos');
    Route::get('/getchapters/{id}', [VideoController::class, 'getchapters'])->name('getchapters');
    Route::get('/getSubjects/{id}', [VideoController::class, 'getSubjects'])->name('getSubjects');
    Route::get('/getsubjects/{id}', [ChapterController::class, 'getsubjects'])->name('getsubjects');
    Route::get('/getsubjects/{id}', [QuestionController::class, 'getsubjects'])->name('getsubjects');
    Route::get('/getprojlab/{id}', [ProjlabController::class, 'getprojlab'])->name('getprojlab');
    Route::get('/chapterlist', [ChapterController::class, 'chapterlist'])->name('chapterlist');
    Route::get('/getsubjects/{id}', [QuestionController::class, 'getsubjects'])->name('getsubjects');
    Route::get('/getcontentsubject/{id}', [QuestionController::class, 'getcontentsubject'])->name('getcontentsubject');
    Route::get('/getcontentchapt/{id}', [QuestionController::class, 'getcontentchapt'])->name('getcontentchapt');
    Route::get('/contentlist', [ContentController::class, 'contentlist'])->name('contentlist');
    Route::get('/subjectlist', [SubjectController::class, 'subjectlist'])->name('subjectlist');
    Route::get('/videolist', [VideoController::class, 'videolist'])->name('videolist');
    Route::get('/classlist', [TtkitController::class, 'classlist'])->name('classlist');
    Route::get('/cltlist', [CltController::class, 'cltlist'])->name('cltlist');
    Route::get('/questionslist', [QuestionController::class, 'questionslist'])->name('questionslist');
    Route::get('/alloctestlist', [AlloctestController::class, 'alloctestlist'])->name('alloctestlist');
    Route::get('/examslist', [OlexamController::class, 'examslist'])->name('examslist');
    Route::get('/examcorrect', [OlexamController::class, 'examcorrect'])->name('examcorrect');
    Route::get('/projlablist', [ProjlabController::class, 'projlablist'])->name('projlablist');
    Route::get('/projlabevallist', [ProjlabController::class, 'projlabevallist'])->name('projlabevallist');
    Route::get('/getqnmasters/{id}', [QuestionbankController::class, 'getqnmasters'])->name('getqnmasters');
    Route::get('/studentlist', [StudentController::class, 'studentlist'])->name('studentlist');
    Route::get('/rolelist', [RbacController::class, 'rolelist'])->name('rolelist');
    Route::get('/studprojlist', [ProjlabController::class, 'studprojlist'])->name('studprojlist');
    Route::get('/homework2list', [HomeworkController::class, 'homework2list'])->name('homework2list');
    Route::get('/homeworkevalnlist', [HomeworkController::class, 'homeworkevalnlist'])->name('homeworkevalnlist');

    Route::get('get-video/{video}', [VideoController::class, 'getVideo'])->name('getVideo');


});

// Route::get('payment', [RazorpayPaymentController::class, 'index']);
// Route::post('payment', [RazorpayPaymentController::class, 'store'])->name('razorpay.payment.store');


// Route::middleware(['check.auth'])->group(function () {
//     Route::get('dashboard', function () {
//         return view('dashboard');
//     });
// });

// if (auth()->check()) {
//     return Redirect::to('dashboard');
// } else {
//     return Redirect::to('/logout');
// }

// if (auth()->check()) {
//     return view('dashboard');
// } else {
//     return Redirect::to('/');
// }

Route::get('sendSMS', [NexmoSMSController::class, 'index']);

Route::post('logincheck', function() {

    // echo "BBBBBBBBBBBBBBBBBBBBBBB";
    // exit;

    $rules = array (
        'email' => 'required|max:255',
        'password' => 'required|max:25',
    );

    $v = Validator::make(Request::all(), $rules);

    // print_r(Request::all());
    // exit;

    if ($v->fails()) {
        Request::flash ("Unauthorized Acesss !!!!");
        return Redirect::to('/')->withErrors($v->messages());
    } else {

        $userdata = array (
            'email' => Request::get('email'),
            'password' => Request::get('password')
        );

        If (Auth::attempt($userdata)) {
            // $user = auth()->user();
            // echo "Yessssssssssssss";
            // exit;
            // return view('dashboard');
            return Redirect::to('/dashboard');
        } else {
            return Redirect::to('/')->with('message', 'Incorrect login details !!!');
        }
    }

});

Route::get('/logout', [AuthController::class, 'logout']);

Route::group(['prefix' => 'payment'], function(){
    Route::get('online', function () { return view('pages.payment.online'); });
});

Route::group(['prefix' => 'training'], function(){
    Route::get('ttkit', function () { return view('pages.training.ttkit'); });
    Route::get('cbtkit', function () { return view('pages.training.cbtkit'); });
});

Route::group(['prefix' => 'masters'], function(){
    Route::get('video', function () { return view('pages.masters.video'); });
    Route::get('content', function () { return view('pages.masters.content'); });
    Route::get('image', function () { return view('pages.masters.image'); });
    Route::get('qtnmatch', function () { return view('pages.masters.qtnmatch'); });
    Route::get('question', function () { return view('pages.masters.question'); });
    Route::get('alloctest', function () { return view('pages.masters.alloctest'); });
    Route::get('upqnsbank', function () { return view('pages.masters.upqnsbank'); });
    Route::get('qnsbank', function () { return view('pages.masters.qnsbank'); });

    // Route::get('rolemaster', function () { return view('pages.masters.rolemaster'); });
});

/*
Route::group(['prefix' => 'email'], function(){
    Route::get('inbox', function () { return view('pages.email.inbox'); });
    Route::get('read', function () { return view('pages.email.read'); });
    Route::get('compose', function () { return view('pages.email.compose'); });
});

Route::group(['prefix' => 'email'], function(){
    Route::get('inbox', function () { return view('pages.email.inbox'); });
    Route::get('read', function () { return view('pages.email.read'); });
    Route::get('compose', function () { return view('pages.email.compose'); });
});

Route::group(['prefix' => 'apps'], function(){
    Route::get('chat', function () { return view('pages.apps.chat'); });
    Route::get('calendar', function () { return view('pages.apps.calendar'); });
});

Route::group(['prefix' => 'ui-components'], function(){
    Route::get('alerts', function () { return view('pages.ui-components.alerts'); });
    Route::get('badges', function () { return view('pages.ui-components.badges'); });
    Route::get('breadcrumbs', function () { return view('pages.ui-components.breadcrumbs'); });
    Route::get('buttons', function () { return view('pages.ui-components.buttons'); });
    Route::get('button-group', function () { return view('pages.ui-components.button-group'); });
    Route::get('cards', function () { return view('pages.ui-components.cards'); });
    Route::get('carousel', function () { return view('pages.ui-components.carousel'); });
    Route::get('collapse', function () { return view('pages.ui-components.collapse'); });
    Route::get('dropdowns', function () { return view('pages.ui-components.dropdowns'); });
    Route::get('list-group', function () { return view('pages.ui-components.list-group'); });
    Route::get('media-object', function () { return view('pages.ui-components.media-object'); });
    Route::get('modal', function () { return view('pages.ui-components.modal'); });
    Route::get('navs', function () { return view('pages.ui-components.navs'); });
    Route::get('navbar', function () { return view('pages.ui-components.navbar'); });
    Route::get('pagination', function () { return view('pages.ui-components.pagination'); });
    Route::get('popovers', function () { return view('pages.ui-components.popovers'); });
    Route::get('progress', function () { return view('pages.ui-components.progress'); });
    Route::get('scrollbar', function () { return view('pages.ui-components.scrollbar'); });
    Route::get('scrollspy', function () { return view('pages.ui-components.scrollspy'); });
    Route::get('spinners', function () { return view('pages.ui-components.spinners'); });
    Route::get('tabs', function () { return view('pages.ui-components.tabs'); });
    Route::get('tooltips', function () { return view('pages.ui-components.tooltips'); });
});

Route::group(['prefix' => 'advanced-ui'], function(){
    Route::get('cropper', function () { return view('pages.advanced-ui.cropper'); });
    Route::get('owl-carousel', function () { return view('pages.advanced-ui.owl-carousel'); });
    Route::get('sweet-alert', function () { return view('pages.advanced-ui.sweet-alert'); });
});

Route::group(['prefix' => 'forms'], function(){
    Route::get('basic-elements', function () { return view('pages.forms.basic-elements'); });
    Route::get('advanced-elements', function () { return view('pages.forms.advanced-elements'); });
    Route::get('editors', function () { return view('pages.forms.editors'); });
    Route::get('wizard', function () { return view('pages.forms.wizard'); });
});

Route::group(['prefix' => 'charts'], function(){
    Route::get('apex', function () { return view('pages.charts.apex'); });
    Route::get('chartjs', function () { return view('pages.charts.chartjs'); });
    Route::get('flot', function () { return view('pages.charts.flot'); });
    Route::get('morrisjs', function () { return view('pages.charts.morrisjs'); });
    Route::get('peity', function () { return view('pages.charts.peity'); });
    Route::get('sparkline', function () { return view('pages.charts.sparkline'); });
});

Route::group(['prefix' => 'tables'], function(){
    Route::get('basic-tables', function () { return view('pages.tables.basic-tables'); });
    Route::get('data-table', function () { return view('pages.tables.data-table'); });
});

Route::group(['prefix' => 'icons'], function(){
    Route::get('feather-icons', function () { return view('pages.icons.feather-icons'); });
    Route::get('flag-icons', function () { return view('pages.icons.flag-icons'); });
    Route::get('mdi-icons', function () { return view('pages.icons.mdi-icons'); });
});

Route::group(['prefix' => 'general'], function(){
    Route::get('blank-page', function () { return view('pages.general.blank-page'); });
    Route::get('faq', function () { return view('pages.general.faq'); });
    Route::get('invoice', function () { return view('pages.general.invoice'); });
    Route::get('profile', function () { return view('pages.general.profile'); });
    Route::get('pricing', function () { return view('pages.general.pricing'); });
    Route::get('timeline', function () { return view('pages.general.timeline'); });
});
*/

Route::group(['prefix' => 'auth'], function(){
    Route::get('login', function () { return view('pages.auth.login'); });
    Route::get('register', function () { return view('pages.auth.register'); });
});

Route::group(['prefix' => 'error'], function(){
    Route::get('404', function () { return view('pages.error.404'); });
    Route::get('500', function () { return view('pages.error.500'); });
});

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

// 404 for undefined routes
Route::any('/{page?}',function(){
    return View::make('pages.error.404');
})->where('page','.*');
