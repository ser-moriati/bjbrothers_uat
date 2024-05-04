<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use DateTime;
use Session;
use Response;
use Datatables;
use File;
use App\Models\Pageuser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class UserController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    
       
        $data['module'] = 'User';
        $data['asset'] = asset('/');
        $data['page'] = 'User';
        $data['page_url'] = 'User';
        
        $query = DB::table('users')->orderBy('id', 'desc');
        
        if ($request->has('name')) {
            $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }
        
        $results = $query->paginate(10);
        
        $data['list_data'] = $results;
        $data['query'] = $request->query();
        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/admin/index', $data);
        
    }
    public function add(){

        $data['page_before'] = 'User';
        $data['page'] = 'User Add';
        $data['page_url'] = 'User Add';
        $data['action'] = "insert";
        return view('admin/admin/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'User';
        $data['page'] = 'User Edit';
        $data['page_url'] = 'User';
        $data['action'] = "../update/$id";
        $data['users'] = DB::table('users')->where('id',$id)->first();

        return view('admin/admin/add', $data);
    }
    public function insert(Request $request)
    {
        DB::beginTransaction();
        try {
         
            
            $existingUser = DB::table('users')
            ->where('name', $request->name)
            ->orWhere('email', $request->email)
            ->first();
        
        if ($existingUser) {
            // ชื่อผู้ใช้หรืออีเมลซ้ำกัน
            // ทำการแจ้งเตือนหรือจัดการตามที่คุณต้องการ
            return redirect('admin/add')->with('message', 'Username or email is already in use.');
          
        } else {
            // ชื่อผู้ใช้หรืออีเมลไม่ซ้ำ
            // ทำการบันทึกข้อมูลใหม่
            $data = new \stdClass;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->password = Hash::make($request->password);
            $data->created_at = now();
            $data->updated_at = now();
        
            DB::table('users')->insert((array)$data);
            DB::commit();
        
            return redirect('admin/User')->with('message', 'Insert Users  success');
        }
     
            // return back();
            $mes = 'Success';
            return redirect('admin/User')->with('message', 'Insert Users  success');
            echo ("<script>alert('$mes'); location.href='$yourURL'; </script>");
        } catch (\Exception $e) {
            DB::rollBack();
            $mes = 'Fail' . $e->getMessage();
            $yourURL = url('backend/user/pageuser');
            echo ("<script>alert('Fail username or email is duplicate!'); location.href='$yourURL'; </script>");
        }
    }



    public function user_edit($id)
    {
        // $user = Pageuser::find($id);
        // $data = array(
        //     'user'     => $user,
        // );
        // // return view('backend/user/update',['user' => $user,]);
        // echo json_encode($data);


        $users = DB::table('users')->where('id', $id)->first();
        return view('backend.user.update', ['users' => $users]);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            
            if (!empty($request->input('password'))) {
                $data = [
                    'name'                => $request->input('name'),
                    'email'               => $request->input('email'),
                    'password'            => Hash::make($request->input('password')),
                    'updated_at'          => new DateTime(),
                ];
            } else {
                $data = [
                    'name'                => $request->input('name'),
                    'email'               => $request->input('email'),
                    'updated_at'          => new DateTime(),
                ];
            }
           
            DB::table('users')->where('id', $request->input('id'))->update($data);
            DB::commit();
            // return back();
          
            return redirect('admin/User')->with('message', 'update Users  success');
            echo ("<script>alert('$mes'); location.href='$yourURL'; </script>");
        } catch (\Exception $e) {
            DB::rollBack();
            $mes = 'update fail ' . $e->getMessage();
            $yourURL = url('backend/user/pageuser');
            echo ("<script>alert('$mes'); location.href='$yourURL'; </script>");
        }
    }

    public function user_destroy($id)
    {
        // echo ("<script>console.log('$id'); </script>");
        DB::beginTransaction();
        try {
            DB::table('users')->delete($id);
            DB::commit();
            $response['success'] = true;
            $response['message'] = 'ลบข้อมูลสำเร็จ !';
            return response()->json($response, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            $response['message'] = 'เกิดข้อผิดพลาด !' . $e->getMessage();;
            return response()->json($response, 400);
        }
    }
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            DB::table('users')->delete($id);
            DB::commit();
            $response['success'] = true;
            $response['message'] = 'ลบข้อมูลสำเร็จ !';
            return response()->json($response, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            $response['message'] = 'เกิดข้อผิดพลาด !' . $e->getMessage();;
            return response()->json($response, 400);
        }
    }
}
