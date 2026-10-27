<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Collective extends Model { use SoftDeletes; protected $guarded=[]; protected $casts=['meta'=>'array']; public function department(){return $this->belongsTo(Department::class);} public function leader(){return $this->belongsTo(Teacher::class,'leader_id');} }