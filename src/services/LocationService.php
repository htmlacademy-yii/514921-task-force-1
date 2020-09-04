<?php


namespace TaskForce\services;

use frontend\models\Cities;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Yii;
use yii\caching\TagDependency;

class LocationService
{
    public function getGeoData($query)
    {
        $loginUser = Yii::$app->user->getIdentity();
        $userSelectedCity = Cities::findOne($loginUser->city_id);
        $hashKey = md5($query);
        try {
            $cached = Yii::$app->cacheRedis->get($hashKey);
        } catch (\Exception $e) {
            $cached = null;
        }

        if (!$cached) {
            $cached = $this->getGeoDataFromApi($query);
            try {
                $dependency = new TagDependency(['tags' => 'geocode']);
                Yii::$app->cacheRedis->set($hashKey, $cached, 86400, $dependency);
            } catch (\Exception $e) {
            }
        }
        $userAddress = array_filter($cached
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

        return $result;
    }

    private function getGeoDataFromApi($query)
    {
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
        return $response_data;
    }
}