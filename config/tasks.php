<?php
/**
 * Created by PhpStorm.
 * User: mimoun
 * Date: 18/01/19
 * Time: 15:56
 */
return [
    'manager_email' => env('TASKS_MANAGER_EMAIL', 'tasksmanager@tasques.cat'),
    //Salts hash id's
    'tasks_salt' => env('TASKS_SALT'),
];
