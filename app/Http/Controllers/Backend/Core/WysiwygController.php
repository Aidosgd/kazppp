<?php

namespace App\Http\Controllers\Backend\Core;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


// requests
use App\Http\Requests\Backend\Core\WysiwygRequest;

// services
use UploaderService;
use MediaService;


class WysiwygController extends Controller
{

    private $breadCrumbsData;

    public function __construct()
    {

    }

    /**
     * Список файлов и каталогов
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function objects(Request $request)
    {
        $groupId = $request->input('parent_id') ?? null;

        return $this->generalResponse($groupId, $request->all());
    }

    /**
     * Json ответ для модального окна
     * @param $groupId
     * @param array $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    private function generalResponse($groupId, array $request = [])
    {
        $folders = UploaderService::folderList($groupId);


        $files = UploaderService::uploadList($groupId, $request);

        $mime = (isset($request['mime'])) ? $request['mime'] : 'all';

        $folderCreateUrl = route('admin.wysiwyg.folder.create', ['parent_id' => $groupId]);
        $breadCrumbs = $this->getBreadCrumbs($groupId);

        return response()->json([
            'functions' => ['closeModal'],
            'modal_for_close' => '#manageFolderModal',
            'type' => 'updateModal',
            'modal' => '#editorModal',
            'modalTitle' => 'Загрузки',
            'modalContent' => view('backend.core.wysiwyg.files', [
                'folders' => $folders,
                'files' => $files,
                'mime' => $mime,
                'folderCreateUrl' => $folderCreateUrl,
                'breadCrumbs' => $breadCrumbs,
                'uploadUrl' => route('admin.wysiwyg.file.store', ['parent_id' => $groupId])
            ])->render()
        ]);
    }


    /**
     * Контент модалки создания/редактирования папки
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function folderCreate(Request $request)
    {
        $parentId = $request->input('parent_id');

        return response()->json([
            'type' => 'updateModal',
            'modal' => '#manageFolderModal',
            'modalTitle' => 'Создание каталога',
            'modalContent' => view('backend.core.wysiwyg.partials.folder_form', [
                'legend' => 'Создание каталога',
                'formAction' => route('admin.wysiwyg.folder.store', ['parent_id' => $parentId]),
                'submitBtnText' => 'Создать'
            ])->render()
        ]);
    }

    /**
     * Создание каталога
     * @param WysiwygRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function folderStore(WysiwygRequest $request)
    {
        $folder = UploaderService::folderStore($request->input('name'), $request->input('parent_id'));

        return $this->generalResponse($folder->parent_id, $request->all());
    }

    /**
     * Контент модалки для редактирования папки
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function folderEdit($id)
    {
        $folder = UploaderService::folderById($id);
        return response()->json([
            'type' => 'updateModal',
            'modal' => '#manageFolderModal',
            'modalTitle' => 'Создание каталога',
            'modalContent' => view('backend.core.wysiwyg.partials.folder_form', [
                'legend' => 'Редактирование каталога',
                'folder' => $folder,
                'formAction' => route('admin.wysiwyg.folder.update', ['id' => $id]),
                'submitBtnText' => 'Сохранить'
            ])->render()
        ]);
    }

    /**
     * Обновление имени папки
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function folderUpdate(Request $request, $id)
    {
        $folder = UploaderService::folderRename($id, $request->input('name'));

        return response()->json([
            'functions' => ['closeModal'],
            'modal_for_close' => '#manageFolderModal',
            'type' => 'update-table-row',
            'table' => '#mediaFilesTable',
            'row' => '.folder-row-' . $id,
            'content' => view('backend.core.wysiwyg.partials.folder_item', ['folder' => $folder])->render()
        ]);
    }

    /**
     * Удаление папки
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function folderDelete($id)
    {
        UploaderService::folderDelete($id);

        return response()->json([
            'type' => 'delete-table-row',
            'table' => '#mediaFilesTable',
            'row' => '.folder-row-' . $id
        ]);


    }

    /**
     * Сохранение папки
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function fileStore(Request $request)
    {
        $parentId = $request->input('parent_id');

        if ($request->hasFile('uploads'))
        {
            foreach ($request->file('uploads') as $file)
            {
                UploaderService::upload($file, $parentId);
            }
        }

        return $this->generalResponse($parentId, $request->all());
    }

    public function imageEdit(int $id)
    {
        $image = UploaderService::uploadById($id);

        if ($image)
        {
            $cancelUrl = route('admin.wysiwyg.objects', ['parent_id' => $image->group_id]);
            return response()->json([
                'functions' => ['initCrop'],
                'type' => 'updateModal',
                'modal' => '#editImageModal',
                'modalTitle' => 'Настройка изображения',
                'modalContent' => view('backend.common.media.crop.index', [
                    'formAction' => route('admin.wysiwyg.image.update', ['id' => $id]),
                    'imgPath' => asset('storage/uploads/' . $image->getOriginal('original_file_name') . '?' . uniqid()),

                ])->render()
            ]);
        }
    }

    public function imageUpdate(Request $request, $id)
    {
        $upload = UploaderService::uploadById($id);
        $path = storage_path('app/public/uploads/' . $upload->getOriginal('original_file_name'));
        MediaService::cropImage($path, $request->all());

        return response()->json([
            'functions' => ['closeModal'],
            'modal_for_close' => '#editImageModal',

        ]);
    }

    /**
     * Удаление файла
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function fileDelete($id)
    {
        UploaderService::uploadDelete($id);

        return response()->json([
            'type' => 'delete-table-row',
            'table' => '#mediaFilesTable',
            'row' => '.file-row-' . $id
        ]);
    }


    /**
     * Герерация хлебных крошек для модалки
     * @param null $parentId
     * @return string
     */
    private function getBreadCrumbs($parentId = null)
    {
        $data = '<a href="' . route('admin.wysiwyg.objects', ['parent_id' => null]) . '" class="handle-click" data-type="ajax-get" data-block-element="#editorModal .modal-body"><i class="fa fa-folder-open-o"></i> Корень</a>';

        if (!$parentId)
        {
            return $data;
        }

        $this->buildBreadCrumbs($parentId);

        $data .= $this->breadCrumbsData;

        return $data;


    }

    /**
     * Рекурсия для создания хлебных крошек
     * @param $id
     */
    private function buildBreadCrumbs($id)
    {

        $folder = UploaderService::folderById($id);

        $this->breadCrumbsData = ' <i class="fa fa-angle-right"></i> <a href="' . route('admin.wysiwyg.objects', ['parent_id' => $folder->id]) . '" class="handle-click" data-type="ajax-get" data-block-element="#editorModal .modal-body"><i class="fa fa-folder-open-o"></i> ' . $folder->name . '</a>' . $this->breadCrumbsData;

        if ($folder->parent_id)
        {
            $this->buildBreadCrumbs($folder->parent_id);
        }


    }

    /**
     * Формирование html для инжекта контента в визивиг
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function inject($id)
    {
        $file = UploaderService::uploadById($id);

        $template = $this->getInjectTemplate($file->type);

        return response()->json([
            'injection' => view($template, ['file' => $file])->render()
        ]);
    }

    /**
     * Определение вьюхи для инжекта в зависимости от типа файла
     * @param $type
     * @return string
     */
    private function getInjectTemplate($type)
    {
        switch ($type)
        {
            case 'file':
                return 'backend.core.wysiwyg.partials.inject_file';
                break;

            case 'image':
                return 'backend.core.wysiwyg.partials.inject_image';
                break;
        }
    }
}
