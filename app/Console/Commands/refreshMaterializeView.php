<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class refreshMaterializeView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:materialize
                            {table : the name of materialize table }
                            {--concurrently=Y : Whether the refresh should be concurrently}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh materialize view table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tableName = $this->argument('table');
        $statement = 'REFRESH MATERIALIZED VIEW ';
        if (strtoupper($this->option('concurrently')) == 'Y') {
            $statement .= 'CONCURRENTLY ';
        }
        echo $statement;
        try {
            DB::statement($statement . $tableName);
            echo 'Success refresh ' . $tableName;
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            \Log::error($statement, [
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
