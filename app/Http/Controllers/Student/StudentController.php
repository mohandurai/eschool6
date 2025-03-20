<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Http\UploadedFile;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    //
    public function index()
    {
        return view('pages.student.student.index');
    }

    public function studentlist()
    {

        $chaps = DB::select("SELECT A.id, A.user_id, A.first_name, A.last_name, A.email, A.mobile, B.class as 'class_id' FROM `students` as A, student_class B WHERE A.class_id=B.id ORDER BY A.updated_date DESC");

        return datatables()->of($chaps)
            ->addColumn('action', function ($selected) {
                return
                    '<a class="btn btn-success" href="' . $selected->id . '/show" title="Detailed view of this Record"> <i class="fas fa-eye"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-warning" title="Edit this Record" href="' . $selected->id . '/edit"> <i class="fas fa-edit"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="' . $selected->id . '/destroy" onclick="return confirmation();" title="Delete this Record"><i class="fas fa-trash"></i></a>';
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
            'first_name' => 'required',
            'class_id' => 'required',
            'Section' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'email' => 'required',
        ]);

        $chekEmail = sizeof(DB::table('students')->where('email', '=', $request->email)->get());

        if($chekEmail > 0 ) {
            return redirect()->route('student.index')->with('message', 'Email already exists in the system. Please try different email.');
        }
        // exit;

        if ($request->require_login == "1") {

            $lastInsertedId = DB::table('users')->insertGetId([
                'name' => $request->first_name,
                'email' => $request->email,
                'password' => Hash::make("Pass@123"),
            ]);
        } else {
            $lastInsertedId = null;
        }


        // echo $lastInsertedId . " Yesssssssssssssss";
        // exit;

        if ($request->file()) {
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
                    'Section'   => $request->Section,
                    'gender'   => $request->gender,
                    'dob'   => $request->dob,
                    'upload_pps_image_info'   => $fileName,
                    'school_id'   => 1,
                    'created_date'   => Carbon::now(),
                    'updated_date'   => Carbon::now(),
                    'is_deleted'   => 0
                )
            );
        } catch (\Throwable $e) {
            print_r($e->getMessage());
            return View::make('pages.student.student.index')->with('message', "Student Title already exists - Try different video name !!!");
        }

        return redirect()->route('student.index')->with('message', "New Student Created Successfully !!!");
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
        // echo "</pre>";
        // exit;

        DB::table('students')->where('id', $request->id)->update(
            [
                'first_name'  =>   $request->first_name,
                'last_name'  =>   $request->last_name,
                'mobile'  =>   $request->mobile,
                'class_id'  =>   $request->class_id,
                'require_login' => $request->require_login,
                'gender'  =>   $request->gender,
                'dob'  =>   $request->dob,
                'marks_history'  =>  $request->marks_history,
                'fees_paid_history'  => $request->fees_paid_history,
                'upload_pps_image_info' => $request->upload_pps_image_info,
                'updated_date' => Carbon::now(),
                'is_deleted'  => 0
            ]
        );
        return redirect()->route('student.index')->with('message', 'Student Info updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('students')->delete($id);
        return redirect()->route('student.index')->with('message', 'Student removed successfully');
    }


    // routes functions
    /**
     * Show the form for creating a new post.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['classlist'] = DB::table('student_class')->select('id', 'class')->where('school_id', '=', 1)->where('is_deleted', '=', '0')->get();
        return view('pages.student.student.create', $data);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['studinfo'] = DB::table('students')->where('id', $id)->first();
        // print_r($data);
        // exit;
        return View::make('pages.student.student.show', $data);
    }


    /**
     * Show the form for editing the specified post.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $classlist = DB::table('student_class')->select('id', 'class')->where('school_id', '=', 1)->where('is_deleted', '=', '0')->get();
        foreach ($classlist as $arr) {
            $classArr[$arr->id] = $arr->class;
        }
        // print_r($classArr);
        // exit;
        $data['studinfo'] = DB::table('students')->where('id', $id)->first();
        return View::make('pages.student.student.edit', $data)->with('classlist', $classArr);
    }
}
