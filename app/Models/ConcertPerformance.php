<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ConcertPerformance extends Model {
 protected $fillable=['post_id','program_number','title','composer','performer','instrument','accompanist','teacher_id','description','audio_url','video_url','is_published'];
 protected $casts=['is_published'=>'boolean'];
 public function concert(){return $this->belongsTo(Post::class,'post_id');}
 public function teacher(){return $this->belongsTo(Teacher::class);}
}
