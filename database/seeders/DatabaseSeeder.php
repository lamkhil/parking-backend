<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);


        DB::table('vehicle_types')->insert([
            [
                'name' => 'Motor',
                'description' => 'Kendaraan roda dua',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mobil',
                'description' => 'Kendaraan roda empat',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $motorId = DB::table('vehicle_types')->where('name', 'Motor')->value('id');
        $mobilId = DB::table('vehicle_types')->where('name', 'Mobil')->value('id');

        DB::table('parking_rate_rules')->insert([
            // Motor
            [
                'vehicle_type_id' => $motorId,
                'start_minute' => 0,
                'end_minute' => 60,
                'fixed_price' => 2000,
                'per_hour_price' => null,
                'per_day_price' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'vehicle_type_id' => $motorId,
                'start_minute' => 61,
                'end_minute' => null,
                'fixed_price' => null,
                'per_hour_price' => 1000,
                'per_day_price' => 10000,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mobil
            [
                'vehicle_type_id' => $mobilId,
                'start_minute' => 0,
                'end_minute' => 60,
                'fixed_price' => 5000,
                'per_hour_price' => null,
                'per_day_price' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'vehicle_type_id' => $mobilId,
                'start_minute' => 61,
                'end_minute' => null,
                'fixed_price' => null,
                'per_hour_price' => 3000,
                'per_day_price' => 20000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('parking_gates')->insert([
            [
                'name' => 'Gate Masuk 1',
                'type' => 'in',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gate Keluar 1',
                'type' => 'out',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('shifts')->insert([
            [
                'name' => 'Shift Pagi',
                'start_time' => '06:00:00',
                'end_time' => '14:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Shift Sore',
                'start_time' => '14:00:00',
                'end_time' => '22:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Shift Malam',
                'start_time' => '22:00:00',
                'end_time' => '06:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
