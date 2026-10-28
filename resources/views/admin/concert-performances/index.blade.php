@extends('layouts.admin')
@section('title','Программа концерта')
@section('content')
<h1>Программа: {{$concert->title}}</h1>
<p><a href="/admin/concerts">← К концертам</a> · <a href="{{route('concerts.show',$concert->slug)}}" target="_blank">Посмотреть на сайте</a></p>
@if(session('success'))<p class="form-success">{{session('success')}}</p>@endif
@if($errors->any())<div class="form-errors">@foreach($errors->all() as $error)<p>{{$error}}</p>@endforeach</div>@endif
@foreach($performances->concat([new \App\Models\ConcertPerformance]) as $performance)
@php $editing=$performance->exists; @endphp
<section class="block"><h2>{{$editing?'Номер №'.$performance->program_number:'Добавить номер'}}</h2>
<form method="POST" action="{{route('admin.concert-performances.save',[$concert,$editing?$performance:null])}}">@csrf
<div class="form-grid">
<label>Номер в программе <input type="number" min="0" name="program_number" value="{{old('program_number',$performance->program_number??$performances->count()+1)}}" required></label>
<label>Произведение <input name="title" value="{{old('title',$performance->title)}}" required></label>
<label>Композитор <input name="composer" value="{{$performance->composer}}"></label>
<label>Исполнитель (текст) <input name="performer" value="{{$performance->performer}}"></label>
<label>Инструмент <input name="instrument" value="{{$performance->instrument}}"></label>
<label>Концертмейстер <input name="accompanist" value="{{$performance->accompanist}}"></label>
</div>
<label>Описание <textarea name="description">{{$performance->description}}</textarea></label>
<div class="form-grid">
<label>Студенты <select name="student_ids[]" multiple size="7">@foreach($students as $student)<option value="{{$student->id}}" @selected($editing&&$performance->students->contains($student->id))>{{$student->name}}</option>@endforeach</select><small>Для выбора нескольких используйте Ctrl или Cmd.</small></label>
<label>Преподаватели <select name="teacher_ids[]" multiple size="7">@foreach($teachers as $teacher)<option value="{{$teacher->id}}" @selected($editing&&$performance->teachers->contains($teacher->id))>{{$teacher->name}}</option>@endforeach</select></label>
<label>Медиафайлы <select name="media_ids[]" multiple size="9">@foreach($media as $file)<option value="{{$file->id}}" @selected($editing&&$performance->media->contains($file->id))>{{$file->title?:basename($file->path)}} ({{$file->type}})</option>@endforeach</select><small>Файлы сначала загружаются в разделе «Медиа».</small></label>
</div>
<label><input type="checkbox" name="is_published" value="1" @checked(!$editing||$performance->is_published)> Опубликовать номер</label>
<button type="submit">Сохранить номер</button>
</form>
@if($editing)<form method="POST" action="{{route('admin.concert-performances.destroy',[$concert,$performance])}}" onsubmit="return confirm('Удалить номер концерта?')">@csrf @method('DELETE')<button type="submit">Удалить номер</button></form>@endif
</section>
@endforeach
@endsection
