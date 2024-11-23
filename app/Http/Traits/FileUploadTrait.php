<?php


namespace App\Http\Traits;

use App\Helpers\Constants;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

trait FileUploadTrait
{
    protected $rootPath = '';

    /**
     * @var string
     */
    protected $uploadPath = '';

    /**
     * @var
     */
    public $fileName;

    /**
     * @var
     */
    public $folderName;

    /**
     * @var
     */
    public $disk = 's3';

    /**
     * @var string
     */
    public $rule = 'file|max:52428800';

    /**
     * @return bool
     */

    public $host =  Constants::host_cloud;


    private function createUploadFolder(): bool
    {
        $folderPath = ($this->rootPath ? $this->rootPath . '/' : '') . $this->uploadPath.'/'.$this->folderName;
        if (!Storage::disk($this->disk)->exists($folderPath)) {
            Storage::disk($this->disk)->makeDirectory($folderPath);
            Storage::disk($this->disk)->put($folderPath.'/index.html', "I'm watching you 0-0");
            return true;
        }
        return false;
    }

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
     * For Handle Put File
     *
     * @param $file
     * @return bool|string
     */
    private function putFile($file)
    {
        $nameFile   = $this->fileName ?? preg_replace('/\s+/', '_', time() . ' ' . $file->getClientOriginalName());
        $folderPath = $this->uploadPath . '/' . $this->folderName ;

        if (Storage::disk($this->disk)->putFileAs(($this->rootPath ? $this->rootPath . '/' : '') . $folderPath, $file, $nameFile)) {
            return preg_replace('/([^:])(\/{2,})/', '$1/',$folderPath . '/' . $nameFile);
        }

        return false;
    }

    /**
     * @param $fileName
     * @return bool
     */
    private function unlinkFile($fileName)
    {
        $folderPath = ($this->rootPath ? $this->rootPath . '/' : '') . ($this->uploadPath ? $this->uploadPath . '/' : '') . ($this->folderName ? $this->folderName . '/' : '');
        $filePath   = $folderPath . $fileName;
        return Storage::disk($this->disk)->delete($filePath);
    }

    /**
     * For Handle Save File Process
     *
     * @param $files
     * @return array
     */
    public function saveFiles($files)
    {
        $data = null;
        $this->host = Storage::disk($this->disk);

        if($files != null){

            $this->validateFile($files);

            $this->createUploadFolder();

            if (is_array($files)) {

                foreach ($files as $file) {
                    $data[] = $this->putFile($file);
                }

            } else {

                $data = $this->putFile($files);
            }

        }

        return $data;
    }

    public function deleteFiles($files)
    {
        $data = null;

        if($files != null){

            if (is_array($files)) {

                foreach ($files as $file) {
                    $data[] = $this->unlinkFile($file);
                }

            } else {

                $data = $this->unlinkFile($files);
            }

        }

        return $data;
    }


}
