<?php

namespace Tests\Feature;

use App\Filament\Resources\ProjectResource\Pages\ListProjects;
use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
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
            'account profile' => ['/admin/profile'],
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

    public function test_projects_table_includes_company_and_date_columns(): void
    {
        $this->get('/admin/projects')
            ->assertOk()
            ->assertSee('ID')
            ->assertSee('Company')
            ->assertSee('Started')
            ->assertSee('Ended')
            ->assertSee('Northstar Studio');
    }

    public function test_projects_can_be_sorted_and_filtered_by_company(): void
    {
        $northstar = Company::query()->where('name', 'Northstar Studio')->firstOrFail();
        $independentProjects = Project::query()
            ->whereHas('company', fn ($query) => $query->where('name', 'Independent'))
            ->get();

        Livewire::test(ListProjects::class)
            ->sortTable('id', 'desc')
            ->assertCanSeeTableRecords(Project::query()->orderByDesc('id')->get())
            ->sortTable('started_on')
            ->filterTable('company', $northstar->getKey())
            ->assertCanSeeTableRecords(Project::query()->where('company_id', $northstar->getKey())->get())
            ->assertCanNotSeeTableRecords($independentProjects);
    }
}
