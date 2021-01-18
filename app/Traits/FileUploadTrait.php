<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait FileUploadTrait
{
    /**
     * @var string
     */
    protected $uploadPath = 'uploads';

    /**
     * @var
     */
    public $folderName = "media";

    /**
     * @var string
     */
    public $rule = 'image|max:2000';



    /**
     * For handle validation file action
     *
     * @param $file
     * @return fileUploadTrait|\Illuminate\Http\RedirectResponse
     */
    private function validateFileAction($file)
    {

        $rules = array('fileupload' => $this->rule);
        $file  = array('fileupload' => $file);

        $fileValidator = Validator::make($file, $rules);

        if ($fileValidator->fails()) {
            $messages = $fileValidator->messages();

            return redirect()->back()->withInput(request()->all())
                ->withErrors($messages);
        }
    }

    /**
     * For Handle validation file
     *
     * @param $files
     * @return fileUploadTrait|\Illuminate\Http\RedirectResponse
     */
    private function validateFile($files)
    {

        if (is_array($files)) {
            foreach ($files as $file) {
                return $this->validateFileAction($file);
            }
        }
        return $this->validateFileAction($files);
    }


    /**
     * Upload the file with slugging to a given path
     *
     * @param UploadedFile $image
     * @param $path
     * @return string
     */
    public function uploadFile(UploadedFile $image, $path)
    {

        $this->validateFile($image);

        $extension = $image->getClientOriginalExtension();
        $name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $image_name = Str::slug(date('Y-m-d-h-i-s') . $name . Str::random()) . '.' . $extension;
        $image->move($path, $image_name);

        return $path . "/" . $image_name;
    }




    /**
     * Suppose, you are browsing in your localhost
     * http://localhost/myproject/index.php?id=8
     */
    public function getBaseUrl()
    {
        // output: /myproject/index.php
        $currentPath = $_SERVER['PHP_SELF'];

        // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index )
        $pathInfo = pathinfo($currentPath);

        // output: localhost
        $hostName = $_SERVER['HTTP_HOST'];

        // output: http://
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https' ? 'https' : 'http';
        // return: http://localhost/myproject/
        return $protocol . '://' . $hostName . "/";
    }
}
