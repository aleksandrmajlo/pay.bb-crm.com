<?php

namespace Tests\Feature;

use App\Models\Billiard;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BilliardSmsSettingsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        DB::purge('sqlite');
        (require database_path('migrations/2024_02_04_073036_create_billiards_table.php'))->up();
        (require database_path('migrations/2024_02_09_090710_create_rates_table.php'))->up();
        (require database_path('migrations/2026_11_17_000000_create_billiard_sms_settings_table.php'))->up();

        $this->actingAs(new User());
    }

    public function test_credentials_are_encrypted_per_club_and_never_rendered(): void
    {
        $club = Billiard::create(['name' => 'Club', 'idd' => 'club_1']);
        $other = Billiard::create(['name' => 'Other', 'idd' => 'club_2']);

        $this->put(route('billiards.update', $club), $this->formData([
            'turbosms_login' => 'turbo-login',
            'turbosms_password' => 'turbo-secret',
            'twillo_sid' => 'sid-123',
            'twillo_token' => 'twilio-secret',
            'twillo_from' => '+18337591488',
        ]))->assertRedirect();

        $settings = $club->fresh()->smsSettings;
        $this->assertSame('turbo-secret', $settings->turbosms_password);
        $this->assertSame('twilio-secret', $settings->twillo_token);
        $this->assertNotSame('turbo-secret', $settings->getRawOriginal('turbosms_password'));
        $this->assertNotSame('twilio-secret', $settings->getRawOriginal('twillo_token'));
        $this->assertSame('turbo-login', $settings->turbosms_login);
        $this->assertSame('sid-123', $settings->twillo_sid);
        $this->assertSame('+18337591488', $settings->twillo_from);
        $this->assertNull($other->fresh()->smsSettings->turbosms_login);
        $this->assertArrayNotHasKey('twillo_token', $settings->toArray());
        $this->assertArrayNotHasKey('turbosms_password', $settings->toArray());
        $this->assertDatabaseCount('billiard_sms_settings', 1);

        $this->get(route('billiards.edit', $club))
            ->assertOk()
            ->assertSee('turbo-login')
            ->assertDontSee('turbo-secret')
            ->assertDontSee('twilio-secret');
    }

    public function test_blank_or_missing_secrets_preserve_values_and_they_can_be_cleared(): void
    {
        $club = Billiard::create(['name' => 'Club', 'idd' => 'club_1']);
        $settings = $club->smsSettings;
        $settings->turbosms_password = 'turbo-secret';
        $settings->twillo_token = 'twilio-secret';
        $club->smsSettings()->save($settings);
        $originalPassword = $settings->getRawOriginal('turbosms_password');
        $originalToken = $settings->getRawOriginal('twillo_token');

        $this->put(route('billiards.update', $club), $this->formData([
            'turbosms_password' => '', 'twillo_token' => '',
        ]))->assertRedirect();
        $this->put(route('billiards.update', $club), $this->formData())->assertRedirect();
        $settings = $club->fresh()->smsSettings;
        $this->assertSame($originalPassword, $settings->getRawOriginal('turbosms_password'));
        $this->assertSame($originalToken, $settings->getRawOriginal('twillo_token'));

        $this->put(route('billiards.update', $club), $this->formData([
            'clear_turbosms_password' => '1', 'clear_twillo_token' => '1',
        ]))->assertRedirect();
        $settings = $club->fresh()->smsSettings;
        $this->assertNull($settings->turbosms_password);
        $this->assertNull($settings->twillo_token);
    }

    public function test_validation_does_not_flash_secrets(): void
    {
        $club = Billiard::create(['name' => 'Club', 'idd' => 'club_1']);

        $this->from(route('billiards.edit', $club))
            ->put(route('billiards.update', $club), $this->formData([
                'turbosms_login' => str_repeat('a', 256),
                'turbosms_password' => 'turbo-secret',
                'twillo_token' => 'twilio-secret',
            ]))
            ->assertSessionHasErrors('turbosms_login')
            ->assertSessionMissing('_old_input.turbosms_password')
            ->assertSessionMissing('_old_input.twillo_token');
    }

    private function formData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Club', 'date_end' => '2027-01-01', 'valuta' => 'UAH', 'comment' => '',
        ], $overrides);
    }
}
