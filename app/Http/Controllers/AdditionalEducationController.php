<?php
namespace App\Http\Controllers;
use App\Models\Document;
use App\Models\LearningOffer;
use Illuminate\View\View;
class AdditionalEducationController extends Controller {
 public function index(): View {return view('additional.index',['courses'=>LearningOffer::scope('additional')->where('is_active',true)->orderBy('sort')->get(),'documents'=>Document::where('is_public',true)->where('category','additional')->orderByDesc('document_date')->get()]);}
 public function show(string $slug): View {$course=LearningOffer::scope('additional')->where('is_active',true)->where('slug',$slug)->firstOrFail();$documents=Document::where('is_public',true)->where('category','additional.'.$slug)->orderByDesc('document_date')->get();return view('additional.show',compact('course','documents'));}
}