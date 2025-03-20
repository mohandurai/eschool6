<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Masters\Content;
use Illuminate\Support\Facades\View;
use DB;
use DataTables;
use Carbon\Carbon;

class SubjectController extends Controller
{
    //
    public function index()
    {
        return view('pages.masters.subject.index');
    }

    public function subjectlist()
    {
        $subs = DB::select("select AA.id as id, BB.class as class, AA.title as title, AA.remarks as remarks,  AA.created_date as created_date, AA.updated_date as updated_date from subject_master as AA, student_class as BB WHERE BB.id=AA.class_id AND AA.is_active=1");

        return datatables()->of($subs)
            ->addColumn('action',function($selected){
                return
                '<a class="btn btn-success" href="' . $selected->id . '/show" title="Detailed view of this Record"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-warning" title="Edit this Record" href="'.$selected->id.'/edit"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="' . $selected->id . '/destroy" onclick="return confirmation();" title="Delete this Record"><i class="fas fa-trash"></i></a>';
            })->toJson();

    }

    /**
     * Store a newly created resource in storage. Success warning
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // print_r($request->all());
        // exit;
        $request->validate([
        'title' => 'required',
        'class_id' => 'required',
        'school_id' => 'required',
        ]);

        try {
            DB::table('subject_master')->insert(
                array(
                       'title'  => $request->title,
                       'class_id' => $request->class_id,
                       'remarks' => $request->remarks,
                       'school_id' => $request->school_id,
                       'created_date' => Carbon::now(),
                       'updated_date' => Carbon::now(),
                       'is_active' => 1
                )
           );
        //    echo "Yessssssssssssssss";
        //    exit;
        }
        catch (\Throwable $e) {
            print_r($e->getMessage());
            return View::make('pages.masters.subject.index')->with('message', "Subject Title already exists - Try different video name !!!");
        }

        return redirect()->route('subject.index')->with('message', "New Subject Created Successfully !!!");
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

        $request->validate([
        'title' => 'required',
        'class_id' => 'required'
        ]);

        DB::table('subject_master')->where('id',$request->id)->update(
            [
                'title'  =>   $request->title,
                'class_id'   => $request->class_id,
                'remarks'   =>   $request->remarks,
                'school_id'   => 1,
                'updated_date'=> Carbon::now(),
                'is_active'  => 1
            ]
        );
        return redirect()->route('subject.index')->with('message', 'Subject updated successfully.');
    }
        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            DB::table('subject_master')->delete($id);

            return redirect()->route('subject.index')->with('message', 'Subject deleted successfully');
        }
        // routes functions
        /**
         * Show the form for creating a new post.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            $data['classlist'] = DB::table('student_class')->select('id','class')->where('school_id', '=', 1)->where( 'is_deleted', '=', '0')->get();
            return view('pages.masters.subject.create', $data);
        }


        public function getchapters($id2)
        {
            $options2 = "";
            $res3 = DB::select( DB::raw("SELECT id, title FROM `chapters` WHERE class_id = :somevariable ORDER BY title"), array('somevariable' => $id2,));

            foreach($res3 as $data3) {
                $options2 .= "<option value='".$data3->id . "'>" . $data3->title ."</option>";
            }
            return $options2;
        }

        public function getsubjects($id)
        {
            $options2 = "";
            $res3 = DB::select( DB::raw("SELECT id, title FROM `subject_master` WHERE class_id = :somevariable ORDER BY title"), array('somevariable' => $id,));

            foreach($res3 as $data3) {
                $options2 .= "<option value='".$data3->id . "'>" . $data3->title ."</option>";
            }
            // print_r($options2);
            // exit;
            return $options2;
        }



        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            $data['subject'] = DB::table('subject_master')->where('id', $id)->first();
            // print_r($data);
            // exit;
            return View::make('pages.masters.subject.show', $data);
        }
        /**
         * Show the form for editing the specified post.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            $data['video'] = DB::table('subject_master')->where('id', $id)->first();

            $clsid = array();
            $res3 = DB::select("SELECT id, class FROM `student_class` ORDER BY id");
            foreach($res3 as $data3) {
                $clsid[$data3->id] = $data3->class;
            }

            // echo "<pre>";
            // print_r($clsid);
            // echo "</pre>";
            // exit;

            return View::make('pages.masters.subject.edit', $data)->with('clsid',$clsid);
        }

}
