<?php

namespace App\Helpers;

use Carbon\Carbon;

/**
 * @since PHP 8.0.24
 * @since Created At: 2022.10.27
 * @since Updated At: 2022.11.09
 * @version 0.0.2 Add generate ID
 * @version 0.0.1
 * @author <a href="https://olivenbarcelon.github.io">Oliven C. Barcelon</a>
 */
class GeneralHelper {
    /**
     * Generate ID from timestamp
     * @return string
     * @since PHP 8.0.24
     * @since Created At: 2022.11.09
     * @version 0.0.1
     * @author <a href="https://olivenbarcelon.github.io">Oliven C. Barcelon</a>
     */
    public static function generateId(): string {
        return Carbon::now('Asia/Manila')->isoFormat('YYYYMMDD-HHmmssSS');
    }
}
