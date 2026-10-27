<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Collective;
use App\Models\Department;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class AchievementController extends Controller {
 public function index(Request $r): View { $type=$r->string('type')->toString(); $year=$r->integer('year'); $q=Achievement::with(['teacher','department','collective'])->latest('year')->latest(); if($type)$q->where('type',$type); if($year)$q->where('year',$year); return view('admin.achievements.index',['items'=>$q->paginate(40)->withQueryString(),'type'=>$type,'year'=>$year,'years'=>Achievement::whereNotNull('year')->distinct()->orderByDesc('year')->pluck('year')]); }
 public function edit(string $id='new'): View { $record=$id==='new'?null:Achievement::findOrFail($id); return view('admin.achievements.edit',['record'=>$record,'departments'=>Department::orderBy('sort')->get(),'teachers'=>Teacher::orderBy('name')->get(),'collectives'=>Collective::orderBy('title')->get()]); }
 public function save(Request $r,string $id='new'): RedirectResponse { $d=$r->validate(['type'=>'required|in:laureate,pride,gratitude','title'=>'required|string|max:255','year'=>'nullable|integer|min:1800|max:2200','competition'=>'nullable|string|max:255','result'=>'nullable|string|max:255','teacher_id'=>'nullable|exists:teachers,id','department_id'=>'nullable|exists:departments,id','collective_id'=>'nullable|exists:collectives,id','person_name'=>'nullable|string|max:255','image'=>'nullable|string|max:255','description'=>'nullable|string']); $record=$id==='new'?new Achievement:Achievement::findOrFail($id); $record->fill($d)->save(); return redirect()->route('admin.achievements.index')->with('success','Достижение сохранено'); }
 public function destroy(Achievement $achievement): RedirectResponse { $achievement->delete(); return back()->with('success','Запись удалена'); }
}