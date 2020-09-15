<?php

namespace TaskForce\models;

abstract class Action
{
    abstract public function getActionName():string;

    abstract public function getInternalName():string;

    abstract public function validateUser(
        int $idCurrentUser = null,
        int $idContractor = null,
        int $idCustomer = null
    ):bool;
}
