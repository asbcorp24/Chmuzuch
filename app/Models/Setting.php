<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Setting extends Model {
 protected $guarded=[];
 public static function getValue(string $group,string $key,$default=null){return static::where('group',$group)->where('key',$key)->value('value')??$default;}
 public static function putValue(string $group,string $key,$value,string $type='string'): void {static::updateOrCreate(['group'=>$group,'key'=>$key],['value'=>$value,'type'=>$type]);}
 public static function grouped(): array {return static::orderBy('group')->orderBy('key')->get()->groupBy('group')->map(fn($rows)=>$rows->pluck('value','key')->all())->all();}
}