<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Auth;
use DB;
use DataTables;
use Carbon\Carbon;

class OlexamController extends Controller
{
    //
    public function index()
    {
        return view('pages.training.olexam.index');
    }

    public function examslist()
    {
        $login_id = Auth::id();

        $loginfo = DB::select("select class_id, Section FROM students WHERE is_deleted = 0 AND user_id=$login_id");
        // echo "<pre>";
        // print_r($loginfo);
        // echo "</pre>";
        // exit;
        $clsid = $loginfo[0]->class_id;
        $secn = $loginfo[0]->Section;

        // echo $clsid . " MMMMMMMMMM   " . $login_id;
        // exit;

        $subs = DB::select("select id, test_title, qn_master_templ_id, start_date, end_date, duration FROM allocate_test WHERE is_active = 1 AND ((class_id=$clsid AND sec_id='". $secn . "') OR $login_id=1)");

        return datatables()->of($subs)
            ->addColumn('action', function ($selected) {
                return
                    '<div class="col-lg-12 margin-tb"><div class="pull-right"> <a class="btn btn-success text-light" data-toggle="modal" id="mediumButton2" data-target="#mediumModal" data-attr="'. $selected->id . '/attendexam" alt="'. $selected->id . '" title="Click to Start Exam ....."> Start <i class="fas fa-book-reader"></i> </a> </div>';
            })->toJson();

    }

    public function attendexam($id)
    {
        // echo $id . " MMMMMMMMMM   " . Auth::id();
        // exit;
        $stud_id = Auth::id();
        // $test_id = $id;
        $result3 = DB::select("select test_title, qn_master_templ_id, duration FROM allocate_test WHERE is_active = 1 AND id=$id");
        $examtitle = $result3[0]->test_title;
        $qnmastid = $result3[0]->qn_master_templ_id;
        $examDur = $result3[0]->duration;

        $result2 = DB::select("select temp_questions, image_qns_ans from question_master_qns_ans WHERE is_active = 1 AND qn_master_temp_id=$qnmastid");
        $res = json_decode($result2[0]->temp_questions, true);
        $imgQue = json_decode($result2[0]->image_qns_ans, true);

        // echo "<pre>";
        // print_r($res);
        // echo "</pre>";
        // echo "sSSSSSSSSSSSSSS";
        // exit;

        $temp = "";
        foreach ($res as $key => $qns) {
            $qtype = explode("_", $key);
            if ($qtype[0] != $temp) {
                if(str_contains($qtype[0], "ReOrd6") || str_contains($qtype[0], "left") || str_contains($qtype[0], "right") ) {
                    continue;
                } else {
                    $qry6 = "select title from question_master_title WHERE is_active = 1 AND id=$qtype[0]";
                    // echo $qry6;
                    // exit;
                    $res3 = DB::select($qry6);
                    $QnsTitle[$qtype[0]] = $res3[0]->title;
                }
             }
            $temp = $qtype[0];

            if ($qtype[0] == 7) {
                $type7 = explode("~~~~~", $qns);


                if (isset($type7[0])) {
                    $Qns[$qtype[0]][$qtype[1]][0] = $type7[0];
                }
                if (isset($type7[1])) {
                    $Qns[$qtype[0]][$qtype[1]][1] = $type7[1];
                }
                if (isset($type7[2])) {
                    $Qns[$qtype[0]][$qtype[1]][2] = $type7[2];
                }
                if (isset($type7[3])) {
                    $Qns[$qtype[0]][$qtype[1]][3] = $type7[3];
                }
                if (isset($type7[4])) {
                    $Qns[$qtype[0]][$qtype[1]][4] = $type7[4];
                }
                if (isset($type7[5])) {
                    $Qns[$qtype[0]][$qtype[1]][5] = $type7[5];
                }
                if (isset($type7[6])) {
                    $Qns[$qtype[0]][$qtype[1]][6] = $type7[6];
                }
                if (isset($type7[7])) {
                    $Qns[$qtype[0]][$qtype[1]][7] = $type7[7];
                }
            } elseif ($qtype[0] == 6) {
                // echo $qns;
                // exit;
                $Qns[6]['qns'] = $res['ReOrd6'];
                // $Qns[6]['ReOrds'] = $res['ReOrd'];

            } elseif ($qtype[0] == 10) {

                // echo "<pre>";
                // print_r($qns);
                // exit;
                for($kk=1; $kk <= 5; $kk++) {
                    if(isset($qns["Qleft_10"][$kk])) {
                        $Q10[$kk] = $qns["Qleft_10"][$kk] . "~~~~~" . $qns["Qright_10"][$kk];
                    } else {
                        continue;
                    }
                }
                $Qns[10] = $Q10;

            } elseif ($qtype[0] == 3) {
                $Qns[3]['qns'][] = $qns;

            } else {
                $Qns[$qtype[0]][$qtype[1]] = $qns;
            }
        }

        $romanLetters = array(1 => "I", 2 => "II", 3 => "III", 4 => "IV", 5 => "V", 6 => "VI", 7 => "VII", 8 => "VIII", 9 => "IX", 10 => "X", 11 => "XI", 12 => "XII", 13 => "XIII", 14 => "XIV", 15 => "XV", 16 => "XVI", 17 => "XVII", 18 => "XVIII", 19 => "XIX", 20 => "XX");

        // echo "<pre>";
        // print_r($QnsTitle);
        // print_r($Qns);
        // print_r($imgQue);
        // echo "</pre>";
        // exit;

        $examDurationMinutes = (int)$examDur; // Set the exam duration to 5 minutes
        $startTime = now(); // Current time
        $endTime = $startTime->copy()->addMinutes($examDurationMinutes); // Calculate end time

        return view('pages.training.olexam.attendexam')->with('qntit', $QnsTitle)->with('qns', $Qns)->with('romlet', $romanLetters)->with('examtitle', $examtitle)->with('stud_id', $stud_id)->with('test_id', $id)->with('qnstempid', $qnmastid)->with('imgQuens', $imgQue)->with('endTime', $endTime);
    }


