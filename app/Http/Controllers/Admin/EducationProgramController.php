<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\EducationProgram;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
class EducationProgramController extends Controller {
 public function index(): View { return view('admin.education.index',['items'=>EducationProgram::orderBy('sort')->orderBy('title')->paginate(30)]); }
 public function edit(string $id='new'): View { return view('admin.education.edit',['record'=>$id==='new'?null:EducationProgram::findOrFail($id)]); }
 public function save(Request $r,string $id='new'): RedirectResponse {
  $d=$r->validate(['title'=>'required|string|max:255','slug'=>'nullable|string|max:255','code'=>'nullable|string|max:50','qualification'=>'nullable|string|max:255','description'=>'nullable|string','profiles_text'=>'nullable|string','sort'=>'nullable|integer|min:0','is_active'=>'nullable|boolean']);
  $d['slug']=Str::slug($d['slug']?:$d['title']); $d['profiles']=collect(preg_split('/\r\n|\r|\n/',$d['profiles_text']??''))->map(fn($v)=>trim($v))->filter()->values()->all(); $d['is_active']=$r->boolean('is_active'); unset($d['profiles_text']);
  $record=$id==='new'?new EducationProgram:EducationProgram::findOrFail($id); $record->fill($d)->save(); return redirect()->route('admin.education.index')->with('success','Образовательная программа сохранена');
 }
 public function destroy(EducationProgram $program): RedirectResponse { $program->delete(); return back()->with('success','Программа удалена'); }
}