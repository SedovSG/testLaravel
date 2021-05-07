<?php

declare(strict_types = 1);

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Services\CBRF\SerivceInterface;
use App\Exceptions\ErrorException;
use App\Models\Currencies;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class CurrenciesController extends Controller
{

	/**
	 * Метод получает курсы валют.
	 * 
	 * Если отсутствуют курсы валют на запрашиваемую дату, то осуществляется запрос к сервису ЦБ РФ,
	 * с последующим сохранением в БД.
	 *
	 * @param string $date            Фильтрация по дате
	 * @param SerivceInterface $cbrf  Сервис ЦБ РФ
	 * 
	 * @return Illuminate\Http\JsonResponse
	 */
	public function getCurrencies(string $date = '', SerivceInterface $cbrf): \Illuminate\Http\JsonResponse
	{
		$currency = new Currencies;

		$dateEn = $date ?: date('Y-m-d');

		try {
			$data = $currency->getItems($dateEn);
		} catch (\Exception $e) {
			throw new ErrorException($e->getMessage());
		}		

		if(count($data) === 0) {
			$dateRu = date('d.m.Y', \strtotime($dateEn));

			try {
				$cbrfData = $cbrf::getDaily(['date_req' => $dateRu]);
				$data = $currency->saveItems($cbrfData, $dateEn);
			} catch (\Exception $e) {
				throw new ErrorException($e->getMessage());
			}
		}
		
		$dataResponse = [
    		'code' => Response::HTTP_OK,
    		'message' => 'OK',
			'data' => $data,
    	];

		return response()->json($dataResponse, Response::HTTP_OK);
	}

	/**
	 * Метод получает курс валюты по её коду.
	 *
	 * @param string $charCode Код валюты
	 * @param string $date     Дата
	 * 
	 * @return Illuminate\Http\JsonResponse
	 */
	public function getCurrency(string $charCode, string $date = ''): \Illuminate\Http\JsonResponse
	{
		$currency = new Currencies;

		$dateEn = $date ?: date('Y-m-d');

		try {
			$data = $currency->getItem($charCode, $dateEn);
		} catch (\Exception $e) {
			throw new ErrorException($e->getMessage());
		}	

		$dataResponse = [
    		'code' => Response::HTTP_OK,
    		'message' => 'OK',
			'data' => $data,
    	];

		return response()->json($dataResponse, Response::HTTP_OK);
	}

	/**
	 * Метод добавляет описание к курсу валюты.
	 *
	 * @param Request $request
	 * @param integer $id
	 * 
	 * @return Illuminate\Http\JsonResponse
	 */
	public function saveDescribeCurrency(Request $request, int $id): \Illuminate\Http\JsonResponse
	{
		$currency = new Currencies;

		$validated = $request->validate([
			'describe' => 'max:255'
		]);

		try {
			$data = $currency->saveItem($validated, $id);
		} catch (\Exception $e) {
			throw new ErrorException($e->getMessage());
		}

		$dataResponse = [
    		'code' => Response::HTTP_OK,
    		'message' => 'OK',
			'data' => $data,
    	];

		return response()->json($dataResponse, Response::HTTP_OK);
	}

}
