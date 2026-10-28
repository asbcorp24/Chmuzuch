<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Student extends Model {
 protected $fillable=['name','slug','course','department_id','is_active'];
 protected $casts=['is_active'=>'boolean'];
 public function department(){return $this->belongsTo(Department::class);}
 public function performances(){return $this->belongsToMany(ConcertPerformance::class,'concert_performance_students')->withPivot(['role','sort']);}
}
