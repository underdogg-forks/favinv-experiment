<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

/**
 * User Service Class
 * 
 * Handles all business logic for User operations.
 * Follows SOLID principles and implements DRY patterns.
 */
class UserService
{
    /**
     * Get all users with optional filtering and pagination.
     *
     * @param array $filters
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
     */
    public function getAll(array $filters = [], int $perPage = 15)
    {
        $query = User::query();

        if (isset($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        if (isset($filters['active'])) {
            $query->where('active', $filters['active']);
        }

        if (isset($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('first_name', 'like', "%{$filters['search']}%")
                  ->orWhere('last_name', 'like', "%{$filters['search']}%")
                  ->orWhere('email', 'like', "%{$filters['search']}%");
            });
        }

        return $perPage > 0 ? $query->paginate($perPage) : $query->get();
    }

    /**
     * Find a user by ID.
     *
     * @param int $id
     * @return User|null
     */
    public function find(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * Find a user by email.
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @return User
     * @throws \Exception
     */
    public function create(array $data): User
    {
        DB::beginTransaction();

        try {
            // Hash password if provided
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            // Set default values using early returns pattern
            $data = $this->setDefaults($data);

            $user = User::create($data);

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update an existing user.
     *
     * @param int $id
     * @param array $data
     * @return User
     * @throws \Exception
     */
    public function update(int $id, array $data): User
    {
        $user = $this->find($id);

        if (!$user) {
            throw new \Exception("User not found with ID: {$id}");
        }

        DB::beginTransaction();

        try {
            // Hash password if being updated
            if (isset($data['password']) && !empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $user->update($data);

            DB::commit();

            return $user->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete a user (soft delete).
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id): bool
    {
        $user = $this->find($id);

        if (!$user) {
            throw new \Exception("User not found with ID: {$id}");
        }

        return $user->delete();
    }

    /**
     * Restore a soft-deleted user.
     *
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        $user = User::withTrashed()->find($id);

        if (!$user) {
            return false;
        }

        return $user->restore();
    }

    /**
     * Permanently delete a user.
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function forceDelete(int $id): bool
    {
        $user = User::withTrashed()->find($id);

        if (!$user) {
            throw new \Exception("User not found with ID: {$id}");
        }

        return $user->forceDelete();
    }

    /**
     * Activate a user account.
     *
     * @param int $id
     * @return User
     * @throws \Exception
     */
    public function activate(int $id): User
    {
        $user = $this->find($id);

        if (!$user) {
            throw new \Exception("User not found with ID: {$id}");
        }

        $user->update(['active' => 1]);

        return $user->fresh();
    }

    /**
     * Deactivate a user account.
     *
     * @param int $id
     * @return User
     * @throws \Exception
     */
    public function deactivate(int $id): User
    {
        $user = $this->find($id);

        if (!$user) {
            throw new \Exception("User not found with ID: {$id}");
        }

        $user->update(['active' => 0]);

        return $user->fresh();
    }

    /**
     * Set default values for user data.
     * Demonstrates early returns pattern.
     *
     * @param array $data
     * @return array
     */
    private function setDefaults(array $data): array
    {
        if (!isset($data['role'])) {
            $data['role'] = 'user';
        }

        if (!isset($data['active'])) {
            $data['active'] = 1;
        }

        if (!isset($data['currency'])) {
            $data['currency'] = 'USD';
        }

        return $data;
    }

    /**
     * Get users by role.
     *
     * @param string $role
     * @return Collection
     */
    public function getByRole(string $role): Collection
    {
        return User::where('role', $role)->get();
    }

    /**
     * Get active users count.
     *
     * @return int
     */
    public function getActiveCount(): int
    {
        return User::where('active', 1)->count();
    }

    /**
     * Assign manager to user.
     *
     * @param int $userId
     * @param int $managerId
     * @return User
     * @throws \Exception
     */
    public function assignManager(int $userId, int $managerId): User
    {
        $user = $this->find($userId);

        if (!$user) {
            throw new \Exception("User not found with ID: {$userId}");
        }

        $manager = $this->find($managerId);

        if (!$manager) {
            throw new \Exception("Manager not found with ID: {$managerId}");
        }

        $user->update(['manager' => $managerId]);

        return $user->fresh();
    }
}
