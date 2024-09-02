<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Hospital; // Use Hospital model

class CheckUserRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hospital:role {id}'; // Changed to 'hospital:role'

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the role of a hospital by their ID';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $id = $this->argument('id');
        $hospital = Hospital::find($id); // Use Hospital model

        if ($hospital) {
            $this->info("Hospital Role: " . $hospital->role);
        } else {
            $this->error('Hospital not found.');
        }
    }
}