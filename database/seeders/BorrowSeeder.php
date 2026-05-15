<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Borrow;

class BorrowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $borrows = [
            ['book_id' => 1, 'member_name' => 'Member 1'],
            ['book_id' => 2, 'member_name' => 'Member 2'],
        ];

        foreach ($borrows as $borrow) {
            Borrow::create($borrow);
        }
    }
}
