<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class HomeBuilderController extends Controller {
 public function edit(): View { $page=Page::firstOrCreate(['slug'=>'home'],['title'=>'Главная','type'=>'builder','status'=>'published','blocks'=>config('home_blocks',[])]); return view('admin.home',['page'=>$page,'blocks'=>$page->blocks??[]]); }
 private function applyScene(Request $r,Page $page,array $blocks): array {
  $existing=collect($page->blocks??[])->firstWhere('id','hero');
  foreach($blocks as &$block){
   if(($block['id']??null)!=='hero')continue;
   $scene=$existing['scene3d']??[];
   if($r->boolean('scene_clear'))unset($scene['stl']);
   if($r->hasFile('scene_stl'))$scene['stl']=$r->file('scene_stl')->store('models/stl','public');
   foreach(['rotation_x','rotation_y','rotation_z','scale'] as $field){
    if($r->filled('scene_'.$field))$scene[$field]=(float)$r->input('scene_'.$field);
   }
   $block['scene3d']=$scene;
  }
  unset($block);
  return $blocks;
 }
 public function save(Request $r): RedirectResponse { $data=$r->validate(['blocks_json'=>'required|json','scene_stl'=>'nullable|file|extensions:stl|max:20480','scene_scale'=>'nullable|numeric|between:0.1,10','scene_rotation_x'=>'nullable|numeric|between:-360,360','scene_rotation_y'=>'nullable|numeric|between:-360,360','scene_rotation_z'=>'nullable|numeric|between:-360,360']); $blocks=json_decode($data['blocks_json'],true); abort_unless(is_array($blocks),422); $page=Page::firstOrCreate(['slug'=>'home'],['title'=>'Главная']); $blocks=$this->applyScene($r,$page,$blocks); $page->update(['type'=>'builder','status'=>'published','blocks'=>$blocks]); return back()->with('success','Главная сохранена'); }
}