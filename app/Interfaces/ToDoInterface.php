<?php


namespace App\Interfaces;

/**
 * Interface ToDoInterface
 * @package App\Interfaces
 */
interface ToDoInterface
{
    /**
     * @param  array  $toDoList
     *
     * @return mixed
     */
    public static function add(array $toDoList = []);

    /**
     * @param  array  $developerList
     *
     * @return mixed
     */
    public static function getWeeklyPlan(array $developerList = []);

    /**
     * @param  array  $developerList
     *
     * @return mixed
     */
    public static function getDeadline(array $developerList = []);
}
