<?php

namespace App\Observers;

use App\Models\ProgressReport;
use Illuminate\Support\Facades\Cache;

class ProgressReportObserver
{
    /**
     * Handle the ProgressReport "created" event.
     */
    public function created(ProgressReport $progressReport): void
    {
        $this->clearUserCache($progressReport->karyawan_id);
        $this->updateAssignmentStatus($progressReport);
    }

    /**
     * Handle the ProgressReport "updated" event.
     */
    public function updated(ProgressReport $progressReport): void
    {
        $this->clearUserCache($progressReport->karyawan_id);
        $this->updateAssignmentStatus($progressReport);
    }

    /**
     * Handle the ProgressReport "deleted" event.
     */
    public function deleted(ProgressReport $progressReport): void
    {
        $this->clearUserCache($progressReport->karyawan_id);
    }

    /**
     * Clear user-specific cache when data changes
     */
    private function clearUserCache($userId): void
    {
        Cache::forget("user_stats_{$userId}");
    }

    /**
     * Update assignment status based on progress report status
     */
    private function updateAssignmentStatus(ProgressReport $progressReport): void
    {
        // Only update if progress report has an associated assignment
        if ($progressReport->assignment_id && $progressReport->assignment) {
            $assignment = $progressReport->assignment;

            // Update assignment status based on progress report status
            if ($progressReport->status_pengantaran === 'delivered') {
                $assignment->update(['status' => 'completed']);
            } elseif ($progressReport->status_pengantaran === 'on_delivery') {
                $assignment->update(['status' => 'in_progress']);
            } elseif ($progressReport->status_pengantaran === 'failed') {
                $assignment->update(['status' => 'cancelled']);
            }
        }
    }
}
