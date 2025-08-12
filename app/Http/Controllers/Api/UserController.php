<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    /**
     * Dapatkan Semua Pengguna
     *
     * Mengambil daftar pengguna yang sudah dipaginasi.
     */
    public function index(): AnonymousResourceCollection
    {
        $users = User::paginate();

        return UserResource::collection($users);
    }

    /**
     * Buat Pengguna Baru
     *
     * Menyimpan pengguna yang baru dibuat ke dalam database.
     */
    public function store(StoreUserRequest $request): UserResource
    {
        $validated = $request->validated();

        $user = User::create($validated);

        return new UserResource($user);
    }

    /**
     * Dapatkan Detail Pengguna
     *
     * Mengambil detail pengguna tertentu berdasarkan ID.
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Perbarui Pengguna
     *
     * Memperbarui detail pengguna tertentu berdasarkan ID.
     */
    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        $validated = $request->validated();

        $user->update($validated);

        return new UserResource($user);
    }

    /**
     * Hapus Pengguna
     *
     * Menghapus pengguna tertentu berdasarkan ID.
     */
    public function destroy(User $user): \Illuminate\Http\Response
    {
        $user->delete();

        return response()->noContent();
    }
}
