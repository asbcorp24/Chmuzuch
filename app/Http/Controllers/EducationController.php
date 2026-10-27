<?php
namespace App\Http\Controllers;
use Illuminate\View\View;
class EducationController extends Controller {
 public function index(): View { return view('education.index',['programs'=>config('education_programs',[]),'departments'=>config('departments',[])]); }
 public function program(string $slug): View { $program=config('education_programs.'.$slug); abort_unless($program,404); return view('education.program',compact('slug','program')); }
}