<?php

namespace App\Http\Controllers;

use App\Users_file;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $dir = 'home';
        if (isset($_GET['dlPath'])){//download
            $dlPath=$_GET['dlPath'];
            $file= Users_file::where('file_url',$dlPath)->first();
            return Storage::download($dlPath, $file->file_name);
        }
        elseif (isset($_GET['word'])){//search
            $word = $_GET['word'];
            if ($word==''){
                unset($word);
                return redirect('/home');
            }
            $Users_files_count = Users_file::where('user_id', $userId)->count();
            $Users_files = Users_file::where('user_id', $userId)->whereRaw('file_name like "%'.$word.'%"')->orderBy('file_name', 'asc')->paginate(10);
            $Users_folders = Users_file::where('user_id', $userId)->where('file_size',0)->orderBy('file_name', 'asc')->get();
            foreach($Users_files as $file){
                $file['file_size'] = $this->trans_byte($file->file_size);
            }
            return view('home',compact('user','Users_files','Users_folders','Users_files_count','word','dir'));
        }
        else{//home
            $Users_files_count = Users_file::where('user_id', $userId)->count();
            $Users_files = Users_file::where('user_id', $userId)->where('file_dir', 'home')->where('file_size', '>',0);
            $Users_files = Users_file::where('user_id', $userId)->where('file_dir', 'home')->where('file_size', '=',0)->union($Users_files)->paginate(10);
            $Users_folders = Users_file::where('user_id', $userId)->where('file_size',0)->orderBy('file_name', 'asc')->get();
            foreach($Users_files as $file){
                $file['file_size'] = $this->trans_byte($file->file_size);
            }
            return view('home',compact('user','Users_files','Users_folders','Users_files_count','dir'));
        }
    }

    public function dir($dir){
        if ($dir=='home'){return redirect('/home');}
        $user = Auth::user();
        $userId = $user->id;
        $Users_files_count = Users_file::where('user_id', $userId)->where('file_dir', $dir)->count();
        $Users_files = Users_file::where('user_id', $userId)->where('file_dir', $dir)->where('file_size', '>',0);
        $Users_files = Users_file::where('user_id', $userId)->where('file_dir', $dir)->where('file_size', '=',0)->union($Users_files)->paginate(10);
        $Users_folders = Users_file::where('user_id', $userId)->where('file_size',0)->orderBy('file_name', 'asc')->get();
        foreach($Users_files as $file){
            $file['file_size'] = $this->trans_byte($file->file_size);
        }
        return view('home',compact('user','Users_files','Users_folders','Users_files_count','dir'));
    }

    public function folderPlus($dir,Request $request){
        $this -> validate($request,['folder_name' => 'required']);
        $user = Auth::user();
        $userId = $user->id;
        $folderName=$_POST['folder_name'];
        $file['user_id'] = $userId;
        $file['file_name'] = $folderName;
        $file['file_dir'] = $dir;
        $file['file_size'] = 0;
        $rst = Users_file::create($file);
        if ($rst){
            return redirect('/home/dir/'.$dir);
        }
    }

    public function share(){
        $path=$_GET['path'];
        $file= Users_file::where('file_url',$path)->first();
        return Storage::download($path, $file->file_name);
    }

    public function upload(Request $request)
    {
        $this -> validate($request,['file' => 'required']);
        $user = Auth::user();
        $dir = $request->get('dir');
        $files = $request->file('file');
        foreach ($files as $_file) {
            $path = $_file->store('storage');

            $file['user_id'] = $user->id;
            $file['file_name'] = $_file -> getClientOriginalName();
            $file['file_url'] = $path;
            $file['file_dir'] = $dir;
            $file['file_size'] = $_file -> getSize();

            $rst = Users_file::create($file);
        }

        if ($rst){
            return redirect('/home/dir/'.$dir);
        }
    }

    public function delete(Request $request){
        $userId = Auth::user()->id;
        $id=$request->get('id');
        $file = Users_file::where('id', $id)->first();
        $size = $file->file_size;
        $dir = $file->file_dir;
        $delDir = $dir.'-'.$file->file_name;
        if ($size == 0){//del folder
            $childFiles = Users_file::where('user_id', $userId)->where('file_dir', 'like', $delDir.'%')->get();
            foreach ($childFiles as $childFile){//del childFiles
                $size = $childFile->file_size;
                if ($size == 0){$childFile->delete();}
                else{
                    $childFile->delete();
                    $path = $childFile->file_url;
                    Storage::delete($path);
                }
            }
            Users_file::where('id',$id)->delete();
            return redirect('/home/dir/'.$dir);
        }
        else{//del file
            $path = $file->file_url;
            Storage::delete($path);
            Users_file::where('id',$id)->delete();
            return redirect('/home/dir/'.$dir);
        }
    }

    public function rename(Request $request){
        $id =$request->get('id');
        $file_name=$request->get('file_name');
        Users_file::where('id',$id)->update([
            'file_name' => $file_name
        ]);
        $file = Users_file::where('id', $id)->first();
        $dir = $file->file_dir;
        return redirect('/home/dir/'.$dir);
    }

    public function reDir(Request $request){
        $id =$request->get('mvId');
            $file = Users_file::where('id', $id)->first();
            $dir = $file->file_dir;
        $newDir=$request->get('dir');
        Users_file::where('id',$id)->update([
            'file_dir' => $newDir
        ]);
        return redirect('/home/dir/'.$dir);
    }

    public function trans_byte($byte){
        $KB = 1024;
        $MB = 1024 * $KB;
        $GB = 1024 * $MB;
        $TB = 1024 * $GB;
        if ($byte < $KB) {
            return $byte . "B";
        } elseif ($byte < $MB) {
            return round($byte / $KB, 2) . "KB";
        } elseif ($byte < $GB) {
            return round($byte / $MB, 2) . "MB";
        } elseif ($byte < $TB) {
            return round($byte / $GB, 2) . "GB";
        } else {
            return round($byte / $TB, 2) . "TB";
        }
    }

}
