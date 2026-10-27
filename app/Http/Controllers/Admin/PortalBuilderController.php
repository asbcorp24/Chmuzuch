<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Http\Controllers\PortalPageController;
use App\Http\Controllers\CommunityPageController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class PortalBuilderController extends Controller {
 private array $allowed=['about','applicants','students','activity','student-life','dormitory','library','practice','union'];
 public function edit(string $slug): View { abort_unless(in_array($slug,$this->allowed,true),404); $page=Page::where('slug',$slug)->first(); if(!$page){if(in_array($slug,['about','applicants','students','activity'],true)){$source=app(PortalPageController::class);$blocks=$source->defaults($slug);$title=$source->title($slug);}else{$source=app(CommunityPageController::class);$blocks=$source->defaults($slug);$title=$source->title($slug);}$page=Page::create(['slug'=>$slug,'title'=>$title,'type'=>'builder','status'=>'published','blocks'=>$blocks]);} return view('admin.portal-builder',['page'=>$page,'blocks'=>$page->blocks??[],'slug'=>$slug]); }
 public function save(Request $r,string $slug): RedirectResponse { abort_unless(in_array($slug,$this->allowed,true),404); $d=$r->validate(['blocks_json'=>'required|json']); $blocks=json_decode($d['blocks_json'],true); abort_unless(is_array($blocks),422); Page::where('slug',$slug)->firstOrFail()->update(['blocks'=>$blocks,'type'=>'builder','status'=>'published']); return back()->with('success','Страница сохранена'); }
}