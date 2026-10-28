<?php
namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\View\View;
class ConcertController extends Controller {
 public function index(): View {return view('concerts.index',['concerts'=>Post::type('concert')->published()->orderByDesc('starts_at')->paginate(12)]);}
 public function show(string $slug): View {return view('concerts.show',['concert'=>Post::type('concert')->published()->where('slug',$slug)->with(['concertPerformances.teacher'])->firstOrFail()]);}
}
