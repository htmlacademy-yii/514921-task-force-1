<?php


namespace TaskForce\models;


class ActionCancel extends Action
{
    const INTERNAL_NAME = "cancel";
    const ACTION_NAME = "Отменить";

    public function getActionName()
    {
        return self::ACTION_NAME;
    }

    public function getInternalName()
    {
        return self::INTERNAL_NAME;
    }

    public function validateUser($idCurrentUser = null, $idContractor = null, $idCustomer = null)
    {
        if ($idCurrentUser ===  $idCustomer) {
            return true;
        }
        return false;
    }
}
