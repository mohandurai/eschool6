<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use DB;
use DataTables;
use Carbon\Carbon;

class AlloctestController extends Controller
{
    //
    public function index()
    {
        return view('pages.masters.alloctest.index');
    }

    public function alloctestlist()
    {
        $alloctest = DB::table('allocate_test')->select('id', 'test_title', 'qn_master_templ_id', 'class_id', 'subject', 'assign_to', 'start_date', 'end_date', 'duration', 'terms', 'year')->where('is_active', '=', '1');
        return datatables()->of($alloctest)
            ->addColumn('action', function ($selected) {
                return
                    '<a class="btn btn-success" href="' . $selected->id . '/show" title="Detailed view of this Record"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-warning" title="Edit this Record" href="' . $selected->id . '/edit"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="' . $selected->id . '/destroy" onclick="return confirmation();" title="Delete this Record"><i class="fas fa-trash"></i></a>';
            })->toJson();
    }


    public function create()
    {

        $res3 = DB::select("SELECT id, class FROM `student_class` WHERE school_id = 1 AND is_deleted=0 ORDER BY id");
        foreach ($res3 as $data3) {
            $clsops[$data3->id] = $data3->class;
        }

        $result2['qntemptitle'] = DB::select("select id, title from question_master_template WHERE is_active = 1 ORDER BY id");

        $data = DB::table('students')->select('user_id', 'first_name')->where('is_deleted', '=', '0')->get();
        $result = $data->toArray();
        foreach ($result as $arr) {
            $student[$arr->user_id] = $arr->first_name;
        }
        // echo "<pre>";
        // print_r($clsops);
        // echo $clsops;
        // exit;
        return view('pages.masters.alloctest.create', $result2)->with('student', $student)->with('classes', $clsops);
    }

    /**
     * Store a newly created resource in storage. Success warning
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());
        // exit;
        // $request->validate([
        // 'test_title' => 'required',
        // 'duration' => 'required',
        // ]);

        $res3 = DB::select("select class_id, subject_id FROM question_master_template WHERE is_active = 1 AND id=$request->qn_master_templ_id");
        $clid = $res3[0]->class_id;
        $subid = $res3[0]->subject_id;

        try {
            DB::table('allocate_test')->insert(
                array(
                    'test_title'  => $request->test_title,
                    'qn_master_templ_id' => $request->qn_master_templ_id,
                    'duration' => $request->duration,
                    'year' => $request->year,
                    'terms' => $request->term,
                    'start_date' => $request->datestart,
                    'end_date' => $request->endstart,
                    'class_id' => $clid,
                    'sec_id' => $request->sec_id,
                    'subject' => $subid,
                    'assign_to' => $request->assign_to,
                    'mode_of_test' => $request->mode_test,
                    'created_date' => Carbon::now(),
                    'updated_date' => Carbon::now(),
                    'is_active' => 1
                )
            );
        } catch (\Throwable $e) {
            print_r($e->getMessage());
            return View::make('pages.masters.alloctest.index')->with('message', "Test Allocation Title already exists - Try different video name !!!");
        }

        return redirect()->route('alloctest.index')->with('message', "Allocation Test Created Successfully !!!");
    }

    public function show($id)
    {
        $data['studinfo'] = DB::table('allocate_test')->where('id', $id)->first();
        // print_r($data);
        // exit;
        return View::make('pages.masters.alloctest.show', $data);
    }

    /**
         * Show the form for editing the specified post.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
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

            $qry = "select id, file_path from video_master ORDER BY file_path";
            $res2 = DB::select($qry);
            foreach($res2 as $data2) {
                $videos[$data2->id] = $data2->file_path;
            }

            $data['allocte'] = DB::table('allocate_test')->where('id', $id)->first();

            return View('pages.masters.alloctest.edit', $data)->with('subjs', $subjs)->with('chapts', $chapts)->with('clslst', $clslst)->with('videos', $videos);
        }

}
