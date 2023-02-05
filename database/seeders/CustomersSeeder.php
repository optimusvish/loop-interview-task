<?php

namespace Database\Seeders;

use App\Models\Customers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = Storage::disk('public')->get('customers.csv');
        $lines = explode(PHP_EOL, $file);

        // Unsetting the Column Names From CSV Data here
        unset($lines[0]);

        foreach ($lines as $line) {
            $customerData = str_getcsv($line);

            $record = Customers::firstOrNew(['Email_Address' => $customerData[2]]);

            if (!$record->exists) {
                Log::info('Inserting new record into customers.', [
                    'Job_Title' => $customerData[1],
                    'Email_Address' => $customerData[2],
                    'FirstName_LastName' => $customerData[3],
                    'registered_since' => date('Y-m-d', strtotime($customerData[4])),
                    'phone' => $customerData[5],
                ]);

                $record->fill([
                    'Job_Title' => $customerData[1],
                    'Email_Address' => $customerData[2],
                    'FirstName_LastName' => $customerData[3],
                    'registered_since' => date('Y-m-d', strtotime($customerData[4])),
                    'phone' => $customerData[5],
                ]);

                $record->save();
            } else {
                Log::info('Record already exists in customers.', [
                    'Email_Address' => $customerData[2],
                ]);
            }
        }
    }
}
