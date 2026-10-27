<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('learning_offers',function(Blueprint $t){$t->id();$t->string('scope')->index();$t->string('title');$t->string('slug');$t->string('kind')->nullable();$t->string('age')->nullable();$t->string('hours')->nullable();$t->string('format')->nullable();$t->string('audience')->nullable();$t->string('symbol',20)->nullable();$t->text('description')->nullable();$t->json('content')->nullable();$t->unsignedInteger('sort')->default(0);$t->boolean('is_active')->default(true)->index();$t->timestamps();$t->unique(['scope','slug']);});
 }
 public function down(): void {Schema::dropIfExists('learning_offers');}
};