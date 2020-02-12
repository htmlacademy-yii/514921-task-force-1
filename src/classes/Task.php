<?php


namespace TaskForce\classes;


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
        $result = [];
        $status = $this->currentStatus;
        $statusActionsMap = [
            self::STATUS_NEW => [self::ACTION_CANCEL, self::ACTION_RESPOND],
            self::STATUS_IN_PROGRESS => [self::ACTION_COMPLETE, self::ACTION_DECLINE]
        ];
        switch ($status) {
            case self::STATUS_IN_PROGRESS:
                return $result = $statusActionsMap[self::STATUS_IN_PROGRESS];
            case self::STATUS_NEW:
                return $result = $statusActionsMap[self::STATUS_NEW];
            default:
                return "Статус не установлен";
        }
    }

    public function getNextStatus($action)
    {
        $actionStatusMap = [
            self::ACTION_CANCEL => self::STATUS_CANCELED,
            self::ACTION_DECLINE => self::STATUS_FAILED,
            self::ACTION_COMPLETE => self::STATUS_COMPLETED
        ];
        switch ($action) {
            case self::ACTION_CANCEL:
                return $result = $actionStatusMap[self::ACTION_CANCEL];
            case self::ACTION_DECLINE:
                return $result = $actionStatusMap[self::ACTION_DECLINE];
            case self::ACTION_COMPLETE:
                return $result = $actionStatusMap[self::ACTION_COMPLETE];
            default:
                return "Действие не выбрано";
        }
    }

}
