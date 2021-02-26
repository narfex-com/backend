<?php


namespace App\Http\Responses;


use App\Http\Resources\BasePaginationCollection;

class JsonResponse
{
    private array $errors = [];
    private ?string $errorCode = null;
    private int $statusCode = 200;
    private bool $isErrorResponse = false;

    public function withErrorCode(string $code): JsonResponse
    {
        $this->errorCode = $code;

        return $this;
    }

    public function withErrors(array $errors, int $statusCode = 400): JsonResponse
    {
        $this->statusCode = $statusCode;
        $this->errors = $errors;
        $this->isErrorResponse = true;

        return $this;
    }

    public function build($data = []): \Illuminate\Http\JsonResponse
    {
        $body = [];

        if ($this->isErrorResponse) {
            $body['errors'] = $this->errors;
            $body['code'] = $this->errorCode;
            return response()->json($body, $this->statusCode);
        }

        $body['data'] = $data;

        if ($data instanceof BasePaginationCollection) {
            $body['pagination'] = $data->getPaginationData();
        }

        return response()->json($body, $this->statusCode);
    }
}
