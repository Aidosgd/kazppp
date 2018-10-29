<?php


namespace App\Services;


use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

class ImageService
{
    private $image;
    private $path;

    public function resize(int $width = null, int $height = null)
    {
        $img = Image::make($this->image);
        if ($img->width() > $width) {
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        $img->save($this->path, 60);
    }


    /**
     * @param UploadedFile $image
     */
    public function setImage(UploadedFile $image)
    {
        $this->image = $image;
    }


    /**
     * @param string $path
     * @throws \Exception
     */
    public function setPath(string $path)
    {
//        if (!file_exists($this->path)) {
//            throw new \Exception('Path not exists', 404);
//        }

        $this->path = $path;
    }


}