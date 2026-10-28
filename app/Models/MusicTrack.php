<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class MusicTrack extends Model {
 protected $fillable=['title','artist','file_path','file_name','mime_type','file_size','sort_order','is_active'];
 protected $casts=['is_active'=>'boolean'];
 public function getFileUrlAttribute(): string {return Storage::disk('public')->url($this->file_path);}
}
