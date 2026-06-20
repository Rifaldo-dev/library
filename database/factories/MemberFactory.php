<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    public function definition(): array
    {
        $names = [
            'Budi Santoso', 'Siti Nurhaliza', 'Ahmad Fauzi', 'Dewi Lestari',
            'Rizky Pratama', 'Anisa Rahma', 'Dimas Aditya', 'Putri Wulandari',
            'Fajar Nugroho', 'Rina Marlina', 'Hendra Gunawan', 'Yuni Astuti',
            'Agus Setiawan', 'Lina Permata', 'Wahyu Hidayat', 'Mega Sari',
            'Irfan Hakim', 'Novi Anggraini', 'Bayu Purnomo', 'Ratna Dewi',
            'Eko Prasetyo', 'Indah Permatasari', 'Andi Kurniawan', 'Fitri Handayani',
            'Galih Ramadhan', 'Wulan Sari', 'Deni Saputra', 'Ayu Lestari',
            'Rendi Mahendra', 'Tika Amelia',
        ];

        return [
            'member_code' => 'MBR-' . fake()->unique()->numerify('####'),
            'name' => fake()->unique()->randomElement($names),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '628' . fake()->numerify('##########'),
            'address' => fake()->address(),
            'joined_at' => fake()->dateTimeBetween('-2 years', 'now'),
        ];
    }
}
