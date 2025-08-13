<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_users(): void
    {
        User::factory()->count(5)->create();

        $response = $this->getJson(route('users.index'));

        $response->assertOk();
        $response->assertJsonCount(5, 'data');
    }

    public function test_can_create_user(): void
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson(route('users.store'), $data);

        $response->assertCreated();
        $response->assertJsonFragment(['name' => 'Test User']);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_can_view_user(): void
    {
        $user = User::factory()->create();

        $response = $this->getJson(route('users.show', $user));

        $response->assertOk();
        $response->assertJsonFragment(['name' => $user->name]);
    }

    public function test_can_update_user(): void
    {
        $user = User::factory()->create();
        $data = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];

        $response = $this->putJson(route('users.update', $user), $data);

        $response->assertOk();
        $this->assertDatabaseHas('users', array_merge(['id' => $user->id], $data));
    }

    public function test_can_update_user_password(): void
    {
        $user = User::factory()->create();
        $data = [
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ];

        $response = $this->putJson(route('users.update', $user), $data);

        $response->assertOk();
        $this->assertTrue(password_verify('newpassword', User::find($user->id)->password));
    }

    public function test_can_delete_user(): void
    {
        $user = User::factory()->create();

        $response = $this->deleteJson(route('users.destroy', $user));

        $response->assertNoContent();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
