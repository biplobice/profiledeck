<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Profile;
use App\Models\Project;
use App\Support\ProfileData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilePageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_home_page_renders_profile(): void
    {
        $profile = Profile::current();

        $this->get('/')
            ->assertOk()
            ->assertSee($profile->name)
            ->assertSee($profile->location)
            ->assertSee('Download CV')
            ->assertSee($profile->blog_url, false)
            ->assertSee('Writing');
    }

    public function test_home_page_hides_the_email_address(): void
    {
        $profile = Profile::current();

        $this->get('/')
            ->assertOk()
            ->assertDontSee($profile->email)
            ->assertDontSee('mailto:', false)
            ->assertSee('Email me');
    }

    public function test_years_of_experience_is_calculated_not_hardcoded(): void
    {
        $years = ProfileData::load()->yearsOfExperience();

        $this->assertGreaterThanOrEqual(10, $years);

        $this->get('/')
            ->assertOk()
            ->assertSee($years.'+ years')
            ->assertDontSee(':years', false);
    }

    public function test_company_rebrand_is_presented_as_one_employer(): void
    {
        $company = Company::query()->where('name', 'Northstar Studio')->firstOrFail();

        $this->assertSame('Acme Digital', $company->former_name);
        $this->assertSame('Northstar Studio (formerly Acme Digital)', $company->displayName());

        $this->get('/')->assertOk()->assertSee('formerly Acme Digital');
    }

    public function test_demo_content_covers_project_visibility_and_kinds(): void
    {
        $this->assertGreaterThanOrEqual(5, Project::query()->count());
        $this->assertGreaterThanOrEqual(3, Project::query()->featured()->count());
        $this->assertTrue(Project::query()->where('is_visible', false)->exists());
        $this->assertTrue(Project::query()->where('kind', Project::KIND_PACKAGE)->exists());
    }

    public function test_featured_projects_have_redistributable_thumbnails(): void
    {
        $project = Project::query()->where('name', 'ProfileDeck')->firstOrFail();

        $this->assertSame('images/demo/project-profiledeck.svg', $project->thumbnail_path);
        $this->assertStringContainsString('project-profiledeck.svg', (string) $project->thumbnailUrl());
        $this->assertFileExists(public_path($project->thumbnail_path));
    }

    public function test_background_section_lists_every_group(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('06 — Background', false)
            ->assertSee('Education')
            ->assertSee('Certifications')
            ->assertSee('Training')
            ->assertSee('Interests');
    }

    public function test_demo_seeder_is_idempotent(): void
    {
        $counts = [
            'profiles' => Profile::query()->count(),
            'companies' => Company::query()->count(),
            'projects' => Project::query()->count(),
        ];

        $this->seed();

        $this->assertSame($counts['profiles'], Profile::query()->count());
        $this->assertSame($counts['companies'], Company::query()->count());
        $this->assertSame($counts['projects'], Project::query()->count());
    }

    public function test_cv_html_page_renders(): void
    {
        $this->get('/cv')->assertOk();
    }

    public function test_cv_pdf_is_generated(): void
    {
        $this->get('/cv.pdf')
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }

    public function test_admin_login_is_available(): void
    {
        $this->get('/admin/login')->assertOk();
    }
}
