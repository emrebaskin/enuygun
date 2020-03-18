<?php


namespace App\Classes;


use App\Interfaces\ToDoInterface;
use App\Models\ToDo as ToDoModel;


class ToDo implements ToDoInterface
{
    public static function add(array $toDoList = [])
    {
        foreach ($toDoList as $todo) {
            ToDoModel::updateOrCreate(
                [
                    'id' => $todo->id,
                ],
                [
                    'time'  => $todo->time,
                    'level' => $todo->level,
                ]
            );
        }
    }

    public static function get()
    {
        return ToDoModel::all();
    }

    public static function getWeeklyPlan(array $developerList = [])
    {
        $developerTasks = self::associateWithDevelopers($developerList);

        foreach ($developerTasks as $key => $developer) {
            $developerTasks[$key]['name']  = $developer['name'];
            $developerTasks[$key]['level'] = $developer['level'];
            $developerTasks[$key]['time']  = $developer['time'];;
            $developerTasks[$key]['weekly'] = self::groupByWeek($developer['tasks']);
        }

        return $developerTasks;
    }

    private static function associateWithDevelopers(array $developerList = [])
    {
        $tasks = ToDoModel::orderBy('time', 'desc')->get();

        // Tasks group by level
        $taskGroup = [];

        foreach ($tasks as $task) {
            $taskGroup[$task->level][] = ['id' => $task->id, 'time' => $task->time];
        }

        krsort($taskGroup);

        // Developers group by level
        $developers = [];

        foreach ($developerList as $developer) {
            $developers[$developer['level']] = ['name' => $developer['name'], 'level' => $developer['level'], 'time' => 0];
        }

        foreach ($taskGroup as $level => $tasks) {

            foreach ($tasks as $task) {


                if ( ! isset($developers[$level])) {
                    return "backlog";
                }

                $findingDeveloperLevel = self::findDeveloperLevelForTask($developers, $level);

                $developers[$findingDeveloperLevel]['tasks'][] = array_merge($task, ['level' => $level]);
                $developers[$findingDeveloperLevel]['time']    += $task['time'];
            }

        }

        return $developers;

    }

    private static function findDeveloperLevelForTask($developers, $level)
    {

        $developer = $developers[$level];

        ksort($developers);

        $index = array_search($level, array_keys($developers));

        $upperLevelDeveloper = array_slice($developers, $index + 1, 1, true);

        if ( ! isset($upperLevelDeveloper[$level + 1]['time'])) {
            return $level;
        } elseif ($developer['time'] <= $upperLevelDeveloper[$level + 1]['time']) {
            return $level;
        } else {

            $upperLevel = self::findDeveloperLevelForTask($developers, $level + 1);

            if ($upperLevel == $level) {
                return $level;
            } else {
                return $upperLevel;
            }
        }

    }

    private static function groupByWeek(array $tasks = [])
    {

        $weeklyTasks = [
            [
                'tasks' => [],
                'time'  => 0,
            ],
        ];

        foreach ($tasks as $task) {

            $taskTime = $task['time'];

            foreach ($weeklyTasks as $key => $week) {

                if ($week['time'] == 45 && isset($weeklyTasks[$key + 1])) {

                    continue;

                }

                if ($week['time'] == 45 && ! isset($weeklyTasks[$key + 1])) {

                    $task['time']  = $taskTime;
                    $weeklyTasks[] = [
                        'tasks' => [$task],
                        'time'  => $task['time'],
                    ];

                    break;

                }

                if ($week['time'] < 45 && ($week['time'] + $taskTime) > 45) {

                    $time                         = 45 - $week['time'];
                    $taskTime                     -= $time;
                    $task['time']                 = $time;
                    $weeklyTasks[$key]['tasks'][] = $task;
                    $weeklyTasks[$key]['time']    += $time;

                    $task['time']  = $taskTime;
                    $weeklyTasks[] = [
                        'tasks' => [$task],
                        'time'  => $task['time'],
                    ];
                    break;

                }

                if ($week['time'] < 45 && ($week['time'] + $taskTime) <= 45) {

                    $weeklyTasks[$key]['tasks'][] = $task;
                    $weeklyTasks[$key]['time']    += $taskTime;
                    break;

                }

            }

        }

        return $weeklyTasks;

    }

    public static function getDeadline(array $developerTasks = [])
    {

        $deadlineWeeks = 0;

        foreach ($developerTasks as $key => $developer) {
            $weeks = count($developer['weekly']);

            if ($weeks > $deadlineWeeks) {
                $deadlineWeeks = $weeks;
            }
        }

        return $deadlineWeeks;
    }

    public static function estimatedTime()
    {
        dd('kalan süre hesaplancak');
    }
}
