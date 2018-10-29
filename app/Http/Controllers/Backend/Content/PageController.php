<?php

namespace App\Http\Controllers\Backend\Content;

use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Backend\PagesRequest;
use App\Models\Media;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use MediaService;


class PageController extends Controller
{
    use ResponseTrait;
    /**
     * @var Page
     */
    private $pages;
    /**
     * @var Media
     */
    private $media;


    public function __construct(Page $pages, Media $media)
    {
        $this->pages = $pages;
        $this->media = $media;

    }

    public function index()
    {
        return view('backend.content.pages.index', [
            'title' => 'Страницы',
        ]);
    }

    public function getList(Request $request)
    {
        $pages = $this->pages->orderBy('created_at', 'desc')->paginate(20);

        return response()->json([
            'tableData' => view('backend.content.pages.list', [
                'items' => $pages
            ])->render(),
            'pagination' => view('backend.common.pagination', [
                'links' => $pages->links('vendor.pagination.bootstrap-4'),
            ])->render(),
        ]);

    }

    public function create()
    {
        $foreign_languages = config('project.foreign_locales');
        $create = 1;

        return response()->json([
            'functions' => ['initEditor'],
            'type' => 'updateModal',
            'modal' => '#superLargeModal',
            'modalTitle' => 'Создание страницы',
            'modalContent' => view('backend.content.pages.form', [
                'foreign_languages' => $foreign_languages,
                'create' => $create,
                'formAction' => route('admin.content.pages.store'),
                'buttonText' => 'Создать'
            ])->render()
        ]);
    }


    public function store(PagesRequest $request)
    {
        $request->merge(['site_display' => $request->has('site_display')]);
        $page = $this->pages->create($request->all());

        if ($request->has('image')) {
            $media = MediaService::upload($request->file('image'), get_class($this->pages), $page->id);
            MediaService::setMainById($media->id, get_class($this->pages), $page->id);
        }

        return response()->json([
            'functions' => ['closeModal'],
            'modal_for_close' => '#superLargeModal',
            'type' => 'prepend-table-row',
            'table' => '#ajaxTable',
            'content' => view('backend.content.pages.item', ['item' => $page])->render()
        ]);


    }

    public function edit($pageId)
    {
        $foreign_languages = config('project.foreign_locales');
        $page = $this->pages->with('mainImage', 'media')->find($pageId);
        $create = 0;
        $medias = $page->media->chunk(2);

        return response()->json([
            'functions' => ['initEditor', 'initCrop'],
            'type' => 'updateModal',
            'modal' => '#superLargeModal',
            'modalTitle' => 'Редактирование страницы',
            'modalContent' => view('backend.content.pages.form', [
                'medias' => $medias,
                'create' => $create,
                'foreign_languages' => $foreign_languages,
                'page' => $page,
                'formAction' => route('admin.content.pages.update', ['id' => $pageId]),
                'buttonText' => 'Сохранить',
            ])->render()
        ]);
    }

    public function update(PagesRequest $request, $pageId)
    {
        $page = $this->pages->find($pageId);

        if ($page) {
            $request->merge(['site_display' => $request->has('site_display')]);
            $page->update($request->all());

            if ($request->hasFile('image')) {
                $media = MediaService::upload($request->file('image'), get_class($this->pages), $pageId);
                MediaService::setMainById($media->id, get_class($this->pages), $pageId);
            }
        }

        return response()->json([
            'functions' => ['updateTableRow', 'closeModal'],
            'modal_for_close' => '#superLargeModal',
            'type' => 'update-table-row',
            'table' => '#ajaxTable',
            'row' => '.row-' . $pageId,
            'content' => view('backend.content.pages.item', ['item' => $page])->render()
        ]);
    }


    public function destroy($pageId)
    {
        $page = $this->pages->find($pageId);
        if ($page) {
            MediaService::deleteForModel(get_class($this->pages), $page->id);
            $page->delete();
        }
        return response()->json([
            'type' => 'delete-table-row',
            'table' => '#ajaxTable',
            'row' => '.row-' . $pageId,
        ]);

    }

    public function media(Request $request, $pageId)
    {
        foreach ($request->file('image') as $image) {
            MediaService::upload($image, get_class($this->pages), $pageId);
        }

        $page = $this->pages->find($pageId);

        return $this->responseJson([
            'media' => view('backend.content.pages.media_list', ['page' => $page,])->render(),
        ]);
    }

    public function mainMedia($pageId, $mediaId)
    {
        $page = $this->pages->find($pageId);
        MediaService::setMainById($mediaId, get_class($this->pages), $page->id);
    }

    public function deleteMedia($mediaId)
    {
        MediaService::deleteById($mediaId);
    }

    public function updateMedia(Request $request, MediaService $mediaService,$mediaId)
    {
        $image = $request->image;
        $thumbSizes = ['512', '256', '128'];
        $mediaService->editVideo($image,$mediaId, $thumbSizes);

    }

    public function imageCrop($mediaId)
    {
        $media = MediaService::getMedia($mediaId);

        return response()->json([
            'functions' => ['initCrop'],
            'type' => 'updateModal',
            'modal' => '#editImageModal',
            'modalTitle' => 'Обрезка изображения',
            'modalContent' => view('backend.common.media.crop.index', [
                'formAction' => route('admin.content.pages.image.crop.store', ['mediaId' => $media->id]),
                'imgPath' => asset('storage/media/' . $media->getOriginal('original_file_name') . '?' . uniqid()),
            ])->render()
        ]);
    }


    public function imageCropStore(Request $request, int $mediaId)
    {

        $media = MediaService::getMedia($mediaId);
        $path = storage_path('app/public/media/' . $media->getOriginal('original_file_name'));

        MediaService::cropImage($path, $request->all());

        foreach ($media->conversions as $size => $conversion) {
            $target = storage_path('app/public/media/' .  $conversion['name']);
            MediaService::resize($path, $target, $conversion['width'], $conversion['height']);
        }

        return response()->json([
            'functions' => ['closeModal', 'initCrop'],
            'type' => 'updateBlock',
            'blockForUpdate' => '.image-' . $mediaId,
            'blockForUpdateContent' => view('backend.content.pages.media_item', [
                'media' => $media,
            ])->render(),
            'modal_for_close' => '#editImageModal',
        ]);
    }
}
