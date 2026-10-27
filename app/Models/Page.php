<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Page extends Model { use SoftDeletes; protected $guarded=[]; protected $casts=['blocks'=>'array','published_at'=>'datetime']; public function scopePublished($q){return $q->where('status','published')->where(fn($x)=>$x->whereNull('published_at')->orWhere('published_at','<=',now()));} }