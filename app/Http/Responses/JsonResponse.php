<?php


namespace App\Http\Responses;


use App\Http\Resources\BasePaginationCollection;

class JsonResponse
{
    private array $errors = [];
    private ?string $errorCode = null;
    private int $statusCode = 200;

    public function withErrors(array $errors, int $statusCode = 400, ?string $errorCode = null): self
    {
        $this->statusCode = $statusCode;
        $this->errors = $errors;
        $this->errorCode = $errorCode;

        return $this;
    }

    public function build($data = []): \Illuminate\Http\JsonResponse
    {
        $body = [];

        if ($this->errors) {
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
