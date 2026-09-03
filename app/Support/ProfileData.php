<?php

namespace App\Support;

use App\Models\Certification;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Interest;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillCategory;
use App\Models\Training;
use Illuminate\Support\Collection;

final class ProfileData
{
    /**
     * @param  Collection<int, Experience>  $experiences
     * @param  Collection<int, SkillCategory>  $skillCategories
     * @param  Collection<int, Project>  $featuredProjects
     * @param  Collection<int, Project>  $packageProjects
     * @param  Collection<int, Education>  $educations
     * @param  Collection<int, Certification>  $certifications
     * @param  Collection<int, Training>  $trainings
     * @param  Collection<int, Interest>  $interests
     */
    public function __construct(
        public Profile $profile,
        public Collection $experiences,
        public Collection $skillCategories,
        public Collection $featuredProjects,
        public Collection $packageProjects,
        public Collection $educations,
        public Collection $certifications,
        public Collection $trainings,
        public Collection $interests,
        public ?Experience $currentRole,
        public int $visibleProjectCount,
    ) {}

    public static function load(): self
    {
        $experiences = Experience::query()
            ->visible()
            ->with('company')
            ->orderByDesc('started_on')
            ->orderBy('sort_order')
            ->get();

        $skillCategories = SkillCategory::query()
            ->visible()
            ->with(['skills' => fn ($query) => $query->visible()])
            ->orderBy('sort_order')
            ->get();

        $featuredProjects = Project::query()
            ->visible()
            ->featured()
            ->with('company')
            ->orderBy('sort_order')
            ->orderByDesc('started_on')
            ->get();

        $packageProjects = Project::query()
            ->visible()
            ->where('kind', Project::KIND_PACKAGE)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return new self(
            profile: Profile::current(),
            experiences: $experiences,
            skillCategories: $skillCategories,
            featuredProjects: $featuredProjects,
            packageProjects: $packageProjects,
            educations: Education::query()->visible()->orderByDesc('ended_on')->get(),
            certifications: Certification::query()->visible()->orderByDesc('awarded_on')->get(),
            trainings: Training::query()->visible()->orderBy('sort_order')->get(),
            interests: Interest::query()->visible()->orderBy('sort_order')->get(),
            currentRole: $experiences->firstWhere('ended_on', null) ?? $experiences->first(),
            visibleProjectCount: Project::query()->visible()->count(),
        );
    }

    public function hasProjectArchive(): bool
    {
        return $this->visibleProjectCount > $this->featuredProjects->count();
    }

    /**
     * Profile copy may contain a ":years" token so the number stays current.
     */
    public function resolve(?string $value): string
    {
        return str_replace(':years', (string) $this->yearsOfExperience(), (string) $value);
    }

    public function yearsOfExperience(): int
    {
        $oldest = $this->experiences
            ->map(fn (Experience $experience) => $experience->started_on)
            ->filter()
            ->sort()
            ->first();

        return $oldest ? max(1, (int) $oldest->diffInYears(now())) : 0;
    }
}
