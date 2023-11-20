<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\ScheduleRepository;
use mysql_xdevapi\Exception;


class ScheduleController extends Controller
{
    public ScheduleRepository $scheduleRepository;

    public function  __construct(ScheduleRepository $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    public  function  index(): JsonResponse
    {
        return $this->scheduleRepository->getAllTask();
    }
    public function show($id) {
        try {
            $isThereAnyTask = Task::findOrFail($id);
            if($isThereAnyTask){
                $task=$this->scheduleRepository->getTask( $id);
            }
        }catch (ModelNotFoundException $e){
            return response()->json(['error' => 'Task not found'], 404);
        }
        return  response()->json($task);

    }
}
