<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use Tests\TestCase;

final class CategoryTest extends TestCase
{
    public function test_can_create_category(): void
    {
        $data = Category::factory()->make()->toArray();

        $response = $this->post(route('categories.store'), $data);

        $response->assertCreated();
        $response->assertJsonFragment($data);
    }

    public function test_can_view_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->get(route('categories.show', $category));

        $response->assertOk();
        $response->assertJsonFragment($category->toArray());
    }

    public function test_can_update_category(): void
    {
        $category = Category::factory()->create();
        $data = Category::factory()->make()->toArray();

        $response = $this->put(route('categories.update', $category), $data);

        $response->assertOk();
        $this->assertDatabaseHas('categories', array_merge(['id' => $category->id], $data));
    }

    public function test_can_delete_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->delete(route('categories.destroy', $category));

        $response->assertNoContent();
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
