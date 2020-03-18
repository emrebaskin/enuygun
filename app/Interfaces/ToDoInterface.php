<?php


namespace App\Interfaces;


interface ToDoInterface
{
    public static function add(array $toDoList = []);
    public static function get();
    public static function estimatedTime();
}
