<?php

namespace Tests\Unit;

use App\Tag;
use App\Task;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_assign_user_to_task()
    {
        // 1 Prepare
        $task = Task::create([
            'name' => 'Comprar pa'
        ]);

        $userOriginal = factory(User::class)->create();

        // 2 Execute
        $task->assignUser($userOriginal);

        $user = $task->user;

        $this->assertTrue($user->is($userOriginal));
    }

    /**
     * @test
     */
    public function can_assign_tag_to_task()
    {
        // 1 Prepare
        $task = Task::create([
            'name' => 'Comprar pa'
        ]);

        $tag = Tag::create([
            'name' => 'home'
        ]);

        // execució
        $task->addTag($tag);

        // Assertion
        $tags = $task->tags;

        $this->assertTrue($tags[0]->is($tag));
    }

    /**
     * @test
     */
    public function a_task_can_have_tags() {
        // 1 Prepare
        $task = Task::create([
            'name' => 'Comprar pa'
        ]);

        $tag1 = Tag::create([
            'name' => 'home'
        ]);
        $tag2 = Tag::create([
            'name' => 'work'
        ]);

        $tag3 = Tag::create([
            'name' => 'studies'
        ]);

        $tags = [$tag1, $tag2, $tag3];

        // execució
        $task->addTags($tags);

        // Assertion
        $tags = $task->tags;

        $this->assertTrue($tags[0]->is($tag1));
        $this->assertTrue($tags[1]->is($tag2));
        $this->assertTrue($tags[2]->is($tag3));
    }


    /**
     * @test
     */
    public function a_task_can_have_one_file()
    {
        // 1 Prepare
        $task = Task::create([
            'name' => 'Comprar pa'
        ]);

        $fileOriginal = File::create([
            'path' => 'fitxer1.pdf'
        ]);

//        add_file_to_task($file, $task);
        $task->assignFile($fileOriginal);

        // 2 Executo -> Wishful programming

        // IMPORTANT 2 maneres
        // 1 Aixó torna tota la relació, treball extra
//        $file = $task->files()->where('path','');
        // 2 Això retorna el object:

        $file = $task->file;

        // 3 Comprovo
        // $file
        $this->assertTrue($file->is($fileOriginal));

    }

    /**
     * @test
     */
    public function a_task_file_returns_null_when_no_file_is_assigned()
    {
        // 1 Prepare
        $task = Task::create([
            'name' => 'Comprar pa'
        ]);
        // 2 Executo -> Wishful programming
        $file = $task->file;

        // 3 Comprovo
        // $file
        $this->assertNull($file);

    }

    /**
     * @test
     */
    public function can_toggle_completed()
    {
        $task = factory(Task::class)->create([
            'completed' => false
        ]);
        $task->toggleCompleted();
        $this->assertTrue($task->completed);

        $task = factory(Task::class)->create([
            'completed' => true
        ]);
        $task->toggleCompleted();
        $this->assertFalse($task->completed);
    }

    /**
     * @test
     */
    public function map()
    {
        $user = factory(User::class)->create();
        $task = Task::create([
            'name' => 'Comprar pa',
            'completed' => false,
            'user_id' => $user->id
        ]);
        $mappedTask = $task->map();
        $this->assertEquals($mappedTask['id'],1);
        $this->assertEquals($mappedTask['name'],'Comprar pa');
        $this->assertEquals($mappedTask['completed'],false);
        $this->assertEquals($mappedTask['user_id'],$user->id);
        $this->assertEquals($mappedTask['user_name'],$user->name);
        $this->assertEquals($mappedTask['user_email'],$user->email);
        $this->assertTrue($user->is($mappedTask['user']));
    }
}
