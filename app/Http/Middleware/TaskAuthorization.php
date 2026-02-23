<?php

namespace App\Http\Middleware;

use App\Models\Task;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class TaskAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $task = Task::where("slug", $request->route("slug"))->first();
        if (!$task) {
            return response()->json([
                "status" => false,
                "message" => "Task not found"
            ], 404);
        }

        if (Gate::denies("task", $task->user_id)) {
            return response()->json([
                "status" => false,
                "message" => "You are not authorized to do this task."
            ], 403);
        }
        return $next($request);
    }
}
