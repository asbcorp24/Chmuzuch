<?php
namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class HomePageSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = config('home_blocks', []);
        $page = Page::firstOrNew(['slug' => 'home']);
        if (!$page->exists) {
            $page->title = 'Главная';
            $page->type = 'builder';
            $page->status = 'published';
            $page->blocks = $defaults;
            $page->save();
            return;
        }

        // Preserve all existing editor changes and uploaded STL scenes.
        $blocks = $page->blocks;
        if (!is_array($blocks) || count($blocks) === 0) {
            $page->blocks = $defaults;
            $page->save();
        }
    }
}
