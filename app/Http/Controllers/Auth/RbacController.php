<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use DB;
use DataTables;
use Carbon\Carbon;

class RbacController extends Controller
{
    // Admin
    public function index()
    {
        return view('pages.auth.rbac.index');
    }

    public function rolelist()
    {

        $chaps = DB::select("SELECT id, role_title, role_description, `status`, created_date, updated_date FROM roles");

        return datatables()->of($chaps)
            ->addColumn('action',function($selected){
                return
                '<a class="btn btn-success" href="' . $selected->id . '/show" title="Detailed view of this Record"> <i class="fas fa-eye"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-warning" title="Edit this Record" href="'.$selected->id.'/edit"> <i class="fas fa-edit"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="' . $selected->id . '/destroy" onclick="return confirmation();" title="Delete this Record"><i class="fas fa-trash"></i></a>';
            })->toJson();

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
        return view('pages.student.student.create', $data);
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
        'first_name' => 'required',
        'class_id' => 'required',
        'email' => 'required',
        ]);

        if($request->require_login == "1") {

            $lastInsertedId = DB::table('users')->insertGetId([
                'name' => $request->first_name,
                'email' => $request->email,
                'password' => Hash::make("Student123"),
            ]);
        } else {
            $lastInsertedId = null;
        }


        // echo $lastInsertedId . " Yesssssssssssssss";
        // exit;

        if($request->file()) {
            $fileName = "Class" . $request->class_id . "_" . $request->first_name . "_" . $request->file->getClientOriginalName();
            $filePath = $request->file('photo_image')->storeAs('images/students', $fileName, 'public');
        } else {
            $fileName = "";
        }

        try {
            DB::table('students')->insert(
                array(
                       'first_name'  =>   $request->first_name,
                       'user_id'  =>   $lastInsertedId,
                       'last_name'   =>   $request->last_name,
                       'email'   => $request->email,
                       'mobile'   => $request->mobile,
                       'class_id'   => $request->class_id,
                       'gender'   => $request->gender,
                       'dob'   => $request->dob,
                       'upload_pps_image_info'   => $fileName,
                       'school_id'   => 1,
                       'created_date'   => Carbon::now(),
                       'updated_date'   => Carbon::now(),
                       'is_deleted'   => 0
                )
           );
        }
        catch (\Throwable $e) {
            print_r($e->getMessage());
            return View::make('pages.student.student.index')->with('message', "Student Title already exists - Try different video name !!!");
        }

        return redirect()->route('student.index')->with('message', "New Student Created Successfully !!!");
    }

}
