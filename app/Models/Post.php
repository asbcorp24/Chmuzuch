<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Post extends Model { use SoftDeletes; protected $guarded=[]; protected $casts=['meta'=>'array','starts_at'=>'datetime','ends_at'=>'datetime','published_at'=>'datetime']; public function scopePublished($q){return $q->where('status','published')->where(fn($x)=>$x->whereNull('published_at')->orWhere('published_at','<=',now()));} public function concertPerformances(){return $this->hasMany(ConcertPerformance::class)->where('is_published',true)->orderBy('program_number')->orderBy('id');} public function scopeType($q,string $type){return $q->where('type',$type);} }