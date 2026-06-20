<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    public function definition(): array
    {
        $loanDate = fake()->dateTimeBetween('-3 months', 'now');
        $dueDate = (clone $loanDate)->modify('+14 days');
        $isReturned = fake()->boolean(60);

        return [
            'book_id' => Book::factory(),
            'member_id' => Member::factory(),
            'loan_date' => $loanDate,
            'due_date' => $dueDate,
            'return_date' => $isReturned ? fake()->dateTimeBetween($loanDate, $dueDate) : null,
            'status' => $isReturned ? 'returned' : ($dueDate < now() ? 'overdue' : 'borrowed'),
        ];
    }
}
