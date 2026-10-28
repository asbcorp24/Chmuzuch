@extends('layouts.admin')
@section('title','Конструктор главной — CMS ЧМУ')
@section('content')
<form method="POST" action="{{route('admin.home.save')}}" enctype="multipart/form-data">@csrf
<header class="admin-top"><div><a href="/admin" class="admin-back">← Панель</a><small>Настройки главной</small><h1>Конструктор главной</h1></div><div class="editor-actions"><a href="/" target="_blank">Предпросмотр ↗</a><button type="submit" class="admin-primary home-save">Сохранить</button></div></header>
@if(session('success'))<div class="admin-flash">{{session('success')}}</div>@endif
<input type="hidden" name="blocks_json" data-blocks-json value="{{json_encode($blocks,JSON_UNESCAPED_UNICODE)}}">
@php($heroScene=collect($blocks)->firstWhere('id','hero')['scene3d']??[])
<section class="block" style="padding:20px"><h2>3D-модель первого экрана</h2>
<p>Загрузите STL или оставьте поле пустым для стандартной модели.</p>
<label>STL <input type="file" name="scene_stl" accept=".stl"></label>
@if(!empty($heroScene['stl']))<p>Загружено: {{basename($heroScene['stl'])}}</p><label><input type="checkbox" name="scene_clear" value="1"> Вернуть модель по умолчанию</label>@endif
@foreach(['x','y','z'] as $axis)<label>Поворот {{strtoupper($axis)}} (градусы) <input type="number" name="scene_rotation_{{$axis}}" min="-360" max="360" value="{{$heroScene['rotation_'.$axis]??0}}"></label>@endforeach
<label>Масштаб <input type="number" name="scene_scale" min="0.1" max="10" step="0.1" value="{{$heroScene['scale']??1}}"></label>
</section>
<div class="home-builder-layout"><section><div class="builder-note"><b>Порядок блоков</b><span>Перетаскивайте карточки за маркер ⋮⋮. Выключенные блоки останутся в CMS, но не будут показаны на сайте.</span></div><div class="home-blocks" data-home-blocks>
@foreach($blocks as $block)<article class="home-block" draggable="true" data-id="{{$block['id']}}"><span class="drag-handle">⋮⋮</span><div class="block-state"><input type="checkbox" {{$block['enabled']?'checked':''}}></div><div><small>{{$block['type']}}</small><h3>{{$block['title']}}</h3><p>{{$block['hint']}}</p></div><button class="block-edit" data-edit="{{$block['id']}}">Настроить</button></article>@endforeach
</div></section>
<aside class="home-inspector"><div class="inspector-empty"><span>↙</span><h3>Выберите блок</h3><p>Здесь появятся настройки выбранной секции.</p></div><div class="inspector-panel" hidden><div class="inspector-head"><small>Редактирование блока</small><h2 data-inspector-title>Блок</h2></div><label>Заголовок<input data-field="title"></label><label>Подзаголовок<textarea rows="3"></textarea></label><label>Источник контента<select><option>Автоматически</option><option>Выбрать вручную</option></select></label><label>Количество элементов<input type="number" value="3" min="1" max="12"></label><div class="hero-only"><h3>Hero / 3D</h3><label>Режим<select><option>3D-сцена</option><option>Видео</option><option>Изображение</option></select></label><label>3D-модель<button class="media-drop" type="button">Выбрать GLB / GLTF</button></label><label class="switch-row"><span>Wireframe</span><input type="checkbox"></label><label class="switch-row"><span>Bloom</span><input type="checkbox" checked></label><label>Интенсивность bloom<input type="range" min="0" max="2" step=".1" value=".8"></label><label>Скорость вращения<input type="range" min="0" max="2" step=".1" value=".5"></label></div><h3>Оформление</h3><label>Фон<select><option>Авто</option><option>Тёмный</option><option>Акцентный</option><option>Фото / видео</option></select></label><label class="switch-row"><span>Показывать заголовок</span><input type="checkbox" checked></label></div></aside></div>
<div class="builder-toast" hidden>Настройки подготовлены к сохранению</div>
</form>
@endsection