<?php

namespace App\Services\CBRF;

interface SerivceInterface
{
    public static function getDaily(array $params): array;
    public static function getCurrencyCode(array $params): array;
    public static function getDynamic(array $params): array;
    public static function getOStat(array $params): array;
    public static function getMetal(array $params): array;
    public static function getMKR(array $params): array;
    public static function getDEPO(array $params): array;
    public static function getNews(): array;
    public static function getBIC(array $params): array;
    public static function getSwap(array $params): array;
    public static function getCoinsBase(array $params): array;
}