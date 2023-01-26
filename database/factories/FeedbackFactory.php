<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feedback>
 */
class FeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $ids = User::All()->where('role_id', '!=', Role::IS_ADMIN)->pluck('id')->toArray();
        return [
            'user_id' => $ids[rand(0, count($ids) - 1)],
            'subject' => fake()->sentence(5),
            'created_at' => Carbon::createFromTimestamp(rand(now()->subDays(60)->timestamp, now()->timestamp)),
            'message' => fake()->text(1000),
            'attachment' => rand(0,1) ? 'attachments/default.png': null,  //some feedbacks have files some don't
        ];
    }
}
