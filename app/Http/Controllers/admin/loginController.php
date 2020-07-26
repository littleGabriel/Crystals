<?php


namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Http\Request;

class loginController extends Controller
{
    public function login(Request $request){
        $method = $request -> method();
        if ($method == 'POST'){
            $msg = [
                'username.max' => '用户名不能大于5位',
                'captcha.captcha' => '验证码错误'
            ];
            $this -> validate($request,[
                'username' => 'required|max:5',
                'password' => 'required',
                'captcha' => 'required|captcha'
            ],$msg);

            $user = User::where('user_name',$request -> username) -> first();
            if (!$user){
                $data = ['Err' => '用户名不存在'];
                return  view('admin.login',$data);
            }

            if ($request -> password == $user -> user_pass){
                $data = ['user_name' => $user -> user_name];
                return redirect('admin/index',$data);
            }
            else{
                $data = ['Err' => '密码错误'];
                return view('admin.login',$data);
            }

        }
        else{
            $data = ['Err' => ''];
            return view('admin.login',$data);
        }
    }
}
