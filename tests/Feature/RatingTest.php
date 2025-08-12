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

        $response->assertCreated();
        $response->assertJsonFragment($data);
    }

    public function test_can_view_rating(): void
    {
        $rating = Rating::factory()->create();

        $response = $this->get(route('ratings.show', $rating));

        $response->assertOk();
        $response->assertJsonFragment($rating->toArray());
    }

    public function test_can_update_rating(): void
    {
        $rating = Rating::factory()->create();
        $data = Rating::factory()->make()->toArray();

        $response = $this->put(route('ratings.update', $rating), $data);

        $response->assertOk();
        $this->assertDatabaseHas('ratings', array_merge(['id' => $rating->id], $data));
    }

    public function test_can_delete_rating(): void
    {
        $rating = Rating::factory()->create();

        $response = $this->delete(route('ratings.destroy', $rating));

        $response->assertNoContent();
        $this->assertDatabaseMissing('ratings', ['id' => $rating->id]);
    }
}
