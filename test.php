<?php

require_once "vendor/autoload.php";

use TaskForce\exceptions\RoleNameException;
use TaskForce\exceptions\StatusNameException;
use TaskForce\models\Task;

$task1 = new Task("new");
$task2 = new Task("in progress");
print_r($task1->getActionList(Task::ROLE_CUSTOMER));
echo '<br/>';

$actionsStatusNew = $task1->getActionList(Task::ROLE_CUSTOMER);
$actionCancel = $actionsStatusNew[0];
print_r($actionCancel->getActionName());
$actionRespond = $actionsStatusNew[1];

$actionsStatusInProgress = $task2->getActionList(Task::ROLE_CUSTOMER);
$actionComplete = $actionsStatusInProgress[0];
$actionDecline = $actionsStatusInProgress[1];

echo '<br/>';
print_r($task2->getActionList(Task::ROLE_CUSTOMER));
echo '<br/>';
print_r($task1->getNextStatus("complete"));
assert($task1->getNextStatus(Task::ACTION_RESPOND) == Task::STATUS_IN_PROGRESS,
    'problem with respond action');
assert($task1->getNextStatus("complete") == Task::STATUS_COMPLETED,
    'expect action "complete"');
assert($task1->getNextStatus("cancel") == Task::STATUS_CANCELED,
    'expect action "cancel"');
echo '<br/>';
assert($actionCancel->validateUser(1, 2, 1) == true,
    'expect true');
assert($actionCancel->validateUser(1, 2, 2) == false,
    'expect false');
assert($actionRespond->validateUser(1, 1, 2) == true,
    'expect true');
assert($actionRespond->validateUser(1, 2, 2) == false,
    'expect false');
assert($actionComplete->validateUser(1, 2, 1) == true,
    'expect true');
assert($actionComplete->validateUser(1, 2, 2) == false,
    'expect false');
assert($actionDecline->validateUser(1, 1, 2) == true,
    'expect true');
assert($actionDecline->validateUser(1, 3, 2) == false,
    'expect false');

try {
    $task3 = new Task("nev");
}
catch (StatusNameException $e) {
    error_log("Проблемы с указанием статуса задания: " . $e->getMessage());
}

try {
    $task1->getActionList("custome");
}
catch (RoleNameException $e) {
    error_log("Роль указана не верно: " . $e->getMessage());
}

