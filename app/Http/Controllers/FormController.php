<?php
namespace App\Http\Controllers;
use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class FormController extends Controller {
 public function show(string $slug): View { return view('public.form',['form'=>Form::where('slug',$slug)->where('is_active',true)->firstOrFail()]); }
 public function submit(Request $r,string $slug): RedirectResponse { $form=Form::where('slug',$slug)->where('is_active',true)->firstOrFail(); $rules=['privacy'=>'accepted']; foreach($form->fields??[] as $f){$name=$f['name']??null;if(!$name)continue;$rule=($f['required']??false)?'required':'nullable';$type=$f['type']??'text';if($type==='email')$rule.='|email';$rules[$name]=$rule.'|string|max:5000';} $data=$r->validate($rules); unset($data['privacy']); FormSubmission::create(['form_id'=>$form->id,'data'=>$data,'status'=>'new','ip_hash'=>hash('sha256',($r->ip()??'').'|'.config('app.key'))]); return back()->with('form_success','Спасибо. Обращение отправлено.'); }
}