<?php

namespace Database\Seeders;

use App\Models\Certification;
use App\Models\Company;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Interest;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\Training;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class DemoSeeder extends Seeder
{
    public const ADMIN_EMAIL = 'admin@example.com';

    public const ADMIN_PASSWORD = 'password';

    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => self::ADMIN_EMAIL],
            [
                'name' => 'Demo Administrator',
                'password' => Hash::make(self::ADMIN_PASSWORD),
            ],
        );

        Profile::query()->updateOrCreate(
            ['email' => 'alex@example.com'],
            [
                'name' => 'Alex Morgan',
                'headline' => 'Full Stack Engineer',
                'tagline' => ':years+ years turning complex ideas into dependable products',
                'summary' => 'Full Stack Engineer with :years+ years of experience building accessible, maintainable web applications.',
                'bio' => 'I work across product strategy, interface design, APIs, and infrastructure. I enjoy small teams, useful software, and leaving codebases easier to change than I found them.',
                'location' => 'Portland, Oregon',
                'phone' => null,
                'website' => 'https://example.com',
                'blog_url' => 'https://notes.example.com',
                'github_url' => 'https://github.com/example',
                'linkedin_url' => 'https://www.linkedin.com/in/example',
                'twitter_url' => null,
                'photo_path' => 'images/demo/avatar.svg',
                'cv_photo_path' => 'images/demo/avatar.svg',
            ],
        );

        $northstar = $this->company(
            name: 'Northstar Studio',
            formerName: 'Acme Digital',
            website: 'https://example.com',
            city: 'Portland',
            country: 'United States',
        );
        $orbit = $this->company(
            name: 'Orbit Systems',
            website: 'https://example.org',
            city: 'Seattle',
            country: 'United States',
        );
        $independent = $this->company(
            name: 'Independent',
            website: 'https://example.net',
            city: 'Portland',
            country: 'United States',
        );

        $this->experience($northstar, [
            'title' => 'Lead Full Stack Engineer',
            'employment_type' => 'Full-time',
            'started_on' => '2021-03-01',
            'ended_on' => null,
            'summary' => 'Leading product delivery for content, commerce, and internal platforms.',
            'responsibilities' => [
                'Translate product goals into maintainable technical plans',
                'Build Laravel applications and APIs',
                'Mentor engineers and improve delivery practices',
            ],
            'achievements' => [
                'Reduced deployment time through repeatable automation',
                'Delivered a shared design system across three products',
            ],
            'sort_order' => 0,
        ]);
        $this->experience($orbit, [
            'title' => 'Software Engineer',
            'employment_type' => 'Full-time',
            'started_on' => '2017-06-01',
            'ended_on' => '2021-02-28',
            'summary' => 'Built customer-facing applications and operational tooling.',
            'responsibilities' => [
                'Developed responsive interfaces and REST APIs',
                'Maintained cloud infrastructure and CI pipelines',
            ],
            'achievements' => ['Improved application performance and observability'],
            'sort_order' => 1,
        ]);
        $this->experience($independent, [
            'title' => 'Web Developer',
            'employment_type' => 'Freelance',
            'started_on' => '2013-09-01',
            'ended_on' => '2017-05-31',
            'summary' => 'Designed and delivered websites for small organizations.',
            'responsibilities' => ['Discovery, design, development, and launch'],
            'achievements' => null,
            'sort_order' => 2,
        ]);

        $this->skills([
            'Backend' => ['PHP', 'Laravel', 'MySQL', 'REST APIs'],
            'Frontend' => ['HTML', 'CSS', 'JavaScript', 'Tailwind CSS'],
            'Delivery' => ['Git', 'Docker', 'CI/CD', 'AWS'],
        ]);

        $this->project($northstar, [
            'name' => 'Beacon Commerce',
            'kind' => Project::KIND_PROFESSIONAL,
            'summary' => 'A multi-region storefront and operations platform.',
            'role' => 'Technical lead',
            'technologies' => ['Laravel', 'MySQL', 'Tailwind CSS', 'AWS'],
            'url' => 'https://example.com',
            'thumbnail_path' => 'images/demo/project-beacon.svg',
            'is_featured' => true,
            'sort_order' => 0,
        ]);
        $this->project($northstar, [
            'name' => 'Atlas Knowledge Base',
            'kind' => Project::KIND_PROFESSIONAL,
            'summary' => 'Searchable documentation for customers and support teams.',
            'role' => 'Full stack engineer',
            'technologies' => ['Laravel', 'Alpine.js', 'Meilisearch'],
            'url' => 'https://example.org',
            'thumbnail_path' => 'images/demo/project-atlas.svg',
            'is_featured' => true,
            'sort_order' => 1,
        ]);
        $this->project($independent, [
            'name' => 'ProfileDeck',
            'kind' => Project::KIND_PERSONAL,
            'summary' => 'An open-source portfolio and CV CMS powered by Laravel and Filament.',
            'role' => 'Creator',
            'technologies' => ['Laravel', 'Filament', 'Tailwind CSS'],
            'url' => 'https://github.com/example/profiledeck',
            'thumbnail_path' => 'images/demo/project-profiledeck.svg',
            'is_featured' => true,
            'sort_order' => 2,
        ]);
        $this->project($independent, [
            'name' => 'Release Notes',
            'kind' => Project::KIND_PERSONAL,
            'summary' => 'A tiny changelog publisher used to demonstrate hidden projects.',
            'technologies' => ['PHP', 'SQLite'],
            'is_featured' => false,
            'is_visible' => false,
            'sort_order' => 3,
        ]);
        $this->project($northstar, [
            'name' => 'Content Blocks',
            'kind' => Project::KIND_PACKAGE,
            'summary' => 'Reusable editorial components for content teams.',
            'technologies' => ['Laravel', 'Blade'],
            'is_featured' => false,
            'sort_order' => 4,
        ]);

        Education::query()->updateOrCreate(
            ['credential' => 'BSc in Computer Science', 'institution' => 'Example State University'],
            [
                'started_on' => '2009-09-01',
                'ended_on' => '2013-06-01',
                'is_visible' => true,
                'sort_order' => 0,
            ],
        );
        Certification::query()->updateOrCreate(
            ['name' => 'Cloud Practitioner', 'organization' => 'Example Cloud'],
            [
                'result' => 'Certified',
                'awarded_on' => '2024-04-15',
                'is_visible' => true,
                'sort_order' => 0,
            ],
        );
        Certification::query()->updateOrCreate(
            ['name' => 'Professional Web Accessibility', 'organization' => 'Open Learning Institute'],
            [
                'result' => 'Completed',
                'awarded_on' => '2023-10-02',
                'is_visible' => true,
                'sort_order' => 1,
            ],
        );
        Training::query()->updateOrCreate(
            ['name' => 'Technical Leadership Workshop'],
            ['organization' => 'Example Academy', 'is_visible' => true, 'sort_order' => 0],
        );

        foreach (['Open source', 'Photography', 'Cycling', 'Coffee'] as $index => $name) {
            Interest::query()->updateOrCreate(
                ['name' => $name],
                ['is_visible' => true, 'sort_order' => $index],
            );
        }
    }

    private function company(
        string $name,
        ?string $formerName = null,
        ?string $website = null,
        ?string $city = null,
        ?string $country = null,
    ): Company {
        return Company::query()->updateOrCreate(
            ['name' => $name],
            [
                'former_name' => $formerName,
                'website' => $website,
                'city' => $city,
                'country' => $country,
            ],
        );
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function experience(Company $company, array $attributes): void
    {
        Experience::query()->updateOrCreate(
            [
                'company_id' => $company->getKey(),
                'title' => $attributes['title'],
                'started_on' => $attributes['started_on'],
            ],
            [
                ...$attributes,
                'is_visible' => $attributes['is_visible'] ?? true,
            ],
        );
    }

    /**
     * @param  array<string, list<string>>  $categories
     */
    private function skills(array $categories): void
    {
        foreach ($categories as $categoryIndex => $skills) {
            $category = SkillCategory::query()->updateOrCreate(
                ['name' => $categoryIndex],
                ['is_visible' => true, 'sort_order' => array_search($categoryIndex, array_keys($categories), true)],
            );

            foreach ($skills as $skillIndex => $name) {
                Skill::query()->updateOrCreate(
                    ['skill_category_id' => $category->getKey(), 'name' => $name],
                    ['is_visible' => true, 'sort_order' => $skillIndex],
                );
            }
        }
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function project(Company $company, array $attributes): void
    {
        if (! $company->exists) {
            throw new RuntimeException('Projects must reference a persisted company.');
        }

        Project::query()->updateOrCreate(
            ['company_id' => $company->getKey(), 'name' => $attributes['name']],
            [
                ...$attributes,
                'is_visible' => $attributes['is_visible'] ?? true,
                'is_featured' => $attributes['is_featured'] ?? false,
            ],
        );
    }
}