    public function saveexam(Request $request)
    {

        $stud_id = $request->student_id;
        $qnstemp_id = $request->qnstempid;
        $test_id = $request->test_id;

        $answers = $request->all();

        // echo "<pre>";
        // print_r($answers);
        // echo "</pre>";
        // exit;

        unset($answers['_token']);
        unset($answers['student_id']);
        unset($answers['qnstempid']);
        unset($answers['test_id']);

        // echo "<pre></pre>";
        // print_r($answers);
        // exit;

        $ansjson = json_encode($answers, true);

        try {
            DB::table('student_answers')->insert(
                array(
                    'student_id'  =>   $stud_id,
                    'que_master_templ_id'   => $qnstemp_id,
                    'alloc_test_id'   => $test_id,
                    'answer'   => $ansjson,
                    'school_id'   => 1,
                    'created_date'   => Carbon::now(),
                    'updated_date'   => Carbon::now(),
                    'is_deleted'   => 0
                )
            );
        } catch (\Throwable $e) {
            print_r($e->getMessage());
            return View('pages.training.olexam.attendexam')->with('message', "Error Submitting Answers - Try once again !!!");
        }

        return redirect()->route('olexam.index')->with('message', "Saving answers Successfully !!!");
    }

    public function correct()
    {
        return view('pages.training.olexam.correct');
    }

    public function examcorrect()
    {
        $subs = DB::select("select A.id, C.class_id, D.title, CONCAT(C.first_name, ' ', C.last_name) as stname, A.is_validated, A.mark, D.total_marks FROM student_answers A, students C, question_master_template D WHERE A.is_deleted = 0 AND A.que_master_templ_id = D.id AND C.user_id = A.student_id AND D.id=A.que_master_templ_id");

        return datatables()->of($subs)
            ->addColumn('action', function ($selected) {
                return
                    '<a class="btn btn-success" href="' . $selected->id . '/correctpaper" title="Correct Exam">Correct Paper</i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-warning" title="View Student Answered paper" href="' . $selected->id . '/view">View Paper</i></a>';
            })->toJson();
    }

