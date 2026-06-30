<?php

namespace Tests\Feature;

use App\Models\SharedAccount;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/')->assertRedirect('/accounts');
        $this->get('/accounts')->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_accounts_and_get_otp(): void
    {
        $user = User::factory()->create();
        $account = SharedAccount::create([
            'website_domain' => 'example.com',
            'login' => 'shared@example.com',
            'password' => 'secret-password',
            'two_factor_secret' => 'JBSWY3DPEHPK3PXP',
        ]);

        $this->actingAs($user)
            ->get('/accounts')
            ->assertOk()
            ->assertSee('example.com')
            ->assertSee('shared@example.com');

        $this->actingAs($user)
            ->getJson(route('accounts.otp', $account))
            ->assertOk()
            ->assertJsonStructure(['otp', 'seconds_remaining'])
            ->assertJson(fn ($json) => $json
                ->whereType('otp', 'string')
                ->whereType('seconds_remaining', 'integer')
                ->etc());
    }

    public function test_admin_can_create_account_with_encrypted_secrets(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->post(route('accounts.store'), [
                'website_domain' => 'example.org',
                'login' => 'team@example.org',
                'password' => 'plain-password',
                'two_factor_secret' => 'JBSWY3DPEHPK3PXP',
            ])
            ->assertRedirect(route('accounts.index'));

        $account = SharedAccount::firstOrFail();

        $this->assertNotSame('plain-password', $account->getRawOriginal('password'));
        $this->assertNotSame('JBSWY3DPEHPK3PXP', $account->getRawOriginal('two_factor_secret'));
    }
}
