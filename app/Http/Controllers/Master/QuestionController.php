<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Masters\Content;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use DB;
use File;
use DataTables;
use Carbon\Carbon;

class QuestionController extends Controller
{

    public function index()
    {
        $data = DB::table('student_class')->select('id', 'class')->where('school_id', '=', 1)->where('is_deleted', '=', '0')->get();
        $result = $data->toArray();
        foreach ($result as $arr) {
            $classArr[$arr->id] = $arr->class;
        }
        return view('pages.masters.question.index')->with('clssArr', $classArr);
    }

    public function questionslist()
    {
        // echo $id;
        // exit;
        $qns = DB::select("select AA.id as id, AA.title, BB.class as class, CC.title as subject, DD.title as chapter, AA.total_marks as totMarks from question_master_template as AA, student_class as BB, subject_master as CC, chapters as DD WHERE BB.id=AA.class_id AND CC.id= AA.subject_id AND DD.id= AA.chapter_id AND AA.is_active = 1 ORDER BY AA.id");
        return datatables()->of($qns)
            ->addColumn('action', function ($selected) {
                return
                    '<a class="btn btn-success" href="' . $selected->id . '/show" title="Detailed view of this Record"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-warning" title="Edit this Record" href="' . $selected->id . '/edit"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-success" href="' . $selected->id . '/generate" title="Generate Questions...."><i class="fas fa-plus"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="' . $selected->id . '/destroy" onclick="return confirmation();" title="Delete this Record"><i class="fas fa-trash"></i></a>';
            })->toJson();
    }

    public function getcontentsubject($id)
    {

        $subQry = "select AA.id as id, AA.title as title from subject_master as AA, content_master as BB WHERE BB.class_id=AA.class_id AND BB.subject_id=AA.id AND BB.video_type_id=1  AND BB.is_active = 1 AND BB.class_id=$id";
        // echo $subQry; exit;
        $subs = DB::select($subQry);
        $options = '<option value="0" selected disabled>Select Subject</option>';
        foreach ($subs as $data2) {
            $options .= "<option value='" . $data2->id . "'>" . $data2->title . "</option>";
        }
        // echo $options; exit;
        return $options;
    }

    public function generate($id)
    {
        $qnstemp = DB::select("select question_template from question_master_template WHERE id=$id AND is_active = 1");
        // $data['qnstemp'] = $qnstemp;
        $qns = json_decode($qnstemp[0]->question_template);
        foreach ($qns as $id4 => $data3) {
            $qnstemp2 = DB::select("select title from question_master_title WHERE id=$id4 AND is_active = 1");
            $qnheads_det[$id4] = $qnstemp2[0]->title;
            // echo "$id4<pre>";
            // print_r($data3);
            if($id4 == 3) {
                $qn_count[$id4] = 1;
                $qn_cnt3 = $data3[0];
            } else {
                $qn_count[$id4] = $data3[0];
            }
            $qn_mark[$id4] = $data3[1];
        }
        // print_r($qn_cnt3);
        // exit;
        if(!isset($qn_cnt3)){
            $qn_cnt3 = 0;
        }


        $result5 = DB::select("select temp_questions, temp_answers from question_master_qns_ans WHERE is_active = 1 AND qn_master_temp_id=$id");

        if(isset($result5[0]->temp_questions)) {
            $qns = json_decode($result5[0]->temp_questions, true);
        } else {
            $qns = array();
        }

        if(isset($result5[0]->temp_answers)) {
            $ans = json_decode($result5[0]->temp_answers, true);
        } else {
            $ans = array();
        }


        $romanLetters = array (1 => "I", 2 => "II", 3 => "III", 4 => "IV", 5 => "V", 6 => "VI", 7 => "VII", 8 => "VIII", 9 => "IX", 10 => "X", 11 => "XI", 12 => "XII", 13 => "XIII", 14 => "XIV", 15 => "XV");
        return view('pages.masters.question.generate')->with('qhead', $qnheads_det)->with('qncnt', $qn_count)->with('qnmark', $qn_mark)->with('romlet', $romanLetters)->with('qn3matchfollow', $qn_cnt3)->with('qns', $qns)->with('ans', $ans);
    }

    public function getcontentchapt($ids)
    {
        $id = explode("~~~", $ids);
        // echo $id[0] . "   " . $id[1];
        // exit;
        $qry6 = "select CC.id as id, CC.title as title from subject_master as AA, content_master as BB, chapters as CC WHERE AA.id=$id[0] AND CC.class_id=$id[1] AND BB.subject_id=$id[0] AND  BB.chapter_id=CC.id AND BB.video_type_id=1 AND AA.is_active = 1 ORDER BY BB.title";
        // echo $qry6; exit;
        $subs = DB::select($qry6);
        $options = "";
        foreach ($subs as $data2) {
            $options .= "<option value='" . $data2->id . "'>" . $data2->title . "</option>";
        }
        // echo $options; exit;
        return $options;
    }


