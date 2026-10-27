<?php
namespace App\Http\Controllers;
use App\Models\Collective;
use Illuminate\View\View;
class CollectiveController extends Controller {
 public function index(): View { return view('collectives.index',['collectives'=>Collective::with(['department','leader'])->orderBy('title')->paginate(30)]); }
 public function show(string $slug): View { $collective=Collective::where('slug',$slug)->with(['department','leader'])->firstOrFail(); return view('collectives.show',compact('collective')); }
}