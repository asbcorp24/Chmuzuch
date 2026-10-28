<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class LearningOffer extends Model {
 protected $guarded=[];
 protected $casts=['content'=>'array','is_active'=>'boolean'];
 public function scopeScope($q,string $scope){return $q->where('scope',$scope);}
}