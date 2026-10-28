<?php
namespace App\Http\Controllers;
use App\Models\Collective;use App\Models\Post;use App\Models\Media;use App\Models\Achievement;
class CollectiveController extends Controller {
 public function index(){return view('collectives.index',['collectives'=>Collective::where('is_active',true)->with(['department','leader'])->orderBy('sort')->orderBy('title')->paginate(30)]);}
 public function show(string $slug){$collective=Collective::where('is_active',true)->where('slug',$slug)->with(['department','leader'])->firstOrFail();$posts=Post::published()->whereIn('type',['news','event','announcement'])->where('meta->collective_id',$collective->id)->orderByDesc('published_at')->limit(8)->get();$media=Media::where('meta->collective_id',$collective->id)->latest()->limit(12)->get();$achievements=Achievement::where('collective_id',$collective->id)->orderByDesc('year')->latest()->limit(12)->get();return view('collectives.show',compact('collective','posts','media','achievements'));}
}