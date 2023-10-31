<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAll(): Collection
    {
        return User::all();
    }

    public function getById(int $id): ?Model
    {
        return User::find($id);
    }

    public function store(array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return User::create($data);
    }

    public function update(User $user, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);
    }

    public function trash(): Collection
    {
        return User::onlyTrashed()->get();
    }

    public function restore(int $id): bool
    {
        $user = User::onlyTrashed()->find($id);
        if (!$user) return false;
        $user->restore();
        return true;
    }

    public function forceDelete(int $id): bool
    {
        $user = User::onlyTrashed()->find($id);
        if (!$user) return false;
        $user->forceDelete();
        return true;
    }

    /**
     * Retrieve all users in a paginated format.
     *
     * @param int $perPage Number of items per page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllPaginated($perPage = 15) // default 15 items per page
    {
        return User::paginate($perPage);
    }

    /**
     * Find a user by ID.
     *
     * @param int $id User ID
     * @return User|null
     */
    public function findById($id)
    {
        try {
            return User::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            // You can decide how to handle the exception.
            // Maybe log the error or handle it differently depending on your application's needs.
            return null;
        }
    }

    /**
     * Soft delete a user by ID.
     *
     * @param int $id User ID
     * @return bool|null
     */
    public function softDelete($id)
    {
        try {
            $user = User::findOrFail($id);
            return $user->delete();
        } catch (ModelNotFoundException $exception) {
            // You can decide how to handle the exception.
            // Maybe log the error or handle it differently depending on your application's needs.
            return null;
        }
    }

    /**
     * Get all trashed (soft-deleted) users in a paginated format.
     *
     * @param int $perPage Number of users per page.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllTrashedPaginated($perPage = 15)
    {
        return User::onlyTrashed()->paginate($perPage);
    }

    /**
     * Permanently delete a soft-deleted user.
     *
     * @param int $id User ID.
     * @return bool|null
     */
    public function permanentDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        return $user->forceDelete();
    }

    /**
     * Upload a user's photo.
     *
     * @param UploadedFile $file Uploaded file instance.
     * @param int $userId User ID.
     * @return string|null
     */
    public function uploadPhoto($file, $userId)
    {
        $user = User::findOrFail($userId);

        // Define the path to store the photos (e.g., 'user_photos')
        $photoPath = 'user_photos';

        // Store the photo and get the path
        $path = $file->store($photoPath, 'public/user_photos');

        // Update the user's photo path in the database
        $user->update(['photo' => $path]);

        return $path;
    }
}
