<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ConcertPerformance extends Model {
 protected $fillable=['post_id','program_number','title','composer','performer','instrument','accompanist','teacher_id','description','audio_url','video_url','is_published'];
 protected $casts=['is_published'=>'boolean'];
 public function concert(){return $this->belongsTo(Post::class,'post_id');}
 public function media(){return $this->belongsToMany(Media::class,'concert_performance_media')->withPivot('sort')->orderByPivot('sort');}
 public function students(){return $this->belongsToMany(Student::class,'concert_performance_students')->withPivot(['role','sort'])->orderByPivot('sort');}
 public function teachers(){return $this->belongsToMany(Teacher::class,'concert_performance_teachers')->withPivot(['role','sort'])->orderByPivot('sort');}
 public function teacher(){return $this->belongsTo(Teacher::class);}
}
