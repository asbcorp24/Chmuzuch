<?php
namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\View\View;
class TeacherController extends Controller {
 public function index(Request $request): View { $department=$request->string('department')->toString(); $q=Teacher::where('is_active',true)->with('department')->orderBy('sort')->orderBy('name'); if($department)$q->whereHas('department',fn($x)=>$x->where('slug',$department)); return view('teachers.index',['teachers'=>$q->paginate(30)->withQueryString(),'departments'=>Department::where('is_active',true)->orderBy('sort')->get(),'department'=>$department]); }
 public function show(string $slug): View { $teacher=Teacher::where('is_active',true)->where('slug',$slug)->with('department')->firstOrFail(); return view('teachers.show',compact('teacher')); }
}