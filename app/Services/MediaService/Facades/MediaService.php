<?php

namespace App\Services\MediaService\Facades;

use Illuminate\Support\Facades\Facade;

class MediaService extends Facade {

    /**
     * @return string
     */
    protected static function getFacadeAccessor() { return 'MediaService'; }

}