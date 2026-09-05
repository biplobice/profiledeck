<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DemoSeeder;
use Filament\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Filament\Auth\Pages\EditProfile;
use Filament\Auth\Pages\PasswordReset\RequestPasswordReset;
use Filament\Auth\Pages\PasswordReset\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_login_page_links_to_password_reset(): void
    {
        $this->get('/admin/login')
            ->assertOk()
            ->assertSee('Forgot password?')
            ->assertSee('/admin/password-reset/request', false);
    }

    public function test_guest_can_open_the_password_reset_request_page(): void
    {
        $this->get('/admin/password-reset/request')
            ->assertOk()
            ->assertSee('Email address');
    }

    public function test_guest_cannot_open_the_profile_page(): void
    {
        $this->get('/admin/profile')
            ->assertRedirect('/admin/login');
    }

    public function test_admin_can_change_password_from_the_profile_page(): void
    {
        $user = User::query()->where('email', DemoSeeder::ADMIN_EMAIL)->firstOrFail();
        $newPassword = 'fresh-admin-password-1';

        $this->actingAs($user);

        Livewire::test(EditProfile::class)
            ->fillForm([
                'name' => $user->name,
                'email' => $user->email,
                'password' => $newPassword,
                'passwordConfirmation' => $newPassword,
                'currentPassword' => DemoSeeder::ADMIN_PASSWORD,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertTrue(Hash::check($newPassword, $user->fresh()->password));
        $this->assertFalse(Hash::check(DemoSeeder::ADMIN_PASSWORD, $user->fresh()->password));
    }

    public function test_forgotten_password_can_be_reset_from_the_emailed_link(): void
    {
        Notification::fake();

        $user = User::query()->where('email', DemoSeeder::ADMIN_EMAIL)->firstOrFail();
        $newPassword = 'reset-admin-password-1';

        Livewire::test(RequestPasswordReset::class)
            ->fillForm([
                'email' => $user->email,
            ])
            ->call('request')
            ->assertHasNoFormErrors();

        $resetUrl = null;

        Notification::assertSentTo(
            $user,
            ResetPasswordNotification::class,
            function (ResetPasswordNotification $notification) use (&$resetUrl): bool {
                $resetUrl = $notification->url;

                return filled($notification->url);
            },
        );

        $this->assertNotNull($resetUrl);
        $this->get($resetUrl)->assertOk();

        parse_str((string) parse_url($resetUrl, PHP_URL_QUERY), $query);

        Livewire::test(ResetPassword::class, [
            'email' => $query['email'] ?? $user->email,
            'token' => $query['token'] ?? null,
        ])
            ->fillForm([
                'password' => $newPassword,
                'passwordConfirmation' => $newPassword,
            ])
            ->call('resetPassword')
            ->assertHasNoFormErrors();

        $this->assertTrue(Hash::check($newPassword, $user->fresh()->password));
    }
}
