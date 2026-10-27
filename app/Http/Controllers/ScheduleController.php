<?php
namespace App\Http\Controllers;
use App\Models\Document;
use App\Models\Page;
use Illuminate\View\View;
class ScheduleController extends Controller {
 public function index(): View {
  $page=Page::published()->where('slug','schedule')->first();
  $documents=Document::where('is_public',true)->where('category','schedule')->orderByDesc('document_date')->orderByDesc('updated_at')->get();
  return view('schedule.index',compact('page','documents'));
 }
}