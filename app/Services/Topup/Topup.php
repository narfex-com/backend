<?php


namespace App\Services\Topup;


class Topup
{
    private ?string $redirectUrl = null;

    public function __construct(string $redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    public function getRedirectUrl(): ?string
    {
        return $this->redirectUrl;
    }
}
