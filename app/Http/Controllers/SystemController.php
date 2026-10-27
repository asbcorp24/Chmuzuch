<?php
namespace App\Http\Controllers;
use Illuminate\View\View;
class SystemController extends Controller {
 public function sitemap(): View { return view('system.sitemap'); }
 public function privacy(): View { return view('system.legal',['title'=>'Политика обработки персональных данных','kind'=>'privacy']); }
 public function consent(): View { return view('system.legal',['title'=>'Согласие на обработку персональных данных','kind'=>'consent']); }
 public function cookies(): View { return view('system.legal',['title'=>'Политика использования cookie','kind'=>'cookies']); }
}