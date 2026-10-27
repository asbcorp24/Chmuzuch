<?php
namespace App\Http\Controllers;
use App\Models\Activity;
use App\Models\Document;
use Illuminate\View\View;
class ScienceController extends Controller {
 public function index(): View {$projects=Activity::type('project')->where('is_active',true)->orderByDesc('year')->get();$conferences=Activity::type('conference')->where('is_active',true)->orderByDesc('year')->get();$years=$conferences->pluck('year')->filter()->unique()->sortDesc()->values();return view('science.index',compact('projects','conferences','years'));}
 public function project(string $slug): View {$project=Activity::type('project')->where('is_active',true)->where('slug',$slug)->firstOrFail();$documents=Document::where('is_public',true)->where('category','project.'.$slug)->orderByDesc('document_date')->get();return view('science.project',compact('project','documents'));}
 public function conference(string $slug): View {$conference=Activity::type('conference')->where('is_active',true)->where('slug',$slug)->firstOrFail();$documents=Document::where('is_public',true)->where('category','conference.'.$slug)->orderByDesc('document_date')->get();return view('science.conference',compact('conference','documents'));}
}