<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\NavigationItem;
use Illuminate\Http\Request;
class NavigationController extends Controller {
 public function index(){return view('admin.navigation.index',['items'=>NavigationItem::orderBy('location')->orderBy('sort')->get()]);}
 public function save(Request $r){$d=$r->validate(['id'=>'nullable|integer|exists:navigation_items,id','label'=>'required|string|max:120','url'=>'required|string|max:2048','parent_id'=>'nullable|integer|exists:navigation_items,id','location'=>'required|in:header,footer','sort'=>'nullable|integer|min:0','is_active'=>'nullable|boolean']);abort_unless(str_starts_with($d['url'],'/')&&!str_starts_with($d['url'],'//'),422,'Используйте внутренний путь сайта');$item=isset($d['id'])?NavigationItem::findOrFail($d['id']):new NavigationItem;if(!empty($d['parent_id'])){$parent=NavigationItem::findOrFail($d['parent_id']);abort_if($parent->location!==$d['location'],422,'Родитель должен находиться в том же меню');$seen=[];while($parent){abort_if(($item->exists&&$parent->id===$item->id)||isset($seen[$parent->id]),422,'Недопустимая вложенность меню');$seen[$parent->id]=true;$parent=$parent->parent_id?NavigationItem::find($parent->parent_id):null;}}$d['is_active']=$r->boolean('is_active');$item->fill($d)->save();return back()->with('success','Пункт меню сохранён');}
 public function destroy(NavigationItem $item){$item->delete();return back()->with('success','Пункт удалён');}
}
