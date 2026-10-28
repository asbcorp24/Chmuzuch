<?php
namespace App\Http\Controllers;
use App\Models\Document;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\View\View;
class ScheduleController extends Controller {
 public function index(Request $request): View {
  $page=Page::published()->where('slug','schedule')->first();
  $type=$request->query('type','');
  $allowed=['classes','exams','consultations','changes'];
  $documents=Document::where('is_public',true)->where('category','schedule')->when(in_array($type,$allowed,true),function($query)use($type){$query->where('meta->schedule_type',$type);})->orderByDesc('document_date')->orderByDesc('updated_at')->get();
  return view('schedule.index',compact('page','documents','type'));
 }
}