    public function correctpaper($id)
    {
        // echo $id . " MMMMMMMMMM   " . Auth::id();
        // exit;
        // $stud_id = Auth::id() . "~~~~~" . $id;

        $res4 = DB::select("select alloc_test_id, que_master_templ_id, student_id, answer FROM student_answers WHERE is_deleted = 0 AND id=$id");
        $stud_id = $res4[0]->student_id;
        $qntempid = $res4[0]->que_master_templ_id;
        $allc_id = $res4[0]->alloc_test_id;

        $stud_answer = json_decode($res4[0]->answer, true);

        $res5 = DB::select("select title, question_template from question_master_template WHERE is_active = 1 AND id=$qntempid");
        $marks_each = json_decode($res5[0]->question_template, true);
        $examtitle2 = $res5[0]->title;
        foreach ($marks_each as $mm => $vals) {
            $emark[$mm] = $vals[1];
        }


        $result2 = DB::select("select temp_questions, temp_answers from question_master_qns_ans WHERE is_active = 1 AND qn_master_temp_id=$qntempid");
        $qtns = json_decode($result2[0]->temp_questions, true);
        $act_answer = json_decode($result2[0]->temp_answers, true);

        // echo "<pre>";
        // print_r($qtns);
        // echo " ================================ <br>";
        // print_r($act_answer);
        // exit;

        $temp = 0;
        foreach ($qtns as $key => $qns) {
            $qtype = explode("_", $key);
            if ($qtype[0] != $temp) {
                if(str_contains($qtype[0], "ReOrd") || str_contains($qtype[0], "left") || str_contains($qtype[0], "right")) {
                    continue;
                } else {
                    $qry6 = "select title from question_master_title WHERE is_active = 1 AND id=$qtype[0]";
                    // echo $qry6;
                    // exit;
                    $res3 = DB::select($qry6);
                    $QnsTitle[$qtype[0]] = $res3[0]->title;
                }
             }
            $temp = $qtype[0];

            if ($qtype[0] == 7) {
                $type7 = explode("~~~~~", $qns);
                if (isset($type7[0])) {
                    $Qns[$qtype[0]][$qtype[1]][0] = $type7[0];
                }
                if (isset($type7[1])) {
                    $Qns[$qtype[0]][$qtype[1]][1] = $type7[1];
                }
                if (isset($type7[2])) {
                    $Qns[$qtype[0]][$qtype[1]][2] = $type7[2];
                }
                if (isset($type7[3])) {
                    $Qns[$qtype[0]][$qtype[1]][3] = $type7[3];
                }
                if (isset($type7[4])) {
                    $Qns[$qtype[0]][$qtype[1]][4] = $type7[4];
                }
                if (isset($type7[5])) {
                    $Qns[$qtype[0]][$qtype[1]][5] = $type7[5];
                }
                if (isset($type7[6])) {
                    $Qns[$qtype[0]][$qtype[1]][6] = $type7[6];
                }
                if (isset($type7[7])) {
                    $Qns[$qtype[0]][$qtype[1]][7] = $type7[7];
                }
            } elseif ($qtype[0] == 6) {
                // echo $qns;
                // exit;
                $Qns[6]['qns'] = $qtns['6_1'];
                $Qns[6]['ReOrds'] = $qtns['ReOrd6'];


            } elseif ($qtype[0] == 10) {
                // echo "<pre>";
                // print_r($qns);
                // exit;
                for($pp = 1; $pp <= 5; $pp++) {
                    if(isset($qns['Qleft_10'][$pp])) {
                        $Q10[$pp] = $qns['Qleft_10'][$pp] . "~~~~~" . $qns['Qright_10'][$pp];
                    }

                }
                $Qns[10]['qns'] = $Q10;


            } else {
                $Qns[$qtype[0]][$qtype[1]] = $qns;
            }
        }

        $romanLetters = array(1 => "I", 2 => "II", 3 => "III", 4 => "IV", 5 => "V", 6 => "VI", 7 => "VII", 8 => "VIII", 9 => "IX", 10 => "X", 11 => "XI", 12 => "XII", 13 => "XIII", 14 => "XIV", 15 => "XV", 16 => "XVI", 17 => "XVII", 18 => "XVIII", 19 => "XIX", 20 => "XX");

        // echo "<pre>";
        // print_r($QnsTitle);
        // print_r($Qns);
        // echo "<br><br>";
        // print_r($stud_answer);
        // echo "<br><br>";
        // print_r($act_answer);
        // echo "<br><br>";
        // print_r($emark);
        // echo "</pre>";
        // exit;

        // return redirect()->route('olexam.correct')->with('message', "Saving answers Successfully !!!");

        return view('pages.training.olexam.correctpaper')->with('qntit', $QnsTitle)->with('qns', $Qns)->with('romlet', $romanLetters)->with('examtitle2', $examtitle2)->with('stud_id', $stud_id)->with('stud_ans', $stud_answer)->with('act_ans', $act_answer)->with('qn_template_id', $qntempid)->with('allocTestId', $allc_id)->with('eachmark', $emark);
    }

