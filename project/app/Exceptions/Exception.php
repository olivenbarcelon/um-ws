<?php

namespace App\Exceptions;

use Exception as BaseException;
use Throwable;
use Illuminate\Http\JsonResponse;

class Exception extends BaseException {
    protected $code;
    private $error;
    protected $message;
    private $description;

    /**
     * @param integer $code
     * @param string $error
     * @param string $message
     * @param string $description
     * @param Throwable|null $previous
     */
    public function __construct(
        int $code = 0,
        string $error = 'unexpected_error',
        string $message = 'Unexpected Error',
        string $description = 'Unexpected Error',
        Throwable $previous = null
    ) {
        $this->error = $error;
        $this->description = $description;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getError(): string {
        return $this->error;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse {
        $response = [
            'code' => $this->getCode(),
            'error' => $this->getError(),
            'message' => $this->getMessage(),
            'description' => $this->getDescription(),
        ];

        return response()->json($response, $this->getCode() ?? 400);
    }
}
