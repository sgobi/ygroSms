<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Student;
use App\Models\Donor;
use App\Models\Caregiver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SystemHealthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test if dashboard is accessible after login.
     */
    public function test_dashboard_is_accessible_after_login(): void
    {
        $user = User::where('email', 'admin@ygro.lk')->first();
        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }

    /**
     * Test if students index is accessible and lists students.
     */
    public function test_students_index_is_accessible(): void
    {
        $user = User::where('email', 'admin@ygro.lk')->first();
        $response = $this->actingAs($user)->get('/students');

        $response->assertStatus(200);
        $response->assertSee('Students');
        $this->assertGreaterThan(0, Student::count());
    }

    /**
     * Test if donors index is accessible.
     */
    public function test_donors_index_is_accessible(): void
    {
        $user = User::where('email', 'admin@ygro.lk')->first();
        $response = $this->actingAs($user)->get('/donors');

        $response->assertStatus(200);
        $response->assertSee('Donors');
    }

    /**
     * Test student creation.
     */
    public function test_can_create_student(): void
    {
        $user = User::where('email', 'admin@ygro.lk')->first();
        
        $studentData = [
            'name' => 'Test Student',
            'admission_number' => 'ADM999',
            'dob' => '2010-01-01',
            'gender' => 'Male',
            'current_grade' => 6,
            'admission_year' => 2024,
            'address' => 'Test Address',
        ];

        $response = $this->actingAs($user)->post('/students', $studentData);

        // Expect redirect to index or show page
        $response->assertStatus(302);
        $this->assertDatabaseHas('students', ['name' => 'Test Student']);
    }

    /**
     * Test if student show page is accessible.
     */
    public function test_student_show_is_accessible(): void
    {
        $user = User::where('email', 'admin@ygro.lk')->first();
        $student = Student::first();
        $response = $this->actingAs($user)->get("/students/{$student->id}");

        $response->assertStatus(200);
        $response->assertSee($student->name);
    }

    /**
     * Test if caregivers index is accessible.
     */
    public function test_caregivers_index_is_accessible(): void
    {
        $user = User::where('email', 'admin@ygro.lk')->first();
        $response = $this->actingAs($user)->get('/caregivers');

        $response->assertStatus(200);
        $response->assertSee('Caregivers');
    }

    /**
     * Test if products index is accessible.
     */
    public function test_products_index_is_accessible(): void
    {
        $user = User::where('email', 'admin@ygro.lk')->first();
        $response = $this->actingAs($user)->get('/products');

        $response->assertStatus(200);
        $response->assertSee('Products');
    }

    /**
     * Test if distributions index is accessible.
     */
    public function test_distributions_index_is_accessible(): void
    {
        $user = User::where('email', 'admin@ygro.lk')->first();
        $response = $this->actingAs($user)->get('/distributions');

        $response->assertStatus(200);
        $response->assertSee('Distribution');
    }

    /**
     * Test data presence from seeders.
     */
    public function test_data_presence(): void
    {
        $this->assertGreaterThan(0, Student::count());
        $this->assertGreaterThan(0, Donor::count());
        $this->assertGreaterThan(0, Caregiver::count());
        $this->assertGreaterThan(0, \App\Models\Product::count());
    }
}
