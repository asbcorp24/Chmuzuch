<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SectionEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
class SectionEntryController extends Controller {
 private function portal(string $portal): string {abort_unless(in_array($portal,['official','employees','safety','anticorruption','tenants'],true),404);return $portal;}
 public function index(string $portal): View {$portal=$this->portal($portal);$items=SectionEntry::portal($portal)->orderBy('sort')->orderBy('group')->get();if($portal==='official'){$stored=$items->keyBy('slug');$items=collect(config('official_sections',[]))->map(fn($cfg,$slug)=>$stored->get($slug)??new SectionEntry(['portal'=>'official','slug'=>$slug,'title'=>$cfg['title'],'group'=>$cfg['group']??null,'lead'=>$cfg['lead']??null,'is_active'=>true]))->values();}return view('admin.sections.index',compact('portal','items'));}
 public function edit(string $portal,string $id='new'): View {$portal=$this->portal($portal);$record=null;if($id!=='new'){$record=ctype_digit($id)?SectionEntry::portal($portal)->findOrFail($id):SectionEntry::portal($portal)->where('slug',$id)->first();if(!$record&&$portal==='official'&&($cfg=config('official_sections.'.$id)))$record=SectionEntry::create(['portal'=>'official','slug'=>$id,'title'=>$cfg['title'],'group'=>$cfg['group']??null,'lead'=>$cfg['lead']??null,'is_active'=>true]);abort_unless($record,404);}return view('admin.sections.edit',compact('portal','record'));}
 public function save(Request $r,string $portal,string $id='new'): RedirectResponse {$portal=$this->portal($portal);$d=$r->validate(['title'=>'required|string|max:255','slug'=>'nullable|string|max:255','group'=>'nullable|string|max:255','icon'=>'nullable|string|max:20','external_url'=>'nullable|string|max:2048','lead'=>'nullable|string','content'=>'nullable|string','sort'=>'nullable|integer|min:0','is_active'=>'nullable|boolean']);$d['portal']=$portal;$d['slug']=Str::slug($d['slug']?:$d['title']);$d['is_active']=$r->boolean('is_active');$record=$id==='new'?new SectionEntry:SectionEntry::portal($portal)->findOrFail($id);$record->fill($d)->save();return redirect()->route('admin.sections.index',$portal)->with('success','Раздел сохранён');}
 public function destroy(string $portal,SectionEntry $entry): RedirectResponse {$portal=$this->portal($portal);abort_unless($entry->portal===$portal,404);$entry->delete();return back()->with('success','Раздел удалён');}
}