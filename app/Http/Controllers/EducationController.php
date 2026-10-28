<?php
namespace App\Http\Controllers;
use App\Models\Document;use App\Models\EducationProgram;use App\Models\Teacher;use Illuminate\View\View;
class EducationController extends Controller {
 public function index(): View{return view('education.index',['programs'=>EducationProgram::where('is_active',true)->with('department')->orderBy('sort')->orderBy('title')->get()]);}
 public function program(string $slug): View{$program=EducationProgram::where('is_active',true)->where('slug',$slug)->with('department')->firstOrFail();$documents=Document::where('is_public',true)->where('category','education.'.$slug)->orderByDesc('document_date')->get();$ids=collect($program->meta['teacher_ids']??[])->map(fn($id)=>(int)$id)->unique()->values();$teachers=$ids->isEmpty()?collect():Teacher::where('is_active',true)->whereIn('id',$ids)->get()->sortBy(fn($t)=>$ids->search($t->id))->values();return view('education.program',compact('program','documents','teachers'));}
}