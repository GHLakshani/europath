<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class RefreshTableSeeder extends Command
{
/**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-table-seeder {seeder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh a specific table by truncating and re-running the seeder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Retrieve the seeder class passed as an argument
        $seeder = $this->argument('seeder');
        
        // Set the table name (dynamic_menus)
        // $table = 'dynamic_menus'; 

        try {
            // Truncate the table to remove all records
            // DB::table($table)->truncate();
            // $this->info("Table '{$table}' truncated successfully.");

            // Run the specified seeder
            Artisan::call('db:seed', ['--class' => $seeder]);
            $this->info("Seeder '{$seeder}' executed successfully.");
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }

        return 0;
    }
}
