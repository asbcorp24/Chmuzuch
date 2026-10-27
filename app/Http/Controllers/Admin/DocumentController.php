<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
class DocumentController extends Controller {
 public function index(Request $r): View { $category=$r->string('category')->toString(); $q=Document::latest('document_date')->latest(); if($category)$q->where('category',$category); return view('admin.documents.index',['items'=>$q->paginate(40)->withQueryString(),'category'=>$category,'categories'=>Document::whereNotNull('category')->distinct()->orderBy('category')->pluck('category')]); }
 public function edit(string $id='new'): View { return view('admin.documents.edit',['record'=>$id==='new'?null:Document::findOrFail($id)]); }
 public function save(Request $r,string $id='new'): RedirectResponse {
  $d=$r->validate(['title'=>'required|string|max:255','category'=>'required|string|max:100','number'=>'nullable|string|max:100','document_date'=>'nullable|date','file'=>'nullable|file|max:102400','is_public'=>'nullable|boolean','schedule_type'=>'nullable|in:classes,exams,consultations,changes']);
  $record=$id==='new'?new Document:Document::findOrFail($id);
  if($r->hasFile('file')){ if($record->file_path)Storage::disk('public')->delete($record->file_path); $d['file_path']=$r->file('file')->store('documents/'.str_replace('.','/',$d['category']),'public'); }
  abort_if(!$record->exists&&!isset($d['file_path']),422,'Выберите файл'); $d['is_public']=$r->boolean('is_public');$meta=$record->meta??[];if($d['category']==='schedule'&&!empty($d['schedule_type']))$meta['schedule_type']=$d['schedule_type'];else unset($meta['schedule_type']);$d['meta']=$meta;unset($d['schedule_type']); unset($d['file']); $record->fill($d)->save(); return redirect()->route('admin.documents.index')->with('success','Документ сохранён');
 }
 public function destroy(Document $document): RedirectResponse { Storage::disk('public')->delete($document->file_path); $document->delete(); return back()->with('success','Документ удалён'); }
}