    public function contentlist()
    {
        $chaps = DB::table('content_master')->join('video_master', 'video_master.id', '=', 'content_master.video_id')->join('video_type_master', 'video_type_master.id', '=', 'video_master.type')->join('student_class', 'content_master.class_id', '=', 'student_class.id')->select('content_master.id as cm_id', 'content_master.title as cm_title', 'video_master.title as vm_title', 'video_type_master.title as vm_type', 'student_class.class as cm_clid', 'content_master.content as content', 'content_master.is_active as status')->orderBy('content_master.created_date', 'desc');
        return datatables()->of($chaps)
            ->addColumn('action', function ($selected) {
                return
                    '<a class="btn btn-success" href="' . $selected->cm_id . '/show" title="Detailed view of this Record">V</i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-warning" title="Edit this Record" href="' . $selected->cm_id . '/edit">E</i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="' . $selected->cm_id . '/destroy" onclick="return confirmation();" title="Delete this Record">D</a>';
            })->toJson();
    }

    public function create()
    {
        // $data2['contents'] = DB::table('content_master')->select('id','class')->where('school_id', '=', 1)->where( 'is_deleted', '=', '0')->get();

        $data['classlist'] = DB::table('student_class')->select('id', 'class')->where('school_id', '=', 1)->where('is_deleted', '=', '0')->get();
        $result2 = DB::select("select id, title from question_master_title WHERE is_active = 1 AND school_id=1 ORDER BY id");
        foreach ($result2 as $arr2) {
            $qntemp[$arr2->id] = $arr2->title;
        }
        return view('pages.masters.question.create', $data)->with('qntemp', $qntemp);;
    }

