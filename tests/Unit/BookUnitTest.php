<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Book;
use Tests\TestCase;

final class BookUnitTest extends TestCase
{
    public function test_book_has_fillable_attributes(): void
    {
        $book = new Book;

        $expected = [
            'title',
            'author_id',
            'description',
            'published_year',
            'stock',
            'price',
            'avg_rating',
            'voters_count',
        ];

        $this->assertEquals($expected, $book->getFillable());
    }

    public function test_book_can_be_created(): void
    {
        $attributes = Book::factory()->make()->toArray();
        $book = Book::factory()->create($attributes);

        $this->assertInstanceOf(Book::class, $book);

        foreach ($attributes as $key => $value) {
            if ($book->isFillable($key)) {
                $this->assertEquals($value, $book->getAttribute($key));
            }
        }
    }

    public function test_book_has_timestamps(): void
    {
        $book = Book::factory()->create();

        $this->assertNotNull($book->created_at);
        $this->assertNotNull($book->updated_at);
    }
}
