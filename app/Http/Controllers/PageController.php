<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\TheLoai;
use App\Slide;
use App\LoaiTin;
use App\TinTuc;
use App\User;
class PageController extends Controller
{	
    public function index(){
        return redirect('trangchu');
    }
	public function __construct(){
		$theloai = TheLoai::all();
		$slide = Slide::all();
		view()->share('theloai',$theloai);
		view()->share('slide',$slide);
        if(Auth::check()){
            view()->share('nguoidung', Auth::user());
        }
	}
    public function trangchu(){
    	return view('pages.trangchu');
    }

    public function lienhe(){
    	return view('pages.lienhe');
    }

    public function loaitin($id){
    	$loaitin = LoaiTin::find($id);
    	$tintuc = TinTuc::where('idLoaiTin', $id)->paginate(5);
    	return view('pages.loaitin', ['loaitin'=>$loaitin, 'tintuc'=>$tintuc]);
    }

    public function tintuc($id){
        $tintuc = TinTuc::find($id);
        $tinnoibat = TinTuc::where('NoiBat', 1)->take(4)->get();
        $tinlienquan = TinTuc::where('idLoaiTin', $tintuc->idLoaiTin)->take(4)->get();
        return view('pages.tintuc', ['tintuc'=>$tintuc, 'tinnoibat'=>$tinnoibat, 'tinlienquan'=>$tinlienquan]);
    }

    public function getDangnhap(){
        return view('pages.dangnhap');
    }

    public function postDangnhap(Request $request){
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
            return redirect('trangchu');
        }else{
            return redirect('dangnhap')->with('thongbao', 'Đăng nhập không thành công');
        }
    }

    public function dangxuat(){
        Auth::logout();
        return redirect('trangchu');
    }

    public function timkiem(Request $request){
        $tukhoa=$request->get('tukhoa');
        $tintuc = TinTuc::where('TieuDe','like','%'.$tukhoa.'%')->orWhere('TomTat','like','%'.$tukhoa.'%')->orWhere('NoiDung','like','%'.$tukhoa.'%')->paginate(5);
        return view('pages.timkiem',['tukhoa'=>$tukhoa,'tintuc'=>$tintuc]);    
    }
}
