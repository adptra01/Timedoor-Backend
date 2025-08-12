<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Author;
use Tests\TestCase;

final class AuthorTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_top_authors(): void
    {
        // Seed data: authors, books, and ratings
        $author1 = Author::factory()->create(['name' => 'Author A']);
        $author2 = Author::factory()->create(['name' => 'Author B']);
        $author3 = Author::factory()->create(['name' => 'Author C']);

        $book1 = \App\Models\Book::factory()->create(['author_id' => $author1->id]);
        $book2 = \App\Models\Book::factory()->create(['author_id' => $author1->id]);
        $book3 = \App\Models\Book::factory()->create(['author_id' => $author2->id]);
        $book4 = \App\Models\Book::factory()->create(['author_id' => $author3->id]);

        // Ratings for Author A (voters: 3, avg: (6+7+8)/3 = 7)
        \App\Models\Rating::factory()->create(['book_id' => $book1->id, 'user_id' => \App\Models\User::factory()->create()->id, 'rating' => 6]);
        \App\Models\Rating::factory()->create(['book_id' => $book1->id, 'user_id' => \App\Models\User::factory()->create()->id, 'rating' => 7]);
        \App\Models\Rating::factory()->create(['book_id' => $book2->id, 'user_id' => \App\Models\User::factory()->create()->id, 'rating' => 8]);

        // Ratings for Author B (voters: 1, avg: 9)
        \App\Models\Rating::factory()->create(['book_id' => $book3->id, 'user_id' => \App\Models\User::factory()->create()->id, 'rating' => 9]);

        // Ratings for Author C (voters: 0, avg: 4)
        \App\Models\Rating::factory()->create(['book_id' => $book4->id, 'user_id' => \App\Models\User::factory()->create()->id, 'rating' => 4]);

        // Make the request
        $response = $this->getJson(route('authors.top'));

        // Assertions
        $response->assertOk();
        $response->assertJsonCount(2); // Only Author A and B should appear (rating > 5)

        $response->assertJsonStructure([
            '*', // Each item in the array
            [
                'id',
                'name',
                'voters',
                'avg_author_rating',
            ],
        ]);

        // Assert specific data for Author A
        $response->assertJsonFragment([
            'name' => 'Author A',
            'voters' => 3,
            'avg_author_rating' => 7.0,
        ]);

        // Assert specific data for Author B
        $response->assertJsonFragment([
            'name' => 'Author B',
            'voters' => 1,
            'avg_author_rating' => 9.0,
        ]);

        // Assert order (Author A should be first due to more voters)
        $this->assertEquals('Author A', $response->json('0.name'));
        $this->assertEquals('Author B', $response->json('1.name'));
    }

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
