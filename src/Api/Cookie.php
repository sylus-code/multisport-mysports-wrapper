<?php

namespace SylusCode\MultiSport\MysportsWrapper\Api;

class Cookie
{
    const MYSPORTS_ID_KEY = "mysports_id";
    private $name;
    private $value;

    public function __construct(string $name, string $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public static function createFromRaw(string $rawValue): ?self
    {
        $whereToStart = strlen(self::MYSPORTS_ID_KEY) + 1;
        $token = substr($rawValue, $whereToStart);
        return new self(self::MYSPORTS_ID_KEY, $token);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}