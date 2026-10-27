<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
class FormController extends Controller {
 public function index(Request $r): View { $status=$r->string('status')->toString(); $formId=$r->integer('form_id'); $q=FormSubmission::with('form')->latest(); if($status)$q->where('status',$status); if($formId)$q->where('form_id',$formId); return view('admin.forms',['items'=>$q->paginate(40)->withQueryString(),'forms'=>Form::orderBy('title')->get(),'status'=>$status,'formId'=>$formId]); }
 public function builder(string $id='new'): View { return view('admin.form-builder',['record'=>$id==='new'?null:Form::findOrFail($id)]); }
 public function save(Request $r,string $id='new'): RedirectResponse { $d=$r->validate(['title'=>'required|string|max:255','slug'=>'nullable|string|max:255','description'=>'nullable|string','fields_json'=>'required|json','is_active'=>'nullable|boolean']); $d['slug']=Str::slug($d['slug']?:$d['title']); $d['fields']=json_decode($d['fields_json'],true); $d['is_active']=$r->boolean('is_active'); unset($d['fields_json']); $record=$id==='new'?new Form:Form::findOrFail($id); $record->fill($d)->save(); return redirect()->route('admin.forms.builder',$record->id)->with('success','Форма сохранена'); }
 public function status(Request $r,FormSubmission $submission): RedirectResponse { $d=$r->validate(['status'=>'required|in:new,processing,waiting,closed']); $d['processed_at']=$d['status']==='closed'?now():null; $submission->update($d); return back()->with('success','Статус обновлён'); }
}