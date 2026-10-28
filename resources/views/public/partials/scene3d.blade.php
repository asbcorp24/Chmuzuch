@php($scene=$scene??[])
<div class="page-3d" role="img" aria-label="Интерактивная трёхмерная модель" data-stl="{{!empty($scene['stl'])?asset('storage/'.$scene['stl']):''}}" data-rotation-x="{{$scene['rotation_x']??0}}" data-rotation-y="{{$scene['rotation_y']??0}}" data-rotation-z="{{$scene['rotation_z']??0}}" data-model-scale="{{$scene['scale']??1}}"></div>
