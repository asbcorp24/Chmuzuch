<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Department extends Model { protected $guarded=[]; protected $casts=['meta'=>'array','is_active'=>'boolean']; public function teachers(){return $this->hasMany(Teacher::class);} public function head(){return $this->belongsTo(Teacher::class,'head_teacher_id');} public function collectives(){return $this->hasMany(Collective::class);} }