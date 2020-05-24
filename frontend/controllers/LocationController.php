<?php

namespace frontend\controllers;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Yii;

class LocationController extends SecuredController
{
    public function actionIndex($query)
    {
        $api_key = Yii::$app->params['apiKey'];
        $answerFormat = RequestOptions::JSON;
        $geocode = $query;

        $client = new Client(['base_uri' => 'https://geocode-maps.yandex.ru/']);

        $response = $client->request('GET','1.x/', ['query' => [
                'apikey' => $api_key,
                'format' => $answerFormat,
                'geocode' => $geocode,
            ]]
        );

        $content = $response->getBody()->getContents();
        $response_data = json_decode($content, true);

        $result = array_map(function ($item) {
            return [
                'title' => $item['GeoObject']['metaDataProperty']['GeocoderMetaData']['text'],
                'coordinates' => $item['GeoObject']['Point']['pos'],
            ];
        }, $response_data['response']['GeoObjectCollection']['featureMember']);

        return $this->asJson($result);
    }
}