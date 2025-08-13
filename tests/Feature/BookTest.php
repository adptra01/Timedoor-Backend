<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Book;
use Tests\TestCase;

final class BookTest extends TestCase
{
    public function test_can_create_book(): void
    {
        $data = Book::factory()->make()->toArray();
        // Unset calculated fields
        unset($data['avg_rating'], $data['voters_count']);

        $response = $this->post(route('books.store'), $data);

        $response->assertCreated();
        $response->assertJsonFragment($data);
        $this->assertDatabaseHas('books', $data);
    }

    public function test_can_view_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->get(route('books.show', $book));

        $response->assertOk();
        $response->assertJsonFragment($book->toArray());
    }

    public function test_can_update_book(): void
    {
        $book = Book::factory()->create();
        $data = Book::factory()->make()->toArray();
        // Unset calculated fields
        unset($data['avg_rating'], $data['voters_count']);

        $response = $this->put(route('books.update', $book), $data);

        $response->assertOk();
        $this->assertDatabaseHas('books', array_merge(['id' => $book->id], $data));
    }

    public function test_can_delete_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->delete(route('books.destroy', $book));

        $response->assertNoContent();
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
