<?php


namespace frontend\controllers;

use app\models\Tasks;
use app\models\TasksFilter;
use TaskForce\models\Task;
use yii\web\Controller;

class TasksController extends Controller
{
    public function actionIndex()
    {

        $query = Tasks::find()->where(['status' => Task::STATUS_NEW]);

        $filter = new TasksFilter();
        $filter->load(\Yii::$app->request->get());

        foreach ($filter as $key => $data) {
            if ($data) {
            switch ($key) {
                case 'categories':
                    $query->andWhere(['category_id' => $data]);
                    break;
                case 'noResponse':
                    $query->joinWith('replies');
                    $query->andWhere(['replies.user_id' => NULL]);
                    break;
                case 'remoteWork':
                    $query->andWhere(['city_id' => NULL]);
                    break;
                case 'search':
                    $query->andWhere(['LIKE', 'tasks.name', $data]);
                    break;
                }
            }
        }

        $tasks = $query->addOrderBy(['date_add'=> SORT_DESC])->all();
        return $this->render('index', ["tasks"=>$tasks, "filter"=>$filter]);
    }
}