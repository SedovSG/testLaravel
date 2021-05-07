<?php

declare(strict_types = 1);

namespace App\Services\CBRF;

class AbstractService
{
    const CURRENCY_CODE = 'http://www.cbr.ru/scripts/XML_valFull.asp';
    const COINBASE      = 'http://www.cbr.ru/scripts/XMLCoinsBase.asp';
    const DYNAMIC       = 'http://www.cbr.ru/scripts/XML_dynamic.asp';
    const DAILY         = 'http://www.cbr.ru/scripts/XML_daily.asp';
    const OSTAT         = 'http://www.cbr.ru/scripts/XML_ostat.asp';
    const METAL         = 'http://www.cbr.ru/scripts/xml_metall.asp';
    const DEPO          = 'http://www.cbr.ru/scripts/xml_depo.asp';
    const NEWS          = 'http://www.cbr.ru/scripts/XML_News.asp';
    const SWAP          = 'http://www.cbr.ru/scripts/xml_swap.asp';
    const MKR           = 'http://www.cbr.ru/scripts/xml_mkr.asp';
    const BIC           = 'http://www.cbr.ru/scripts/XML_bic.asp';

    /**
     * Метод осуществляет запрос к сервису ЦБ РФ.
     * 
     * @param $url
     * @param array $params
     * 
     * @return array|mixed
     */
    protected static function query(string $url, array $params = []): array
    {
        $data = [];

        try {
            $xml = simplexml_load_file($url . '?' . http_build_query($params));
            $json = json_encode($xml);
            $data = json_decode($json, true);
        } catch (\Exception $e) {
            $data = ['error' => $e->getMessage()];
        }

        return $data;
    }
}