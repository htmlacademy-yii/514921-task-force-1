<?php


namespace TaskForce\models;


class ActionDecline extends Action
{
    const INTERNAL_NAME = "decline";
    const ACTION_NAME = "Отказаться";

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
        if ($idCurrentUser ===  $idContractor) {
            return true;
        }
        return false;
    }
}
