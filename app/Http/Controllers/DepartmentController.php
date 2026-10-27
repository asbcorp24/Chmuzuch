<?php
namespace App\Http\Controllers;
use App\Models\Department;
use Illuminate\View\View;
class DepartmentController extends Controller {
 public function index(): View { return view('departments.index',['departments'=>Department::where('is_active',true)->orderBy('sort')->withCount('teachers')->get()]); }
 public function show(string $slug): View { $department=Department::where('is_active',true)->where('slug',$slug)->with(['head','teachers'=>fn($q)=>$q->where('is_active',true)->orderBy('sort'),'collectives'])->firstOrFail(); return view('departments.show',compact('department')); }
}