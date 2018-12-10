<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getDanhSach(){
    	$user = User::all();
    	return view('admin.user.danhsach', ['user'=>$user]);
    }

    public function getThem(){
    	return view('admin.user.them');
    }

    public function postThem(Request $request){
    	$this->validate($request, 
        [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password'=>'required|min:6|max:15',
            'passwordAgain' =>'required|same:password'
        ],[
            'name.require' => 'Bạn chưa nhập tên người dùng',
            'name.min' => 'Tên người dùng ít nhất 3 ký tự',
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Bạn chưa nhập đúng định dạng email',
            'email.unique' => 'Email đã trùng',
            'password.required'=>'Bạn chưa nhập mật khẩu',
            'password.min'=>'Mật khẩu ít nhất 6 ký tự',
            'password.max' => 'Mật khẩu tối đa 15 ký tự',
            'password.required' => 'Bạn chưa nhập lại mật khẩu',
            'password.same' => 'Mật khẩu nhập nhập chưa khớp'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->quyen = $request->quyen;
        $user->save();
         
        return redirect('admin/user/them')->width('thongbao', 'Thêm thành công');
    }


    public function getSua($id){
         $user = User::find($id);
        return view('admin.user.sua', ['user'=>$user]);
    }

    public function postSua(Request $request, $id){
        $this->validate($request, 
        [
            'name' => 'required|min:3',
        ],[
            'name.require' => 'Bạn chưa nhập tên người dùng',
            'name.min' => 'Tên người dùng ít nhất 3 ký tự'
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->quyen = $request->quyen; 
        if($request->changePassword == "on"){
        $this->validate($request, 
        [
            'password'=>'required|min:6|max:15',
            'passwordAgain' =>'required|same:password'
        ],[
            'password.required'=>'Bạn chưa nhập mật khẩu',
            'password.min'=>'Mật khẩu ít nhất 6 ký tự',
            'password.max' => 'Mật khẩu tối đa 15 ký tự',
            'password.required' => 'Bạn chưa nhập lại mật khẩu',
            'password.same' => 'Mật khẩu nhập nhập chưa khớp'
        ]);
            $user->password = bcrypt($request->password);
        }

        $user->save();
        return redirect('admin/user/sua/'.$id)->width('thongbao', 'Sửa thành công');
    }


    public function getDangnhapAdmin(){
        return view('admin.login');
    }

     public function postDangnhapAdmin(Request $request){
        $this->validate($request, 
        [
            'email'=>'required',
            'password'=>'required|min:6|max:15'
        ],[
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Bạn chưa nhập đúng định dạng email',
            'password.required'=>'Bạn chưa nhập mật khẩu',
            'password.min'=>'Mật khẩu ít nhất 6 ký tự',
            'password.max' => 'Mật khẩu tối đa 15 ký tự',
        ]);

        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){
            return redirect('admin/theloai/danhsach');
        }else{
            return redirect('admin/dangnhap')->with('thongbao', 'Đăng nhập không thành công');
        }

    }

    public function getXoa($id){
        $user = User::find($id);
        $user->delete();
        return redirect('admin/user/danhsach')->with('thongbao', 'Xóa thành công');
    }

    public function getDangxuatAdmin(){
        Auth::logout();
        return redirect('admin/dangnhap');
    }

}
