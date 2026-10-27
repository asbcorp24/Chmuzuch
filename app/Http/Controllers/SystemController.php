<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
class SystemController extends Controller {
 public function search(Request $request): View {
  $q=trim((string)$request->query('q','')); $items=[
   ['title'=>'Об училище','url'=>'/about','text'=>'История руководство структура Ф. П. Павлов'],
   ['title'=>'Отделения','url'=>'/departments','text'=>'Специальности преподаватели дисциплины'],
   ['title'=>'Преподаватели','url'=>'/teachers','text'=>'Педагогический состав'],
   ['title'=>'Афиша','url'=>'/events','text'=>'Концерты события мастер-классы'],
   ['title'=>'Абитуриенту','url'=>'/applicants','text'=>'Прием поступление экзамены специальности'],
   ['title'=>'Студенту','url'=>'/students','text'=>'Расписание библиотека практика стипендии'],
   ['title'=>'Конкурсы','url'=>'/competitions','text'=>'Эвтерпа Сентти FortePiano Шапиро'],
   ['title'=>'Сведения об образовательной организации','url'=>'/official','text'=>'Документы образование финансы доступная среда'],
  ];
  $results=$q===''?[]:array_values(array_filter($items,fn($x)=>str_contains(mb_strtolower($x['title'].' '.$x['text']),mb_strtolower($q))));
  return view('system.search',compact('q','results'));
 }
 public function sitemap(): View { return view('system.sitemap'); }
 public function privacy(): View { return view('system.legal',['title'=>'Политика обработки персональных данных','kind'=>'privacy']); }
 public function consent(): View { return view('system.legal',['title'=>'Согласие на обработку персональных данных','kind'=>'consent']); }
 public function cookies(): View { return view('system.legal',['title'=>'Политика использования cookie','kind'=>'cookies']); }
}