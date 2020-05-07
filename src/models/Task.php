<?php


namespace TaskForce\models;


use TaskForce\exceptions\RoleNameException;
use TaskForce\exceptions\StatusNameException;

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
    const ROLE_CUSTOMER = "customer";
    const ROLE_CONTRACTOR = "contractor";

    private $currentStatus;
    private $idCurrentUser;
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

    public function __construct(string $currentStatus = null, int $idContractor = null,
                                int $idCustomer = null, int $idCurrentUser = null)
    {
        if (!array_key_exists($currentStatus, $this->statusList)) {
            throw new StatusNameException("Переданный статус отсутсвует");
        }
        $this->currentStatus = $currentStatus;
        $this->idCurrentUser = $idCurrentUser;
        $this->idContractor = $idContractor;
        $this->idCustomer = $idCustomer;
    }

    public function getActionList(string $nameRole):array {
        $status = $this->currentStatus;
        if ($nameRole !== self::ROLE_CUSTOMER && $nameRole !== self::ROLE_CONTRACTOR) {
            throw new RoleNameException("Такой роли не существует");
        }
        if ($nameRole === self::ROLE_CUSTOMER) {
            $statusActionsMap = [
                self::STATUS_NEW => [self::ACTION_CANCEL],
                self::STATUS_IN_PROGRESS => [self::ACTION_COMPLETE],
                self::STATUS_COMPLETED => [],
                self::STATUS_CANCELED => []
            ];
        } else {
            $statusActionsMap = [
                self::STATUS_NEW => [self::ACTION_RESPOND],
                self::STATUS_IN_PROGRESS => [self::ACTION_DECLINE],
            ];
        }
        return $statusActionsMap[$status];
    }

    public function getNextStatus(string $action):string
    {
        $actionStatusMap = [
            self::ACTION_CANCEL => self::STATUS_CANCELED,
            self::ACTION_DECLINE => self::STATUS_FAILED,
            self::ACTION_COMPLETE => self::STATUS_COMPLETED,
            self::ACTION_RESPOND => self::STATUS_IN_PROGRESS
        ];
        return $actionStatusMap[$action];
    }

}
