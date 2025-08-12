<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Author;
use Tests\TestCase;

final class AuthorTest extends TestCase
{
    public function test_can_create_author(): void
    {
        $data = Author::factory()->make()->toArray();

        $response = $this->post(route('authors.store'), $data);

        $response->assertCreated();
        $response->assertJsonFragment($data);
    }

    public function test_can_view_author(): void
    {
        $author = Author::factory()->create();

        $response = $this->get(route('authors.show', $author));

        $response->assertOk();
        $response->assertJsonFragment($author->toArray());
    }

    public function test_can_update_author(): void
    {
        $author = Author::factory()->create();
        $data = Author::factory()->make()->toArray();

        $response = $this->put(route('authors.update', $author), $data);

        $response->assertOk();
        $this->assertDatabaseHas('authors', array_merge(['id' => $author->id], $data));
    }

    public function test_can_delete_author(): void
    {
        $author = Author::factory()->create();

        $response = $this->delete(route('authors.destroy', $author));

        $response->assertNoContent();
        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }
}
