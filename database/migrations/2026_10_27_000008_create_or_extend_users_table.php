<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {if(!Schema::hasTable('users'))Schema::create('users',function(Blueprint $t){$t->id();$t->string('name');$t->string('email')->unique();$t->timestamp('email_verified_at')->nullable();$t->string('password');$t->string('role')->default('editor')->index();$t->boolean('is_active')->default(true)->index();$t->rememberToken();$t->timestamps();});else Schema::table('users',function(Blueprint $t){if(!Schema::hasColumn('users','role'))$t->string('role')->default('editor')->index();if(!Schema::hasColumn('users','is_active'))$t->boolean('is_active')->default(true)->index();});}
 public function down(): void {}
};