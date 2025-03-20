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

class ContentController extends Controller
{
    //
    public function index()
    {
        $data = DB::table('student_class')->select('id','class')->where('school_id', '=', 1)->where( 'is_deleted', '=', '0')->get();
        $result = $data->toArray();
        foreach($result as $arr) {
            $classArr[$arr->id] = $arr->class;
        }
        return view('pages.masters.content.index')->with('clssArr',$classArr);
    }

    public function contentlist()
    {
        $chaps = DB::table('content_master')->join('video_master', 'video_master.id', '=', 'content_master.video_id')->join('video_type_master', 'video_type_master.id', '=', 'content_master.video_type_id')->join('student_class', 'content_master.class_id', '=', 'student_class.id')->join('subject_master', 'content_master.subject_id', '=', 'subject_master.id')->select('content_master.id as cm_id', 'content_master.title as cm_title', 'video_master.file_path as filename', 'video_type_master.title as vm_type', 'student_class.class as cm_clid', 'subject_master.title as subject', 'content_master.is_active as status')->orderBy('content_master.created_date', 'desc');
        return datatables()->of($chaps)
            ->addColumn('action',function($selected){
                return
                '<a class="btn btn-success" href="' . $selected->cm_id . '/show" title="Detailed view of this Record"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-warning" title="Edit this Record" href="'.$selected->cm_id.'/edit"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="' . $selected->cm_id . '/destroy" onclick="return confirmation();" title="Delete this Record"><i class="fas fa-trash"></i></a>';
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
        // $request->validate([
        // 'title' => 'required',
        // 'video_id' => 'required',
        // 'class_id' => 'required',
        // 'subject_id' => 'required',
        // 'video_type_id' => 'required',
        // 'chapter_id' => 'required',
        // 'school_id' => 'required'
        // ]);

        try {
            DB::table('content_master')->insert(
                array(
                       'title'  =>   $request->content,
                       'video_id'   =>   $request->video_id,
                       'school_id'   => $request->school_id,
                       'class_id'   => $request->class_id,
                       'subject_id' => $request->subject_id,
                       'video_type_id'   => $request->video_type_id,
                       'chapter_id'   => $request->chapter_id,
                       'created_date'   => Carbon::now(),
                       'updated_date'   => Carbon::now(),
                       'is_deleted'   => 0,
                       'is_active'   => 1
                )
            );
        }
        catch (\Throwable $e) {
            print_r($e->getMessage());
            return View::make('pages.masters.content.index')->with('message', "Content Title already exists - Try different video name !!!");
        }

        return redirect()->route('content.index')->with('message', "New Content Created Successfully !!!");
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
        'video_id' => 'required',
        'class_id' => 'required',
        'video_type_id' => 'required',
        'chapter_id' => 'required',
        'school_id' => 'required'
        ]);

        DB::table('content_master')->where('id',$request->id)->update(
            [
                'title'  =>   $request->title,
                'video_id'   =>   $request->video_id,
                'school_id'   => $request->school_id,
                'class_id'   => $request->class_id,
                'video_type_id'   => $request->video_type_id,
                'chapter_id'   => $request->chapter_id,
                'updated_date'   => Carbon::now(),
                'is_deleted'   => 0,
                'is_active'   => 1
            ]
        );
        return redirect()->route('content.index')->with('message', 'Content updated successfully.');
    }
        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            DB::table('content_master')->delete($id);
            return redirect()->route('content.index')->with('message', 'Content deleted successfully');
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
            return view('pages.masters.content.create', $data);
        }

        public function getvideos($id)
        {
            $ids = explode("~~~", $id);
            // echo $ids[0] . "   " . $ids[1];
            // exit;
            $options = "";
            $qry = "select AA.id as id, BB.title as title from video_master as AA, chapters as BB WHERE AA.class_id=" . $ids[2] . " AND AA.title= BB.id AND AA.type=" . $ids[1] . " ORDER BY BB.title";
            // echo $qry;
            // exit;
            $res2 = DB::select($qry);

            foreach($res2 as $data2) {
                $options .= "<option value='".$data2->id . "'>" . $data2->title ."</option>";
            }
            return $options;
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

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            $data['content'] = DB::table('content_master')->where('id', $id)->first();
            return View('pages.masters.content.show', $data);
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

            $data['content'] = DB::table('content_master')->where('id', $id)->first();

            return View('pages.masters.content.edit', $data)->with('subjs', $subjs)->with('chapts', $chapts)->with('clslst', $clslst)->with('videos', $videos);
        }
}
