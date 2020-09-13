<?php

namespace TaskForce\models;

class ActionComplete extends Action
{
    const INTERNAL_NAME = "complete";
    const ACTION_NAME = "Выполнено";

    public function getActionName():string
    {
        return self::ACTION_NAME;
    }

    public function getInternalName():string
    {
        return self::INTERNAL_NAME;
    }

    public function validateUser(int $idCurrentUser = null, int $idContractor = null, int $idCustomer = null):bool
    {
        if ($idCurrentUser ===  $idCustomer) {
            return true;
        }
        return false;
    }
}
