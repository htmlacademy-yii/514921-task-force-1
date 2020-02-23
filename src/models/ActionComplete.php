<?php


namespace TaskForce\models;


class ActionComplete extends Action
{
    const INTERNAL_NAME = "complete";
    const ACTION_NAME = "Выполнено";

    public function getActionName()
    {
        return self::ACTION_NAME;
    }

    public function getInternalName()
    {
        return self::INTERNAL_NAME;
    }

    public function validateUser($idCurrentUser, $idContractor, $idCustomer)
    {
        if ($idCurrentUser ===  $idCustomer) {
            return true;
        }
        return false;
    }
}
