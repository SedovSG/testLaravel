<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Currencies extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'num_code',
        'char_code',
        'nominal',
        'name',
        'value',
        'describe',
        'date',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
        'created_at',
    ];
    
    /**
     * Метод получает все доступные записи по дате добавления.
     *
     * @param string $date Дата
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getItems(string $date): \Illuminate\Database\Eloquent\Collection
    {
        return Currencies::where('date', 'LIKE', '%' . $date . '%')->get();
    }

    /**
     * Метод получает запись по коду валюты и дате добавления.
     *
     * @param string $charCode  Код валюты
     * @param string $date      Дата
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getItem(string $charCode, string $date): \Illuminate\Database\Eloquent\Collection
    {
        return Currencies::where([
            ['char_code', $charCode],
            ['date', $date]
        ])->get();
    }

    /**
     * Метод сохраняет записи в БД.
     *
     * @param array $data  Данные от сервиса ЦБ РФ
     * @param string $date     Дата
     * 
     * @return array
     */
    public function saveItems(array $data, string $date): array
    {
        if(empty($data)) {
            return [];
        }

        foreach ($data['Valute'] as $val) {
            $items[] = $this->create([
                'num_code' => $val['NumCode'],
                'char_code' => $val['CharCode'],
                'nominal' => $val['Nominal'],
                'name' => $val['Name'],
                'value' => $val['Value'],
                'date' => $date,
            ]);
        }
        
        return $items;
    }

    /**
     * Метод сохраняет описание к записи, по её идентификатору.
     *
     * @param array $data
     * @param integer $id
     * 
     * @return int
     */
    public function saveItem(array $data, int $id): int
    {
        return $this->whereId($id)->update(['describe' => $data['describe']]);
    }
}
