<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function imageUpload(Request $request){
        $this->validate($request,[
            'file' => 'required|mimes:jpeg,jpg,png'
        ]);
        $picName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads/image'),$picName);
        return $picName;
    }

    public function otherUpload(Request $request){
        $this->validate($request,[
            'file' => 'required|mimes:doc,docx,zip,pdf,xls,xlsx,rp,mp3,rp,ppt,pptx,pptm,apk,rar'
        ]);
        $file = $request->file();
        $fileSize = $request->file->getSize();
        if($fileSize>1024*1024){
            $fileSize = round($fileSize/1024/1024,1).'MB';
        }else{
            $fileSize = round($fileSize/1024,1).'KB';
        }
        $fileOriName = $request->file->getClientOriginalName();
        $fileExtension = $request->file->extension();
        $fileName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads/other'),$fileName);
        return response()->json([
            'fileName'=>$fileName,
            'fileOriName'=>$fileOriName,
            'fileSize'=>$fileSize,
            'fileExtension'=>$fileExtension    
        ]);
    }

    public function videoUpload(Request $request){
        $this->validate($request,[
            'file' => 'required'
        ]);
        $file = $request->file();
        $fileSize = $request->file->getSize();
        if($fileSize>1024*1024){
            $fileSize = round($fileSize/1024/1024,1).'MB';
        }else{
            $fileSize = round($fileSize/1024,1).'KB';
        }
        $fileOriName = $request->file->getClientOriginalName();
        $fileExtension = $request->file->extension();
        $fileName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads/video'),$fileName);
        return response()->json([
            'fileName'=>$fileName,
            'fileOriName'=>$fileOriName,
            'fileSize'=>$fileSize,
            'fileExtension'=>$fileExtension    
        ]);
    }

    public function deleteFile(Request $request){
        $fileName = $request->fileName;
        $this->deleteFileFromServer($fileName);
        return 'done';
    }

    public function deleteFileFromServer($fileName){
        $filePath = public_path().$fileName;
        if(file_exists($filePath)){
            @unlink($filePath);
        }
        return;
    }
}
