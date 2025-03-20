<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class GradereportController extends Controller
{
    //
    public function report()
    {
        $res3 = DB::select("SELECT id, class FROM `student_class` WHERE school_id = 1 AND is_deleted=0 ORDER BY id");
        foreach($res3 as $data3) {
            $classlist[$data3->id] = $data3->class;
        }

        $data = DB::table('students')->select('user_id','first_name','last_name')->where( 'is_deleted', '=', '0')->get();
        $result = $data->toArray();
        foreach($result as $arr) {
            $student[$arr->user_id] = "Roll No. ".$arr->user_id . " - " . $arr->first_name . " " . $arr->last_name;
        }

        return view('pages.reports.gradereport.report')->with('classlist',$classlist)->with('student',$student);
    }


}
