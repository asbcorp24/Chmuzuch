<?php
namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class HomePageSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = config('home_blocks', []);
        $page = Page::withTrashed()->firstOrNew(['slug' => 'home']);
        $existing = is_array($page->blocks) ? $page->blocks : [];
        $byId = collect($existing)->filter(fn ($b) => is_array($b) && isset($b['id']))->keyBy('id');

        $blocks = [];
        foreach ($defaults as $default) {
            $id = $default['id'];
            $saved = $byId->get($id, []);
            // Keep editorial text, visibility and uploaded 3D settings.
            $merged = array_replace($default, $saved);
            if ($id === 'hero') {
                // The old seed used the constructor's internal label as a public headline.
                if (in_array($merged['title'] ?? '', ['Hero / первый экран', 'Первый экран'], true)) {
                    $merged['title'] = 'Первый экран';
                }
                if (empty($merged['headline'])) {
                    $merged['headline'] = $default['headline'];
                }
            }
            $blocks[] = $merged;
        }

        // Preserve custom CMS blocks beyond the standard homepage.
        foreach ($existing as $block) {
            if (is_array($block) && isset($block['id']) && !collect($defaults)->contains('id', $block['id'])) {
                $blocks[] = $block;
            }
        }

        $page->title = $page->title ?: 'Главная';
        $page->type = 'builder';
        $page->status = 'published';
        $page->blocks = $blocks;
        $page->save();
        if ($page->trashed()) {
            $page->restore();
        }
    }
}
