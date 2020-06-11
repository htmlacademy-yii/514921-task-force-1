<?php


namespace frontend\controllers;

use frontend\models\CompletionForm;
use frontend\models\DeclineForm;
use frontend\models\Replies;
use frontend\models\ReplyForm;
use frontend\models\TaskCreateForm;
use frontend\models\Tasks;
use frontend\models\TasksFilter;
use TaskForce\models\Task;
use TaskForce\services\TaskService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class TasksController extends SecuredController
{
    public function behaviors()
    {
        $rules = parent::behaviors();
        $rule = [
            'allow' => false,
            'actions' => ['create'],
            'roles' => ['@'],
            'matchCallback' => function ($rule, $action) {
                $user = Yii::$app->user->getIdentity();
                $userRole = $user->role;
                $accessRole = Task::ROLE_CONTRACTOR;
                return $userRole === $accessRole;
            }
        ];

        array_unshift($rules['access']['rules'], $rule);

        return $rules;
    }

    public function actionIndex()
    {
        $query = Tasks::find()->alias('t')->where(['t.status' => Task::STATUS_NEW]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 5],
            'sort' => ['defaultOrder' => ['date_add' => SORT_DESC]],
        ]);

        $filter = new TasksFilter();
        $filter->load(\Yii::$app->request->get());

        if ($filter->categories) {
            $query->andWhere(['category_id' => $filter->categories]);
        }
        if ($filter->noResponse) {
            $query->joinWith('replies')
                ->andWhere(['replies.user_id' => null]);
        }
        if ($filter->remoteWork) {
            $query->andWhere(['city_id' => null]);
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

        return $this->render('index', ['dataProvider' => $dataProvider, "filter" => $filter]);
    }

    public function actionView($id)
    {
        $task = Tasks::findOne($id);
        if (!$task) {
            throw new NotFoundHttpException("Задания с id $id не существует");
        }

        $currentUser = Yii::$app->user->getIdentity();
        $currentTask = new Task(
            $task->status,
            $task->contractor_id,
            $task->customer_id
        );
        $availableActions = $currentTask->getActionList($currentUser->role);
        $replyForm = new ReplyForm();
        $postedReply = Replies::findOne(['user_id' => "{$currentUser->id}", 'task_id' => "$id"]);
        if (\Yii::$app->request->post()
            && $currentUser->role === Task::ROLE_CONTRACTOR
            && $postedReply['user_id'] !== $currentUser->id) {
            $replyForm->load(\Yii::$app->request->post());
            $taskReply = new TaskService();
            if ($taskReply->createReply($replyForm, $id)) {
                $this->redirect(["task/view/{$id}"]);
            }
        }

        if (\Yii::$app->request->post()
            && $currentUser->role === Task::ROLE_CONTRACTOR
            && $task->contractor_id === $currentUser->id) {
            $declineForm = new DeclineForm();
            if ($declineForm->decline($id,$postedReply->id)) {
                $this->redirect(Url::to(["/task/view/{$id}"]));
            }
        }

        $completionForm = new CompletionForm();
        if (\Yii::$app->request->post()
            && $currentUser->role === Task::ROLE_CUSTOMER
            && $task->customer_id === $currentUser->id) {
            $completionForm->load(\Yii::$app->request->post());
            $taskService = new TaskService();
            if ($taskService->completeTask($completionForm, $id)) {
                $this->goHome();
            }
        }

        return $this->render('view', [
            'task' => $task,
            'replyForm' => $replyForm,
            'currentUser' => $currentUser,
            'postedReply' => $postedReply,
            'completionForm' => $completionForm,
            'availableActions' => $availableActions
        ]);
    }

    public function actionCreate()
    {
        $form = new TaskCreateForm();
        if (\Yii::$app->request->post()) {
            $form->load(\Yii::$app->request->post());
            $taskService = new TaskService();
            if ($taskService->createTask($form)) {
                $this->goHome();
            }
        }

        return $this->render('create', ['model' => $form]);
    }

    public function actionConfirm($taskId, $contractorId)
    {
        $currentUser = Yii::$app->user->getIdentity();
        $task = Tasks::findOne($taskId);
        if (!$task) {
            throw new NotFoundHttpException("Задания с id $taskId не существует");
        }
        if ($task->customer_id === $currentUser->id) {
            $task->status = Task::STATUS_IN_PROGRESS;
            $task->contractor_id = $contractorId;
            $task->save();
            return $this->redirect(Url::to(["/tasks"]));
        }
    }

    public function actionRefuse($taskId, $replyId)
    {
        $currentUser = Yii::$app->user->getIdentity();
        $task = Tasks::findOne($taskId);
        if (!$task) {
            throw new NotFoundHttpException("Задания с id $taskId не существует");
        }
        $reply = Replies::findOne($replyId);
        if ($task->customer_id === $currentUser->id) {
            $reply->status = 'refused';
            $reply->save();
            return $this->redirect(Url::to(["/task/view/{$reply->task_id}"]));
        }
    }

    public function actionCancel($taskId)
    {
        $currentUser = Yii::$app->user->getIdentity();
        $task = Tasks::findOne($taskId);
        if (!$task) {
            throw new NotFoundHttpException("Задания с id $taskId не существует");
        }
        if ($task->status === 'new' && $task->customer_id === $currentUser->id) {
            $task->status = Task::STATUS_CANCELED;
            $task->save();
            return $this->redirect(Url::to(["/tasks"]));
        }
    }

}
