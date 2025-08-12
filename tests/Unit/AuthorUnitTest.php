<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Author;
use Tests\TestCase;

final class AuthorUnitTest extends TestCase
{
    public function test_author_has_fillable_attributes(): void
    {
        $author = new Author;

        $expected = ['name'];

        $this->assertEquals($expected, $author->getFillable());
    }

    public function test_author_can_be_created(): void
    {
        $attributes = Author::factory()->make()->toArray();
        $author = Author::factory()->create($attributes);

        $this->assertInstanceOf(Author::class, $author);

        foreach ($attributes as $key => $value) {
            if ($author->isFillable($key)) {
                $this->assertEquals($value, $author->getAttribute($key));
            }
        }
    }

    public function test_author_has_timestamps(): void
    {
        $author = Author::factory()->create();

        $this->assertNotNull($author->created_at);
        $this->assertNotNull($author->updated_at);
    }
}
