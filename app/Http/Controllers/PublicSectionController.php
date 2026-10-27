<?php
namespace App\Http\Controllers;
use App\Models\Media;
use App\Models\Achievement;
use App\Models\Setting;
use App\Models\Form;
use Illuminate\View\View;
class PublicSectionController extends Controller {
 public function dormitory(): View{return view('public.dormitory');}
 public function media(): View{return view('public.media',['images'=>Media::where('type','image')->latest()->limit(12)->get(),'videos'=>Media::where('type','video')->latest()->limit(6)->get(),'audio'=>Media::where('type','audio')->latest()->limit(8)->get()]);}
 public function videoGallery(): View{return view('public.video-gallery',['items'=>Media::where('type','video')->latest()->paginate(18)]);}
 public function audio(): View{return view('public.audio',['items'=>Media::where('type','audio')->latest()->paginate(30)]);}
 public function achievements(): View{return view('public.achievements',['items'=>Achievement::with(['teacher','department','collective'])->orderByDesc('year')->paginate(30)]);}
 public function pride(): View{return view('public.pride',['items'=>Achievement::where('type','pride')->with(['teacher','department','collective'])->orderByDesc('year')->paginate(24)]);}
 public function laureates(): View{return view('public.laureates',['items'=>Achievement::where('type','laureate')->with(['teacher','department','collective'])->orderByDesc('year')->paginate(40)]);}
 public function gratitudes(): View{return view('public.gratitudes',['items'=>Achievement::where('type','gratitude')->orderByDesc('year')->paginate(24)]);}
 public function contacts(): View{return view('public.contacts',['settings'=>Setting::grouped(),'feedbackForm'=>Form::where('slug','feedback')->where('is_active',true)->first()]);}
}