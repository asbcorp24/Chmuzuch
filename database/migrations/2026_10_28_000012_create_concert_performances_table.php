<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {Schema::create('concert_performances',function(Blueprint $t){$t->id();$t->foreignId('post_id')->constrained('posts')->cascadeOnDelete();$t->unsignedInteger('program_number')->default(0);$t->string('title');$t->string('composer')->nullable();$t->string('performer')->nullable();$t->string('instrument')->nullable();$t->string('accompanist')->nullable();$t->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();$t->text('description')->nullable();$t->string('audio_url')->nullable();$t->string('video_url')->nullable();$t->boolean('is_published')->default(true);$t->timestamps();});}
 public function down(): void {Schema::dropIfExists('concert_performances');}
};
