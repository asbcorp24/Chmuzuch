<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
class TeacherController extends Controller {
 public function index(Request $request): View {
  $teachers=config('teachers',[]); $department=$request->string('department')->toString();
  if($department) $teachers=array_filter($teachers,fn($t)=>$t['department']===$department);
  return view('teachers.index',['teachers'=>$teachers,'department'=>$department]);
 }
 public function show(string $slug): View {
  $teachers=config('teachers',[]); abort_unless(isset($teachers[$slug]),404);
  return view('teachers.show',['teacher'=>$teachers[$slug],'slug'=>$slug]);
 }
}