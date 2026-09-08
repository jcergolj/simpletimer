<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\RunningTimerSessionController;
use App\Models\TimeEntry;
use App\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(RunningTimerSessionController::class)]
final class RunningTimerSessionControllerTest extends TestCase
{
    #[Test]
    public function a_stale_edit_cannot_change_the_current_timer(): void
    {
        $user = User::factory()->create();
        $staleTimer = TimeEntry::factory()->ongoing()->create();
        $staleTimer->update(['end_time' => now(), 'duration' => 60]);
        $runningTimer = TimeEntry::factory()->ongoing()->create();
        $originalStartTime = $runningTimer->start_time;

        $response = $this->actingAs($user)->put(route('running-timer-session.update'), [
            'time_entry_id' => $staleTimer->id,
            'start_time' => now()->subHour()->format('Y-m-d H:i:s'),
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertTrue($runningTimer->fresh()->start_time->equalTo($originalStartTime));
    }

    #[Test]
    public function a_stale_cancel_cannot_delete_the_current_timer(): void
    {
        $user = User::factory()->create();
        $staleTimer = TimeEntry::factory()->ongoing()->create();
        $staleTimer->update(['end_time' => now(), 'duration' => 60]);
        $runningTimer = TimeEntry::factory()->ongoing()->create();

        $response = $this->actingAs($user)->delete(route('running-timer-session.destroy', [
            'time_entry_id' => $staleTimer->id,
        ]));

        $response->assertRedirect(route('dashboard'));
        $this->assertNotNull($runningTimer->fresh());
        $this->assertNull($runningTimer->fresh()->end_time);
    }

    #[Test]
    public function a_stale_stop_cannot_complete_the_current_timer(): void
    {
        $user = User::factory()->create();
        $staleTimer = TimeEntry::factory()->ongoing()->create();
        $staleTimer->update(['end_time' => now(), 'duration' => 60]);
        $runningTimer = TimeEntry::factory()->ongoing()->create();

        $response = $this->actingAs($user)->post(route('running-timer-session.completion', [
            'time_entry_id' => $staleTimer->id,
        ]));

        $response->assertRedirect(route('dashboard'));
        $this->assertNull($runningTimer->fresh()->end_time);
    }
}
