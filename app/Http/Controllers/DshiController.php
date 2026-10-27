<?php
namespace App\Http\Controllers;
use App\Models\Document;
use App\Models\LearningOffer;
use App\Models\Post;
use App\Models\Teacher;
use Illuminate\View\View;
class DshiController extends Controller {
 public function index(): View {return view('dshi.index',['programs'=>LearningOffer::scope('dshi')->where('is_active',true)->orderBy('sort')->get(),'documents'=>Document::where('is_public',true)->where('category','dshi')->orderByDesc('document_date')->get(),'teachers'=>Teacher::where('is_active',true)->orderBy('sort')->limit(3)->get(),'events'=>Post::published()->type('event')->orderBy('starts_at')->limit(3)->get()]);}
 public function show(string $slug): View {$program=LearningOffer::scope('dshi')->where('is_active',true)->where('slug',$slug)->firstOrFail();$documents=Document::where('is_public',true)->where('category','dshi.'.$slug)->orderByDesc('document_date')->get();return view('dshi.show',compact('program','documents'));}
}