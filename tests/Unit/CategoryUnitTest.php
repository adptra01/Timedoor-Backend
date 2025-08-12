<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Category;
use Tests\TestCase;

final class CategoryUnitTest extends TestCase
{
    public function test_category_has_fillable_attributes(): void
    {
        $category = new Category;

        $expected = ['name', 'description'];

        $this->assertEquals($expected, $category->getFillable());
    }

    public function test_category_can_be_created(): void
    {
        $attributes = Category::factory()->make()->toArray();
        $category = Category::factory()->create($attributes);

        $this->assertInstanceOf(Category::class, $category);

        foreach ($attributes as $key => $value) {
            if ($category->isFillable($key)) {
                $this->assertEquals($value, $category->getAttribute($key));
            }
        }
    }

    public function test_category_has_timestamps(): void
    {
        $category = Category::factory()->create();

        $this->assertNotNull($category->created_at);
        $this->assertNotNull($category->updated_at);
    }
}
