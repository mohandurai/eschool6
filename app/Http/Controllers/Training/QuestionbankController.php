<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use DataTables;
use Carbon\Carbon;

class QuestionbankController extends Controller
{
    //
    public function index()
    {
        // echo "Yesssssssss";
        // exit;
        $data['classlist'] = DB::table('student_class')->select('id','class')->where('school_id', '=', 1)->where( 'is_deleted', '=', '0')->get();
        return view('pages.training.questionbank.index', $data);
    }

    public function getqnmasters($id2)
        {

            $options2 = '<option value="999">All Chapters</option>';
            $res3 = DB::select("SELECT id, title FROM `question_master_template` WHERE class_id=$id2 ORDER BY title");

            foreach($res3 as $data3) {
                $options2 .= "<option value='".$data3->id . "'>" . $data3->title ."</option>";
            }
            return $options2;
        }

    // public function show2()
    // {
    //     return view('pages.training.questionbank.show2');
    // }

    /**
     * Store a newly created resource in storage. Success warning
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store2(Request $request)
    {

        $res3 = DB::select("SELECT qn_master_temp_id, temp_questions, temp_answers, image_qns_ans FROM `question_master_qns_ans` WHERE qn_master_temp_id = $request->qnmastemp");

        $qnsArray = json_decode($res3[0]->temp_questions, true);
        $ansArray = json_decode($res3[0]->temp_answers, true);
        $imgQAArray = json_decode($res3[0]->image_qns_ans, true);

        // echo "<pre>";
        // print_r($qnsArray);
        // print_r($ansArray);
        // echo "</pre>";
        // exit;

        // echo "<pre>";
        // print_r($imgQue);
        // echo "</pre>";
        // exit;

        $temp = 0;
        foreach($qnsArray as $key => $qns) {
            $qtype = explode("_",$key);
            if($qtype[0] != $temp){
                $res4 = DB::select("select title from question_master_title WHERE is_active = 1 AND id=$qtype[0]");
                $QnsTitle[$qtype[0]] = $res4[0]->title;
            }
            $temp = $qtype[0];

            if($qtype[0] == 7) {
                $type7 = explode("~~~~~",$qns);


                if(isset($type7[0])) {
                    $Qns[$qtype[0]][$qtype[1]][0] = $type7[0];
                }
                if(isset($type7[1])) {
                    $Qns[$qtype[0]][$qtype[1]][1] = $type7[1];
                }
                if(isset($type7[2])) {
                    $Qns[$qtype[0]][$qtype[1]][2] = $type7[2];
                }
                if(isset($type7[3])) {
                    $Qns[$qtype[0]][$qtype[1]][3] = $type7[3];
                }
                if(isset($type7[4])) {
                    $Qns[$qtype[0]][$qtype[1]][4] = $type7[4];
                }
                if(isset($type7[5])) {
                    $Qns[$qtype[0]][$qtype[1]][5] = $type7[5];
                }
                if(isset($type7[6])) {
                    $Qns[$qtype[0]][$qtype[1]][6] = $type7[6];
                }
                if(isset($type7[7])) {
                    $Qns[$qtype[0]][$qtype[1]][7] = $type7[7];
                }

            } else {
                $Qns[$qtype[0]][$qtype[1]] = $qns;
            }


        }

        $romanLetters = array (1 => "I", 2 => "II", 3 => "III", 4 => "IV", 5 => "V", 6 => "VI", 7 => "VII", 8 => "VIII", 9 => "IX", 10 => "X");

        // echo "<pre>";
        // print_r($QnsTitle);
        // print_r($Qns);
        // print_r($ansArray);
        // print_r($imgQAArray);
        // echo "</pre>";
        // echo $request->qntemp_title;
        // exit;

        return view('pages.training.questionbank.show2')->with('qtmpid',$res3[0]->qn_master_temp_id)->with('qntemptitle',$request->qntemp_title)->with('qntit',$QnsTitle)->with('qns',$Qns)->with('romlet', $romanLetters)->with('Ans',$ansArray)->with('imgQuens',$imgQAArray)->with('message', "Question Dump Created Successfully !!!");

    }


    // Method to generate PDF
    public function genpdf(Request $request)
    {
        // print_r($request->all());
        // echo " <<<====== " . $request['qtpltitle'];
        // exit;
        $qpid = $request['qtplid'];

        $res3 = DB::select("SELECT temp_questions, temp_answers, image_qns_ans FROM `question_master_qns_ans` WHERE qn_master_temp_id = $qpid");

        $qnsArray = json_decode($res3[0]->temp_questions, true);
        $ansArray = json_decode($res3[0]->temp_answers, true);
        $imgQAArray = json_decode($res3[0]->image_qns_ans, true);

        $temp = 0;
        foreach($qnsArray as $key => $qns) {
            $qtype = explode("_",$key);
            if($qtype[0] != $temp){
                $res3 = DB::select("select title from question_master_title WHERE is_active = 1 AND id=$qtype[0]");
                $QnsTitle[$qtype[0]] = $res3[0]->title;
            }
            $temp = $qtype[0];

            if($qtype[0] == 7) {
                $type7 = explode("~~~~~",$qns);


                if(isset($type7[0])) {
                    $Qns[$qtype[0]][$qtype[1]][0] = $type7[0];
                }
                if(isset($type7[1])) {
                    $Qns[$qtype[0]][$qtype[1]][1] = $type7[1];
                }
                if(isset($type7[2])) {
                    $Qns[$qtype[0]][$qtype[1]][2] = $type7[2];
                }
                if(isset($type7[3])) {
                    $Qns[$qtype[0]][$qtype[1]][3] = $type7[3];
                }
                if(isset($type7[4])) {
                    $Qns[$qtype[0]][$qtype[1]][4] = $type7[4];
                }
                if(isset($type7[5])) {
                    $Qns[$qtype[0]][$qtype[1]][5] = $type7[5];
                }
                if(isset($type7[6])) {
                    $Qns[$qtype[0]][$qtype[1]][6] = $type7[6];
                }
                if(isset($type7[7])) {
                    $Qns[$qtype[0]][$qtype[1]][7] = $type7[7];
                }

            } else {
                $Qns[$qtype[0]][$qtype[1]] = $qns;
            }

        }

        $romanLetters = array (1 => "I", 2 => "II", 3 => "III", 4 => "IV", 5 => "V", 6 => "VI", 7 => "VII", 8 => "VIII", 9 => "IX", 10 => "X");

        $data = [
            'qntemptitle' => $request['qtpltitle'],
            'qtmpid' => $qpid,
            'qntit' => $QnsTitle,
            'qns' => $Qns,
            'romlet' => $romanLetters,
            'Ans' => $ansArray,
            'imgQuens' => $imgQAArray
        ];

        // echo "<pre>";
        // print_r($data);
        // exit;

        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('pages.training.questionbank.genpdf',$data);
        return $pdf->download('document.pdf');


    }

}
