<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use DB;
use DataTables;
use Carbon\Carbon;

class TtkitController extends Controller
{
    //
    public function classlist()
    {
        $data['classlist'] = DB::table('student_class')->select('id','class')->where('school_id', '=', 1)->where( 'is_deleted', '=', '0')->get();

        foreach($data['classlist'] as $clsid){
            // $chapters[$clsid->id] = DB::table('chapters')->select('id','title')->where('class_id', '=', $clsid->id)->where('school_id', '=', 1)->where('is_deleted', '=', 0)->get();
            // echo $clsid->id . "</br>";
            $chapters[$clsid->id] = DB::select("SELECT AA.id, BB.title, AA.file_path FROM `video_master` as AA, `content_master` as BB WHERE AA.id=BB.video_id AND AA.class_id = $clsid->id AND AA.type=2 ORDER BY BB.title");
        }
        // echo "<pre>";
        // print_r($chapters);
        // echo "</pre>";
        // exit;
        return view('pages.training.ttkit',$data)->with('chapters', $chapters);

    }

    public function datatab()
    {
        $videos = DB::table('student_class')->orderBy('created_date', 'desc');
        return datatables()->of($videos)
            ->addColumn('action',function($selected){
                return
                '<a class="btn btn-success" href="' . $selected->id . '/show" title="Detailed view of this Record">V</i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-warning" title="Edit this Record" href="'.$selected->id.'/edit">E</i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="' . $selected->id . '/destroy" onclick="return confirmation();" title="Delete this Record">D</a>';
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
        'type' => 'required',
        'file_path' => 'required',
        ]);

        try {
            DB::table('video_master')->insert(
                array(
                       'title'  =>   $request->title,
                       'type'   =>   $request->type,
                       'file_path'   => $request->file_path,
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
            return View::make('pages.masters.video.index')->with('message', "Video Title already exists - Try different video name !!!");
        }

        return redirect()->route('video.index')->with('message', "New Video Created Successfully !!!");
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
        'type' => 'required',
        'file_path' => 'required'
        ]);

        DB::table('video_master')->where('id',$request->id)->update(
            [
                'title'  =>   $request->title,
                'type'   =>   $request->type,
                'file_path'   => $request->file_path,
                'school_id'   => $request->school_id,
                'updated_date'=> Carbon::now(),
                'is_deleted'  => 0
            ]
        );
        return redirect()->route('video.index')->with('message', 'Video updated successfully.');
    }
        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            DB::table('video_master')->delete($id);
            return redirect()->route('video.index')->with('message', 'Video deleted successfully');
        }
        // routes functions
        /**
         * Show the form for creating a new post.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            return view('pages.masters.video.create');
        }
        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            $data['video'] = DB::table('video_master')->where('id', $id)->first();
            // print_r($video);
            // exit;
            return View::make('pages.masters.video.show', $data);
        }
        /**
         * Show the form for editing the specified post.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            $data['video'] = DB::table('video_master')->where('id', $id)->first();
            return View::make('pages.masters.video.edit', $data);
        }

}
