<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Activity extends Model {
 protected $guarded=[];
 protected $casts=['meta'=>'array','starts_at'=>'datetime','ends_at'=>'datetime','is_active'=>'boolean'];
 public function scopeType($q,string $type){return $q->where('type',$type);}
}