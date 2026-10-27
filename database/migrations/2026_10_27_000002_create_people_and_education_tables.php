<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('departments',function(Blueprint $t){$t->id();$t->string('title');$t->string('slug')->unique();$t->text('description')->nullable();$t->longText('history')->nullable();$t->unsignedBigInteger('head_teacher_id')->nullable();$t->unsignedInteger('sort')->default(0);$t->boolean('is_active')->default(true);$t->json('meta')->nullable();$t->timestamps();});
  Schema::create('teachers',function(Blueprint $t){$t->id();$t->string('name');$t->string('slug')->unique();$t->foreignId('department_id')->nullable()->constrained()->nullOnDelete();$t->string('position')->nullable();$t->string('photo')->nullable();$t->text('education')->nullable();$t->text('qualifications')->nullable();$t->longText('bio')->nullable();$t->json('achievements')->nullable();$t->unsignedInteger('sort')->default(0);$t->boolean('is_active')->default(true);$t->timestamps();$t->softDeletes();});
  Schema::table('departments',function(Blueprint $t){$t->foreign('head_teacher_id')->references('id')->on('teachers')->nullOnDelete();});
  Schema::create('collectives',function(Blueprint $t){$t->id();$t->string('title');$t->string('slug')->unique();$t->foreignId('department_id')->nullable()->constrained()->nullOnDelete();$t->foreignId('leader_id')->nullable()->constrained('teachers')->nullOnDelete();$t->text('description')->nullable();$t->longText('history')->nullable();$t->longText('repertoire')->nullable();$t->string('cover')->nullable();$t->json('meta')->nullable();$t->timestamps();$t->softDeletes();});
  Schema::create('education_programs',function(Blueprint $t){$t->id();$t->string('title');$t->string('slug')->unique();$t->string('code')->nullable()->index();$t->string('qualification')->nullable();$t->text('description')->nullable();$t->json('profiles')->nullable();$t->json('documents')->nullable();$t->boolean('is_active')->default(true);$t->unsignedInteger('sort')->default(0);$t->timestamps();});
 }
 public function down(): void {Schema::dropIfExists('education_programs');Schema::dropIfExists('collectives');Schema::table('departments',fn(Blueprint $t)=>$t->dropForeign(['head_teacher_id']));Schema::dropIfExists('teachers');Schema::dropIfExists('departments');}
};