    public function view($id)
    {
        // echo $id . " MMMMMMMMMM   " . Auth::id();
        // exit;
        // $stud_id = Auth::id() . "~~~~~" . $id;

        $res4 = DB::select("select alloc_test_id, que_master_templ_id, student_id, CONCAT(B.first_name, ' ', B.last_name) as student_name, answer FROM student_answers as A, students B WHERE A.is_deleted = 0 AND A.id=$id AND A.student_id = B.user_id;");
        $stud_id = $res4[0]->student_id;
        $qntempid = $res4[0]->que_master_templ_id;
        $allc_id = $res4[0]->alloc_test_id;
        $student_name = $res4[0]->student_name;

        $stud_answer = json_decode($res4[0]->answer, true);

        $res5 = DB::select("select title, question_template from question_master_template WHERE is_active = 1 AND id=$qntempid");
        $marks_each = json_decode($res5[0]->question_template, true);
        $examtitle2 = $res5[0]->title;
        foreach ($marks_each as $mm => $vals) {
            $emark[$mm] = $vals[1];
        }
        // echo "<pre>";
        // print_r($emark);
        // exit;

        $result2 = DB::select("select temp_questions, temp_answers from question_master_qns_ans WHERE is_active = 1 AND qn_master_temp_id=$qntempid");
        $qtns = json_decode($result2[0]->temp_questions, true);
        $act_answer = json_decode($result2[0]->temp_answers, true);

        $temp = 0;
        foreach ($qtns as $key => $qns) {
            $qtype = explode("_", $key);
            if ($qtype[0] != $temp) {
                $res3 = DB::select("select title from question_master_title WHERE is_active = 1 AND id=$qtype[0]");
                $QnsTitle[$qtype[0]] = $res3[0]->title;
            }
            $temp = $qtype[0];

            if ($qtype[0] == 7) {
                $type7 = explode("~~~~~", $qns);
                if (isset($type7[0])) {
                    $Qns[$qtype[0]][$qtype[1]][0] = $type7[0];
                }
                if (isset($type7[1])) {
                    $Qns[$qtype[0]][$qtype[1]][1] = $type7[1];
                }
                if (isset($type7[2])) {
                    $Qns[$qtype[0]][$qtype[1]][2] = $type7[2];
                }
                if (isset($type7[3])) {
                    $Qns[$qtype[0]][$qtype[1]][3] = $type7[3];
                }
                if (isset($type7[4])) {
                    $Qns[$qtype[0]][$qtype[1]][4] = $type7[4];
                }
                if (isset($type7[5])) {
                    $Qns[$qtype[0]][$qtype[1]][5] = $type7[5];
                }
                if (isset($type7[6])) {
                    $Qns[$qtype[0]][$qtype[1]][6] = $type7[6];
                }
                if (isset($type7[7])) {
                    $Qns[$qtype[0]][$qtype[1]][7] = $type7[7];
                }
            } else {
                $Qns[$qtype[0]][$qtype[1]] = $qns;
            }
        }

        $romanLetters = array(1 => "I", 2 => "II", 3 => "III", 4 => "IV", 5 => "V", 6 => "VI", 7 => "VII", 8 => "VIII", 9 => "IX", 10 => "X", 11 => "XI", 12 => "XII", 13 => "XIII", 14 => "XIV", 15 => "XV", 16 => "XVI", 17 => "XVII", 18 => "XVIII", 19 => "XIX", 20 => "XX");

        // echo "<pre>";
        // print_r($QnsTitle);
        // print_r($Qns);
        // echo "<br><br>";
        // print_r($stud_answer);
        // echo "<br><br>";
        // print_r($act_answer);
        // echo "<br><br>";
        // print_r($emark);
        // echo "</pre>";
        // exit;

        // return redirect()->route('olexam.correct')->with('message', "Saving answers Successfully !!!");

        return view('pages.training.olexam.view')->with('qntit', $QnsTitle)->with('qns', $Qns)->with('romlet', $romanLetters)->with('examtitle2', $examtitle2)->with('stud_id', $stud_id)->with('stud_name', $student_name)->with('stud_ans', $stud_answer)->with('act_ans', $act_answer)->with('qn_template_id', $qntempid)->with('allocTestId', $allc_id)->with('eachmark', $emark);
    }

    public function savecorrected(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());
        // echo "ZZZZZZZZZZZZZZZZ";
        // exit;

        $marks = $request->all();

        $studid = $marks['student_id'];
        $testId = $marks['allocTestId'];
        $qntmpid = $marks['qn_template_id'];

        unset($marks['_token']);
        unset($marks['student_id']);
        unset($marks['qn_template_id']);

        $totmark = 0;
        foreach ($marks as $k2 => $vals) {
            if (str_contains($k2, 'mark_')) {
                $totmark = $totmark + $vals;
            }
        }

