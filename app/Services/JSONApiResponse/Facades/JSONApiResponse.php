<?php

namespace App\Services\JSONApiResponse\Facades;

use Illuminate\Support\Facades\Facade;

class JSONApiResponse extends Facade {

    /**
     * @return string
     */
    protected static function getFacadeAccessor() { return 'JSON'; }

}