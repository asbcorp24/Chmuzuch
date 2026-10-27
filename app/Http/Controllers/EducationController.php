<?php
namespace App\Http\Controllers;
use App\Models\Document;
use App\Models\EducationProgram;
use Illuminate\View\View;
class EducationController extends Controller {
 public function index(): View { return view('education.index',['programs'=>EducationProgram::where('is_active',true)->orderBy('sort')->orderBy('title')->get()]); }
 public function program(string $slug): View { $program=EducationProgram::where('is_active',true)->where('slug',$slug)->firstOrFail(); $documents=Document::where('is_public',true)->where('category','education.'.$slug)->orderByDesc('document_date')->get(); return view('education.program',compact('program','documents')); }
}