        // echo "<pre>";
        // print_r($marks);
        // echo "</pre>";

        // echo $studid . " <<<==== " . $testId  . " <<<==== " . $qntmpid . " <<<==== " . $totmark;
        // exit;

        try {
            DB::table('student_answers')
                ->where('alloc_test_id', $testId)
                ->where('student_id', $studid)
                ->where('que_master_templ_id', $qntmpid)
                ->where('is_deleted', 0)
                ->update(['mark' => $totmark, 'is_validated' => "Yes", 'updated_date' => Carbon::now()]);
        } catch (\Throwable $e) {
            print_r($e->getMessage());
            return View::make('pages.training.olexam.correct')->with('message', "Error Submitting Answers - Try once again !!!");
        }

        // return View::make('pages.training.olexam.correct');
        return redirect()->route('olexam.correct')->with('message', "Student Paper corrected Successfully !!!");
    }

    public function getStudents($id)
    {
        $clssec = explode("~~~~~",$id);

        $qry5 = "select user_id, CONCAT('Roll No. ', user_id, ' - ', first_name, ' ', last_name) as student_name FROM students WHERE is_deleted = 0 AND class_id=" . $clssec[0] . " AND Section='" . $clssec[1] . "'";
        // echo $qry5;
        // exit;
        $res6 = DB::select($qry5);

        $options2 = "<option value='0'>Select Student</option>";
        foreach ($res6 as $data3) {
            $options2 .= "<option value='" . $data3->user_id . "'>" . $data3->student_name . "</option>";
        }
        return $options2;
    }

    public function getAllocExams($id)
    {
        $res6 = DB::select("select qn_master_templ_id, test_title FROM allocate_test WHERE is_deleted = 0 AND class_id=$id");
        $options3 = "";
        foreach ($res6 as $data7) {
            $options3 .= "<option value='" . $data7->qn_master_templ_id . "'>" . $data7->test_title . "</option>";
        }
        return $options3;
    }


    public function printreport(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());
        // echo "</pre>";
        // exit;

        $tmplid = $request->que_templ_id;

        if(!isset($request->student_id))
        {
            $sql6 = "select C.user_id as roleid, CONCAT(C.first_name, ' ', C.last_name) as stname, C.class_id, C.Section, A.mark, D.total_marks, D.title FROM student_answers A, students C, question_master_template D WHERE A.is_deleted = 0 AND D.class_id=$request->class_id AND A.que_master_templ_id = $tmplid AND A.que_master_templ_id = D.id AND A.student_id = C.user_id";
            // echo $sql6; exit;
            $prep3 = DB::select($sql6);
            if(!empty($prep3)) {
            // exit;
                foreach ($prep3 as $kk => $data2) {
                    $examtitle = $data2->title;
                    $info3[$kk][0] = $data2->roleid;
                    $info3[$kk][1] = $data2->stname;
                    $info3[$kk][2] = $data2->mark;
                    $info3[$kk][3] = $data2->total_marks;
                    $info3[$kk][4] = $data2->class_id;
                    $info3[$kk][5] = $data2->Section;
                }
            } else {
                $info3 = [];
                $examtitle = "";
            }
        } else {
            $sql6 = "select C.user_id as roleid, CONCAT(C.first_name, ' ', C.last_name) as stname, C.class_id, C.Section, A.mark, D.total_marks, D.title FROM student_answers A, students C, question_master_template D WHERE A.is_deleted = 0 AND A.que_master_templ_id = D.id AND C.user_id = A.student_id AND D.id=A.que_master_templ_id AND C.user_id=" . $request->student_id;
            $prep3 = DB::select($sql6);
            if(!empty($prep3)) {
                foreach ($prep3 as $kk => $data2) {
                    $examtitle = $data2->title;
                    $info3[$kk][0] = $data2->roleid;
                    $info3[$kk][1] = $data2->stname;
                    $info3[$kk][2] = $data2->mark;
                    $info3[$kk][3] = $data2->total_marks;
                    $info3[$kk][4] = $data2->class_id;
                    $info3[$kk][5] = $data2->Section;
                }
            } else {
                $info3 = [];
                $examtitle = "";
            }
        }

        // echo $sql6 . "<br>";
        // echo $examtitle . "<br>";
        // echo "<pre>";
        // print_r($info3);
        // echo "</pre>";
        // exit;

        return view('pages.training.olexam.printreport')->with('stud_data',$info3)->with('examtitle',$examtitle)->with('tmplid',$tmplid);
    }
}
