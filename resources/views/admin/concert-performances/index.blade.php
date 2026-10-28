@extends('layouts.admin')
@section('title','Программа концерта')
@section('content')
<h1>Программа: {{$concert->title}}</h1>
<p><a href="/admin/concerts">← К концертам</a> · <a href="{{route('concerts.show',$concert->slug)}}" target="_blank">Посмотреть на сайте</a></p>
@if(session('success'))<p class="form-success">{{session('success')}}</p>@endif
@if($errors->any())<div class="form-errors">@foreach($errors->all() as $error)<p>{{$error}}</p>@endforeach</div>@endif
<section class="block"><h2>Медиа всего концерта</h2><p>Выберите общую запись, афишу или фотографии из медиатеки.</p><form method="POST" action="{{route('admin.concerts.media.save',$concert)}}">@csrf
<input type="search" class="concert-filter" data-target="media" placeholder="Поиск в медиатеке…"><select data-concert-list="media" name="media_ids[]" multiple size="10" style="width:100%">@foreach($media as $file)<option value="{{$file->id}}" @selected(in_array($file->id,$concertMediaIds))>{{$file->title?:basename($file->path)}} ({{$file->type}})</option>@endforeach</select>
<p><button type="submit">Сохранить медиа концерта</button></p></form></section>
@foreach($performances->concat([new \App\Models\ConcertPerformance()]) as $performance)
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
<label>Студенты <input type="search" class="concert-filter" data-target="students" placeholder="Найти студента…"><select data-concert-list="students" name="student_ids[]" multiple size="7">@foreach($students as $student)<option value="{{$student->id}}" @selected($editing&&$performance->students->contains($student->id))>{{$student->name}}</option>@endforeach</select><small>Для выбора нескольких используйте Ctrl или Cmd.</small></label>
<label>Преподаватели <input type="search" class="concert-filter" data-target="teachers" placeholder="Найти преподавателя…"><select data-concert-list="teachers" name="teacher_ids[]" multiple size="7">@foreach($teachers as $teacher)<option value="{{$teacher->id}}" @selected($editing&&$performance->teachers->contains($teacher->id))>{{$teacher->name}}</option>@endforeach</select></label>
<label>Медиафайлы <input type="search" class="concert-filter" data-target="media" placeholder="Найти файл…"><select data-concert-list="media" name="media_ids[]" multiple size="9">@foreach($media as $file)<option value="{{$file->id}}" @selected($editing&&$performance->media->contains($file->id))>{{$file->title?:basename($file->path)}} ({{$file->type}})</option>@endforeach</select><small>Файлы сначала загружаются в разделе «Медиа».</small></label>
</div>
<details><summary>Роли участников</summary>
<p>Заполните роли для выбранных участников (например, исполнитель, дирижёр, концертмейстер).</p>
@foreach($students as $student)
<label>{{$student->name}} <input name="student_roles[{{$student->id}}]" placeholder="Роль студента" value="{{$editing?($performance->students->firstWhere('id',$student->id)?->pivot?->role??''):''}}"></label>
@endforeach
@foreach($teachers as $teacher)
<label>{{$teacher->name}} <input name="teacher_roles[{{$teacher->id}}]" placeholder="Роль преподавателя" value="{{$editing?($performance->teachers->firstWhere('id',$teacher->id)?->pivot?->role??''):''}}"></label>
@endforeach
</details>
<label><input type="checkbox" name="is_published" value="1" @checked(!$editing||$performance->is_published)> Опубликовать номер</label>
<button type="submit">Сохранить номер</button>
</form>
@if($editing)<form method="POST" action="{{route('admin.concert-performances.destroy',[$concert,$performance])}}" onsubmit="return confirm('Удалить номер концерта?')">@csrf @method('DELETE')<button type="submit">Удалить номер</button></form>@endif
</section>
@endforeach
<script>
document.addEventListener('input',function(e){
 if(!e.target.matches('.concert-filter'))return;
 const select=e.target.parentElement.querySelector('select[data-concert-list]');
 if(!select)return;
 const term=e.target.value.trim().toLocaleLowerCase('ru');
 for(const option of select.options){
  option.hidden=!option.selected&&!option.textContent.toLocaleLowerCase('ru').includes(term);
 }
});
</script>
@endsection
