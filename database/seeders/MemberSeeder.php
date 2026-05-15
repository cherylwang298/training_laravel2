<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $data = [
            ['name' => 'John Doe', 'email' => 'johndoe@gmail.com'],
            ['name' => 'Jane Doe', 'email' => 'janedoe@gmail.com']
        ];


        foreach($data as $member){
            Member::create($member);
        }
    }
}
