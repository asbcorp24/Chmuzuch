<?php
namespace App\Http\Controllers;
use App\Models\Document;
use App\Models\LearningOffer;
use App\Models\Form;
use App\Models\Teacher;
use Illuminate\View\View;
class AdditionalEducationController extends Controller {
 public function index(): View {return view('additional.index',['courses'=>LearningOffer::scope('additional')->where('is_active',true)->orderBy('sort')->get(),'documents'=>Document::where('is_public',true)->where('category','additional')->orderByDesc('document_date')->get(),'enrollmentForm'=>Form::where('slug','additional-enrollment')->where('is_active',true)->first()]);}
 public function show(string $slug): View {$course=LearningOffer::scope('additional')->where('is_active',true)->where('slug',$slug)->firstOrFail();$documents=Document::where('is_public',true)->where('category','additional.'.$slug)->orderByDesc('document_date')->get();$enrollmentForm=Form::where('slug','additional-enrollment')->where('is_active',true)->first();$ids=collect($course->content['teacher_ids']??[])->map(fn($id)=>(int)$id)->unique()->values();$teachers=$ids->isEmpty()?collect():Teacher::where('is_active',true)->whereIn('id',$ids)->get()->sortBy(fn($t)=>$ids->search($t->id))->values();return view('additional.show',compact('course','documents','enrollmentForm','teachers'));}
}