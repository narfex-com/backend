<?php


namespace App\Services\Topup;


class Topup
{
    private string $redirectUrl;
    private int $id;

    public function __construct(int $id, string $redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
        $this->id = $id;
    }

    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


}
