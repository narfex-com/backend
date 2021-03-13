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
                'is_fiat' => false,
                'is_enabled' => true
            ]
        );
        Currency::firstOrCreate(
            [
                'code' => 'rub',
                'name' => 'Russian Ruble',
                'is_fiat' => true,
                'is_enabled' => true
            ]
        );
        Currency::firstOrCreate(
            [
                'code' => 'idr',
                'name' => 'Indonesian Rupiah',
                'is_fiat' => true,
                'is_enabled' => true
            ]
        );
        Currency::firstOrCreate(
            [
                'code' => 'usd',
                'name' => 'U.S. Dollar',
                'is_fiat' => true,
                'is_enabled' => true
            ]
        );
        Currency::firstOrCreate(
            [
                'code' => 'eth',
                'name' => 'Ethereum',
                'is_fiat' => false,
                'is_enabled' => true
            ]
        );
        Currency::firstOrCreate(
            [
                'code' => 'ltc',
                'name' => 'Litecoin',
                'is_fiat' => false,
                'is_enabled' => true
            ]
        );
        Currency::firstOrCreate(
            [
                'code' => 'eur',
                'name' => 'Euro',
                'is_fiat' => true,
                'is_enabled' => true
            ]
        );
    }
}
