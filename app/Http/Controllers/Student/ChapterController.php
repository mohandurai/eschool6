<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use DataTables;
use Carbon\Carbon;

class ChapterController extends Controller
{
    //
    public function index()
    {
        $data = DB::select("select `id`, `class` from student_class WHERE `school_id` = 1 AND `is_deleted` = 0");
        foreach($data as $arr) {
            $classArr[$arr->id] = $arr->class;
        }
        // echo "<pre>";
        // print_r($classArr);
        // echo "</pre>";
        // exit;
        return view('pages.student.chapter.index')->with('clssArr',$classArr);
    }

    public function chapterlist()
    {
        // $chaps = DB::table('chapters')->orderBy('created_date', 'desc');
        $chaps2 = DB::select("select AA.id as id, AA.title as title, BB.class as class_id, CC.title as subject, AA.created_date as created_date, AA.updated_date as updated_date from chapters as AA, student_class as BB, subject_master AS CC WHERE AA.class_id=BB.id AND CC.id=AA.subject_id AND AA.is_deleted=0 ORDER BY AA.id DESC");
        return datatables()->of($chaps2)
            ->addColumn('action',function($selected){
                return
                '<a class="btn btn-success" href="' . $selected->id . '/show" title="Detailed view of this Record"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-warning" title="Edit this Record" href="'.$selected->id.'/edit"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="' . $selected->id . '/destroy" onclick="return confirmation();" title="Delete this Record"><i class="fas fa-trash"></i></a>';
            })->toJson();

    }

    public function getsubjects($id)
    {
        $options2 = "";
        $res3 = DB::select("SELECT id, title FROM `subject_master` WHERE is_active=1 AND class_id = $id ORDER BY title");

        // print_r($res3);
        // exit;

        foreach($res3 as $data3) {
            $options2 .= "<option value='".$data3->id . "'>" . $data3->title ."</option>";
        }

        return $options2;
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
        'school_id' => 'required'
        ]);

        try {
            DB::table('chapters')->insert(
                array(
                       'title'  =>   $request->title,
                       'class_id'   =>   $request->class_id,
                       'subject_id'   =>   $request->subject_id,
                       'school_id'   => $request->school_id,
                       'created_date'   => Carbon::now(),
                       'updated_date'   => Carbon::now(),
                       'is_deleted'   => 0
                )
           );
        //    echo "Yessssssssssssssss";
        //    exit;
        }
        catch (\Throwable $e) {
            print_r($e->getMessage());
            return View::make('pages.student.chapter.index')->with('message', "Chapter Title already exists - Try different video name !!!");
        }

        return redirect()->route('chapter.index')->with('message', "New Chapter Created Successfully !!!");
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
        'class_id' => 'required',
        'school_id' => 'required'
        ]);

        DB::table('chapters')->where('id',$request->id)->update(
            [
                'title'  =>   $request->title,
                'class_id'   => $request->class_id,
                'school_id'   => $request->school_id,
                'updated_date'=> Carbon::now(),
                'is_deleted'  => 0
            ]
        );
        return redirect()->route('chapter.index')->with('message', 'Chapter updated successfully.');
    }
        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            DB::table('chapters')->delete($id);
            return redirect()->route('chapter.index')->with('message', 'Chapter deleted successfully');
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
            return view('pages.student.chapter.create', $data);
        }
        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            $data['chapter'] = DB::table('chapters')->where('id', $id)->first();
            return View('pages.student.chapter.show', $data);
        }
        /**
         * Show the form for editing the specified post.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            $data['chapter'] = DB::table('chapters')->where('id', $id)->first();
            return View('pages.student.chapter.edit', $data);
        }
}
