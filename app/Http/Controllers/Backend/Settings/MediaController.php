<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\ResponseTrait;
use App\Services\MediaService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    use ResponseTrait;
    private $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function getModelMedia($owner, $modelId)
    {
        $media = $this->mediaService->getModelMedia($owner, $modelId);

        $data = [
            'modalTitle' => 'Управление изображениями',
            'modalContent' => view('backend.common.media.list', [
                'media' => $media->chunk(4),
                'formAction' => route('admin.media.model.upload', ['owner' => $owner, 'modelId' => $modelId]),
            ])->render()];

        return $this->responseJson($data);

    }

    public function addMediaForModel(Request $request, $owner, $modelId)
    {
        if ($request->hasFile('images'))
        {
            foreach ($request->file('images') as $image)
            {
                $this->mediaService->uploadImage($image, $owner, $modelId);
            }
        }

        $media = $this->mediaService->getModelMedia($owner, $modelId);

        $data = [
            'functions' => ['updateMediaList'],
            'media' => view('backend.common.media.images', [
                'media' => $media->chunk(4),
            ])->render()
        ];

        return $this->responseJson($data);
    }

    public function deleteMediaForModel($mediaId)
    {
        $this->mediaService->delete($mediaId);
    }

    public function setMediaMain($mediaId)
    {
        $this->mediaService->setMain($mediaId);
    }

    public function addMediaForEditor(Request $request)
    {
        if ($request->hasFile('images'))
        {
            foreach ($request->file('images') as $image)
            {
                $this->mediaService->uploadImage($image, null, 'editor');
            }
        }

        $images = $this->mediaService->getEditorMedia();

        $content = view('backend.common.media.editor.images.images', [
            'images' => $images->chunk(4)
        ])->render();

        return response()->json([
            'content' => $content
        ]);

    }

    public function addFilesForEditor(Request $request)
    {
        if ($request->has('files'))
        {
            foreach ($request->file('files') as $file)
            {
                $this->mediaService->uploadFile($file,  'editor');
            }
        }

        $files = $this->mediaService->getEditorMedia();

        $content = view('backend.common.media.editor.files.files', [
            'files' => $files
        ])->render();

        return response()->json([

            'content' => $content
        ]);
    }

    public function getEditorImages()
    {
        $images = $this->mediaService->getEditorMedia();

        return response()->json([
            'modalTitle' => 'Изображения',
            'content' => view('backend.common.media.editor.images.index', [
                'images' => $images->chunk(4)
            ])->render()

        ]);
    }

    public function getEditorFiles()
    {
        $files = $this->mediaService->getEditorMedia();

        return response()->json([

            'modalTitle' => 'Файлы',
            'content' => view('backend.common.media.editor.files.index', [
                'files' => $files
            ])->render()

        ]);
    }
}
