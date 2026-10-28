<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Post,ConcertPerformance,Student,Teacher,Media};
use Illuminate\Http\Request;
class ConcertPerformanceController extends Controller {
 private function concert(Post $concert): Post {abort_unless($concert->type==='concert',404);return $concert;}
 public function index(Post $concert){$this->concert($concert);return view('admin.concert-performances.index',['concert'=>$concert,'performances'=>$concert->concertPerformances()->with(['students','teachers','media'])->get(),'students'=>Student::where('is_active',true)->orderBy('name')->get(),'teachers'=>Teacher::where('is_active',true)->orderBy('name')->get(),'media'=>Media::orderByDesc('id')->get()]);}
 public function save(Request $r,Post $concert,?ConcertPerformance $performance=null){
  $this->concert($concert);
  abort_if($performance && $performance->post_id!==$concert->id,404);
  $data=$r->validate(['title'=>'required|string|max:255','program_number'=>'required|integer|min:0','composer'=>'nullable|string|max:255','performer'=>'nullable|string|max:255','instrument'=>'nullable|string|max:255','accompanist'=>'nullable|string|max:255','description'=>'nullable|string','is_published'=>'nullable|boolean','student_ids'=>'array','student_ids.*'=>'integer|distinct|exists:students,id','teacher_ids'=>'array','teacher_ids.*'=>'integer|distinct|exists:teachers,id','media_ids'=>'array','media_ids.*'=>'integer|distinct|exists:media,id']);
  $performance??=new ConcertPerformance;
  $data['post_id']=$concert->id;$data['is_published']=$r->boolean('is_published');
  $performance->fill(collect($data)->except(['student_ids','teacher_ids','media_ids'])->all())->save();
  $performance->students()->sync($data['student_ids']??[]);
  $performance->teachers()->sync($data['teacher_ids']??[]);
  $performance->media()->sync($data['media_ids']??[]);
  return redirect()->route('admin.concert-performances.index',$concert)->with('success','Номер сохранён');
 }
 public function destroy(Post $concert,ConcertPerformance $performance){$this->concert($concert);abort_unless($performance->post_id===$concert->id,404);$performance->delete();return back()->with('success','Номер удалён');}
}
