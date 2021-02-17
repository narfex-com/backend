<?php


namespace App\Http\Responses;


class JsonResponse
{
    private array $errors = [];
    private int $statusCode = 200;

    public function withErrors(array $errors, int $statusCode = 400): self
    {
        $this->statusCode = $statusCode;
        $this->errors = $errors;

        return $this;
    }

    public function withStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function build($data = []): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'errors' => $this->errors,
            'data' => $data
        ], $this->statusCode);
    }
}
