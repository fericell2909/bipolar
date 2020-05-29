<?php

namespace App\Http\Services;

use Goutte\Client;
use Zttp\Zttp;
use Zttp\ZttpResponse;

class BsaleCrawler
{
    /**
     * @param string $searchText
     * @param int $page
     * @return ZttpResponse
     */
    /*
          Ej:
          [
              'search' => [
                  [
                      "variante_producto" =>
                      [
                          "codigo_barras" => "1750131200243"
                          "permite_stock_negativo" => 0
                          "stock_variante" => 0.0
                          "nombre" => "122 CELESTE & NEGRO 35"
                          "nombre_sin_sku" => "122 CELESTE & NEGRO 35"
                          "stock_ilimitado" => 0
                          "permite_decimal" => "0"
                          "id_variante_producto" => 3975
                      ]
              ]
          ]
         */
    public static function search(string $searchText, int $page = 1)
    {
        $client = new Client();
        $client->request('GET', 'https://login.bsale.com.pe');
        $client->submitForm('btn-sing-in', [
            'username' => config('bsale.user_email'),
            'password' => sha1(config('bsale.user_pass')),
        ]);
        $client->submitForm('btn-join', ['cpn' => "18579"]);
        $cookies = $client->getCookieJar()->allValues('https://app.bsale.com.pe');

        $cookiesString = \Cache::get('bsale_cookies', '');
        if ($cookiesString === '') {
            foreach ($cookies as $cookieKey => $cookieValue) {
                $cookiesString = "{$cookiesString} {$cookieKey}=${cookieValue};";
            }
            \Cache::put('bsale_cookies', $cookiesString, 300);
        }

        $response = Zttp::asJson()->withHeaders(['Cookie' => $cookiesString])
            ->get('https://app.bsale.com.pe/pos_mobile/find_attr', [
                'q'               => $searchText,
                'page'            => $page,
                'id_lista_precio' => config('bsale.price_list_pen'),
            ]);

        return $response;
    }
}
