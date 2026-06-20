<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@library.com',
        ]);

        // Categories
        $categories = Category::factory(10)->create();

        // Publishers
        $publishers = Publisher::factory(8)->create();

        // Books - assign to existing categories & publishers
        $books = Book::factory(50)->recycle($categories)->recycle($publishers)->create();

        // Members
        $members = Member::factory(20)->create();

        // Loans - assign to existing books & members
        Loan::factory(30)->recycle($books)->recycle($members)->create();
    }
}
