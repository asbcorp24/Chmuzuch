<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
class CmsController extends Controller {
 private array $modules=[
  'home'=>['title'=>'Главная','icon'=>'⌂','count'=>'12 блоков'],
  'pages'=>['title'=>'Страницы','icon'=>'□','count'=>'Системные страницы'],
  'news'=>['title'=>'Новости','icon'=>'N','count'=>'Публикации'],
  'events'=>['title'=>'Афиша','icon'=>'◉','count'=>'Мероприятия'],
  'departments'=>['title'=>'Отделения','icon'=>'11','count'=>'11 отделений'],
  'teachers'=>['title'=>'Преподаватели','icon'=>'P','count'=>'Карточки педагогов'],
  'collectives'=>['title'=>'Коллективы','icon'=>'♫','count'=>'Творческие коллективы'],
  'documents'=>['title'=>'Документы','icon'=>'D','count'=>'Файлы и категории'],
  'media'=>['title'=>'Медиатека','icon'=>'▶','count'=>'Фото · видео · аудио'],
  'forms'=>['title'=>'Заявки','icon'=>'↗','count'=>'Обращения и формы'],
  'settings'=>['title'=>'Настройки','icon'=>'⚙','count'=>'Сайт · SEO · контакты'],
 ];
 public function dashboard(): View { return view('admin.dashboard',['modules'=>$this->modules]); }
 public function module(string $module): View { abort_unless(isset($this->modules[$module]),404); if($module==='home') return view('admin.home',['blocks'=>config('home_blocks',[])]); if($module==='media') return view('admin.media'); return view('admin.module',['module'=>$module,'meta'=>$this->modules[$module]]); }
 public function editor(string $module,string $id='new'): View { abort_unless(isset($this->modules[$module]),404); return view('admin.editor',['module'=>$module,'id'=>$id,'meta'=>$this->modules[$module]]); }
}