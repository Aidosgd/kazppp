<?php

namespace App\Services\UploaderService\Facades;

use Illuminate\Support\Facades\Facade;

class UploaderService extends Facade {

    /**
     * @return string
     */
    protected static function getFacadeAccessor() { return 'UploaderService'; }

}