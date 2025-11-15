<?php

namespace Tests\Unit\Services;

use App\Services\UserService;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * UserService Test Class
 * 
 * Comprehensive tests for UserService following TDD principles.
 */
class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserService();
    }

    /** @test */
    public function it_can_create_a_user()
    {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
        ];

        $user = $this->userService->create($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John', $user->first_name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    /** @test */
    public function it_hashes_password_when_creating_user()
    {
        $data = [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'password' => 'plaintext',
        ];

        $user = $this->userService->create($data);

        $this->assertNotEquals('plaintext', $user->password);
        $this->assertTrue(\Hash::check('plaintext', $user->password));
    }

    /** @test */
    public function it_sets_default_values_when_creating_user()
    {
        $data = [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $user = $this->userService->create($data);

        $this->assertEquals('user', $user->role);
        $this->assertEquals(1, $user->active);
        $this->assertEquals('USD', $user->currency);
    }

    /** @test */
    public function it_can_find_user_by_id()
    {
        $user = User::factory()->create();

        $found = $this->userService->find($user->id);

        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals($user->id, $found->id);
    }

    /** @test */
    public function it_returns_null_when_user_not_found()
    {
        $found = $this->userService->find(99999);

        $this->assertNull($found);
    }

    /** @test */
    public function it_can_find_user_by_email()
    {
        $user = User::factory()->create(['email' => 'unique@example.com']);

        $found = $this->userService->findByEmail('unique@example.com');

        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals($user->id, $found->id);
    }

    /** @test */
    public function it_can_update_user()
    {
        $user = User::factory()->create(['first_name' => 'Original']);

        $updated = $this->userService->update($user->id, [
            'first_name' => 'Updated',
        ]);

        $this->assertEquals('Updated', $updated->first_name);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => 'Updated',
        ]);
    }

    /** @test */
    public function it_hashes_password_when_updating()
    {
        $user = User::factory()->create();

        $updated = $this->userService->update($user->id, [
            'password' => 'newpassword',
        ]);

        $this->assertTrue(\Hash::check('newpassword', $updated->password));
    }

    /** @test */
    public function it_throws_exception_when_updating_non_existent_user()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('User not found');

        $this->userService->update(99999, ['first_name' => 'Test']);
    }

    /** @test */
    public function it_can_soft_delete_user()
    {
        $user = User::factory()->create();

        $result = $this->userService->delete($user->id);

        $this->assertTrue($result);
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    /** @test */
    public function it_can_restore_soft_deleted_user()
    {
        $user = User::factory()->create();
        $user->delete();

        $result = $this->userService->restore($user->id);

        $this->assertTrue($result);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'deleted_at' => null,
        ]);
    }

    /** @test */
    public function it_can_activate_user()
    {
        $user = User::factory()->create(['active' => 0]);

        $activated = $this->userService->activate($user->id);

        $this->assertEquals(1, $activated->active);
    }

    /** @test */
    public function it_can_deactivate_user()
    {
        $user = User::factory()->create(['active' => 1]);

        $deactivated = $this->userService->deactivate($user->id);

        $this->assertEquals(0, $deactivated->active);
    }

    /** @test */
    public function it_can_get_users_by_role()
    {
        User::factory()->count(3)->create(['role' => 'admin']);
        User::factory()->count(2)->create(['role' => 'user']);

        $admins = $this->userService->getByRole('admin');

        $this->assertCount(3, $admins);
        $admins->each(function ($user) {
            $this->assertEquals('admin', $user->role);
        });
    }

    /** @test */
    public function it_can_get_active_users_count()
    {
        User::factory()->count(5)->create(['active' => 1]);
        User::factory()->count(3)->create(['active' => 0]);

        $count = $this->userService->getActiveCount();

        $this->assertEquals(5, $count);
    }

    /** @test */
    public function it_can_assign_manager_to_user()
    {
        $user = User::factory()->create();
        $manager = User::factory()->create(['role' => 'admin']);

        $result = $this->userService->assignManager($user->id, $manager->id);

        $this->assertEquals($manager->id, $result->manager);
    }

    /** @test */
    public function it_can_filter_users_by_search()
    {
        User::factory()->create(['first_name' => 'John', 'email' => 'john@test.com']);
        User::factory()->create(['first_name' => 'Jane', 'email' => 'jane@test.com']);

        $results = $this->userService->getAll(['search' => 'John'], 0);

        $this->assertCount(1, $results);
        $this->assertEquals('John', $results->first()->first_name);
    }
}
