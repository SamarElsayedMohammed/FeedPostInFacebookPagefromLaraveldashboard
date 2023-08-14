<?php
namespace App\DTO;

class UserDTO
{
    public string $name;
    public string $email;
    public string $password;
    public string $token;
    public string $image;
    public string $provider_app_id;
    public string $facebook_app_id;
    public string $provider;

    public function __construct(string $name, string $email, string $password, string $token, string $image, string $provider_app_id, string $facebook_app_id, string $provider)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->token = $token;
        $this->image = $image;
        $this->provider_app_id = $provider_app_id;
        $this->facebook_app_id = $facebook_app_id;
        $this->provider = $provider;
    }
}