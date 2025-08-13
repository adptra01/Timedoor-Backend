<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\BookCategory;
use Tests\TestCase;

final class BookCategoryTest extends TestCase
{
    public function test_can_create_book_category(): void
    {
        $data = BookCategory::factory()->make()->toArray();

        $response = $this->post(route('book-categories.store'), $data);

        $response->assertCreated();
        $response->assertJsonFragment($data);
    }

    public function test_can_view_book_category(): void
    {
        $bookCategory = BookCategory::factory()->create();

        $response = $this->get(route('book-categories.show', $bookCategory));

        $response->assertOk();
        $response->assertJsonFragment($bookCategory->toArray());
    }

    public function test_can_update_book_category(): void
    {
        $bookCategory = BookCategory::factory()->create();
        $newCategory = \App\Models\Category::factory()->create();
        $data = [
            'book_id' => $bookCategory->book_id,
            'category_id' => $newCategory->id,
        ];

        $response = $this->put(route('book-categories.update', $bookCategory), $data);

        $response->assertOk();
        $this->assertDatabaseHas('book_categories', array_merge(['id' => $bookCategory->id], $data));
    }

    public function test_can_delete_book_category(): void
    {
        $bookCategory = BookCategory::factory()->create();

        $response = $this->delete(route('book-categories.destroy', $bookCategory));

        $response->assertNoContent();
        $this->assertDatabaseMissing('book_categories', ['id' => $bookCategory->id]);
    }
}
