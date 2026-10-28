<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  if(!Schema::hasTable('students'))Schema::create('students',function(Blueprint $t){$t->id();$t->string('name');$t->string('slug')->unique();$t->string('course')->nullable();$t->foreignId('department_id')->nullable()->constrained()->nullOnDelete();$t->boolean('is_active')->default(true);$t->timestamps();});
  if(!Schema::hasTable('concert_performance_students'))Schema::create('concert_performance_students',function(Blueprint $t){$t->id();$t->foreignId('concert_performance_id')->constrained()->cascadeOnDelete();$t->foreignId('student_id')->constrained()->cascadeOnDelete();$t->string('role')->nullable();$t->unsignedInteger('sort')->default(0);$t->unique(['concert_performance_id','student_id'],'cps_performance_student_uq');});
  if(!Schema::hasTable('concert_performance_teachers'))Schema::create('concert_performance_teachers',function(Blueprint $t){$t->id();$t->foreignId('concert_performance_id')->constrained()->cascadeOnDelete();$t->foreignId('teacher_id')->constrained()->cascadeOnDelete();$t->string('role')->nullable();$t->unsignedInteger('sort')->default(0);$t->unique(['concert_performance_id','teacher_id'],'cpt_performance_teacher_uq');});
  if(!Schema::hasTable('concert_performance_media'))Schema::create('concert_performance_media',function(Blueprint $t){$t->id();$t->foreignId('concert_performance_id')->constrained()->cascadeOnDelete();$t->foreignId('media_id')->constrained('media')->cascadeOnDelete();$t->unsignedInteger('sort')->default(0);$t->unique(['concert_performance_id','media_id'],'cpm_performance_media_uq');});
  if(!Schema::hasTable('concert_media'))Schema::create('concert_media',function(Blueprint $t){$t->id();$t->foreignId('post_id')->constrained('posts')->cascadeOnDelete();$t->foreignId('media_id')->constrained('media')->cascadeOnDelete();$t->unsignedInteger('sort')->default(0);$t->unique(['post_id','media_id'],'cm_post_media_uq');});
 }
 public function down(): void {Schema::dropIfExists('concert_media');Schema::dropIfExists('concert_performance_media');Schema::dropIfExists('concert_performance_teachers');Schema::dropIfExists('concert_performance_students');Schema::dropIfExists('students');}
};
