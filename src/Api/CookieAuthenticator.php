<?php

namespace SylusCode\MultiSport\MysportsWrapper\Api;

use GuzzleHttp\Client;

class CookieAuthenticator implements CookieAuthenticatorInterface
{
    const URL = 'https://mysports.tomtom.com/service/webapi/v2/auth/user/login';

    private $client;
    private $email;
    private $password;

    public function __construct(Client $client, string $email, string $password)
    {
        $this->client = $client;
        $this->email = $email;
        $this->password = $password;
    }

    public function getCookie(): Cookie
    {
        $response = $this->client->request('POST', self::URL, [
            'json' => [
                'email' => $this->email,
                'password' => $this->password
            ]
        ]);
        $cookie = $response->getHeader("Set-Cookie");
        $exploded = explode(';', $cookie[0]);

        return Cookie::createFromRaw($exploded[0]);
    }
}
