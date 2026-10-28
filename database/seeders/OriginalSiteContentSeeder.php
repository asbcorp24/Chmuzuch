<?php
namespace Database\Seeders;
use App\Models\Post;
use Illuminate\Database\Seeder;
class OriginalSiteContentSeeder extends Seeder {
 public function run(): void {
  $news=[
   ['tematicheskaya-lekciya-surskie-rubezhi','Тематическая лекция, посвященная трудовому подвигу строителей Сурского и Казанского оборонительных рубежей'],
   ['vystavka-pamyati-stroiteley','Выставка ко Дню памяти строителей Сурского и Казанского оборонительных рубежей'],
   ['molodezhnyy-informacionnyy-den','Единый молодёжный информационный день в училище'],
  ];
  foreach($news as [$slug,$title]){
   Post::firstOrCreate(['slug'=>$slug],['title'=>$title,'type'=>'news','status'=>'published','excerpt'=>$title,'published_at'=>'2026-10-28 12:00:00']);
  }
  $events=[
   ['post-ludus-vitaliy-harisov','V POST-LUDUS. Вечер I: творческий вечер композитора Виталия Харисова'],
   ['prikosnovenie-avtorskaya-ispoved','Концерт «Прикосновение: авторская исповедь»'],
   ['ritmy-lyubvi-mazhukov','В ритмах любви: музыка Алексея Мажукова'],
   ['festival-post-ludus','V Фестиваль современной академической музыки «POST-LUDUS»'],
   ['garmoniya-tembrov','Концерт «Гармония тембров»'],
  ];
  foreach($events as [$slug,$title]){
   Post::firstOrCreate(['slug'=>$slug],['title'=>$title,'type'=>'event','status'=>'published','excerpt'=>'Афиша официального сайта училища. Дата не подтверждена.']);
  }
 }
}
