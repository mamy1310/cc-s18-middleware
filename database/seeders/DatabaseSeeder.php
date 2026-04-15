<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Rôle "admin" + permission "view dashboard"
        $adminRole = Role::create(['name' => 'admin']);
        $viewDashboard = Permission::create(['name' => 'view dashboard']);
        $adminRole->givePermissionTo($viewDashboard);

       // Utilisateur "admin"
        $admin = User::factory()->create([
            'name'     => 'Admin',
            'email'    => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole($adminRole);

        // Utilisateur "user"
        $user = User::factory()->create([
            'name'     => 'User',
            'email'    => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        // Produits de l'admin
        Product::factory()->count(3)->create([
            'user_id' => $admin->id,
        ]);

        // Produits de l'utilisateur simple
        Product::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);
    }
}
