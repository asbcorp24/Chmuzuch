<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('achievements',function(Blueprint $t){$t->id();$t->string('type')->default('laureate')->index();$t->string('title');$t->unsignedSmallInteger('year')->nullable()->index();$t->string('competition')->nullable();$t->string('result')->nullable();$t->foreignId('teacher_id')->nullable()->constrained()->nullOnDelete();$t->foreignId('department_id')->nullable()->constrained()->nullOnDelete();$t->foreignId('collective_id')->nullable()->constrained()->nullOnDelete();$t->string('person_name')->nullable();$t->string('image')->nullable();$t->text('description')->nullable();$t->json('meta')->nullable();$t->timestamps();});
  Schema::create('forms',function(Blueprint $t){$t->id();$t->string('title');$t->string('slug')->unique();$t->text('description')->nullable();$t->json('fields');$t->boolean('is_active')->default(true);$t->json('settings')->nullable();$t->timestamps();});
  Schema::create('form_submissions',function(Blueprint $t){$t->id();$t->foreignId('form_id')->constrained()->cascadeOnDelete();$t->json('data');$t->string('status')->default('new')->index();$t->string('ip_hash')->nullable();$t->timestamp('processed_at')->nullable();$t->timestamps();});
 }
 public function down(): void {Schema::dropIfExists('form_submissions');Schema::dropIfExists('forms');Schema::dropIfExists('achievements');}
};