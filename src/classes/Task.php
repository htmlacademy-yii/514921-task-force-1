<?php


namespace TaskForce\classes;


class Task
{
    const STATUS_NEW = "new";
    const STATUS_IN_PROGRESS = "in progress";
    const STATUS_COMPLETED = "completed";
    const STATUS_CANCELED = "canceled";
    const STATUS_FAILED = "failed";

    const CANCEL = "cancel";
    const RESPOND = "respond";
    const DECLINE = "decline";

    private $currentStatus;
    private $idContractor;
    private $idCustomer;

    private $map = [
        "new" => "Новое",
        "in progress" => "В работе",
        "completed" => "Выполнено",
        "canceled" => "Отменено",
        "failed" => "Провалено",
        "cancel" => "Отменить",
        "respond" => "Откликнуться",
        "decline" => "Отказаться"
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
        $map = $this->map;
        switch ($status) {
            case "inProgress":
                return $result = (array_filter($map, function($value) {
                    return $value === "completed" || $value == "decline";
                }, ARRAY_FILTER_USE_KEY));
                break;
            case "new":
                return $result = (array_filter($map, function($value) {
                    return $value === "cancel" || $value == "respond";
                }, ARRAY_FILTER_USE_KEY));
                break;
            default:
                return "Статус не установлен";
        }
    }

    public function getNextStatus($action)
    {
        $map = $this->map;
        switch ($action) {
            case "cancel":
                return $result = (array_filter($map, function($value) {
                    return $value === "canceled";
                }, ARRAY_FILTER_USE_KEY));
                break;
            case "decline":
                return $result = (array_filter($map, function($value) {
                    return $value === "failed";
                }, ARRAY_FILTER_USE_KEY));
                break;
            default:
                return "Действие не выбрано";
        }
    }

}
