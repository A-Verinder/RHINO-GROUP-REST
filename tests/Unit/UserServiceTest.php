<?php
namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class UserServiceTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase, WithFaker;

    protected $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserService();  // Instantiate the service.
    }

    /** @test */
    public function it_can_return_a_paginated_list_of_users()
    {
        $users = User::factory()->count(10)->create();

        $result = $this->userService->getAllPaginated();

        $this->assertNotEmpty($result);
        $this->assertCount(10, $result);
    }

    /** @test */
    public function it_can_store_a_user_to_database()
    {
        $data = User::factory()->make()->toArray();
        $data['password'] = 'testPassword';  // Example password.

        $this->userService->store($data);

        $this->assertDatabaseHas('users', ['email' => $data['email']]);
    }

    /** @test */
    public function it_can_find_and_return_an_existing_user()
    {
        $user = User::factory()->create();

        $foundUser = $this->userService->findById($user->id);

        $this->assertNotNull($foundUser);
        $this->assertEquals($user->id, $foundUser->id);
    }

    /** @test */
    public function it_can_update_an_existing_user()
    {
        $user = User::factory()->create();
        $data = ['first_name' => 'UpdatedFirstName'];

        $this->userService->update($user->id, $data);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'first_name' => 'UpdatedFirstName']);
    }

    /** @test */
    public function it_can_soft_delete_an_existing_user()
    {
        $user = User::factory()->create();

        $this->userService->softDelete($user->id);

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    /** @test */
    public function it_can_return_a_paginated_list_of_trashed_users()
    {
        $users = User::factory()->count(10)->create();
        foreach ($users as $user) {
            $user->delete();
        }

        $trashedUsers = $this->userService->getAllTrashedPaginated();

        $this->assertNotEmpty($trashedUsers);
        $this->assertCount(10, $trashedUsers);
    }

    /** @test */
    public function it_can_restore_a_soft_deleted_user()
    {
        $user = User::factory()->create();
        $user->delete();

        $this->userService->restore($user->id);

        $this->assertDatabaseHas('users', ['id' => $user->id]);
        $this->assertDatabaseMissing('users', ['id' => $user->id, 'deleted_at' => null]);
    }

    /** @test */
    public function it_can_permanently_delete_a_soft_deleted_user()
    {
        $user = User::factory()->create();
        $user->delete();

        $this->userService->permanentDelete($user->id);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function it_can_upload_photo()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('avatar.jpg');

        $path = $this->userService->uploadPhoto($file, $user->id);

        $this->assertNotNull($path);
        Storage::disk('public')->assertExists($path);
    }
}
