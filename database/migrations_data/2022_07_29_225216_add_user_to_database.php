<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        User::create([
            'name' => 'Rick Zandvoort',
            'email' => 'info@domein.nl',
            'password' => bcrypt('password')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $user = (new User())->where('email', 'info@domein.nl')->first();

        $user?->delete();
    }
};
