<?php

namespace App\Http\Controllers\Backend\Content;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// form requests
use App\Http\Requests\Backend\NewsRequest;

// models
use App\Models\News;

// traits
use App\Http\Controllers\ResponseTrait;
use App\Http\Controllers\FormatTrait;

// services
use App\Services\CategoryService;
use MediaService;

class NewsController extends Controller
{
    use ResponseTrait;
    use FormatTrait;

    private $news;
    private $categoryService;

    public function __construct(News $news, CategoryService $categoryService)
    {
        $this->news = $news;
        $this->categoryService = $categoryService;
    }


    public function index()
    {
        $news = $this->news->orderBy('title')->get();

        return view('backend.content.news.index', [
            'title' => 'Список новостей',
            'news' => $news
        ]);
    }


    public function getList(Request $request)
    {
        $news = $this->news->with('mainImage')->orderBy('created_at', 'desc')->paginate(20);
dd($news->toArray());
        return response()->json([
            'tableData' => view('backend.content.news.list', [
                'news' => $news,
                'filters' => $request->all()
            ])->render(),
        ]);
    }


    public function create()
    {
        $foreign_languages = config('project.foreign_locales');
        $categories = $this->categoryService->categoriesForSelect('news');
        $create = 1;

        return response()->json([
            'functions' => ['initEditor'],
            'type' => 'updateModal',
            'modal' => '#superLargeModal',
            'modalTitle' => 'Создание новости',
            'modalContent' => view('backend.content.news.form', [
                'foreign_languages' => $foreign_languages,
                'create' => $create,
                'categories' => $categories,
                'formAction' => route('admin.content.news.store'),
                'buttonText' => 'Создать'
            ])->render()
        ]);


    }


    public function store(NewsRequest $request)
    {
        $request->merge(['site_display' => $request->has('site_display')]);

        $news = $this->news->create($request->all());

        if ($request->has('image')) {


            $media = MediaService::upload($request->file('image'), get_class($this->news), $news->id);
            MediaService::setMainById($media->id, get_class($this->news), $news->id);
        }

        return response()->json([
            'functions' => ['closeModal'],
            'modal_for_close' => '#superLargeModal',
            'type' => 'prepend-table-row',
            'table' => '#ajaxTable',
            'content' => view('backend.content.news.item', ['item' => $news])->render()
        ]);


    }


    public function edit($itemId)
    {
        $foreign_languages = config('project.foreign_locales');
        $news = $this->news->with('mainImage', 'media')->find($itemId);

        $categories = $this->categoryService->categoriesForSelect('news');
        $medias = $news->media->chunk(2);
        $create = 0;

        return response()->json([
            'functions' => ['initEditor', 'initCrop'],
            'type' => 'updateModal',
            'modal' => '#superLargeModal',
            'modalTitle' => 'Редактирование новости',
            'modalContent' => view('backend.content.news.form', [
                'foreign_languages' => $foreign_languages,
                'create' => $create,
                'medias' => $medias,
                'news' => $news,
                'categories' => $categories,
                'formAction' => route('admin.content.news.update', ['itemId' => $itemId]),
                'buttonText' => 'Сохранить',
            ])->render()
        ]);


    }

    public function update(NewsRequest $request, $itemId)
    {
        $news = $this->news->find($itemId);

        $request->merge([
            'site_display' => ($request->has('site_display')) ? 1 : 0
        ]);

        if ($news) {
            $news->update($request->all());

            if ($request->hasFile('image')) {

                $media = MediaService::upload($request->file('image'), get_class($this->news), $itemId);

                MediaService::setMainById($media->id, get_class($this->news), $news->id);
            }
        }

        return response()->json([
            'functions' => ['updateTableRow', 'closeModal'],
            'modal_for_close' => '#superLargeModal',
            'type' => 'update-table-row',
            'table' => '#ajaxTable',
            'row' => '.row-' . $itemId,
            'content' => view('backend.content.news.item', ['item' => $news])->render()
        ]);
    }


    public function destroy($itemId)
    {
        $news = $this->news->find($itemId);

        if ($news) {
            MediaService::deleteForModel(get_class($this->news), $news->id);
            $news->delete();
        }

        return response()->json([
            'type' => 'delete-table-row',
            'table' => '#ajaxTable',
            'row' => '.row-' . $itemId,
        ]);
    }


    public function media(Request $request, int $itemId)
    {
        foreach ($request->file('image') as $image) {
            MediaService::upload($image, get_class($this->news), $itemId);
        }

        $news = $this->news->find($itemId);

        return $this->responseJson([
            'media' => view('backend.content.news.media_list', ['news' => $news,])->render(),
        ]);
    }

    public function mainMedia(int $itemId, int $mediaId)
    {
        $news = $this->news->find($itemId);
        MediaService::setMainById($mediaId, get_class($this->news), $news->id);
    }

    public function deleteMedia($mediaId)
    {
        MediaService::deleteById($mediaId);
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
                'formAction' => route('admin.content.news.image.crop.store', ['mediaId' => $media->id]),
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

        $news = $this->news->find($media->imageable_id);

        return response()->json([
            'functions' => ['closeModal', 'initCrop'],
            'type' => 'updateBlock',
            'blockForUpdate' => '.image-' . $mediaId,
            'blockForUpdateContent' => view('backend.content.news.media_item', [
                'media' => $media,
                'news' => $news
            ])->render(),
            'modal_for_close' => '#editImageModal',

        ]);
    }
}