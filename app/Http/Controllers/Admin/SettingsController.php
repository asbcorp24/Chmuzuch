<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class SettingsController extends Controller {
 private array $fields=[
 'general'=>['site_name','short_name','tagline','logo','favicon'],
 'contacts'=>['address','postal_address','phone','email','work_hours','map_embed'],
 'social'=>['vk','telegram','rutube'],
 'seo'=>['default_title','default_description'],
 'appearance'=>['accent','ornament','hero_3d','wireframe','bloom','rotation','quality'],
 'privacy'=>['cookie_text','privacy_url','personal_data_url'],
 'footer'=>['copyright','footer_text']
 ];
 public function edit(): View {return view('admin.settings',['settings'=>Setting::grouped(),'fields'=>$this->fields]);}
 public function save(Request $r): RedirectResponse {foreach($this->fields as $group=>$keys)foreach($keys as $key)Setting::putValue($group,$key,(string)$r->input($group.'.'.$key,''));return back()->with('success','Настройки сохранены');}
}