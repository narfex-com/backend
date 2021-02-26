<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::firstOrCreate(
            [
                'code' => 'btc',
                'name' => 'Bitcoin',
                'is_fiat' => false
            ]
        );
        Currency::firstOrCreate(
            [
                'code' => 'rub',
                'name' => 'Russian Ruble',
                'is_fiat' => true
            ]
        );
        Currency::firstOrCreate(
            [
                'code' => 'idr',
                'name' => 'Indonesian Rupiah',
                'is_fiat' => true
            ]
        );
    }
}
