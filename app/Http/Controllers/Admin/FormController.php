<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;
class FormController extends Controller {
 public function index(Request $r): View { $status=$r->string('status')->toString(); $formId=$r->integer('form_id'); $q=FormSubmission::with('form')->latest(); if($status)$q->where('status',$status); if($formId)$q->where('form_id',$formId); return view('admin.forms',['items'=>$q->paginate(40)->withQueryString(),'forms'=>Form::orderBy('title')->get(),'status'=>$status,'formId'=>$formId]); }
 public function builder(string $id='new'): View { return view('admin.form-builder',['record'=>$id==='new'?null:Form::findOrFail($id)]); }
 public function save(Request $r,string $id='new'): RedirectResponse { $d=$r->validate(['title'=>'required|string|max:255','slug'=>'nullable|string|max:255','description'=>'nullable|string','fields_json'=>'required|json','is_active'=>'nullable|boolean']); $d['slug']=Str::slug($d['slug']?:$d['title']); $d['fields']=json_decode($d['fields_json'],true); $d['is_active']=$r->boolean('is_active'); unset($d['fields_json']); $record=$id==='new'?new Form:Form::findOrFail($id); $record->fill($d)->save(); return redirect()->route('admin.forms.builder',$record->id)->with('success','Форма сохранена'); }
 public function report(Request $r,string $slug): View {$form=Form::where('slug',$slug)->firstOrFail();$q=$form->submissions()->latest();if($r->filled('status'))$q->where('status',$r->string('status'));if($r->filled('from'))$q->whereDate('created_at','>=',$r->date('from'));if($r->filled('to'))$q->whereDate('created_at','<=',$r->date('to'));if($r->filled('q')){$term=mb_strtolower($r->string('q')->toString());$q->where(fn($x)=>$x->whereRaw('LOWER(data) LIKE ?', ['%'.$term.'%']));}$items=$q->paginate(50)->withQueryString();$total=$form->submissions()->count();$today=$form->submissions()->whereDate('created_at',today())->count();return view('admin.form-builder.report',compact('form','items','total','today'));}
 public function csv(Request $r,string $slug): StreamedResponse {$form=Form::where('slug',$slug)->firstOrFail();$fields=collect($form->fields??[])->pluck('label','name');$items=$form->submissions()->latest()->get();return response()->streamDownload(function()use($fields,$items){$out=fopen('php://output','w');fwrite($out,"\xEF\xBB\xBF");fputcsv($out,array_merge(['ID','Дата','Статус'],$fields->values()->all()),';');foreach($items as $item){$row=[$item->id,$item->created_at->format('d.m.Y H:i'),$item->status];foreach($fields->keys() as $name)$row[]=is_array($item->data[$name]??null)?implode(', ',$item->data[$name]):($item->data[$name]??'');fputcsv($out,$row,';');}fclose($out);},$form->slug.'-submissions.csv',['Content-Type'=>'text/csv; charset=UTF-8']);}
 public function status(Request $r,FormSubmission $submission): RedirectResponse { $d=$r->validate(['status'=>'required|in:new,processing,waiting,closed']); $d['processed_at']=$d['status']==='closed'?now():null; $submission->update($d); return back()->with('success','Статус обновлён'); }
}