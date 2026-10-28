<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\MusicTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class MusicController extends Controller {
 public function index(){return view('admin.music.index',['tracks'=>MusicTrack::orderBy('sort_order')->orderBy('id')->get()]);}
 public function save(Request $r,?MusicTrack $track=null){
  $data=$r->validate(['title'=>'required|string|max:255','artist'=>'nullable|string|max:255','audio_file'=>[$track?'nullable':'required','file','max:51200','mimes:mp3,wav,ogg,m4a,aac'],'sort_order'=>'nullable|integer|min:0','is_active'=>'nullable|boolean']);
  $track??=new MusicTrack;
  if($r->hasFile('audio_file')){$file=$r->file('audio_file');$newPath=$file->store('music','public');if($track->exists&&$track->file_path)Storage::disk('public')->delete($track->file_path);$data['file_path']=$newPath;$data['file_name']=$file->getClientOriginalName();$data['mime_type']=$file->getMimeType();$data['file_size']=$file->getSize();}
  unset($data['audio_file']);$data['is_active']=$r->boolean('is_active');$track->fill($data)->save();
  return redirect()->route('admin.music.index')->with('success','Трек сохранён');
 }
 public function destroy(MusicTrack $track){if($track->file_path)Storage::disk('public')->delete($track->file_path);$track->delete();return back()->with('success','Трек удалён');}
}
