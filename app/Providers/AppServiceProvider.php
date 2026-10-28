<?php
namespace App\Providers;
use App\Models\Setting;
use App\Models\NavigationItem;
use App\Models\MusicTrack;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider {
 public function register(): void {}
 public function boot(): void {
  View::composer('layouts.app',function($view){
   $settings=[];
   try{if(Schema::hasTable('settings'))$settings=Setting::grouped();}catch(\Throwable $e){}
   $view->with('siteSettings',$settings);
   $navigation=collect();try{if(Schema::hasTable('navigation_items'))$navigation=NavigationItem::where('is_active',true)->orderBy('sort')->orderBy('id')->get();}catch(\Throwable $e){}
   $view->with('siteNavigation',$navigation);
   $tracks=collect();try{if(Schema::hasTable('music_tracks'))$tracks=MusicTrack::where('is_active',true)->orderBy('sort_order')->orderBy('id')->get();}catch(\Throwable $e){}
   $view->with('siteMusicTracks',$tracks);
  });
 }
}