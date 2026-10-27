<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SectionEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
class SectionEntryController extends Controller {
 private function portal(string $portal): string {abort_unless(in_array($portal,['official','employees','safety'],true),404);return $portal;}
 public function index(string $portal): View {$portal=$this->portal($portal);return view('admin.sections.index',['portal'=>$portal,'items'=>SectionEntry::portal($portal)->orderBy('sort')->orderBy('group')->get()]);}
 public function edit(string $portal,string $id='new'): View {$portal=$this->portal($portal);$record=$id==='new'?null:SectionEntry::portal($portal)->findOrFail($id);return view('admin.sections.edit',compact('portal','record'));}
 public function save(Request $r,string $portal,string $id='new'): RedirectResponse {$portal=$this->portal($portal);$d=$r->validate(['title'=>'required|string|max:255','slug'=>'nullable|string|max:255','group'=>'nullable|string|max:255','icon'=>'nullable|string|max:20','external_url'=>'nullable|string|max:2048','lead'=>'nullable|string','content'=>'nullable|string','sort'=>'nullable|integer|min:0','is_active'=>'nullable|boolean']);$d['portal']=$portal;$d['slug']=Str::slug($d['slug']?:$d['title']);$d['is_active']=$r->boolean('is_active');$record=$id==='new'?new SectionEntry:SectionEntry::portal($portal)->findOrFail($id);$record->fill($d)->save();return redirect()->route('admin.sections.index',$portal)->with('success','Раздел сохранён');}
 public function destroy(string $portal,SectionEntry $entry): RedirectResponse {$portal=$this->portal($portal);abort_unless($entry->portal===$portal,404);$entry->delete();return back()->with('success','Раздел удалён');}
}