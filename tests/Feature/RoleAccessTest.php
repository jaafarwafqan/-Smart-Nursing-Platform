<?php

namespace Tests\Feature;

use App\Models\Event;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Branch;
use Illuminate\Support\Facades\Artisan;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Disable permission cache during testing
        config(['permission.cache.store' => 'array']);
        app()['cache']->flush();
        Artisan::call('permission:cache-reset');

        // Create branches for testing
        Branch::firstOrCreate(['id' => 1, 'name' => 'رئيسي']);
        Branch::firstOrCreate(['id' => 2, 'name' => 'فرع 2']);

        // Create permissions
        Permission::firstOrCreate(['name' => 'manage_events', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'manage_campaigns', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'view_events', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'edit_events', 'guard_name' => 'web']);

        // Create roles
        $ole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $professorRole = Role::firstOrCreate(['name' => 'professor', 'guard_name' => 'web']);
        $studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
        $supervisorRole = Role::firstOrCreate(['name' => 'supervisor', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Assign permissions to roles
        $ole->givePermissionTo(['manage_events', 'manage_campaigns', 'view_events', 'edit_events']);
        $supervisorRole->givePermissionTo(['manage_events', 'view_events', 'edit_events']);
        $userRole->givePermissionTo(['view_events']);
    }

    /** @test */
    public function can_access_everything()
    {
        $admin = User::factory()->create(['is_admin' => true, 'branch_id' => 1]);
        $admin->assignRole('admin');
        $this->actingAs($admin->fresh(), 'web');

        $this->get(route('events.index'))->assertStatus(200);
        $this->get(route('campaigns.index'))->assertStatus(200);
    }

    /** @test */
    public function professor_cannot_access_events_or_campaigns()
    {
        $prof = User::factory()->create(['is_admin' => false]);
        $prof->assignRole('professor');
        $this->actingAs($prof);

        $this->get(route('events.index'))->assertStatus(403);
        $this->get(route('campaigns.index'))->assertStatus(403);
    }

    /** @test */
    public function student_cannot_create_or_edit_proposals()
    {
        $student = User::factory()->create(['is_admin' => false]);
        $student->assignRole('student');
        $this->actingAs($student);

        $this->get(route('researches.proposals.create'))->assertStatus(403);
        $proposal = ResearchProposal::factory()->create();
        $this->get(route('researches.proposals.edit', $proposal))->assertStatus(403);
    }

    /** @test */
    public function supervisor_can_only_see_and_edit_his_branch_events()
    {
        $supervisor = User::factory()->create(['branch_id' => 1, 'is_admin' => false]);
        $supervisor->assignRole('supervisor');
        $this->actingAs($supervisor->fresh(), 'web');

        $eventA = Event::factory()->create(['branch_id' => 1]);
        $eventB = Event::factory()->create(['branch_id' => 2]);

        $this->get(route('events.index'))->assertStatus(200);
        $this->get(route('events.edit', $eventA))->assertStatus(200);
        $this->get(route('events.edit', $eventB))->assertStatus(403);
    }

    /** @test */
    public function user_can_only_see_his_branch_events()
    {
        $user = User::factory()->create(['branch_id' => 1, 'is_admin' => false]);
        $user->assignRole('user');
        $this->actingAs($user->fresh(), 'web');

        $eventA = Event::factory()->create(['branch_id' => 1]);
        $eventB = Event::factory()->create(['branch_id' => 2]);

        $this->get(route('events.index'))->assertStatus(200);
        $this->get(route('events.edit', $eventA))->assertStatus(403);
        $this->get(route('events.edit', $eventB))->assertStatus(403);
    }
}
