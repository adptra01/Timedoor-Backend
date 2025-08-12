<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Rating;
use Tests\TestCase;

final class RatingTest extends TestCase
{
    public function test_can_create_rating(): void
    {
        $data = Rating::factory()->make()->toArray();

        $response = $this->post(route('ratings.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('ratings', $data);
    }

    public function test_can_view_rating(): void
    {
        $rating = Rating::factory()->create();

        $response = $this->get(route('ratings.show', $rating));

        $response->assertOk();
        $response->assertViewHas('rating', $rating);
    }

    public function test_can_update_rating(): void
    {
        $rating = Rating::factory()->create();
        $data = Rating::factory()->make()->toArray();

        $response = $this->put(route('ratings.update', $rating), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('ratings', array_merge(['id' => $rating->id], $data));
    }

    public function test_can_delete_rating(): void
    {
        $rating = Rating::factory()->create();

        $response = $this->delete(route('ratings.destroy', $rating));

        $response->assertRedirect();
        $this->assertDatabaseMissing('ratings', ['id' => $rating->id]);
    }
}
