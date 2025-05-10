<?php

namespace Tests\Unit;

use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_student()
    {
        $service = app(StudentService::class);
        $data = [
            'name' => 'طالب اختبار',
            'gender' => 'ذكر',
            'study_type' => 'أولية',
        ];
        $student = $service->create($data);
        $this->assertInstanceOf(Student::class, $student);
        $this->assertEquals('طالب اختبار', $student->name);
    }

    public function test_update_student()
    {
        $service = app(StudentService::class);
        $student = Student::factory()->create(['name' => 'قديم']);
        $service->update($student, ['name' => 'جديد']);
        $this->assertEquals('جديد', $student->fresh()->name);
    }

    public function test_delete_student()
    {
        $service = app(StudentService::class);
        $student = Student::factory()->create();
        $result = $service->delete($student);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }
} 