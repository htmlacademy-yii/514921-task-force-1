<?php

namespace frontend\controllers;

use TaskForce\services\LocationService;
use yii\web\Response;

class LocationController extends SecuredController
{
    public function actionIndex(string $query): Response
    {
        $LocationService = new LocationService();
        $data = $LocationService->getGeoData($query);
        return $this->asJson($data);
    }

}