<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\NavigationItem;
use Illuminate\Http\Request;
class NavigationController extends Controller {
 public function index(){return view('admin.navigation.index',['items'=>NavigationItem::orderBy('location')->orderBy('sort')->get()]);}
 public function save(Request $r){$d=$r->validate(['id'=>'nullable|integer|exists:navigation_items,id','label'=>'required|string|max:120','url'=>'required|string|max:2048','parent_id'=>'nullable|integer|exists:navigation_items,id','location'=>'required|in:header,footer','sort'=>'nullable|integer|min:0','is_active'=>'nullable|boolean']);abort_unless(str_starts_with($d['url'],'/')&&!str_starts_with($d['url'],'//'),422,'Используйте внутренний путь сайта');$item=isset($d['id'])?NavigationItem::findOrFail($d['id']):new NavigationItem;abort_if(isset($d['parent_id'])&&$item->exists&&$d['parent_id']==$item->id,422);$d['is_active']=$r->boolean('is_active');$item->fill($d)->save();return back()->with('success','Пункт меню сохранён');}
 public function destroy(NavigationItem $item){$item->delete();return back()->with('success','Пункт удалён');}
}
