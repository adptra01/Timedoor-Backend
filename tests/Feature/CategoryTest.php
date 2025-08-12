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

        $response->assertRedirect();
        $this->assertDatabaseHas('categories', $data);
    }

    public function test_can_view_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->get(route('categories.show', $category));

        $response->assertOk();
        $response->assertViewHas('category', $category);
    }

    public function test_can_update_category(): void
    {
        $category = Category::factory()->create();
        $data = Category::factory()->make()->toArray();

        $response = $this->put(route('categories.update', $category), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('categories', array_merge(['id' => $category->id], $data));
    }

    public function test_can_delete_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->delete(route('categories.destroy', $category));

        $response->assertRedirect();
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
