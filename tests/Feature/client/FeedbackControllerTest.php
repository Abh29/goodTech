<?php

namespace Tests\Feature\client;

use App\Models\Feedback;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class FeedbackControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function test_get_non_authenticated_redirection()
    {
        $response = $this->get('/');
        $response->assertStatus(302);
        $response = $this->get(route('home'));
        $response->assertStatus(302);
        $response = $this->get('/feedbacks');
        $response->assertStatus(302);
        $response = $this->get('/admin/feedbacks');
        $response->assertStatus(302);
    }

    public function test_get_authenticated_client_redirections()
    {
        $response = $this->actingAs($this->user)->get('/');
        $response->assertRedirect(route('user.home'));
        $response = $this->actingAs($this->user)->get(route('user.home'));
        $response->assertStatus(200);
        $response = $this->actingAs($this->user)->get('/feedbacks');
        $response->assertStatus(200);
        $response = $this->actingAs($this->user)->get('/home');
        $response->assertStatus(302);
        $response->assertRedirect(route('user.feedbacks.index'));
        $response = $this->actingAs($this->user)->get(route('admin.feedbacks.index'));
        $response->assertStatus(403);
    }





}
