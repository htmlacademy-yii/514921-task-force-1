<?php


namespace TaskForce\models;


class ActionRespond extends Action
{
    const INTERNAL_NAME = "respond";
    const ACTION_NAME = "Откликнуться";

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
