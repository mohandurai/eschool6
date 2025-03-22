<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use DB;
use File;
use DataTables;
use Carbon\Carbon;

class ProjlabController extends Controller
{
    //
    public function index()
    {
        $data['projlab'] = DB::select("select id, title, describe_activity, class_id, assign_to, attachment FROM project_lab_activity ORDER BY id DESC");
        // print_r($projlab);
        // exit;

        $data2 = DB::table('student_class')->select('id','class')->where('school_id', '=', 1)->where( 'is_deleted', '=', '0')->get();
        $result = $data2->toArray();
        foreach($result as $arr) {
            $classArr[$arr->id] = $arr->class;
        }
        return view('pages.training.projlab.index',$data)->with('classlist',$classArr);
    }

    public function projlablist()
    {
        // echo $id;
        // exit;
        $projlab = DB::select("select id, title, describe_activity, class_id, assign_to, attachment FROM project_lab_activity ORDER BY id DESC");

        return datatables()->of($projlab)
        ->addColumn('action',function($selected){
            return
            '<a class="btn btn-success" href="' . $selected->id . '/show" title="Detailed view of this Record">V</i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-warning" title="Edit this Record" href="#">E</i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="' . $selected->id . '/destroy" onclick="return confirmation();" title="Delete this Record">D</a>';
        })->toJson();
    }

    /**
     * Show the form for creating a new post.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['classlist'] = DB::table('student_class')->select('id','class')->where('school_id', '=', 1)->where( 'is_deleted', '=', '0')->get();

        // $data2 = DB::table('students')->select('user_id','first_name')->where( 'is_deleted', '=', '0')->get();
        // $result = $data2->toArray();
        // foreach($result as $arr) {
        //     $student[$arr->user_id] = $arr->first_name;
        // }
        return view('pages.training.projlab.create', $data);
    }

    public function store(Request $request)
    {

        // echo "<pre>";
        // print_r($request->all());
        // echo "</pre>";
        // exit;

        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:212048',
        ]);

        // echo "<pre>";
        // print_r($lastre);
        // echo "</pre>";
        // exit;

        if($request->file('image')) {

            $image = $request->file('image');
            $imageName = $request->title . "_" . $image->getClientOriginalName();
            $storeAt = "project_activity\class_". $request->class_id;
            $filePath = $request->file('image')->storeAs($storeAt, $imageName, 'public');

        }

        try {

            DB::table('project_lab_activity')->insert(
                array(
                        'title'  => $request->title,
                        'describe_activity' => $request->describe_activity,
                        'attachment' => $imageName,
                        'class_id' => $request->class_id,
                        'sec_id' => $request->sec_id,
                        'assign_to' => $request->assign_to,
                        'max_marks' => $request->max_marks,
                        'created_date' => Carbon::now(),
                        'updated_date' => Carbon::now(),
                        'is_active' => 1
                )
            );
        }

        catch (\Throwable $e) {
            print_r($e->getMessage());
            return View::make('pages.training.projlab.projevaln')->with('message', "Some errrrrrrrrr already exists - Try different video name !!!");
        }

        return redirect()->route('projlab.projevaln')->with('message', "New Project/Lab Activity Created Successfully !!!");

    }

        /**
         * Show the form for creating a new post.
         *
         * @return \Illuminate\Http\Response
         */
        public function studprojindex()
        {
            $stud_id = auth()->user()->id;
            $data3 = DB::table('students')->select('class_id','Section')->where( 'user_id', '=', $stud_id)->get();
            $clsid = $data3[0]->class_id;
            $secid = $data3[0]->Section;

            $stuQry = "select id, title, class_id, sec_id, student_id, status FROM project_lab_activity WHERE (class_id=$clsid) AND (sec_id = '$secid' OR sec_id = 'Z') ORDER BY sec_id, id DESC";
            // print_r($stuQry);
            // exit;

            $data['projLabAct'] = DB::select($stuQry);

            return View::make('pages.training.projlab.studprojindex', $data);
        }

