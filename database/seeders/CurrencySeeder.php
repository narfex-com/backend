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
        Currency::insert([
            [
                'code' => 'btc',
                'name' => 'Bitcoin',
                'is_fiat' => false
            ],
            [
                'code' => 'rub',
                'name' => 'Russian Ruble',
                'is_fiat' => true
            ],
            [
                'code' => 'idr',
                'name' => 'Indonesian Rupiah',
                'is_fiat' => true
            ],
        ]);
    }
}
