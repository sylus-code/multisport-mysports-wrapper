<?php

namespace SylusCode\MultiSport\MysportsWrapper\Api;

interface CookieAuthenticatorInterface
{
    public function getCookie(): Cookie;
}