        public function studprojlist()
        {
            // echo $id;
            // exit;
            $stud_id = auth()->user()->id;
            $data3 = DB::table('students')->select('class_id','Section')->where( 'user_id', '=', $stud_id)->get();
            $clsid = $data3[0]->class_id;
            $secid = $data3[0]->Section;

            if($stud_id == 1) {
                $projlab6 = DB::select("select id, title, class_id, sec_id, student_id, status FROM project_lab_activity ORDER BY class_id, id DESC");
            } else {
                $projlab6 = DB::select("select id, title, class_id, sec_id, student_id, status FROM project_lab_activity WHERE (class_id=$clsid) AND (sec_id = '$secid' OR sec_id = 'Z') ORDER BY id DESC");
            }

            // echo $projlab2;
            // exit;

            return datatables()->of($projlab6)
            ->addColumn('action',function($selected){
                return
                '<div class="col-lg-12 margin-tb"><div class="pull-right"> <a class="btn btn-success text-light" data-toggle="modal" id="mediumButton2" data-target="#mediumModal" data-attr="'. $selected->id . '/studsubmit" title="Submit Activity"  alt="'. $selected->id . '" title="Click to Start Project Submit .....">Submit</i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-warning" title="Detailed View Record" href="'.$selected->id.'/studview">Show</i></a>';
            })->toJson();
        }

        public function studview($id)
        {
            // echo $id;
            // exit;
            $data['projLabAct'] = DB::table('project_lab_activity')->where('id', $id)->get()->first();
            return View::make('pages.training.projlab.studview', $data);

        }

        public function projsubmituser($id)
        {

            $stud_id = auth()->user()->id;
            // $class_id = DB::table('students')->select('class_id')->where('user_id', $stud_id)->get();
            // $clsid = $class_id[0]->class_id;

            $data['projLabAct'] = DB::table('project_lab_activity')->where('id', $id)->get()->first();

            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            // exit;

            return View::make('pages.training.projlab.studsubmit', $data)->with('studid',$stud_id);
        }


        /**
         * Show the form for creating a new post.
         *
         * @return \Illuminate\Http\Response
         */
        public function projevaln()
        {
            return view('pages.training.projlab.projevaln');
        }