    public function storeqns(Request $request)
    {
        $qn_master_temp_id = $request->qn_temp_id;

        //echo "<pre>";
        //print_r($request->all());
        // print_r($request->file());
        // echo "</pre>";
        // echo $qn_master_temp_id;
        //exit;

        $imgInfoArray = array();

        if ($request->file()) {

            foreach ($request->file() as $folder => $imgfile) {
                $storeAt = "storage\images\\$folder";
                if (!file_exists($storeAt)) {
                    mkdir($storeAt, 0700);
                }

                if (isset($imgfile[0])) {
                    $mcqimgque = $imgfile[0]->getClientOriginalName();
                    $imgfile[0]->move($storeAt, $mcqimgque);
                    $imgInfoArray[$folder][0] = $mcqimgque;
                }
                if (isset($imgfile[1])) {
                    $mcqimgchoice1 = $imgfile[1]->getClientOriginalName();
                    $imgfile[1]->move($storeAt, $mcqimgchoice1);
                    $imgInfoArray[$folder][1] = $mcqimgchoice1;
                }
                if (isset($imgfile[2])) {
                    $mcqimgchoice2 = $imgfile[2]->getClientOriginalName();
                    $imgfile[2]->move($storeAt, $mcqimgchoice2);
                    $imgInfoArray[$folder][2] = $mcqimgchoice2;
                }
                if (isset($imgfile[3])) {
                    $mcqimgchoice3 = $imgfile[3]->getClientOriginalName();
                    $imgfile[3]->move($storeAt, $mcqimgchoice3);
                    $imgInfoArray[$folder][3] = $mcqimgchoice3;
                }
                if (isset($imgfile[4])) {
                    $mcqimgchoice4 = $imgfile[4]->getClientOriginalName();
                    $imgfile[4]->move($storeAt, $mcqimgchoice4);
                    $imgInfoArray[$folder][4] = $mcqimgchoice4;
                }
                if (isset($imgfile[5])) {
                    $mcqimgchoice5 = $imgfile[5]->getClientOriginalName();
                    $imgfile[5]->move($storeAt, $mcqimgchoice5);
                    $imgInfoArray[$folder][5] = $mcqimgchoice5;
                }
                if (isset($imgfile[6])) {
                    $mcqimgchoice6 = $imgfile[6]->getClientOriginalName();
                    $imgfile[6]->move($storeAt, $mcqimgchoice6);
                    $imgInfoArray[$folder][6] = $mcqimgchoice6;
                }
            }
        }

        // echo "<pre>";
        // print_r($imgInfoArray);
        // echo "</pre>";

        foreach ($request->all() as $key => $vals) {
            if ($key == "_token" || $key == "qn_temp_id") {
                continue;
            } else {
                $splitque = explode("_", $key);
                //echo "<pre>";
                ///print_r($splitque);
                // exit;
                if ($splitque[0] == "que") {
                    if ($splitque[1] == 7) {
                        if ($splitque[2] == 1) {
                            $joinOptions = $vals . "~~~~~" . $request->ops_7_1a . "~~~~~" . $request->ops_7_1b . "~~~~~" . $request->ops_7_1c . "~~~~~" . $request->ops_7_1d . "~~~~~" . $request->ops_7_1e . "~~~~~" . $request->ops_7_1f;
                        } else if ($splitque[2] == 2) {
                            $joinOptions = $vals . "~~~~~" . $request->ops_7_2a . "~~~~~" . $request->ops_7_2b . "~~~~~" . $request->ops_7_2c . "~~~~~" . $request->ops_7_2d . "~~~~~" . $request->ops_7_2e . "~~~~~" . $request->ops_7_2f;
                        } else if ($splitque[2] == 3) {
                            $joinOptions = $vals . "~~~~~" . $request->ops_7_3a . "~~~~~" . $request->ops_7_3b . "~~~~~" . $request->ops_7_3c . "~~~~~" . $request->ops_7_3d . "~~~~~" . $request->ops_7_3e . "~~~~~" . $request->ops_7_3f;
                        } else if ($splitque[2] == 4) {
                            $joinOptions = $vals . "~~~~~" . $request->ops_7_4a . "~~~~~" . $request->ops_7_4b . "~~~~~" . $request->ops_7_4c . "~~~~~" . $request->ops_7_4d . "~~~~~" . $request->ops_7_4e . "~~~~~" . $request->ops_7_4f;
                        } else if ($splitque[2] == 5) {
                            $joinOptions = $vals . "~~~~~" . $request->ops_7_5a . "~~~~~" . $request->ops_7_5b . "~~~~~" . $request->ops_7_5c . "~~~~~" . $request->ops_7_5d . "~~~~~" . $request->ops_7_5e . "~~~~~" . $request->ops_7_5f;
                        } else if ($splitque[2] == 6) {
                            $joinOptions = $vals . "~~~~~" . $request->ops_7_6a . "~~~~~" . $request->ops_7_6b . "~~~~~" . $request->ops_7_6c . "~~~~~" . $request->ops_7_6d . "~~~~~" . $request->ops_7_6e . "~~~~~" . $request->ops_7_6f;
                        } else {
                            $joinOptions = $vals . "~~~~~" . $request->ops_7_7a . "~~~~~" . $request->ops_7_7b . "~~~~~" . $request->ops_7_7c . "~~~~~" . $request->ops_7_7d . "~~~~~" . $request->ops_7_7e . "~~~~~" . $request->ops_7_7f;
                        }

                        $qnstemp[$splitque[1] . "_" . $splitque[2]] = $joinOptions;

                    } elseif ($splitque[1] == 6) {
                        $qnstemp[$splitque[1] . "_" . $splitque[2]] = $vals;

                        for($nn=1; $nn <= 15; $nn++) {
                            $str2 = "ReOrd_6-".$nn;
                            // echo $str2 . "<br>";
                            $joinOptions[$nn] = $request->{$str2};
                        }

                        $reord_array = array_filter($joinOptions);

                        // $qnstemp[$splitque[1] . "_" . $splitque[2]] = $vals;
                        $qnstemp['ReOrd6'] = $reord_array;

                    } elseif ($splitque[1] == 10) {

                        for($nn=1; $nn <= 5; $nn++) {
                            $str2 = "que_10_".$nn."-left";
                            $str3 = "que_10_".$nn."-right";
                            // echo $str2 . "<br>";
                            $diffCols["Qleft_10"][$nn] = $request->{$str2};
                            $diffCols["Qright_10"][$nn] = $request->{$str3};

                            $qnstemp['10_0'] = $diffCols;
                        }

                        // $reord_array = array_filter($joinOptions);

                        // // $qnstemp[$splitque[1] . "_" . $splitque[2]] = $vals;
                        // $qnstemp['ReOrd6'] = $reord_array;


                    } elseif ($splitque[1] == 3) {
                            for($nn=1; $nn <= 10; $nn++) {
                                $str2 = "A_3_".$nn;
                                if(isset($request->{$str2})) {
                                    $mthqns["A"][] = $request->{$str2};
                                } else {
                                    continue;
                                }

                            }
                            for($nn=1; $nn <= 10; $nn++) {
                                $str2 = "B_3_".$nn;
                                    if(isset($request->{$str2})) {
                                        $mthqns["B"][] = $request->{$str2};
                                    } else {
                                        continue;
                                    }
                            }

                        $qnstemp['3_0'] = $mthqns;

                    } else {
                        $qnstemp[$splitque[1] . "_" . $splitque[2]] = $vals;
                    }
                } else {
                    if( isset($splitque[1]) && $splitque[1] <> 6 ) {
                        $anstemp[$splitque[0] . "_" . $splitque[1]] = $vals;
                    }

                }
            }
        }

        // unset($anstemp['ops_7']);
        // echo "<pre>";
        // print_r($qnstemp);
        // echo " ================================<br><br>";
        // print_r($anstemp);
        // exit;
        $imginfo_json = json_encode($imgInfoArray, true);
        $que_json = json_encode($qnstemp, true);
        $ans_json = json_encode($anstemp, true);

        try {
            DB::table('question_master_qns_ans')->insert(
                array(
                    'qn_master_temp_id'  =>   $qn_master_temp_id,
                    'temp_questions'   =>   $que_json,
                    'temp_answers'   => $ans_json,
                    'image_qns_ans'   => $imginfo_json,
                    'created_date'   => Carbon::now(),
                    'updated_date'   => Carbon::now(),
                    'is_active'   => 1
                )
            );
        } catch (\Throwable $e) {
            print_r($e->getMessage());
            return View::make('pages.masters.question.index')->with('message', "Question Title already exists - Try different video name !!!");
        }

        return redirect()->route('question.index')->with('message', "New Question Created Successfully !!!");
    }

