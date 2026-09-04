<?php

namespace Tests\Unit;

use App\Exceptions\ClubDatabaseProvisionerException;
use App\Models\Billiard;
use App\Services\ClubDatabaseProvisioner;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ClubDatabaseProvisionerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('club_database_provisioner', [
            'base_url' => 'http://localhost:8081',
            'token' => 'test-token',
            'idempotency_key' => 'club-database-provisioner',
            'connect_timeout' => 5,
            'timeout' => 30,
            'config_paths' => [
                '/login/config/database.php',
                '/pt/config',
                '/pay/config/database.php',
            ],
        ]);

        Http::preventStrayRequests();
    }

    public function test_it_sends_the_expected_delete_request(): void
    {
        Http::fake([
            'http://localhost:8081/api/club-databases/billiards_16' => Http::response([
                'deleted' => true,
                'already_deleted' => false,
                'database' => 'billiards_16',
                'billing_record_deleted' => true,
                'database_deleted' => true,
            ]),
        ]);

        $billiard = new Billiard([
            'idd' => 'billiards_16',
            'isFree' => 1,
        ]);

        $result = app(ClubDatabaseProvisioner::class)->delete($billiard);

        $this->assertTrue($result['deleted']);

        Http::assertSent(function (Request $request): bool {
            return $request->method() === 'DELETE'
                && $request->url() === 'http://localhost:8081/api/club-databases/billiards_16'
                && $request->hasHeader('Authorization', 'Bearer test-token')
                && $request->hasHeader('Idempotency-Key', 'club-database-provisioner')
                && $request->data() === [
                    'dry_run' => false,
                    'config_paths' => [
                        '/login/config/database.php',
                        '/pt/config',
                        '/pay/config/database.php',
                    ],
                ];
        });
    }

    public function test_it_rejects_a_response_for_another_database(): void
    {
        Http::fake([
            '*' => Http::response([
                'deleted' => true,
                'database' => 'billiards_15',
            ]),
        ]);

        $this->expectException(ClubDatabaseProvisionerException::class);

        app(ClubDatabaseProvisioner::class)->delete(new Billiard([
            'idd' => 'billiards_16',
            'isFree' => 1,
        ]));
    }
}
