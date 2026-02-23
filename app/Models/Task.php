<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;

class Task extends Model
{
    use Sluggable;

    protected $guarded = [];
    public function Sluggable(): array
    {
        return [
            "slug" => [
                "source" => "title",
                'onUpdate' => true
            ]
        ];
    }
    protected $casts = [
        'due_date' => 'datetime',
    ];
}
