<?php

namespace App\Message;

final class StatusHasChanged
{
    private string $email;
    private string $code;
    private string $status;

    public function __construct(string $email, string $code, string $status)
    {
        $this->email = $email;
        $this->code = $code;
        $this->status = $status;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
