<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Masters\Role;
use Illuminate\Support\Facades\View;
use DB;
use DataTables;
use Carbon\Carbon;


class RolesController extends Controller
{
    public function index()
    {
        return view('pages.masters.role.index');
    }

    public function rolelist()
    {
        $roles = DB::table('roles')->orderBy('updated_at', 'desc');
        return datatables()->of($roles)
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
        'role_title' => 'required',
        'role_description' => 'required',
        ]);

        try {
            $role = new Role();

            $role->role_title = $request->role_title;
            $role->role_description = $request->role_description;
            $role->status = 1;

            $role->save();
        }
        catch (\Throwable $e) {
            print_r($e->getMessage());
            return View::make('pages.masters.role.index')->with('message', "Role Title already exists - Try different role name !!!");
        }

        return redirect()->route('role.index')->with('message', "New Role Created Successfully !!!");
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

        // print_r($request->all());
        // exit;
        $request->validate([
        'role_title' => 'required',
        'role_description' => 'required',
        ]);
        Role::where('id',$request->id)->update(['role_title'=>$request->role_title,'role_description'=>$request->role_description,'status'=>$request->status,'updated_at'=>Carbon::now()]);
        return redirect()->route('role.index')->with('message', 'Role updated successfully.');
    }
        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            $post = Role::find($id);
            $post->delete();
            return redirect()->route('role.index')->with('message', 'Role deleted successfully');
        }
        // routes functions
        /**
         * Show the form for creating a new post.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            return view('pages.masters.role.create');
        }
        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            $data['role'] = Role::find($id);
            return View::make('pages.masters.role.show', $data);
        }
        /**
         * Show the form for editing the specified post.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            $data['role'] = Role::find($id);
            return View::make('pages.masters.role.edit', $data);
        }

}
