<?php


namespace TaskForce\models;


abstract class Action
{
    abstract public function getActionName();

    abstract public function getInternalName();

    abstract public function validateUser(int $idCurrentUser,int $idContractor,int $idCustomer);
}
