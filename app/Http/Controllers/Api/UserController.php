<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;

/**
 * @tag User "Operations about users"
 */
class UserController extends Controller
{
    /**
     * Dapatkan Semua Pengguna (Terpaginasi)
     *
     * Mengambil daftar pengguna yang sudah dipaginasi, dengan 10 item per halaman.
     *
     * @response 200 App\Http\Resources\UserResource[] "Paginated list of users"
     */
    public function index(): AnonymousResourceCollection
    {
        $users = User::paginate(10);

        return UserResource::collection($users);
    }

    /**
     * Buat Pengguna Baru
     *
     * Menyimpan pengguna yang baru dibuat ke dalam database.
     *
     * @body App\Http\Requests\User\StoreUserRequest "New user data"
     *
     * @response 200 App\Http\Resources\UserResource "Created user"
     * @response 422 App\Http\Responses\ValidationException "Validation error"
     */
    public function store(StoreUserRequest $request): UserResource
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return new UserResource($user);
    }

    /**
     * Dapatkan Detail Pengguna
     *
     * Mengambil detail pengguna tertentu berdasarkan ID.
     *
     * @param int user "The user ID"
     *
     * @response 200 App\Http\Resources\UserResource "User details"
     * @response 404 App\Http\Responses\ModelNotFoundException "User not found"
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Perbarui Pengguna
     *
     * Memperbarui detail pengguna tertentu berdasarkan ID.
     *
     * @param int user "The user ID"
     *
     * @body App\Http\Requests\User\UpdateUserRequest "Updated user data"
     *
     * @response 200 App\Http\Resources\UserResource "Updated user"
     * @response 404 App\Http\Responses\ModelNotFoundException "User not found"
     * @response 422 App\Http\Responses\ValidationException "Validation error"
     */
    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        $data = $request->validated();
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);

        return new UserResource($user);
    }

    /**
     * Hapus Pengguna
     *
     * Menghapus pengguna tertentu berdasarkan ID.
     *
     * @param int user "The user ID"
     *
     * @response 204 "No content"
     * @response 404 App\Http\Responses\ModelNotFoundException "User not found"
     */
    public function destroy(User $user): \Illuminate\Http\Response
    {
        $user->delete();

        return response()->noContent();
    }
}
