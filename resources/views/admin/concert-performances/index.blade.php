@extends('layouts.admin')
@section('title','Программа концерта')
@section('content')
<h1>Программа: {{$concert->title}}</h1>
<p><a href="/admin/concerts">← К концертам</a> · <a href="{{route('concerts.show',$concert->slug)}}" target="_blank">Посмотреть на сайте</a></p>
@if(session('success'))<p class="form-success">{{session('success')}}</p>@endif
@if($errors->any())<div class="form-errors">@foreach($errors->all() as $error)<p>{{$error}}</p>@endforeach</div>@endif
<section class="block"><h2>Медиа всего концерта</h2><p>Выберите общую запись, афишу или фотографии из медиатеки.</p><form method="POST" action="{{route('admin.concerts.media.save',$concert)}}">@csrf
<input type="search" class="concert-filter" data-target="media" placeholder="Поиск в медиатеке…"><select data-concert-list="media" name="media_ids[]" multiple size="10" style="width:100%">@foreach($media as $file)<option data-media-type="{{$file->type}}" data-media-url="{{asset('storage/'.$file->path)}}" value="{{$file->id}}" @selected(in_array($file->id,$concertMediaIds))>{{$file->title?:basename($file->path)}} ({{$file->type}})</option>@endforeach</select><div class="concert-media-preview" aria-live="polite"></div>
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
<label>Медиафайлы <input type="search" class="concert-filter" data-target="media" placeholder="Найти файл…"><select data-concert-list="media" name="media_ids[]" multiple size="9">@foreach($media as $file)<option data-media-type="{{$file->type}}" data-media-url="{{asset('storage/'.$file->path)}}" value="{{$file->id}}" @selected($editing&&$performance->media->contains($file->id))>{{$file->title?:basename($file->path)}} ({{$file->type}})</option>@endforeach</select><div class="concert-media-preview" aria-live="polite"></div><small>Файлы сначала загружаются в разделе «Медиа».</small></label>
</div>
<details open class="concert-roles"><summary>Роли выбранных участников</summary>
<p>Заполните роли для выбранных участников (например, исполнитель, дирижёр, концертмейстер).</p>
@foreach($students as $student)
<label data-role-kind="students" data-role-id="{{$student->id}}" hidden>{{$student->name}} <input name="student_roles[{{$student->id}}]" placeholder="Роль студента" value="{{$editing?($performance->students->firstWhere('id',$student->id)?->pivot?->role??''):''}}"></label>
@endforeach
@foreach($teachers as $teacher)
<label data-role-kind="teachers" data-role-id="{{$teacher->id}}" hidden>{{$teacher->name}} <input name="teacher_roles[{{$teacher->id}}]" placeholder="Роль преподавателя" value="{{$editing?($performance->teachers->firstWhere('id',$teacher->id)?->pivot?->role??''):''}}"></label>
@endforeach
</details>
<label><input type="checkbox" name="is_published" value="1" @checked(!$editing||$performance->is_published)> Опубликовать номер</label>
<button type="submit">Сохранить номер</button>
</form>
@if($editing)<form method="POST" action="{{route('admin.concert-performances.destroy',[$concert,$performance])}}" onsubmit="return confirm('Удалить номер концерта?')">@csrf @method('DELETE')<button type="submit">Удалить номер</button></form>@endif
</section>
@endforeach
<style>
.concert-roles{margin:1rem 0;padding:1rem;border:1px solid #d6dce4;border-radius:12px}
.concert-roles label:not([hidden]){display:flex;gap:1rem;align-items:center;justify-content:space-between;margin:.5rem 0}
.concert-roles label input{max-width:300px;width:100%}
.concert-media-preview{display:grid;grid-template-columns:repeat(auto-fill,minmax(145px,1fr));gap:12px;margin:12px 0}
.concert-media-preview figure{margin:0;border:1px solid #d6dce4;border-radius:10px;padding:8px;overflow:hidden}
.concert-media-preview img,.concert-media-preview video{width:100%;height:100px;object-fit:cover}
.concert-media-preview figcaption{font-size:.8rem;overflow-wrap:anywhere}
</style>
<script>
(function(){
 function refresh(form){
  for(const kind of ['students','teachers']){
   const select=form.querySelector('select[data-concert-list="'+kind+'"]');
   if(!select)continue;
   const selected=new Set(Array.from(select.selectedOptions,option=>option.value));
   form.querySelectorAll('[data-role-kind="'+kind+'"]').forEach(label=>{
    const active=selected.has(label.dataset.roleId);
    label.hidden=!active;
    const input=label.querySelector('input');
    if(input)input.disabled=!active;
   });
  }
  const select=form.querySelector('select[data-concert-list="media"]');
  const preview=form.querySelector('.concert-media-preview');
  if(select&&preview){
   preview.replaceChildren();
   Array.from(select.selectedOptions).forEach(option=>{
    const figure=document.createElement('figure');
    const type=option.dataset.mediaType;
    const url=option.dataset.mediaUrl;
    if(type==='image'&&url){
     const img=document.createElement('img');img.src=url;img.loading='lazy';img.alt=option.textContent;figure.append(img);
    }else if(type==='video'&&url){
     const video=document.createElement('video');video.src=url;video.preload='none';video.controls=true;figure.append(video);
    }else if(type==='audio'){
     const icon=document.createElement('span');icon.textContent='♫ Аудио';figure.append(icon);
    }
    const caption=document.createElement('figcaption');caption.textContent=option.textContent;figure.append(caption);
    preview.append(figure);
   });
  }
 }
 document.querySelectorAll('form').forEach(refresh);
 document.addEventListener('change',event=>{
  if(event.target.matches('select[data-concert-list]'))refresh(event.target.closest('form'));
 });
 document.addEventListener('input',event=>{
  if(!event.target.matches('.concert-filter'))return;
  const select=event.target.parentElement.querySelector('select[data-concert-list]');
  if(!select)return;
  const term=event.target.value.trim().toLocaleLowerCase('ru');
  Array.from(select.options).forEach(option=>{option.hidden=!option.selected&&!option.textContent.toLocaleLowerCase('ru').includes(term)});
 });
})();
</script>
@endsection
