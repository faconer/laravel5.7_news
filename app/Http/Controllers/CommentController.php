<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Comment;
use App\TinTuc;
class CommentController extends Controller
{
    public function getXoa($id, $idTinTuc){
    	$comment = Comment::find($id);
    	$comment->delete();

    	return redirect('admin/tintuc/sua/'.$idTinTuc)->with('thongbao', 'Xóa bình luận thành công');
    }


    public function postComment(Request $request, $id){
    	$idTinTuc = $id;
    	$tintuc = TinTuc::find($id);
    	$comment = new Comment;
    	$comment->idTinTuc = $idTinTuc;
    	$comment->idUser = Auth::user()->id;
    	$comment->NoiDung = $request->NoiDung;
    	$comment->save();
    	return redirect('tintuc/'.$id."/".$tintuc->TieuDeKhongDau.".html"); 
    }
}
