<?php

namespace App\Helpers;

use Carbon\Carbon;

class GeneralHelper {

    /**
     * @return string
     */
    public static function generateId(): string {
        return Carbon::now('Asia/Manila')->isoFormat('YYYYMMDD-HHmmssSS');
    }
}
