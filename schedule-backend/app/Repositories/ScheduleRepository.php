<?php

namespace App\Repositories;

use App\Models\Task;
use http\Env\Request;
use Illuminate\Http\JsonResponse;

class ScheduleRepository
{

    public function getAllTask(): JsonResponse
    {
        $tasks=Task::all();
        return response()->json($tasks);
    }
    public function getTask($id): JsonResponse
    {
        $task=Task::find($id);
        return response()->json($task);
    }
}
