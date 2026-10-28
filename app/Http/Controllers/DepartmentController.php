<?php
namespace App\Http\Controllers;
use App\Models\Department;use App\Models\Post;use App\Models\Media;use App\Models\Achievement;
class DepartmentController extends Controller {
 public function index(){return view('departments.index',['departments'=>Department::where('is_active',true)->orderBy('sort')->withCount('teachers')->get()]);}
 public function show(string $slug){$department=Department::where('is_active',true)->where('slug',$slug)->with(['head','teachers'=>fn($q)=>$q->where('is_active',true)->orderBy('sort'),'collectives'=>fn($q)=>$q->where('is_active',true)->orderBy('sort')->orderBy('title')])->firstOrFail();$posts=Post::published()->whereIn('type',['news','event','announcement'])->where('meta->department_id',$department->id)->orderByDesc('published_at')->limit(8)->get();$media=Media::where('meta->department_id',$department->id)->latest()->limit(12)->get();$achievements=Achievement::where('department_id',$department->id)->orderByDesc('year')->latest()->limit(12)->get();return view('departments.show',compact('department','posts','media','achievements'));}
}