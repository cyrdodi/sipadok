<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // \App\Models\User::factory(10)->create();

    // \App\Models\User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);

    User::create([
      'name' => 'Dodi Yulian',
      'email' => 'dodi.diskomsantik@gmail.com',
      'password' => bcrypt('12345678'),
      'is_admin' => true
    ]);

    User::create([
      'name' => 'Ade Ratna',
      'email' => 'aderatna@gmail.com',
      'password' => bcrypt('12345678'),
      'is_admin' => true
    ]);

    Type::create([
      'name' => 'Pelaporan'
    ]);
    Type::create([
      'name' =>  'Perencanaan'
    ]);
  }
}
