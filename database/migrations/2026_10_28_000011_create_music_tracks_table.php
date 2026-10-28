<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {Schema::create('music_tracks',function(Blueprint $t){$t->id();$t->string('title');$t->string('artist')->nullable();$t->string('file_path');$t->string('file_name')->nullable();$t->string('mime_type')->nullable();$t->unsignedBigInteger('file_size')->nullable();$t->unsignedInteger('sort_order')->default(0);$t->boolean('is_active')->default(true);$t->timestamps();});}
 public function down(): void {Schema::dropIfExists('music_tracks');}
};
