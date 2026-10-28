<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class NavigationItem extends Model {
 protected $fillable=['parent_id','label','url','location','sort','is_active'];
 protected $casts=['is_active'=>'boolean'];
 public function children(){return $this->hasMany(self::class,'parent_id')->where('is_active',true)->orderBy('sort')->orderBy('id');}
}
