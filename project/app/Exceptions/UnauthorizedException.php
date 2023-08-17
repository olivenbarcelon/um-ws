<?php

namespace App\Exceptions;

class UnauthorizedException extends Exception {
    /**
     * @param string $message
     * @param string $description
     */
    public function __construct(string $message = 'Unauthorized', string $description = 'Unauthorized') {
        parent::__construct(401, 'unauthorized', $message, $description);
    }
}
