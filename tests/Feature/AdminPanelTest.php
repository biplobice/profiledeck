<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->actingAs(User::query()->firstOrFail());
    }

    public static function resourcePathProvider(): array
    {
        return [
            'dashboard' => ['/admin'],
            'profiles' => ['/admin/profiles'],
            'companies' => ['/admin/companies'],
            'experiences' => ['/admin/experiences'],
            'projects' => ['/admin/projects'],
            'skill categories' => ['/admin/skill-categories'],
            'skills' => ['/admin/skills'],
            'education' => ['/admin/education'],
            'certifications' => ['/admin/certifications'],
            'trainings' => ['/admin/trainings'],
            'interests' => ['/admin/interests'],
        ];
    }

    #[DataProvider('resourcePathProvider')]
    public function test_admin_page_loads(string $path): void
    {
        $this->get($path)->assertOk();
    }

    public function test_experience_edit_form_loads(): void
    {
        $this->get('/admin/experiences/1/edit')->assertOk();
    }

    public function test_project_create_form_loads(): void
    {
        $this->get('/admin/projects/create')->assertOk();
    }
}
