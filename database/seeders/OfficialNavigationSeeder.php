<?php
namespace Database\Seeders;

use App\Models\NavigationItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class OfficialNavigationSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('navigation_items')) return;

        // Sections from the existing portal structure, with local CMS URLs.
        $items = [
            ['Главная', '/'],
            ['Об училище', '/about', [
                ['История', '/history'],
                ['Руководство', '/administration'],
                ['Преподаватели', '/teachers'],
                ['Сведения об образовательной организации', '/official'],
            ]],
            ['Отделения', '/departments', [
                ['Фортепиано', '/departments'],
                ['Народные инструменты', '/departments'],
                ['Оркестровые струнные инструменты', '/departments'],
                ['Духовые и ударные инструменты', '/departments'],
                ['Дирижёрско-хоровое', '/departments'],
                ['Вокальное искусство', '/departments'],
                ['Теория музыки', '/departments'],
                ['Музыкальное искусство эстрады', '/departments'],
                ['Сольное и хоровое народное пение', '/departments'],
                ['Общее фортепиано', '/departments'],
                ['Гуманитарные и общеобразовательные дисциплины', '/departments'],
            ]],
            ['Абитуриентам', '/applicants'],
            ['Студентам', '/students', [
                ['Студенческая жизнь', '/student-life'],
                ['Общежитие', '/dormitory'],
            ]],
            ['Новости', '/news'],
            ['Афиша', '/events'],
            ['Конкурсы', '/competitions'],
            ['Конференции', '/conferences'],
            ['Коллективы', '/collectives'],
            ['Медиатека', '/media'],
            ['ДШИ', '/dshi'],
            ['Центр дополнительного образования', '/additional-education'],
            ['Контакты', '/contacts'],
        ];

        foreach ($items as $position => $item) {
            $parent = NavigationItem::firstOrCreate(
                ['location' => 'header', 'parent_id' => null, 'url' => $item[1]],
                ['label' => $item[0], 'sort' => ($position + 1) * 10, 'is_active' => true]
            );
            foreach ($item[2] ?? [] as $childPosition => $child) {
                NavigationItem::firstOrCreate(
                    ['location' => 'header', 'parent_id' => $parent->id, 'label' => $child[0]],
                    ['url' => $child[1], 'sort' => ($childPosition + 1) * 10, 'is_active' => true]
                );
            }
        }
    }
}
