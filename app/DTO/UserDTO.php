<?php

namespace App\DTO;

use Illuminate\Support\Arr;

class UserDTO
{
    public readonly  string $name;
    public readonly string $email;
    public readonly string $password;

    // todo: it can save redundant data (if you didn't get what I mean ask me please)
    public function __construct(public readonly array $data)
    {
        $this->name = Arr::get($this->data, 'name');
        $this->email = Arr::get($this->data, 'email');
        $this->password = Arr::get($this->data, 'password');
    }
}
