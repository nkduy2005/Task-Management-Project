<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = File::get(path: "database/json/task.json");
        $tasks = collect(json_decode($file));
        $tasks->each(function ($task) {
            Task::create([
                "title" => $task->title,
                "description" => $task->description,
                "due_date" => $task->due_date,
                "user_id" => $task->user_id,
                "slug" => $task->slug
            ]);
        });
    }
}
