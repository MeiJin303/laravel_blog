<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class PostTest extends TestCase
{
    /**
     *  Test Post creation without authentication
     *
     * @return void
     */
    public function test_creation_without_authentication()
    {
        $data = [
            'title' => "Post Creation Unit Test",
            'description' => "Without Authentication. This test can't fail.",
            'user_id' => null
        ];
        $response = $this->post('/add_post', $data);
        $response->assertStatus(401);
        $response->assertJson(['message' => "Unauthenticated."]);
    }

    /**
     *  Test Post creation with authentication
     *
     * @return void
     */
    public function test_creation_with_authentication()
    {
        $data = [
            'title' => "Post Creation Unit Test",
            'description' => "Without Authentication. This test can't fail.",
        ];

        $user = User::factory()->create();
        $data['user_id'] = $user->id;

        $response = $this->post('/add_post', $data);
        $response->assertStatus(200);
        $response->assertJson(['message' => "Success."]);
        $response->assertJson(['data' => $data]);
    }

    /**
     *  Test getting all posts
     *
     * @return void
     */
    public function test_get_all_posts()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                [
                    'id',
                    'title',
                    'description',
                    'user_id',
                    'created_at',
                ]
            ]
        );
    }

    /**
     *  Test getting all user posts
     *
     * @return void
     */
    public function test_get_user_posts()
    {
        $user = User::factory()->create();
        $response = $this->get('/dashboard');
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                [
                    'id',
                    'title',
                    'description',
                    'user_id',
                    'created_at',
                ]
            ]
        );
    }
}
