<?php

namespace frontend\controllers;

use TaskForce\services\LocationService;

class LocationController extends SecuredController
{
    public function actionIndex($query)
    {
        $LocationService = new LocationService();
        $data = $LocationService->getCacheGeoData($query);
        return $this->asJson($data);
    }

}