<?php

namespace App\Services;

use App\Exceptions\ClubDatabaseProvisionerException;
use App\Models\Billiard;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class ClubDatabaseProvisioner
{
    /**
     * @return array<string, mixed>
     */
    public function delete(Billiard $billiard): array
    {
        $baseUrl = rtrim((string) config('club_database_provisioner.base_url'), '/');
        $token = (string) config('club_database_provisioner.token');
        $idempotencyKey = (string) config('club_database_provisioner.idempotency_key');
        $configPaths = array_values(array_filter(
            (array) config('club_database_provisioner.config_paths'),
            fn ($path) => is_string($path) && $path !== ''
        ));

        if ($baseUrl === '' || $token === '' || $idempotencyKey === '' || $configPaths === []) {
            throw new ClubDatabaseProvisionerException('Club database provisioner is not configured.');
        }

        $url = sprintf('%s/api/club-databases/%s', $baseUrl, rawurlencode($billiard->idd));

        try {
            $response = Http::acceptJson()
                ->asJson()
                ->withToken($token)
                ->withHeaders(['Idempotency-Key' => $idempotencyKey])
                ->connectTimeout((int) config('club_database_provisioner.connect_timeout', 5))
                ->timeout((int) config('club_database_provisioner.timeout', 30))
                ->delete($url, [
                    'dry_run' => false,
                    'config_paths' => $configPaths,
                ])
                ->throw();
        } catch (ConnectionException|RequestException $exception) {
            throw new ClubDatabaseProvisionerException(
                'Club database provisioner request failed.',
                0,
                $exception
            );
        }

        $payload = $response->json();

        if (! is_array($payload)) {
            throw new ClubDatabaseProvisionerException('Club database provisioner returned invalid JSON.');
        }

        if (($payload['database'] ?? null) !== $billiard->idd) {
            throw new ClubDatabaseProvisionerException('Club database provisioner returned a different database.');
        }

        if (! ($payload['deleted'] ?? false) && ! ($payload['already_deleted'] ?? false)) {
            throw new ClubDatabaseProvisionerException('Club database provisioner did not confirm deletion.');
        }

        return $payload;
    }
}
