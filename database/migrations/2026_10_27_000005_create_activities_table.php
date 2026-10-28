<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {Schema::create('activities',function(Blueprint $t){$t->id();$t->string('type')->index();$t->string('title');$t->string('slug');$t->string('subtitle')->nullable();$t->string('status')->nullable()->index();$t->unsignedSmallInteger('year')->nullable()->index();$t->string('lead')->nullable();$t->text('description')->nullable();$t->dateTime('starts_at')->nullable()->index();$t->dateTime('ends_at')->nullable();$t->string('place')->nullable();$t->string('symbol',20)->nullable();$t->json('meta')->nullable();$t->boolean('is_active')->default(true)->index();$t->timestamps();$t->unique(['type','slug']);});}
 public function down(): void {Schema::dropIfExists('activities');}
};