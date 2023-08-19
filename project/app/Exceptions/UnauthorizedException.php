<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;

class UnauthorizedException extends Exception {
    /**
     * @param string $message
     * @param string $description
     */
    public function __construct(string $message = 'Unauthorized', string $description = 'Unauthorized') {
        parent::__construct(JsonResponse::HTTP_UNAUTHORIZED, 'unauthorized', $message, $description);
    }
}
