<?php
namespace App\Http\Controllers;
use App\Models\Department;use App\Models\Teacher;use App\Models\Post;use App\Models\Media;use Illuminate\Http\Request;
class TeacherController extends Controller {
 public function index(Request $request){$department=$request->string('department')->toString();$q=Teacher::where('is_active',true)->with('department')->orderBy('sort')->orderBy('name');if($department)$q->whereHas('department',fn($x)=>$x->where('slug',$department));return view('teachers.index',['teachers'=>$q->paginate(30)->withQueryString(),'departments'=>Department::where('is_active',true)->orderBy('sort')->get(),'department'=>$department]);}
 public function show(string $slug){$teacher=Teacher::where('is_active',true)->where('slug',$slug)->with('department')->firstOrFail();$posts=Post::published()->whereIn('type',['news','event','announcement'])->where('meta->teacher_id',$teacher->id)->orderByDesc('published_at')->limit(8)->get();$media=Media::where('meta->teacher_id',$teacher->id)->latest()->limit(12)->get();return view('teachers.show',compact('teacher','posts','media'));}
}