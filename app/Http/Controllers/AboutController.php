<?php
namespace App\Http\Controllers;
use Illuminate\View\View;
class AboutController extends Controller {
 public function index(): View { return view('about.index',['departments'=>config('departments',[]),'collectives'=>config('collectives',[])]); }
 public function section(string $section): View {
  $sections=[
   'history'=>['title'=>'История училища','eyebrow'=>'Время и музыка','lead'=>'История становления училища, важные даты, люди, традиции и этапы развития.'],
   'pavlov'=>['title'=>'Ф. П. Павлов','eyebrow'=>'Имя училища','lead'=>'Страница о Ф. П. Павлове, его жизни, творческом наследии и значении для культуры.'],
   'leadership'=>['title'=>'Руководство','eyebrow'=>'Команда','lead'=>'Руководители училища, направления ответственности и контакты.'],
   'structure'=>['title'=>'Структура училища','eyebrow'=>'Организация','lead'=>'Подразделения, отделения, службы и взаимосвязи внутри образовательной организации.'],
   'pride'=>['title'=>'Наша гордость','eyebrow'=>'Люди и достижения','lead'=>'Выдающиеся выпускники, преподаватели, студенты и значимые достижения училища.'],
   'facilities'=>['title'=>'Материальная база','eyebrow'=>'Пространство для музыки','lead'=>'Учебные аудитории, концертные пространства, инструменты, оборудование, библиотека и инфраструктура.'],
  ];
  abort_unless(isset($sections[$section]),404);
  return view('about.section',['page'=>$sections[$section],'section'=>$section]);
 }
}