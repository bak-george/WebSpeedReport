<?php

require('vendor/autoload.php');
class Tasks
{
    protected $tasks;

    public function __construct($tasks)
    {
        $this->tasks = $tasks;
    }
}

class Task
{
    public $description;

    public function __construct($description)
    {
        $this->description = $description;
    }
}

$tasks = new Tasks([
    new Task('Got to the store'),
    new Task('take a shower'),
    new Task('Take a walk')
]);

dd($tasks);
