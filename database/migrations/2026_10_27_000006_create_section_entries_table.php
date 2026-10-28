<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {Schema::create('section_entries',function(Blueprint $t){$t->id();$t->string('portal')->index();$t->string('slug');$t->string('title');$t->string('group')->nullable()->index();$t->string('icon',20)->nullable();$t->string('external_url')->nullable();$t->text('lead')->nullable();$t->longText('content')->nullable();$t->unsignedInteger('sort')->default(0);$t->boolean('is_active')->default(true)->index();$t->timestamps();$t->unique(['portal','slug']);});}
 public function down(): void {Schema::dropIfExists('section_entries');}
};