@extends('layouts.admin')
@section('title','Музыка сайта')
@section('content')
<header class="admin-top"><div><a href="{{route('admin.dashboard')}}" class="admin-back">← Панель</a><h1>Музыка сайта</h1></div></header>
@if(session('success'))<p>{{session('success')}}</p>@endif
@if($errors->any())<div class="form-errors">@foreach($errors->all() as $error)<p>{{$error}}</p>@endforeach</div>@endif
<section class="block"><h2>Добавить трек</h2><form method="POST" action="{{route('admin.music.save')}}" enctype="multipart/form-data">@csrf
<label>Название <input name="title" required></label><label>Исполнитель <input name="artist"></label><label>Аудиофайл (до 50 МБ) <input type="file" name="audio_file" accept=".mp3,.wav,.ogg,.m4a,.aac" required></label><label>Порядок <input type="number" name="sort_order" min="0" value="0"></label><label><input type="checkbox" name="is_active" value="1" checked> Показывать</label><button class="admin-primary">Добавить</button></form></section>
<section class="block"><h2>Плейлист</h2>@forelse($tracks as $track)<div class="admin-row"><form method="POST" action="{{route('admin.music.save',$track)}}" enctype="multipart/form-data">@csrf
<label>Название <input name="title" value="{{$track->title}}" required></label><label>Исполнитель <input name="artist" value="{{$track->artist}}"></label><label>Заменить файл <input type="file" name="audio_file" accept=".mp3,.wav,.ogg,.m4a,.aac"></label><label>Порядок <input type="number" name="sort_order" min="0" value="{{$track->sort_order}}"></label><label><input type="checkbox" name="is_active" value="1" @checked($track->is_active)> Активен</label><button>Сохранить</button></form><audio controls preload="none" src="{{$track->file_url}}"></audio><form method="POST" action="{{route('admin.music.destroy',$track)}}" onsubmit="return confirm('Удалить трек?')">@csrf @method('DELETE')<button>Удалить</button></form></div>@empty<p>Пока нет треков.</p>@endforelse</section>
@endsection
