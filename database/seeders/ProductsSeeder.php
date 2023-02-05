<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = Storage::disk('public')->get('products.csv');
        $lines = explode(PHP_EOL, $file);

        // Unsetting the Column Names here
        unset($lines[0]);

        foreach ($lines as $line) {
            $productData = str_getcsv($line);

            $record = Products::firstOrNew(['productname' => $productData[1]]);

            if (!$record->exists) {
                Log::info('Inserting new record into products.', [
                    'productname' => $productData[1],
                    'price' => $productData[2],
                ]);

                $record->fill([
                    'productname' => $productData[1],
                    'price' => $productData[2],
                ]);

                $record->save();
            } else {
                Log::info('Record already exists in products.', [
                    'productname' => $productData[1],
                ]);
            }
        }
    }
}
