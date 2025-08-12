<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\BookCategory;
use Tests\TestCase;

final class BookCategoryUnitTest extends TestCase
{
    public function test_book_category_has_fillable_attributes(): void
    {
        $bookCategory = new BookCategory;

        $expected = ['book_id', 'category_id'];

        $this->assertEquals($expected, $bookCategory->getFillable());
    }

    public function test_book_category_can_be_created(): void
    {
        $attributes = BookCategory::factory()->make()->toArray();
        $bookCategory = BookCategory::factory()->create($attributes);

        $this->assertInstanceOf(BookCategory::class, $bookCategory);

        foreach ($attributes as $key => $value) {
            if ($bookCategory->isFillable($key)) {
                $this->assertEquals($value, $bookCategory->getAttribute($key));
            }
        }
    }

    public function test_book_category_has_timestamps(): void
    {
        $bookCategory = BookCategory::factory()->create();

        $this->assertNotNull($bookCategory->created_at);
        $this->assertNotNull($bookCategory->updated_at);
    }
}
