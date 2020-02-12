<?php

use TaskForce\models\Task;

$task = new Task("new");
print_r($task->getActionList());
echo '<br/>';
print_r($task->getNextStatus("complete"));
assert($task->getNextStatus("complete") == Task::STATUS_COMPLETED,
    'expect action "complete"');
assert($task->getNextStatus("cancel") == Task::STATUS_CANCELED,
    'expect action "cancel"');
