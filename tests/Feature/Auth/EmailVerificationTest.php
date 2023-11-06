<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class usernameVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_username_verification_screen_can_be_rendered(): void
    {
        $user = User::factory()->create([
            'username_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->get('/verify-username');

        $response->assertStatus(200);
    }

    public function test_username_can_be_verified(): void
    {
        $user = User::factory()->create([
            'username_verified_at' => null,
        ]);

        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->username)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        $this->assertTrue($user->fresh()->hasVerifiedusername());
        $response->assertRedirect(RouteServiceProvider::HOME.'?verified=1');
    }

    public function test_username_is_not_verified_with_invalid_hash(): void
    {
        $user = User::factory()->create([
            'username_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1('wrong-username')]
        );

        $this->actingAs($user)->get($verificationUrl);

        $this->assertFalse($user->fresh()->hasVerifiedusername());
    }
}
