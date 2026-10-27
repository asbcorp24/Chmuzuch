<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {Schema::table('education_programs',function(Blueprint $t){$t->foreignId('department_id')->nullable()->after('code')->constrained()->nullOnDelete();$t->json('meta')->nullable()->after('documents');});}
 public function down(): void {Schema::table('education_programs',function(Blueprint $t){$t->dropForeign(['department_id']);$t->dropColumn(['department_id','meta']);});}
};