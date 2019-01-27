<?php

namespace Tests\Feature\Api;

use App\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;

class TagsControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;

    /**
     * @test
     */
    public function tag_manager_can_show_a_tag()
    {
        $this->loginAsTagsManager('api');
        $tag = factory(Tag::class)->create();

        $response = $this->json('GET', '/api/v1/tags/' . $tag->id);

        $result = json_decode($response->getContent());
        $response->assertSuccessful();
        $this->assertEquals($tag->name, $result->name);
        $this->assertEquals($tag->name, $result->name);
        $this->assertEquals($tag->description, $result->description);
        $this->assertEquals($tag->color, $result->color);
    }

    /**
     * @test
     */
    public function tags_manager_can_delete_tag()
    {
        $this->loginAsTagsManager('api');
        $tag = factory(Tag::class)->create();
        $this->assertNotNull($tag);

        $response = $this->json('DELETE', '/api/v1/tags/' . $tag->id);

        $result = json_decode($response->getContent());
        $response->assertSuccessful();
        $this->assertEquals($result->name, $tag->name);

        $this->assertNull(Tag::find($tag->id));
    }

    /**
     * @test
     */
    public function superadmin_can_delete_tag()
    {
        $this->loginAsSuperAdmin('api');
        $tag = factory(Tag::class)->create();

        $response = $this->json('DELETE', '/api/v1/tags/' . $tag->id);

        $result = json_decode($response->getContent());
        $response->assertSuccessful();
        $this->assertEquals($result->name, $tag->name);

        $this->assertNull(Tag::find($tag->id));
    }

    /**
     * @test
     */
    public function regular_user_cannot_delete_tag()
    {
        $this->login('api');
        $tag = factory(Tag::class)->create();

        $response = $this->json('DELETE', '/api/v1/tags/' . $tag->id);

        $result = json_decode($response->getContent());
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function regular_user_cannot_show_a_tag()
    {
        //$this->withoutExceptionHandling();
        $this->login('api');
        $tag = factory(Tag::class)->create();
        $this->assertNotNull($tag);

        $response = $this->json('GET', '/api/v1/tags/' . $tag->id);
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function guest_user_cannot_show_a_tag()
    {
        $tag = factory(Tag::class)->create();

        $response = $this->json('GET', '/api/v1/tags/' . $tag->id);
        $response->assertStatus(401);
    }

    /**
     * @test
     */
    public function tags_manager_can_show_a_tag()
    {
        $this->loginAsTagsManager('api');
        $tag = factory(Tag::class)->create();

        $this->assertNotNull($tag);

        $response = $this->json('GET', '/api/v1/tags/' . $tag->id);

        $result = json_decode($response->getContent());

        $response->assertSuccessful();

        $this->assertEquals($tag->id, $result->id);
        $this->assertEquals($tag->name, $result->name);
        $this->assertEquals($tag->description, $result->description);
        $this->assertEquals($tag->color, $result->color);
    }


    /**
     * @test
     */
    public function cannot_create_tags_without_name()
    {
//        $this->loginAsTagManager('api');
        $this->loginWithPermission('api', 'tags.store');
        $response = $this->json('POST', '/api/v1/tags/', [
            'name' => ''
        ]);
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function superadmin_can_create_tag()
    {
        $this->loginAsSuperAdmin('api');

        $response = $this->json('POST', '/api/v1/tags/', [
            'name' => 'tag1',
            'color' => 'blue',
            'description' => 'Bla bla bla'
        ]);

        $result = json_decode($response->getContent());
        $response->assertSuccessful();

        $this->assertNotNull($tag = Tag::find($result->id));
        $this->assertEquals('tag1', $result->name);
        $this->assertEquals('blue', $result->color);
        $this->assertEquals('Bla bla bla', $result->description);

    }

    /**
     * @test
     */
    public function tag_manager_can_create_tag()
    {
        $this->loginAsTagsManager('api');

        $response = $this->json('POST', '/api/v1/tags/', [
            'name' => 'tag1',
            'description' => 'Bla bla bla',
            'color' => 'blue'
        ]);

        $result = json_decode($response->getContent());
        $response->assertSuccessful();

        $this->assertNotNull($tag = Tag::find($result->id));
        $this->assertEquals('tag1', $result->name);
        $this->assertEquals('Bla bla bla', $result->description);
        $this->assertEquals('blue', $result->color);
    }

    /**
     * @test
     */
    public function regular_user_cannot_create_tag()
    {
        $this->withExceptionHandling();
        $user = $this->login('api');

        $response = $this->json('POST', '/api/v1/tags/', [
            'name' => 'Tag1'
        ]);

        $result = json_decode($response->getContent());
        //dd($result);
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function regular_user_cannot_index_tags()
    {
        $this->login('api');

        $response = $this->json('GET', '/api/v1/tags');
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function superadmin_can_index_tags()
    {
        $this->loginAsSuperAdmin('api');

        create_example_tags();

        $response = $this->json('GET', '/api/v1/tags');
        $response->assertSuccessful();

        $result = json_decode($response->getContent());

        $this->assertCount(3, $result);

        $this->assertEquals('estudis', $result[0]->name);
        $this->assertEquals('#FFFFFF', $result[0]->color);
        $this->assertEquals('relacionat amb estudis', $result[0]->description);


        $this->assertEquals('laravel', $result[1]->name);
        $this->assertEquals('#FFFFFF', $result[1]->color);
        $this->assertEquals('relacionat amb laravel', $result[1]->description);

        $this->assertEquals('php', $result[2]->name);
        $this->assertEquals('#FFFFFF', $result[2]->color);
        $this->assertEquals('relacionat amb php', $result[2]->description);
    }

    /**
     * @test
     */
    public function tag_manager_can_index_tags()
    {
        $this->loginAsTagsManager('api');

        create_example_tags();

        $response = $this->json('GET', '/api/v1/tags');
        $response->assertSuccessful();

        $result = json_decode($response->getContent());

        $this->assertCount(3, $result);

        $this->assertEquals('estudis', $result[0]->name);
        $this->assertEquals('#FFFFFF', $result[0]->color);
        $this->assertEquals('relacionat amb estudis', $result[0]->description);


        $this->assertEquals('laravel', $result[1]->name);
        $this->assertEquals('#FFFFFF', $result[1]->color);
        $this->assertEquals('relacionat amb laravel', $result[1]->description);

        $this->assertEquals('php', $result[2]->name);
        $this->assertEquals('#FFFFFF', $result[2]->color);
        $this->assertEquals('relacionat amb php', $result[2]->description);
    }

    /**
     * @test
     */
    public function regular_user_cannot_edit_tag()
    {
        $this->login('api');

        $oldTag = factory(Tag::class)->create([
            'name' => 'Tag1',
            'color' => 'red',
            'description' => 'hello!'
        ]);

        $response = $this->json('PUT', '/api/v1/tags/' . $oldTag->id, [
            'name' => 'Tag2',
            'color' => 'blue',
            'description' => 'Bla bla bla'
        ]);

        json_decode($response->getContent());
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function superadmin_can_edit_tag()
    {
        $this->loginAsSuperAdmin('api');

        $oldTag = factory(Tag::class)->create([
            'name' => 'Tag2'
        ]);

        // 2
        $response = $this->json('PUT', '/api/v1/tags/' . $oldTag->id, [
            'name' => 'Tag1',
            'description' => 'Bla bla bla',
            'color' => 'blue'
        ]);

        $result = json_decode($response->getContent());
        $response->assertSuccessful();

        $newTag = $oldTag->refresh();
        $this->assertNotNull($newTag);
        $this->assertEquals('Tag1', $result->name);
        $this->assertEquals('Bla bla bla', $result->description);
        $this->assertEquals('blue', $result->color);

        $this->assertEquals('Tag1', $newTag->name);
        $this->assertEquals('Bla bla bla', $newTag->description);
        $this->assertEquals('blue', $newTag->color);
    }

    /**
     * @test
     */
    public function tag_manager_can_edit_tag()
    {
        $this->loginAsTagsManager('api');

        $oldTag = factory(Tag::class)->create([
            'name' => 'Tag1',
            'description' => 'Bla bla bla',
            'color' => 'blue'
        ]);

        // 2
        $response = $this->json('PUT', '/api/v1/tags/' . $oldTag->id, [
            'name' => 'Tag1',
            'description' => 'Bla bla bla',
            'color' => 'blue'
        ]);

        $result = json_decode($response->getContent());
        $response->assertSuccessful();

        $newTag = $oldTag->refresh();
        $this->assertNotNull($newTag);
        $this->assertEquals('Tag1', $result->name);
        $this->assertEquals('Bla bla bla', $result->description);
        $this->assertEquals('blue', $result->color);

        $this->assertEquals('Tag1', $newTag->name);
        $this->assertEquals('Bla bla bla', $newTag->description);
        $this->assertEquals('blue', $newTag->color);
    }

    /**
     * @test
     */
    public function cannot_edit_tag_without_name()
    {
        $this->loginAsTagsManager('api');

        $oldTag = factory(Tag::class)->create();
        $response = $this->json('PUT', '/api/v1/tags/' . $oldTag->id, [
            'name' => ''
        ]);

        $response->assertStatus(422);
    }
}
