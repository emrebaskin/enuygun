<?php


namespace App\Http\Controllers;


use App\Classes\ToDo;
use Illuminate\Http\Request;

class ToDoController extends Controller
{

    public function index(Request $request)
    {
        // Name => level
        $developerList = [
            ['name' => 'DEV1', 'level' => 1],
            ['name' => 'DEV2', 'level' => 2],
            ['name' => 'DEV3', 'level' => 3],
            ['name' => 'DEV4', 'level' => 4],
            ['name' => 'DEV5', 'level' => 5],
        ];

        $developers = ToDo::getWeeklyPlan($developerList);
        $deadline   = ToDo::getDeadline($developers);

        $datas = [
            'developers' => $developers,
            'deadline'   => $deadline,
        ];

        return view('todos', $datas);
    }

}
