<?php
namespace App\Providers;
use App\Models\Setting;
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
  });
 }
}