<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {Schema::table('collectives',function(Blueprint $t){$t->unsignedInteger('sort')->default(0)->index();$t->boolean('is_active')->default(true)->index();});}
 public function down(): void {Schema::table('collectives',function(Blueprint $t){$t->dropIndex(['sort']);$t->dropIndex(['is_active']);$t->dropColumn(['sort','is_active']);});}
};