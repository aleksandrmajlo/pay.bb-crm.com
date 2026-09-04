<?php

namespace Tests\Unit;

use App\Http\Controllers\BilliardController;
use App\Models\Billiard;
use App\Services\ClubDatabaseProvisioner;
use Mockery;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class BilliardControllerTest extends TestCase
{
    public function test_it_forbids_deleting_a_non_free_billiard(): void
    {
        $billiard = new Billiard([
            'idd' => 'billiards_16',
            'isFree' => 0,
        ]);
        $provisioner = Mockery::mock(ClubDatabaseProvisioner::class);
        $provisioner->shouldNotReceive('delete');

        try {
            app(BilliardController::class)->destroy($billiard, $provisioner);
            $this->fail('A non-free billiard deletion should be forbidden.');
        } catch (HttpException $exception) {
            $this->assertSame(403, $exception->getStatusCode());
        }
    }

    public function test_it_deletes_a_free_billiard_after_provisioner_confirmation(): void
    {
        $billiard = new Billiard([
            'idd' => 'billiards_16',
            'isFree' => 1,
        ]);
        $provisioner = Mockery::mock(ClubDatabaseProvisioner::class);
        $provisioner->shouldReceive('delete')
            ->once()
            ->with($billiard)
            ->andReturn([
                'deleted' => true,
                'database' => 'billiards_16',
            ]);

        $response = app(BilliardController::class)->destroy($billiard, $provisioner);

        $this->assertSame(route('billiards.index'), $response->getTargetUrl());
        $this->assertSame(__('billiard.deleted'), session('success'));
    }
}
