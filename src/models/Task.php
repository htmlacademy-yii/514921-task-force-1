<?php


namespace TaskForce\models;


class Task
{
    const STATUS_NEW = "new";
    const STATUS_IN_PROGRESS = "in progress";
    const STATUS_COMPLETED = "completed";
    const STATUS_CANCELED = "canceled";
    const STATUS_FAILED = "failed";

    const ACTION_CANCEL = "cancel";
    const ACTION_RESPOND = "respond";
    const ACTION_DECLINE = "decline";
    const ACTION_COMPLETE = "complete";

    private $currentStatus;
    private $idContractor;
    private $idCustomer;

    private $statusList = [
        self::STATUS_NEW => "Новое",
        self::STATUS_IN_PROGRESS => "В работе",
        self::STATUS_COMPLETED => "Выполнено",
        self::STATUS_CANCELED => "Отменено",
        self::STATUS_FAILED => "Провалено"
    ];

    private $actionsList = [
        self::ACTION_CANCEL => "Отменить",
        self::ACTION_RESPOND => "Откликнуться",
        self::ACTION_DECLINE => "Отказаться",
        self::ACTION_COMPLETE => "Выполнено"
    ];

    public function __construct($currentStatus = null, $idContractor = null, $idCustomer = null)
    {
        $this->currentStatus = $currentStatus;
        $this->idContractor = $idContractor;
        $this->idCustomer = $idCustomer;
    }

    public function getActionList() {
        $status = $this->currentStatus;
        $statusActionsMap = [
            self::STATUS_NEW => [self::ACTION_CANCEL, self::ACTION_RESPOND],
            self::STATUS_IN_PROGRESS => [self::ACTION_COMPLETE, self::ACTION_DECLINE]
        ];
        return $statusActionsMap[$status];
    }

    public function getNextStatus($action)
    {
        $actionStatusMap = [
            self::ACTION_CANCEL => self::STATUS_CANCELED,
            self::ACTION_DECLINE => self::STATUS_FAILED,
            self::ACTION_COMPLETE => self::STATUS_COMPLETED
        ];
        return $actionStatusMap[$action];
    }

}
