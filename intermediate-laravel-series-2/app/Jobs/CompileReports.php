<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class CompileReports
{
    use Dispatchable, Queueable;

    protected $reportId;
    protected $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($reportId)
    {
        $this->reportId = $reportId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        var_dump('Compiling the ' . $this->type . ' report with id ' . $this->reportId . ' within the Job class.');
    }
}
