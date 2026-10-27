<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Document extends Model { protected $guarded=[]; protected $casts=['document_date'=>'date','is_public'=>'boolean','meta'=>'array']; }