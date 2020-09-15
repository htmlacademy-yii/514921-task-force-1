<?php


namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\CompletionForm;
use frontend\models\Replies;
use frontend\models\ReplyForm;
use frontend\models\TaskCreateForm;
use frontend\models\Tasks;
use frontend\models\TasksFilter;
use TaskForce\helpers\UrlHelper;
use TaskForce\models\Task;
use TaskForce\services\EventService;
use TaskForce\services\FilterService;
use TaskForce\services\TaskService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class TasksController extends SecuredController
{
    public function behaviors(): array
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

    public function actionIndex(): string
    {
        $currentUser = Yii::$app->user->getIdentity();
        $userSessionCity = Yii::$app->session->get('city_id');
        $query = Tasks::find()->alias('t')->where(['t.status' => Task::STATUS_NEW]);

        if (!$userSessionCity) {
            $query->andWhere('city_id = :userProfileCity AND t.status = :status', [
                ':status' => Task::STATUS_NEW,
                ':userProfileCity' => $currentUser->city_id]);
        } else {
            $query->andWhere('city_id = :userSessionCity AND t.status = :status', [
                ':status' => Task::STATUS_NEW,
                ':userSessionCity' => $userSessionCity]);
        }

        $query->orWhere(['and',
            ['city_id' => null],
            ['t.status' => Task::STATUS_NEW]
        ]);

        $filter = new TasksFilter();
        $filter->load(\Yii::$app->request->get());

        $categoriesFilter = new FilterService();

        $dataProvider = new ActiveDataProvider([
            'query' => $categoriesFilter->applyCategoriesFilter($filter, $query),
            'pagination' => ['pageSize' => 5],
            'sort' => ['defaultOrder' => ['date_add' => SORT_DESC]],
        ]);

        $categoriesDataProvider = new ActiveDataProvider([
            'models' => Categories::find()->select('name')->indexBy('id')->column(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider, "filter" => $filter, 'categories' => $categoriesDataProvider]);
    }

    public function actionView(int $id): string
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
        $postedReply = Replies::findOne(['user_id' => "{$currentUser->id}", 'task_id' => "$id"]);

        return $this->render('view', [
            'task' => $task,
            'replyForm' => new ReplyForm(),
            'currentUser' => $currentUser,
            'postedReply' => $postedReply,
            'completionForm' => new CompletionForm(),
            'availableActions' => $availableActions
        ]);
    }

    public function actionDecline(int $id): void
    {
        $task = Tasks::findOne($id);
        $currentUser = Yii::$app->user->getIdentity();
        $postedReply = Replies::findOne(['user_id' => "{$currentUser->id}", 'task_id' => "$id"]);
        if (\Yii::$app->request->post()
            && $currentUser->role === Task::ROLE_CONTRACTOR
            && $task->contractor_id === $currentUser->id) {
            $taskService = new TaskService();
            if ($taskService->declineTask($id, $postedReply->id)) {
                $this->redirect(Url::to(["/task/view/{$id}"]));
            }
        }
    }

    public function actionComplete(int $id): void
    {
        $task = Tasks::findOne($id);
        $currentUser = Yii::$app->user->getIdentity();
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
    }

    public function actionReply(int $id): void
    {
        $currentUser = Yii::$app->user->getIdentity();
        $postedReply = Replies::findOne(['user_id' => "{$currentUser->id}", 'task_id' => "$id"]);
        $replyForm = new ReplyForm();
        if (\Yii::$app->request->post()
            && $currentUser->role === Task::ROLE_CONTRACTOR
            && $postedReply['user_id'] !== $currentUser->id) {
            $replyForm->load(\Yii::$app->request->post());
            $taskReply = new TaskService();
            if ($taskReply->createReply($replyForm, $id)) {
                $this->redirect(["task/view/{$id}"]);
            }
        }
    }

    public function actionCreate(): string
    {
        $categoriesDataProvider = new ActiveDataProvider([
                'models' => Categories::find()->select('name')->indexBy('id')->column(),
            ]);
        $form = new TaskCreateForm();
        if (\Yii::$app->request->post()) {
            $form->load(\Yii::$app->request->post());
            $taskService = new TaskService();
            $taskId = $taskService->createTask($form);
            if ($taskId) {
                $this->redirect(UrlHelper::getTaskUrl($taskId));
            }
        }

        return $this->render('create', ['model' => $form,
            'categories' => $categoriesDataProvider
        ]);
    }

    public function actionConfirm(int $taskId, int $contractorId): Response
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
            $newEvent = new EventService();
            $newEvent->createEventStartTask($task);
            return $this->redirect(Url::to(["/tasks"]));
        }
    }

    public function actionRefuse(int $taskId, int $replyId): Response
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

    public function actionCancel(int $taskId): Response
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
