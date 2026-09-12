<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Wallet;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Wallet::create(['user_id' => 2, 'wallet_name' => 'Tabungan HP', 'type' => 'tunai', 'nominal' => 120000]);
        Wallet::create(['user_id' => 2, 'wallet_name' => 'Tabungan PC', 'type' => 'bank', 'nominal' => 210000]);
        Wallet::create(['user_id' => 2, 'wallet_name' => 'Tabungan Laptop', 'type' => 'e-wallet', 'nominal' => 32000]);
    }
}
