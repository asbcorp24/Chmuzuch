<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class EducationProgram extends Model {
 protected $guarded=[];
 protected $casts=['profiles'=>'array','documents'=>'array','meta'=>'array','is_active'=>'boolean'];
 public function department(){return $this->belongsTo(Department::class);}
}