    /**
     * Store a newly created resource in storage. Success warning
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ord2 = $request->order;
        asort($ord2);
        // print_r($request->all());
        // print_r($ord2);
        // exit;

        $request->validate([
            'title' => 'required',
            'chapter_id' => 'required',
            'mode_test' => 'required',
            'class_id' => 'required',
            'subject_id' => 'required'
        ]);

        $total_marks = 0;
        foreach ($ord2 as $nn => $arr) {
            $total_mark = 0;
            $qnstemp[$nn] = array($request->noqns[$nn], $request->markque[$nn]);
            $total_mark  = (int) $request->noqns[$nn] * (int) $request->markque[$nn];
            $total_marks = $total_marks + $total_mark;
        }

        // print_r($qnstemp);
        // exit;
        $qns_template = json_encode($qnstemp, true);

        try {
            DB::table('question_master_template')->insert(
                array(
                    'title' => $request->title,
                    'chapter_id'  =>   $request->chapter_id,
                    'mode_test'   =>   $request->mode_test,
                    'class_id'   => $request->class_id,
                    'subject_id'   => $request->subject_id,
                    'question_template' => $qns_template,
                    'total_marks'   => (int) $total_marks,
                    'created_date'   => Carbon::now(),
                    'updated_date'   => Carbon::now(),
                    'is_active'   => 1
                )
            );
        } catch (\Throwable $e) {
            print_r($e->getMessage());
            return View::make('pages.masters.question.index')->with('message', "Question Template already exists - Try different Question Template name !!!");
        }

        return redirect()->route('question.index')->with('message', "New Question Template Created Successfully !!!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['question'] = DB::table('question_master_template')->where('id', $id)->first();

        $result2 = DB::select("select id, title from question_master_title WHERE is_active = 1 AND school_id=1 ORDER BY id");
        // print_r($result2);
        // exit;
        foreach ($result2 as $arr2) {
            $qnTit[$arr2->id] = $arr2->title;
        }

        $romanLetters = array (1 => "I", 2 => "II", 3 => "III", 4 => "IV", 5 => "V", 6 => "VI", 7 => "VII", 8 => "VIII", 9 => "IX", 10 => "X", 11 => "XI", 12 => "XII", 13 => "XIII", 14 => "XIV", 15 => "XV");

        $result2 = DB::select("select temp_questions, image_qns_ans from question_master_qns_ans WHERE is_active = 1 AND qn_master_temp_id=$id");

        // print_r($result2);
        // exit;

            if(!empty($result2))
            {
                $res = json_decode($result2[0]->temp_questions, true);
                $imgQue = json_decode($result2[0]->image_qns_ans, true);

                // echo "<pre>";
                // print_r($res);
                // exit;

                $temp = "";
                    foreach ($res as $key => $qns) {
                        // echo $key . " <<===== <br>";
                    //   if(str_contains($key, "_")) {
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
                    //    }
                        $temp = $qtype[0];
                    // }

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
                        $Qns[6]['qns'] = $res['6_1'];
                        $Qns[6]['ReOrds'] = $res['ReOrd6'];


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

                return View::make('pages.masters.question.show', $data)->with('qnMasTitle', $qnTit)->with('romLet', $romanLetters)->with('qns2', $Qns);

            }

        else {
            return View::make('pages.masters.question.show', $data)->with('romLet', $romanLetters)->with('qnMasTitle', $qnTit);
        }

    }

    public function getsubjects($id3)
    {
        $options4 = "";
        $res4 = DB::select("SELECT id, title FROM `subject_master` WHERE class_id = $id3 ORDER BY title");

        foreach($res4 as $data4) {
            $options4 .= "<option value='".$data4->id . "'>" . $data4->title ."</option>";
        }
        return $options4;
    }

    public function getchapters($id2)
    {
        $aaa = explode("~~~~~",$id2);

        $options2 = "";
        $res3 = DB::select("SELECT id, title FROM `chapters` WHERE class_id = $aaa[0] AND subject_id=$aaa[1] ORDER BY title");

        foreach($res3 as $data3) {
            $options2 .= "<option value='".$data3->id . "'>" . $data3->title ."</option>";
        }
        return $options2;
    }

    public function edit($id)
    {
        $data['question'] = DB::table('question_master_template')->where('id', $id)->first();

        $res4 = DB::select("SELECT id, title FROM `subject_master` ORDER BY title");
        foreach($res4 as $data4) {
            $subjs[$data4->id] = $data4->title;
        }

        $res5 = DB::select("SELECT id, title FROM `chapters` ORDER BY title");
        foreach($res5 as $data5) {
            $chapts[$data5->id] = $data5->title;
        }

        $classlist = DB::table('student_class')->select('id', 'class')->where('school_id', '=', 1)->where('is_deleted', '=', '0')->get();
        foreach ($classlist as $cls2) {
            $clslst[$cls2->id] = $cls2->class;
        }

        $result2 = DB::select("select id, title from question_master_title WHERE is_active = 1 AND school_id=1 ORDER BY id");
        foreach ($result2 as $arr2) {
            $qnTit[$arr2->id] = $arr2->title;
        }

        $romanLetters = array (1 => "I", 2 => "II", 3 => "III", 4 => "IV", 5 => "V", 6 => "VI", 7 => "VII", 8 => "VIII", 9 => "IX", 10 => "X", 11 => "XI", 12 => "XII", 13 => "XIII", 14 => "XIV", 15 => "XV");

        $result3 = DB::select("select question_template from question_master_template WHERE is_active = 1 AND id=$id");

        if(isset($result3[0]->question_template)) {
            $quetmp = json_decode($result3[0]->question_template, true);
        } else {
            $quetmp = array();
        }

        return View::make('pages.masters.question.edit', $data)->with('quetmp',$quetmp)->with('qTitle',$qnTit)->with('clslst',$clslst)->with("subjects",$subjs)->with("chapts",$chapts)->with('romLet',$romanLetters);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $ord2 = array_filter($request->order,function($a){
            return $a!='';
        });
        asort($ord2);

        $noqns = array_filter($request->noqns,function($a){
            return $a!='';
        });

        $markque = array_filter($request->markque,function($a){
            return $a!='';
        });

        // echo "<pre>";
        // print_r($request->all());
        // print_r($ord2);
        // print_r($noqns);
        // print_r($markque);
        // echo "</pre>";
        // exit;

        $total_marks = 0;
        foreach ($ord2 as $nn => $arr) {
            $total_mark = 0;
            $qnstemp[$nn] = array($noqns[$nn], $markque[$nn]);
            $total_mark  = (int) $noqns[$nn] * (int) $markque[$nn];
            $total_marks = $total_marks + $total_mark;
        }

        $qns_template = json_encode($qnstemp, true);

        try {
            DB::table('question_master_template')->where('id', $request->id)->update(
                array(
                    'title' => $request->title,
                    'chapter_id'  =>   $request->chapter_id,
                    'mode_test'   =>   $request->mode_test,
                    'class_id'   => $request->class_id,
                    'subject_id'   => $request->subject_id,
                    'question_template' => $qns_template,
                    'total_marks'   => (int) $total_marks,
                    'updated_date'   => Carbon::now(),
                )
            );
        } catch (\Throwable $e) {
            print_r($e->getMessage());
            return View::make('pages.masters.question.index')->with('message', "Question Template some issues while saving - Try different Question Template name !!!");
        }

        return redirect()->route('question.index')->with('message', "Updated Question Template Successfully !!!");

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('question_master_template')->delete($id);

        return redirect()->route('question.index')->with('message', 'Question Master Template deleted successfully');
    }
}
