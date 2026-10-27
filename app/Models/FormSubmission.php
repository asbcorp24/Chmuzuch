<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class FormSubmission extends Model { protected $guarded=[]; protected $casts=['data'=>'array','processed_at'=>'datetime']; public function form(){return $this->belongsTo(Form::class);} }