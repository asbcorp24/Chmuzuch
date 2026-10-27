<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class EducationProgram extends Model {
 protected $guarded=[];
 protected $casts=['profiles'=>'array','documents'=>'array','is_active'=>'boolean'];
}