<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Masters\Video;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use DB;
use DataTables;
use Carbon\Carbon;

class VideoController extends Controller
{
    //
    public function index()
    {
        return view('pages.masters.video.index');

    }

    public function videolist()
    {

        $videos = DB::select("select AA.id as id, DD.title as title, BB.class as class_id, EE.title as subject, CC.title as video_type  from video_master as AA, student_class as BB, video_type_master as CC, chapters as DD, subject_master as EE WHERE DD.id=AA.title AND AA.class_id=BB.id AND CC.id = AA.type AND EE.id = DD.subject_id order by AA.id ASC");
        return datatables()->of($videos)
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
        'type' => 'required',
        'class_id' => 'required',
        'school_id' => 'required',
        'file' => 'required | mimes:mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv|max:5000000'
        ]);

        if($request->file()) {

            $fileName = "Class" . $request->class_id . "_Type" . $request->type . "_" . $request->file->getClientOriginalName();

            // if(Storage::exists('public/videos/'.$fileName))
            // {
            //     // dd(var_dump("it did exist")); exit;
            //     return redirect()->route('video.create')->with('message', "File Name already Exists !!!");

            // }

            $filePath = $request->file('file')->storeAs('videos', $fileName, 'public');
        }

        try {
            DB::table('video_master')->insert(
                array(
                       'title'  =>   $request->title,
                       'type'   =>   $request->type,
                       'file_path'   => $fileName,
                       'class_id'   => $request->class_id,
                       'school_id'   => $request->school_id,
                       'created_date'   => Carbon::now(),
                       'updated_date'   => Carbon::now(),
                       'is_deleted'   => 0
                )
           );
        }

        catch (\Throwable $e) {
            print_r($e->getMessage());
            return View::make('pages.masters.video.index')->with('message', "Video Title already exists - Try different video name !!!");
        }

        return redirect()->route('video.index')->with('message', "New Video Created Successfully !!!");
    }


    public function getVideo(Video $video)
    {
        $name = $video->name;
        $fileContents = Storage::disk('public')->get("{$name}");
        $response = Response::make($fileContents, 200);
        $response->header('Content-Type', "video/mp4");
        return $response;
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
        // echo "<pre>";
        // print_r($request->all());
        // exit;

        $request->validate([
        'title' => 'required',
        'type' => 'required',
        'file_path' => 'required'
        ]);

        if($request->file()) {
            $fileName = "Class" . $request->class_id . "_Type" . $request->type . "_" . $request->file_path->getClientOriginalName();
            $filePath = $request->file('file_path')->storeAs('videos', $fileName, 'public');
        }

        DB::table('video_master')->where('id',$request->id)->update(
            [
                'title'  =>   $request->title,
                'class_id'   => $request->class_id,
                'type'   =>   $request->type,
                'file_path'   => $filePath,
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
            $video_file = DB::table('video_master')->select('file_path')->where('id', $id)->first();
            $delete_file = 'public/videos/'.$video_file->file_path;
            // echo $delete_file;  exit;

            DB::table('video_master')->delete($id);

            Storage::delete($delete_file);

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
            $data['classlist'] = DB::table('student_class')->select('id','class')->where('school_id', '=', 1)->where( 'is_deleted', '=', '0')->get();
            return view('pages.masters.video.create', $data);
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

        public function getSubjects($id3)
        {
            $options4 = "";
            $res4 = DB::select("SELECT id, title FROM `subject_master` WHERE class_id = $id3 AND is_active=1 ORDER BY title");

            foreach($res4 as $data4) {
                $options4 .= "<option value='".$data4->id . "'>" . $data4->title ."</option>";
            }
            return $options4;
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
            $classlist = DB::select("SELECT id, class FROM `student_class` WHERE is_deleted = 0 AND school_id = 1");
            foreach($classlist as $data2) {
                $class[$data2->id] = $data2->class;
            }
            // echo "<pre>";
            // print_r($class);
            // exit;

            $chaps = DB::select("SELECT id, title FROM `chapters` WHERE is_deleted=0 ORDER BY title");
            foreach($chaps as $data4) {
                $options4[$data4->id] = $data4->title;
            }

            $data['video'] = DB::table('video_master')->where('id', $id)->first();
            return View::make('pages.masters.video.edit', $data)->with('chapts',$options4)->with('classlist',$class);
        }

}
