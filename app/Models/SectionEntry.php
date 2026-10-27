<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SectionEntry extends Model {protected $guarded=[];protected $casts=['is_active'=>'boolean'];public function scopePortal($q,string $portal){return $q->where('portal',$portal);}}
