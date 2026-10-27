<?php
namespace App\Http\Controllers;
use Illuminate\View\View;
class ServicePortalController extends Controller {
 public function safety(): View { return view('service.index',['mode'=>'safety','title'=>'Безопасность','eyebrow'=>'Безопасная образовательная среда','items'=>config('service_portals.safety',[])]); }
 public function employees(): View { return view('service.index',['mode'=>'employees','title'=>'Работникам','eyebrow'=>'Рабочее пространство','items'=>config('service_portals.employees',[])]); }
 public function show(string $portal,string $slug): View { abort_unless(in_array($portal,['safety','employees']),404); $items=config('service_portals.'.$portal,[]); abort_unless(isset($items[$slug]),404); return view('service.show',['portal'=>$portal,'page'=>$items[$slug],'slug'=>$slug]); }
}