        public function projlabevallist()
        {
            $projlab = DB::select("select id, title, class_id, assign_to, student_id, evaluator_status, mark_scored, max_marks, evaluator_comments FROM project_lab_activity ORDER BY id DESC");

            return datatables()->of($projlab)
            ->addColumn('action',function($selected){
                return
                '<a class="btn btn-success" href="' . $selected->id . '/evaluate" title="Evaluate Activity">Evaluate</i></a>';
            })->toJson();
        }


        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            $data['projLabAct'] = DB::table('project_lab_activity')->where('id', $id)->first();
            // print_r($data);
            // exit;
            return View::make('pages.training.projlab.show', $data);
        }

        public function studsubmit($id)
        {
            $data['projLabAct'] = DB::table('project_lab_activity')->where('id', $id)->first();
            // print_r($data);
            // exit;
            return View::make('pages.training.projlab.studsubmit', $data);
        }

        public function projlabfinish(Request $request)
        {

            // echo "<pre>";
            // print_r($request->all());
            // echo "</pre>";
            // exit;

            $proj_id = $request->proj_id;
            $class_id = $request->class_id;
            $assign_id = $request->assign_to;

            if($assign_id == 0) {
                $stud_id = auth()->user()->id;
            }
            else {
                $stud_id = $request->student_id;
            }

            // $request->validate([
            //     'image_projlab_finish' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:212048',
            // ]);

            if( $request->file('image_projlab_finish') != '' )
            {
                // echo "Yessssssssssssssssssssssss";
                // exit;
                if($request->file('image_projlab_finish')) {

                    $image = $request->file('image_projlab_finish');
                    $imageName = "PID" . $proj_id . "_Student" . $stud_id . "_" . $image->getClientOriginalName();
                    $storeAt = "project_activity\class_". $class_id;
                    $filePath = $request->file('image_projlab_finish')->storeAs($storeAt, $imageName, 'public');
                }
                DB::table('project_lab_activity')->where('id', $proj_id)->update(
                    [
                        'student_submit_attach' => $imageName,
                        'student_id' => $stud_id,
                        'student_remarks' => $request->student_remarks,
                        'status' => $request->status,
                        'updated_date'=> Carbon::now()
                    ]
                );
            }
            else {
                // echo "Nooooooooooooooooooooooooooo";
                // exit;
                try {
                    DB::table('project_lab_activity')->where('id', $proj_id)->update(
                        [
                            'student_id' => $stud_id,
                            'student_remarks' => $request->student_remarks,
                            'status' => $request->status,
                            'updated_date'=> Carbon::now()
                        ]
                    );
                }
                    catch (\Throwable $e) {
                        print_r($e->getMessage());
                        return View::make('pages.training.projlab.studprojindex')->with('message', "Some errrrrrrrrr already exists - Try different Project Acvitity name !!!");
                    }
            }


            return redirect()->route('projlab.studprojindex')->with('message', "Project/Lab Activity Submitted by Student Successfully !!!");

        }

        /**
         * Show the form for creating a new post.
         *
         * @return \Illuminate\Http\Response
         */
        public function evaluate($id)
        {
            $data['projLabEval'] = DB::table('project_lab_activity')->where('id', $id)->first();
            // print_r($data);
            // exit;
            return View::make('pages.training.projlab.evaluate', $data);
        }


        public function evaluatefinish(Request $request)
        {

            // echo "<pre>";
            // print_r($request->all());
            // echo "</pre>";
            // exit;

            try {
                DB::table('project_lab_activity')
                    ->where('id', $request->id)
                    ->update(
                        [
                            'mark_scored' => $request->mark_scored,
                            'evaluator_comments' => $request->evaluator_comments,
                            'evaluator_status' => $request->evaluator_status
                    ]);
            }

            catch (\Throwable $e) {
                print_r($e->getMessage());
                return View::make('pages.training.projlab.evaluate')->with('message', "Some errrrrrrrrr already exists - Try different video name !!!");
            }

            return redirect()->route('projlab.projevaln')->with('message', "Project/Lab Activity Evaluated Successfully !!!");

        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            DB::table('project_lab_activity')->delete($id);

            return redirect()->route('projlab.index')->with('message', 'Project Lab Activity deleted successfully');
        }

    public function getprojlab($id2)
    {
        $aaa = explode("~~~~~",$id2);

        $options2 = "";
        $projlab = DB::select("select id, title, describe_activity, class_id, assign_to, attachment FROM project_lab_activity ORDER BY id DESC");
        $res3 = DB::select("SELECT id, title FROM `chapters` WHERE class_id = $aaa[0] AND subject_id=$aaa[1] ORDER BY title");

        foreach($res3 as $data3) {
            $options2 .= "<option value='".$data3->id . "'>" . $data3->title ."</option>";
        }
        return $options2;
    }

    public function getAllprojLab($id)
    {
        $res6 = DB::select("select id, title FROM project_lab_activity WHERE is_active = 1 AND class_id=$id");
        $options3 = "";
        foreach ($res6 as $data7) {
            $options3 .= "<option value='" . $data7->id . "'>" . $data7->title . "</option>";
        }
        return $options3;
    }

    public function getStudents2($id)
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



    public function printreport(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());
        // echo "</pre>";
        // exit;

        if(!isset($request->student_id))
        {
            $sql6 = "select C.user_id as roleid, CONCAT(C.first_name, ' ', C.last_name) as stname, C.class_id, C.Section, D.mark_scored, D.max_marks, D.title FROM students C, project_lab_activity D WHERE (C.user_id=D.assign_to OR C.user_id=D.student_id) AND D.id = $request->projlab_id AND D.is_active = 1 AND C.Section = '". $request->sec_id . "'";

            $prep3 = DB::select($sql6);
            if(!empty($prep3)) {
            // exit;
                foreach ($prep3 as $kk => $data2) {
                    $examtitle = $data2->title;
                    $info3[$kk][0] = $data2->roleid;
                    $info3[$kk][1] = $data2->stname;
                    $info3[$kk][2] = $data2->mark_scored;
                    $info3[$kk][3] = $data2->max_marks;
                    $info3[$kk][4] = $data2->class_id;
                    $info3[$kk][5] = $data2->Section;
                }
            } else {
                $info3 = [];
                $examtitle = "";
            }
        } else {
            $sql6 = "select C.user_id as roleid, CONCAT(C.first_name, ' ', C.last_name) as stname, C.class_id, C.Section, D.mark_scored, D.max_marks, D.title FROM students C, project_lab_activity D WHERE (C.user_id=D.assign_to OR C.user_id=D.student_id) AND D.is_active = 1 AND D.id = $request->projlab_id AND C.user_id=D.student_id AND D.student_id = " . $request->student_id;
            $prep3 = DB::select($sql6);
            if(!empty($prep3)) {
                foreach ($prep3 as $kk => $data2) {
                    $examtitle = $data2->title;
                    $info3[$kk][0] = $data2->roleid;
                    $info3[$kk][1] = $data2->stname;
                    $info3[$kk][2] = $data2->mark_scored;
                    $info3[$kk][3] = $data2->max_marks;
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

        return view('pages.training.projlab.printreport')->with('stud_data',$info3)->with('examtitle',$examtitle);
    }

}
