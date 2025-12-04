<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeOverviewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_list_of_employees_to_practice_manager()
    {
        // Create a practice manager
        $practiceManager = User::factory()->create([
            'role' => 'practicemanager',
            'status' => 'active'
        ]);

        // Create some test employees
        $dentist = User::factory()->create([
            'role' => 'dentist',
            'status' => 'active'
        ]);

        $assistant = User::factory()->create([
            'role' => 'assistant',
            'status' => 'active'
        ]);

        // Act as the practice manager
        $response = $this->actingAs($practiceManager)
                         ->get(route('employees.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('employees.index');
        $response->assertViewHas('employees');
        $response->assertSee($dentist->name);
        $response->assertSee(ucfirst($dentist->role));
        $response->assertSee('Actief');
        $response->assertSee($assistant->name);
        $response->assertSee(ucfirst($assistant->role));
    }

    /** @test */
    public function it_shows_no_employees_message_when_no_regular_employees_exist()
    {
        // Create a practice manager
        $practiceManager = User::factory()->create([
            'role' => 'practicemanager',
            'status' => 'active'
        ]);

        // Delete all users except the practice manager
        User::where('id', '!=', $practiceManager->id)
            ->where('role', '!=', 'practicemanager')
            ->delete();

        // Act as the practice manager
        $response = $this->actingAs($practiceManager)
                         ->get(route('employees.index'));

        // Assert that the practice manager is not in the list
        $response->assertStatus(200);
        $response->assertViewIs('employees.index');
        
        // The practice manager's name should not appear in the employee list table
        $response->assertSee('Geen medewerkers beschikbaar');
        
        // The practice manager should not be in the employees list
        $this->assertTrue($practiceManager->role === 'practicemanager');
        $this->assertCount(0, $response->viewData('employees'));
    }

    /** @test */
    public function it_denies_access_to_non_practice_managers()
    {
        // Create a regular employee (not a practice manager)
        $employee = User::factory()->create([
            'role' => 'dentist',
            'status' => 'active'
        ]);

        // Act as the regular employee
        $response = $this->actingAs($employee)
                         ->get(route('employees.index'));

        // Assert access is denied
        $response->assertStatus(403);
    }

    /** @test */
    public function it_redirects_guests_to_login()
    {
        $response = $this->get(route('employees.index'));
        $response->assertRedirect(route('login'));
    }
}
