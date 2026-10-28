<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('pages',function(Blueprint $t){$t->id();$t->string('title');$t->string('slug')->unique();$t->string('type')->default('page')->index();$t->string('status')->default('draft')->index();$t->text('excerpt')->nullable();$t->longText('content')->nullable();$t->json('blocks')->nullable();$t->string('template')->nullable();$t->string('seo_title')->nullable();$t->text('seo_description')->nullable();$t->timestamp('published_at')->nullable()->index();$t->timestamps();$t->softDeletes();});
  Schema::create('posts',function(Blueprint $t){$t->id();$t->string('type')->default('news')->index();$t->string('title');$t->string('slug')->unique();$t->string('status')->default('draft')->index();$t->text('excerpt')->nullable();$t->longText('content')->nullable();$t->string('cover')->nullable();$t->timestamp('starts_at')->nullable()->index();$t->timestamp('ends_at')->nullable();$t->string('place')->nullable();$t->string('external_url')->nullable();$t->json('meta')->nullable();$t->timestamp('published_at')->nullable()->index();$t->timestamps();$t->softDeletes();});
  Schema::create('media',function(Blueprint $t){$t->id();$t->string('type')->default('image')->index();$t->string('title')->nullable();$t->string('path');$t->string('mime_type')->nullable();$t->unsignedBigInteger('size')->nullable();$t->string('alt')->nullable();$t->text('caption')->nullable();$t->json('meta')->nullable();$t->timestamps();});
  Schema::create('documents',function(Blueprint $t){$t->id();$t->string('title');$t->string('category')->nullable()->index();$t->string('file_path');$t->string('number')->nullable();$t->date('document_date')->nullable()->index();$t->boolean('is_public')->default(true)->index();$t->json('meta')->nullable();$t->timestamps();});
  Schema::create('settings',function(Blueprint $t){$t->id();$t->string('group')->default('general')->index();$t->string('key');$t->longText('value')->nullable();$t->string('type')->default('string');$t->timestamps();$t->unique(['group','key']);});
 }
 public function down(): void { Schema::dropIfExists('settings');Schema::dropIfExists('documents');Schema::dropIfExists('media');Schema::dropIfExists('posts');Schema::dropIfExists('pages'); }
};