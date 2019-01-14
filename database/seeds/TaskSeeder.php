<?php

use Illuminate\Database\Seeder;
use App\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Task::class, 10)->create()->each(function ($task) {
            $task->tags()->save(factory(App\Tag::class)->make());
        });
    }
}
