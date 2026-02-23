<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function findTasksByIdUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "is_completed" => [Rule::in(["pending", "completed"])]
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Validation error",
                "errors" => $validator->errors()
            ], 422);
        }
        $tasks = Task::where("user_id", $request->user()->id)
            ->when($request->is_completed, function ($query, $value) {
                $query->where("is_completed", $value);
            })
            ->orderBy("created_at", "desc")->paginate();
        return response()->json([
            "status" => true,
            "tasks" => $tasks
        ], 200);
    }
    public function createTask(TaskRequest $request)
    {
        $task = Task::create([
            "title" => $request->title,
            "description" => $request->description,
            "due_date" => $request->due_date,
            "user_id" => $request->user()->id
        ]);
        return response()->json([
            "status" => true,
            "message" => "Create Task successful",
            "task" => $task
        ], 201);
    }
    public function deleteTask(string $slug)
    {
        $task = Task::where("slug", $slug)->first();
        $task->delete();
        return response()->json([
            "status" => true,
            "message" => "Delete task successful"
        ], 200);
    }
    public function findTaskBySlug(string $slug)
    {
        $task = Task::where("slug", $slug)->first();
        return response()->json([
            "status" => true,
            "task" => $task
        ], 200);
    }
    public function updateStatusTask(string $slug)
    {
        $task = Task::where("slug", $slug)->first();
        $task->update([
            "is_completed" => $task->is_completed == "pending" ? "completed" : "pending"
        ]);
        return response()->json([
            "status" => true,
            "message" => "Update status task successfull"
        ], 200);
    }
    public function updateTask(TaskRequest $request, string $slug)
    {
        $task = Task::where("slug", $slug)->first();
        $task->update([
            "title" => $request->title,
            "description" => $request->description,
            "due_date" => $request->due_date
        ]);
        return response()->json([
            "status" => true,
            "message" => "Update task successfull"
        ], 200);
    }
}
