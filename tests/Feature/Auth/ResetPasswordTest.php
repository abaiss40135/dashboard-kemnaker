<?php

namespace Tests\Feature\Auth;

use App\Models\OSS\NIB;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    public function test_reset_password_link_screen_can_be_rendered()
    {
        $response = $this->get(route('password.request'));

        $response->assertStatus(200);
    }

    public function test_password_link_can_be_requested()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post(route('password.email'), ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class);

        $user->delete();
    }

    public function test_reset_password_screen_can_be_rendered()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post(route('password.email'), ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
            $response = $this->get(route('password.reset', $notification->token));

            $response->assertStatus(200);

            return true;
        });

        $user->delete();
    }

    public function test_password_can_be_reset_with_valid_token()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post(route('password.email'), ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $response = $this->post(route('password.update'), [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response->assertSessionHasNoErrors();

            return true;
        });

        $user->delete();
    }

    public function test_showing_alert_when_reset_password_with_unregistered_email()
    {
        $response = $this->post(route('password.email'), ['email' => 'unregistered.email@example.net']);
        $response->assertSessionHasErrors([
            "email" => Lang::get('passwords.user')
        ]);

    }

    public function test_showing_alert_when_reset_password_with_unregistered_nrp()
    {
        do {
            $nrp = rand('70000000', '00000000');
        } while (User::where('nrp', $nrp)->exists());

        $response = $this->post(route('password.email'), ['email' => $nrp]);
        $response->assertSessionHasErrors([
            "email" => Lang::get('passwords.user_nrp')
        ]);
    }

    public function test_showing_alert_when_reset_password_with_unregistered_nib()
    {
        do {
            $nib   = rand('0000000000001', '9999999999999');
        } while (NIB::where('nib', $nib)->exists());

        $response = $this->post(route('password.email'), ['email' => $nib]);

        $response->assertSessionHasErrors([
            "email" => Lang::get('passwords.user_nib')
        ]);
    }
}
