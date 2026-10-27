<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Achievement extends Model { protected $guarded=[]; protected $casts=['meta'=>'array']; public function teacher(){return $this->belongsTo(Teacher::class);} public function department(){return $this->belongsTo(Department::class);} public function collective(){return $this->belongsTo(Collective::class);} }