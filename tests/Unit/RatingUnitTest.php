<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Rating;
use Tests\TestCase;

final class RatingUnitTest extends TestCase
{
    public function test_rating_has_fillable_attributes(): void
    {
        $rating = new Rating;

        $expected = ['name'];

        $this->assertEquals($expected, $rating->getFillable());
    }

    public function test_rating_can_be_created(): void
    {
        $attributes = Rating::factory()->make()->toArray();
        $rating = Rating::factory()->create($attributes);

        $this->assertInstanceOf(Rating::class, $rating);

        foreach ($attributes as $key => $value) {
            if ($rating->isFillable($key)) {
                $this->assertEquals($value, $rating->getAttribute($key));
            }
        }
    }

    public function test_rating_has_timestamps(): void
    {
        $rating = Rating::factory()->create();

        $this->assertNotNull($rating->created_at);
        $this->assertNotNull($rating->updated_at);
    }
}
