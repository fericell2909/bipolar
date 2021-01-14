<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Models\Video;
use App\Models\Attachment;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\UploadFileDO;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\TryCatch;

class VideoController extends Controller
{

    private $folder = 'videos';

    public function videoUpload(Request $request, $productHashId)
    {
        
        $this->validate($request, ['file' => 'required']);

        $fullPath = "";
        $folderUpload = $request->input('folder', $this->folder);
        $inputName = $request->input('input_name', 'file');

        
        $product = Product::findByHash($productHashId);
        $image = $request->file('file');

        if ($image->isValid()) {
            

            $fileTmp = $request->file($inputName);
            $file['path'] = $fileTmp->path();
            $file['name'] = $fileTmp->getClientOriginalName();
            $file['name_original'] = $fileTmp->getClientOriginalName();
            $file['mime_type'] = $fileTmp->getMimeType();

            $extension = explode('/', $file['mime_type']);
            $file['name'] = str_replace( $extension[1], '', $file['name']);
            $file['name'] = strtotime("now") . '_' . Str::slug($file['name'], '_')
                            . '.' . $extension[1];


             try{
                $DOFileService = (new UploadFileDO)->put(
                    $folderUpload,
                    $file['name'],
                    $file['path'],
                    $file['mime_type']
                );
            } catch( \Exception $e){
                return $e->getMessage();
            } 


           
           // \Storage::disk('do')->putFile('uploads', $image);

           $public_url = config('digitalocean.do_url').'/'.$folderUpload.'/'.$file['name'];

           //$public_url = 'https://devmarcoestrada.nyc3.digitaloceanspaces.com'.'/'.$folderUpload.'/'.$file['name'];

           
            $fileModel = Attachment::create([
                'name' => $file['name'],
                'name_original' => $file['name_original'],
                'folder_path' => '/' . $folderUpload . '/' ,
                'mime_type' => $file['mime_type'],
                's3_url' => $public_url
            ]);

            $fullPath = $fileModel->s3_url;

            $photo = new Video;
            $photo->product()->associate($product);
            $photo->url =  $public_url;
            $photo->relative_url = $fileModel->name;
            $photo->attachment_id = $fileModel->id;
            $photo->order = 0;
            
            $photo->save();
        
        }

        return response()->json($fullPath);
    }

    public function orderVideos(Request $request)
    {
        $this->validate($request, ['newOrder' => 'required|array']);

        $newOrder = $request->input('newOrder');

        foreach ($newOrder as $orderKey => $photoHashId) {
            $photo = Video::findByHash($photoHashId);
            $photo->order = $orderKey;
            $photo->save();
        }

        return response()->json(['success' => true]);
    } 

    public function deleteVideo($videoHashId){

        $video = Video::findByHash($videoHashId);
      
        if($video){

            $attachment = Attachment::where('id',$video->attachment_id)->first();
           
            if($attachment) {

               /*  try{
                    $DOFileService = (new UploadFileDO)->delete('videos/'.$this->folder);
                } catch( \Exception $e){
                    return response()->json([
                        'success' => false,
                        'message' => 'Video eliminado correctamente',
                    ]);
                }  */

                $DOFileService = (new UploadFileDO)->delete($this->folder.'/'.$attachment->name);


                $video->delete();

                $attachment->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Video eliminado correctamente',
                ]);

            }

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Video No Eliminado',
            ]);

        }
    }
   

}