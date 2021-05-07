<?php

declare(strict_types = 1);

namespace App\Services\CBRF;

use Illuminate\Http\Request;
use App\Exceptions\ErrorException;

class CBRFSerivce extends AbstractService implements SerivceInterface
{

    /**
     * @param $params
     * @return mixed
     */
    public static function getDaily(array $params): array {
        return self::query(self::DAILY, $params);
    }

    /**
     * @param $params
     * @return mixed
     */
    public static function getCurrencyCode(array $params): array {
        return self::query(self::CURRENCY_CODE, $params);
    }

    /**
     * @param $params
     * @return mixed
     */
    public static function getDynamic(array $params): array {
        return self::query(self::DYNAMIC, $params);
    }

    /**
     * @param $params
     * @return mixed
     */
    public static function getOStat(array $params): array {
        return self::query(self::OSTAT, $params);
    }

    /**
     * @param $params
     * @return mixed
     */
    public static function getMetal(array $params): array {
        return self::query(self::METAL, $params);
    }

    /**
     * @param $params
     * @return mixed
     */
    public static function getMKR(array $params): array {
        return self::query(self::MKR, $params);
    }

    /**
     * @param $params
     * @return mixed
     */
    public static function getDEPO(array $params): array {
        return self::query(self::DEPO, $params);
    }

    /**
     * @return mixed
     */
    public static function getNews():array {
        return self::query( self::NEWS, []);
    }

    /**
     * @param $params
     * @return mixed
     */
    public static function getBIC(array $params): array {
        return self::query( self::BIC, $params);
    }

    /**
     * @param $params
     * @return mixed
     */
    public static function getSwap(array $params): array {
        return self::query(self::SWAP, $params);
    }

    /**
     * @param $params
     * @return mixed
     */
    public static function getCoinsBase(array $params): array {
        return self::query( self::COINBASE, $params);
    }

}