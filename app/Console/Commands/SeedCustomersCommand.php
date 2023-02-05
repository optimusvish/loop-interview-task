<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customers;
use Illuminate\Support\Facades\Storage;

class SeedCustomersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:customers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Customers CSV import';

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
        $file = Storage::disk('public')->get('customers.csv');
        $lines = explode(PHP_EOL, $file);

        // Unsetting the Column Names From CSV Data here
        unset($lines[0]);

        foreach ($lines as $line) {
            $customerData = str_getcsv($line);
            $customer = new Customers([
                'Job_Title' => $customerData[1],
                'Email_Address' => $customerData[2],
                'FirstName_LastName' => $customerData[3],
                'registered_since' => date('Y-m-d', strtotime($customerData[4])),
                'phone' => $customerData[5],
            ]);
            $customer->save();
        }
    }
}
