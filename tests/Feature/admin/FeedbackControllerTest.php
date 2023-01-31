<?php

namespace Tests\Feature\admin;

use App\Jobs\MailSenderJob;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Queue\Queue;
use Tests\TestCase;
use function PHPUnit\Framework\assertTrue;

class FeedbackControllerTest extends TestCase
{
    protected $users;
    protected $feedbacks;
    protected $oneFeedback;
    protected $oneUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->users = User::factory(10)->create();
        $this->feedbacks = Feedback::factory(101)->create();
        $this->oneFeedback = Feedback::factory()->create();
        $this->oneUser = $this->oneFeedback->user;

        foreach ($this->users as $u) $u->refresh();
        foreach ($this->feedbacks as $f) $f->refresh();

        $this->oneFeedback->refresh();
        $this->oneUser->refresh();

        self::assertNotNull($this->users);
        self::assertNotNull($this->feedbacks);
        self::assertNotNull($this->oneFeedback);
        self::assertEquals(101, $this->feedbacks->count());
        self::assertEquals(10, $this->users->count());
        self::assertEquals($this->oneUser->email, $this->oneFeedback->user->email);
    }

    public function test_get_authenticated_admin_redirections()
    {
        $response = $this->actingAs($this->admin)->get('/');
        $response->assertRedirect(route('user.home'));
        $response = $this->actingAs($this->admin)->get(route('user.home'));
        $response->assertStatus(302);
        $response = $this->actingAs($this->admin)->get('/feedbacks');
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.home'));
        $response = $this->actingAs($this->admin)->get('/home');
        $response->assertStatus(302);
        $response = $this->actingAs($this->admin)->get(route('admin.home'));
        $response->assertStatus(200);
        $response = $this->actingAs($this->admin)->get(route('user.feedbacks.index'));
        $response->assertRedirect(route('admin.feedbacks.index'));
        $response = $this->actingAs($this->admin)->get(route('admin.feedbacks.index'));
        $response->assertStatus(200);
    }

    public function test_admin_get_feedback_paginatons() {
        $response = $this->actingAs($this->admin)->get(route('admin.feedbacks.index'));
        self::assertEquals(10, $response['perPage']);
        $response->assertViewHas('feedbacks');
        self::assertEquals(10, count($response['feedbacks']));

        $response = $this->actingAs($this->admin)->get(route('admin.feedbacks.index', [
            'perPage' => 50,
        ]));
        self::assertEquals(50, $response['perPage']);
        self::assertEquals(50, count($response['feedbacks']));

        $response = $this->actingAs($this->admin)->get(route('admin.feedbacks.index', [
            'perPage' => 100,
        ]));
        self::assertEquals(100, $response['perPage']);
        self::assertEquals(100, count($response['feedbacks']));
    }

    public function test_admin_create_request()
    {
        $before = Feedback::All()->count();
        $response = $this->actingAs($this->admin)->post(route('user.feedbacks.create'), [
            'subject' => 'feed subject',
            'message' => 'feed message'
        ]);
        $after = Feedback::All()->count();

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.feedbacks.index'));
        self::assertEquals($before, $after);
    }

    public function test_adim_post_process_feedback()
    {
//        Queue::fake('default');
        $response = $this->actingAs($this->admin)->post(route('admin.feedbacks.process', $this->oneFeedback->id));
        $response->assertRedirect('/');
//        self::assertEquals(true, $this->oneFeedback->processed);
//        Queue::assertPushed(MailSenderJob::class);

    }

    public function testIndex() {

        assertTrue(true);
    }
}
