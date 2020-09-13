<?php

namespace TaskForce\models;

class ActionCancel extends Action
{
    const INTERNAL_NAME = "cancel";
    const ACTION_NAME = "Отменить";

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
