<?php

namespace App\Repositories;

use App\Http\Requests\AddTaskRequest;
use App\Http\Requests\EditTaskRequest;
use App\Models\Task;
use App\Models\Week;
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

    public function createTask(AddTaskRequest $request)
    {
        $start_time = $request->start_time;
        $end_time = $request->end_time;

        //Aşağıdakilerden herhangi birisine takılırsa görev eklemez.
        $conflictingTask = Task::where('day_number', $request->day_number)
            ->where('week_id', $request->week_id)
            ->where(function ($query) use ($start_time, $end_time) {
                $query->where(function ($q) use ($start_time, $end_time) {
                    $q->where('start_time', '>=', $start_time)
                        ->where('start_time', '<', $end_time);
                })
                    //4. Durum Bura
                    ->orWhere(function ($q) use ($start_time, $end_time) {
                        $q->where('end_time', '>', $start_time)
                            ->where('end_time', '<=', $end_time);
                    })
                    //3. Durum Bura
                    ->orWhere(function ($q) use ($start_time, $end_time) {
                        $q->where('start_time', '<', $start_time)
                            ->where('end_time', '>', $end_time);
                    })
                    //5.Durum
                    ->orWhere(function ($q) use ($start_time, $end_time) {
                        $q->where('start_time', '>=', $start_time)
                            ->where('end_time', '<=', $end_time);
                    });

            })
            //Eşit girme Durumu
            ->orWhere(function ($query) use ($start_time, $end_time) {
                $query->where('start_time', '=', $start_time)
                    ->where('end_time', '=', $end_time);
            })
            ->first();

        if (!$conflictingTask) {
             return Task::create([
                'day_number' => $request->day_number,
                'week_id' => $request->week_id,
                'title' => $request->title,
                'description' => $request->description,
                'start_time' => $start_time,
                'end_time' => $end_time
                ]);
        }





    }

    public function updateTask(EditTaskRequest $request, $id)
    {

        $start_time = $request->start_time;
        $end_time = $request->end_time;


        $conflictingTask = Task::where('day_number', $request->day_number)
            ->where(function ($query) use ($start_time, $end_time) {
                $query->where(function ($q) use ($start_time, $end_time) {
                    $q->where('start_time', '>=', $start_time)
                        ->where('start_time', '<', $end_time);
                })
                    //4. Durum Bura
                    ->orWhere(function ($q) use ($start_time, $end_time) {
                        $q->where('end_time', '>', $start_time)
                            ->where('end_time', '<=', $end_time);
                    })
                    //3. Durum Bura
                    ->orWhere(function ($q) use ($start_time, $end_time) {
                        $q->where('start_time', '<', $start_time)
                            ->where('end_time', '>', $end_time);
                    })
                    //5.Durum
                    ->orWhere(function ($q) use ($start_time, $end_time) {
                        $q->where('start_time', '>=', $start_time)
                            ->where('end_time', '<=', $end_time);
                    });

            })
            ->first();

        if (!$conflictingTask) {
            $task = Task::findOrFail($id);
            if($task)
            {
                return $task->update([
                    'day_number' => $request->day_number,
                    'week_id' => $request->week_id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'start_time' => $start_time,
                    'end_time' => $end_time
                ]);
            }

        }
    }
}
