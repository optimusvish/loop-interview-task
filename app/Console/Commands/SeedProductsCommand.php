<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Products;
use Illuminate\Support\Facades\Storage;

class SeedProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Products CSV Import';

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
        $file = Storage::disk('public')->get('products.csv');
        $lines = explode(PHP_EOL, $file);

        // Unsetting the Column Names here
        unset($lines[0]);

        foreach ($lines as $line) {
            $productData = str_getcsv($line);
            $product = new Products([
                'productname' => $productData[1],
                'price' => $productData[2],
            ]);
            $product->save();
        }
    }
}
