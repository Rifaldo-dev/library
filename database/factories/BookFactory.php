<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    private static array $books = [
        ['title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata'],
        ['title' => 'Bumi Manusia', 'author' => 'Pramoedya Ananta Toer'],
        ['title' => 'Anak Semua Bangsa', 'author' => 'Pramoedya Ananta Toer'],
        ['title' => 'Jejak Langkah', 'author' => 'Pramoedya Ananta Toer'],
        ['title' => 'Rumah Kaca', 'author' => 'Pramoedya Ananta Toer'],
        ['title' => 'Perahu Kertas', 'author' => 'Dee Lestari'],
        ['title' => 'Supernova: Ksatria, Puteri, dan Bintang Jatuh', 'author' => 'Dee Lestari'],
        ['title' => 'Filosofi Teras', 'author' => 'Henry Manampiring'],
        ['title' => 'Laut Bercerita', 'author' => 'Leila S. Chudori'],
        ['title' => 'Pulang', 'author' => 'Leila S. Chudori'],
        ['title' => 'Negeri 5 Menara', 'author' => 'Ahmad Fuadi'],
        ['title' => 'Ranah 3 Warna', 'author' => 'Ahmad Fuadi'],
        ['title' => 'Rantau 1 Muara', 'author' => 'Ahmad Fuadi'],
        ['title' => 'Ayat-Ayat Cinta', 'author' => 'Habiburrahman El Shirazy'],
        ['title' => 'Ketika Cinta Bertasbih', 'author' => 'Habiburrahman El Shirazy'],
        ['title' => 'Sang Pemimpi', 'author' => 'Andrea Hirata'],
        ['title' => 'Edensor', 'author' => 'Andrea Hirata'],
        ['title' => 'Maryamah Karpov', 'author' => 'Andrea Hirata'],
        ['title' => 'Tenggelamnya Kapal Van Der Wijck', 'author' => 'Hamka'],
        ['title' => 'Di Bawah Lindungan Ka\'bah', 'author' => 'Hamka'],
        ['title' => 'Dilan 1990', 'author' => 'Pidi Baiq'],
        ['title' => 'Dilan 1991', 'author' => 'Pidi Baiq'],
        ['title' => 'Milea: Suara dari Dilan', 'author' => 'Pidi Baiq'],
        ['title' => 'Cantik Itu Luka', 'author' => 'Eka Kurniawan'],
        ['title' => 'Lelaki Harimau', 'author' => 'Eka Kurniawan'],
        ['title' => 'Ronggeng Dukuh Paruk', 'author' => 'Ahmad Tohari'],
        ['title' => 'Saman', 'author' => 'Ayu Utami'],
        ['title' => 'Larung', 'author' => 'Ayu Utami'],
        ['title' => 'Hujan', 'author' => 'Tere Liye'],
        ['title' => 'Bumi', 'author' => 'Tere Liye'],
        ['title' => 'Bulan', 'author' => 'Tere Liye'],
        ['title' => 'Matahari', 'author' => 'Tere Liye'],
        ['title' => 'Bintang', 'author' => 'Tere Liye'],
        ['title' => 'Ceros dan Batozar', 'author' => 'Tere Liye'],
        ['title' => 'Komet', 'author' => 'Tere Liye'],
        ['title' => 'Si Anak Pintar', 'author' => 'Tere Liye'],
        ['title' => 'Hafalan Shalat Delisa', 'author' => 'Tere Liye'],
        ['title' => 'Mariposa', 'author' => 'Luluk HF'],
        ['title' => 'Critical Eleven', 'author' => 'Ika Natassa'],
        ['title' => 'Antologi Rasa', 'author' => 'Ika Natassa'],
        ['title' => 'The Architecture of Love', 'author' => 'Ika Natassa'],
        ['title' => 'Sapiens', 'author' => 'Yuval Noah Harari'],
        ['title' => 'Atomic Habits', 'author' => 'James Clear'],
        ['title' => 'Sebuah Seni untuk Bersikap Bodo Amat', 'author' => 'Mark Manson'],
        ['title' => 'Psikologi Perdagangan', 'author' => 'Adi Gunawan'],
        ['title' => 'Rich Dad Poor Dad', 'author' => 'Robert Kiyosaki'],
        ['title' => 'Mindset', 'author' => 'Carol S. Dweck'],
        ['title' => 'Algoritma', 'author' => 'Thomas H. Cormen'],
        ['title' => 'Clean Code', 'author' => 'Robert C. Martin'],
        ['title' => 'Pemrograman Web dengan Laravel', 'author' => 'Dian Prasetyo'],
    ];

    private static int $index = 0;

    public function definition(): array
    {
        $book = self::$books[self::$index % count(self::$books)];
        self::$index++;

        return [
            'title' => $book['title'],
            'isbn' => fake()->unique()->isbn13(),
            'author' => $book['author'],
            'category_id' => Category::factory(),
            'publisher_id' => Publisher::factory(),
            'year_published' => fake()->numberBetween(2000, 2025),
            'stock' => fake()->numberBetween(1, 20),
            'description' => 'Buku karya ' . $book['author'] . '.',
        ];
    }
}
