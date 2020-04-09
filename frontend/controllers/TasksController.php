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

        if ($filter->categories) {
            $query->andWhere(['category_id' => $filter->categories]);
        }
        if ($filter->noResponse) {
            $query->joinWith('replies')
                ->andWhere(['replies.user_id' => NULL]);
        }
        if ($filter->remoteWork) {
            $query->andWhere(['city_id' => NULL]);
        }
        if ($filter->search) {
            $query->andWhere(['LIKE', 'tasks.name', $filter->search]);
        }
        switch ($filter->period) {
            case '1 day':
                $query->andWhere(['>', 'tasks.date_add', date("Y-m-d H:i:s", strtotime("- 1 day"))]);
                break;
            case '1 week':
                $query->andWhere(['>', 'tasks.date_add', date("Y-m-d H:i:s", strtotime("- 1 week"))]);
                break;
            case '1 month':
                $query->andWhere(['>', 'tasks.date_add', date("Y-m-d H:i:s", strtotime("- 1 month"))]);
                break;
        }

        $tasks = $query->addOrderBy(['date_add'=> SORT_DESC])->all();
        return $this->render('index', ["tasks"=>$tasks, "filter"=>$filter]);
    }
}