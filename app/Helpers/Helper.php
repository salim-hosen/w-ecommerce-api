<?php

//Global image file uploader
function uploadImage($request, $arribute_name, $save_path, $width = null, $height = null, $imageName = null){

    if($request->hasFile($arribute_name)){

        $image = $request->file($arribute_name);
        $filename = $imageName ? $imageName .'.'. $image->getClientOriginalExtension() : $image->hashName();

        $location = public_path($save_path);

        // If directory doesn't exists create directory first
        File::isDirectory($location) or File::makeDirectory($location, 0777, true, true);
        $filepath = public_path($save_path.'/'.$filename); // make new location to the created folder

        Image::make($image)->resize($width, $height, function($constraint){
            $constraint->aspectRatio();
        })->save($filepath);

        return $filename;
   }

   return null;

}


//Global image file uploader
function uploadFile($request, $arribute_name, $save_path, $fileName = null){

    if($request->hasFile($arribute_name)){

        $file = $request->file($arribute_name);
        $filename = $fileName ? $fileName .'.'. $file->getClientOriginalExtension() : $file->hashName();

        $location = public_path($save_path);

        // If directory doesn't exists create directory first
        File::isDirectory($location) or File::makeDirectory($location, 0777, true, true);
        $filepath = public_path($save_path.'/'.$filename); // make new location to the created folder

        $file->move($location, $filepath);

        return $filename;
   }

   return null;

}

// Global File deleter
function deleteOldFile($filename, $filepath){
    if($filename && file_exists(public_path()."/".$filepath."/".$filename)) {
        unlink(public_path()."/".$filepath."/".$filename);
    }
}

