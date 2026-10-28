<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('navigation_items',function(Blueprint $t){$t->id();$t->foreignId('parent_id')->nullable()->constrained('navigation_items')->nullOnDelete();$t->string('label');$t->string('url');$t->string('location')->default('header')->index();$t->unsignedInteger('sort')->default(0);$t->boolean('is_active')->default(true);$t->timestamps();}); }
 public function down(): void { Schema::dropIfExists('navigation_items'); }
};
