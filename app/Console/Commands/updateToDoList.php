<?php

namespace App\Console\Commands;

use App\Classes\ToDo;
use Illuminate\Console\Command;
use Ixudra\Curl\Facades\Curl;

class updateToDoList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'todo:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'API\'lerden verileri çekerek to do listesini günceller';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // API 1
        $provider1 = $this->getDataToApi('http://www.mocky.io/v2/5d47f24c330000623fa3ebfa');

        foreach ($provider1 as $index => $taskData) {

            $provider1[$index] = (object) [
                'level' => $taskData->zorluk,
                'time'  => $taskData->sure,
                'id'    => $taskData->id,
            ];

        }

        ToDo::add($provider1);

        // API 2
        $provider2 = $this->getDataToApi('http://www.mocky.io/v2/5d47f235330000623fa3ebf7');


        foreach ($provider2 as $index => $taskData) {

            foreach ($taskData as $id => $taskProperty) {

                $provider2[$index] = (object) [
                    'level' => $taskProperty->level,
                    'time'  => $taskProperty->estimated_duration,
                    'id'    => $id,
                ];

            }

        }

        ToDo::add($provider2);

    }

    private function getDataToApi($url)
    {
        $response = Curl::to($url)->get();
        $response = json_decode($response);

        return $response;
    }


}
