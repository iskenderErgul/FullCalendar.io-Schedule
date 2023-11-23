<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddTaskRequest;
use App\Http\Requests\EditTaskRequest;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
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
                return  response()->json($task);
            }
        }catch (ModelNotFoundException $e){
            return response()->json(['error' => 'Task not found'], 404);
        }
    }
    public  function store(AddTaskRequest $request)
    {
        try {
            $task=$this->scheduleRepository->createTask($request);
            return  response()->json($task);

        }catch (ModelNotFoundException $e){
            return response()->json(['error' => 'Task is not added'], 404);
        }
    }

    public function update(EditTaskRequest $request , $id)
    {

        try {
            $task = $this->scheduleRepository->updateTask($request,$id);
            return response()->json($task);
        }catch (ModelNotFoundException $e){
            return response()->json(['error' => 'Task is not updated'], 404);
        }
    }
}
