<?php


namespace TaskForce\models;


class ActionRespond extends Action
{
    const INTERNAL_NAME = "respond";
    const ACTION_NAME = "Откликнуться";

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
        if ($idCurrentUser ===  $idContractor) {
            return true;
        }
        return false;
    }
}
