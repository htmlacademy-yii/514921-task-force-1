<?php

namespace frontend\controllers;

use frontend\models\Cities;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Yii;
use yii\caching\TagDependency;

class LocationController extends SecuredController
{
    public function actionIndex($query)
    {
        $loginUser = Yii::$app->user->getIdentity();
        $userSelectedCity = Cities::findOne($loginUser->city_id);
        $hashKey = md5($query);
        try {
            $redisConnectionCheck = Yii::$app->redis->ping();
        } catch (\yii\db\Exception $e) {
            $api_key = Yii::$app->params['apiKey'];
            $answerFormat = RequestOptions::JSON;
            $geocode = $query;

            $client = new Client(['base_uri' => 'https://geocode-maps.yandex.ru/']);

            $response = $client->request(
                'GET',
                '1.x/',
                [
                    'query' => [
                        'apikey' => $api_key,
                        'format' => $answerFormat,
                        'geocode' => $geocode,
                    ]
                ]
            );

            $content = $response->getBody()->getContents();
            $response_data = json_decode($content, true);

            $filteredAddresses = array_filter($response_data
            ['response']['GeoObjectCollection']['featureMember'], function ($data) use ($userSelectedCity) {
                foreach ($data['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['Components'] as $value) {
                    if (in_array("locality", $value)) {
                        return $value['name'] === $userSelectedCity->name;
                    }
                }
            });

            $result = array_map(function ($item) {
                return [
                    'title' => $item['GeoObject']['metaDataProperty']['GeocoderMetaData']['text'],
                    'coordinates' => $item['GeoObject']['Point']['pos'],
                ];
            }, $filteredAddresses);

            return $this->asJson($result);
        }
        if ($redisConnectionCheck) {
            $cacheData = Yii::$app->cacheRedis->get($hashKey);
            if ($cacheData) {
                $cacheAddress = json_decode($cacheData, true);
                $userAddress = array_filter($cacheAddress
                ['response']['GeoObjectCollection']['featureMember'], function ($data) use ($userSelectedCity) {
                    foreach ($data['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['Components'] as $value) {
                        if (in_array("locality", $value)) {
                            return $value['name'] === $userSelectedCity->name;
                        }
                    }
                });

                $result = array_map(function ($item) {
                    return [
                        'title' => $item['GeoObject']['metaDataProperty']['GeocoderMetaData']['text'],
                        'coordinates' => $item['GeoObject']['Point']['pos'],
                    ];
                }, $userAddress);
                return $this->asJson($result);
            } else {
                $api_key = Yii::$app->params['apiKey'];
                $answerFormat = RequestOptions::JSON;
                $geocode = $query;

                $client = new Client(['base_uri' => 'https://geocode-maps.yandex.ru/']);

                $response = $client->request(
                    'GET',
                    '1.x/',
                    [
                        'query' => [
                            'apikey' => $api_key,
                            'format' => $answerFormat,
                            'geocode' => $geocode,
                        ]
                    ]
                );

                $content = $response->getBody()->getContents();
                $dependency= new TagDependency(['tags' => 'geocode']);
                Yii::$app->cacheRedis->set($hashKey, $content, 86400, $dependency);

                $response_data = json_decode($content, true);
                $filteredAddresses = array_filter($response_data
                ['response']['GeoObjectCollection']['featureMember'], function ($data) use ($userSelectedCity) {
                    foreach ($data['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['Components'] as $value) {
                        if (in_array("locality", $value)) {
                            return $value['name'] === $userSelectedCity->name;
                        }
                    }
                });

                $result = array_map(function ($item) {
                    return [
                        'title' => $item['GeoObject']['metaDataProperty']['GeocoderMetaData']['text'],
                        'coordinates' => $item['GeoObject']['Point']['pos'],
                    ];
                }, $filteredAddresses);

                return $this->asJson($result);
            }
        }
    }
}