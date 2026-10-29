@extends('layouts.admin')
@section('title','Редактор — '.$meta['title'])
@section('content')
<form method="POST" action="{{route('admin.save',[$module,$id])}}" class="cms-record-form" enctype="multipart/form-data">@csrf
<header class="admin-top editor-top"><div><a href="/admin/{{$module}}" class="admin-back">← {{$meta['title']}}</a><small>{{$id==='new'?'Новый материал':'Редактирование'}}</small><h1>{{$id==='new'?'Создать: ':'Редактировать: ' }}{{$meta['title']}}</h1></div><div class="editor-actions"><button type="submit" name="status" value="draft">Сохранить черновик</button>@if(auth()->user()?->role!=='editor')<button type="submit" name="status" value="published" class="admin-primary">Опубликовать</button>@endif</div></header>
@if($errors->any())<div class="cms-editor-errors" role="alert"><strong>Проверьте заполнение полей:</strong><ul>@foreach($errors->all() as $error)<li>{{$error}}</li>@endforeach</ul></div>@endif
<div class="cms-editor-tabs" role="navigation" aria-label="Разделы редактора"><a href="#editor-content">Содержание</a><a href="#editor-media">Медиа и документы</a><a href="#editor-publication">Публикация</a><a href="#editor-seo">SEO и адрес</a><a href="#editor-scene">3D</a><a href="#editor-form">Форма</a></div>
<div class="editor-layout"><section class="editor-canvas" id="editor-content"><div class="editor-field"><label>Заголовок</label><input name="title" class="editor-title" value="{{old('title',$record?->title)}}" required placeholder="Название материала"></div><div class="editor-field"><label>Краткое описание</label><textarea name="excerpt" rows="3" placeholder="Лид / анонс">{{old('excerpt',$record?->excerpt)}}</textarea></div><p>Текст, таблицы, фотографии, аудио, видео и ссылки. Медиа можно вставлять через редактор.</p>@if($module==='pages')<p><a href="{{route('admin.navigation.index')}}">Добавить страницу в меню →</a>@if($record?->slug) · <a href="{{route('custom-page.show',$record->slug)}}" target="_blank" rel="noopener">Открыть страницу ↗</a>@endif</p>@endif<textarea name="content" class="cms-content-editor" rows="18" placeholder="Содержание материала">{{old('content',$record?->content)}}</textarea><section class="page-media-editor" id="editor-media">
<h2>Медиа и документы публикации</h2>
<p>Прикреплённые файлы сохраняются вместе с материалом. Отметьте ненужные и нажмите «Сохранить черновик» или «Опубликовать», чтобы удалить их из публикации.</p>
<label>Добавить файлы<input id="cms-media-upload" type="file" name="page_media[]" accept="image/jpeg,image/png,image/webp,image/gif,audio/mpeg,audio/wav,audio/ogg,audio/mp4,video/mp4,video/webm,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.odt,.ods,.odp" multiple></label>
<small>До 50 файлов за раз, до 50 МБ каждый. Большие видео лучше хранить отдельно.</small>
<div id="cms-media-preview" class="cms-media-preview" aria-live="polite"></div>
@php($attachedMedia = $module==='pages'?($record?->blocks['media']??[]):($record?->meta['media']??[]))
@if(count($attachedMedia))
<h3>Уже загружено ({{count($attachedMedia)}})</h3>
<div class="cms-media-grid">
@foreach($attachedMedia as $media)
@php($mediaUrl = !empty($media['path'])?asset('storage/'.$media['path']):null)
<div class="cms-media-card">
@if($mediaUrl && ($media['type']??'')==='image')
<a href="{{$mediaUrl}}" target="_blank" rel="noopener"><img loading="lazy" src="{{$mediaUrl}}" alt="{{$media['title']??'Фото'}}"></a>
@elseif($mediaUrl && ($media['type']??'')==='video')
<video controls preload="metadata" src="{{$mediaUrl}}"></video>
@elseif($mediaUrl && ($media['type']??'')==='audio')
<audio controls preload="none" src="{{$mediaUrl}}"></audio>
@else
<div class="cms-media-file-icon">📄</div>
@endif
<div class="cms-media-caption"><span title="{{$media['title']??''}}">{{$media['title']??basename($media['path']??'Файл')}}</span>
@if($mediaUrl)<a href="{{$mediaUrl}}" target="_blank" rel="noopener">Открыть</a>@endif</div>
<label class="cms-media-remove"><input type="checkbox" name="remove_media[]" value="{{$media['path']??''}}"> Удалить из публикации</label>
</div>
@endforeach
</div>
@else
<p>Пока нет прикреплённых файлов.</p>
@endif
</section>
<style>
.cms-media-grid,.cms-media-preview{display:grid;grid-template-columns:repeat(auto-fill,minmax(165px,1fr));gap:14px;margin:16px 0}
.cms-media-card{border:1px solid #d9e1ea;border-radius:12px;padding:10px;min-width:0;background:var(--surface,#fff)}
.cms-media-card img,.cms-media-card video{display:block;width:100%;height:130px;object-fit:cover;border-radius:8px}
.cms-media-card audio{width:100%;max-width:100%}
.cms-media-file-icon{font-size:38px;text-align:center;padding:35px 0}
.cms-media-caption{display:flex;flex-direction:column;gap:5px;overflow-wrap:anywhere;font-size:13px;margin:8px 0}
.cms-media-remove{display:flex;align-items:center;gap:7px;font-size:13px;color:#a32626;cursor:pointer}
.cms-media-card:has(.cms-media-remove input:checked){opacity:.5;outline:2px solid #d15a5a}
</style>
<script>
document.addEventListener('DOMContentLoaded',function(){
 const input=document.getElementById('cms-media-upload'),preview=document.getElementById('cms-media-preview');
 if(!input||!preview)return;
 input.addEventListener('change',function(){
  preview.replaceChildren();
  Array.from(input.files||[]).forEach(function(file){
   const card=document.createElement('div');card.className='cms-media-card';
   const name=document.createElement('div');name.className='cms-media-caption';name.textContent=file.name;
   if(file.type.startsWith('image/')){
    const img=document.createElement('img');img.alt=file.name;const url=URL.createObjectURL(file);img.src=url;img.addEventListener('load',()=>URL.revokeObjectURL(url),{once:true});card.append(img);
   }else{const ico=document.createElement('div');ico.className='cms-media-file-icon';ico.textContent=file.type.startsWith('video/')?'🎬':file.type.startsWith('audio/')?'🎵':'📄';card.append(ico);}
   card.append(name);preview.append(card);
  });
 });
});
</script></section><aside class="editor-settings"><div class="cms-settings-panel" id="editor-publication"><h3>Публикация</h3><label>Статус<select name="status"><option value="draft" @selected(($record?->status??'draft')==='draft')>Черновик</option><option value="published" @selected($record?->status==='published')>Опубликовано</option><option value="scheduled" @selected($record?->status==='scheduled')>Запланировано</option></select></label><label>Дата<input name="published_at" type="datetime-local" value="{{$record?->published_at?->format('Y-m-d\TH:i')}}"></label></div><div class="cms-settings-panel" id="editor-seo"><h3>SEO / URL</h3><label>URL<input name="slug" value="{{old('slug',$record?->slug)}}" placeholder="slug"></label>@if($module==='pages')<label>Meta title<input name="seo_title" value="{{old('seo_title',$record?->seo_title)}}"></label><label>Meta description<textarea name="seo_description" rows="4">{{old('seo_description',$record?->seo_description)}}</textarea></label>@endif</div>@if($module!=='pages')<div class="cms-settings-panel" id="editor-links"><h3>Связи</h3><label>Отделение<select name="department_id"><option value="">—</option>@foreach($departments as $d)<option value="{{$d->id}}" @selected(old('department_id',$record?->meta['department_id']??null)==$d->id)>{{$d->title}}</option>@endforeach</select></label><label>Преподаватель<select name="teacher_id"><option value="">—</option>@foreach($teachers as $t)<option value="{{$t->id}}" @selected(old('teacher_id',$record?->meta['teacher_id']??null)==$t->id)>{{$t->name}}</option>@endforeach</select></label><label>Коллектив<select name="collective_id"><option value="">—</option>@foreach($collectives as $c)<option value="{{$c->id}}" @selected(old('collective_id',$record?->meta['collective_id']??null)==$c->id)>{{$c->title}}</option>@endforeach</select></label></div>@endif
@php($scene=$module==='pages'?($record?->blocks['scene3d']??[]):($record?->meta['scene3d']??[]))
<div class="cms-settings-panel" id="editor-scene"><h3>3D-модель страницы</h3>
<p>STL необязателен: если модель не загружена, используется стандартная 3D-сцена.</p>
<label>Загрузить STL <input type="file" name="scene_stl" accept=".stl"></label>
@if(!empty($scene['stl']))<small>Текущая модель: {{basename($scene['stl'])}}</small><label><input type="checkbox" name="scene_clear" value="1"> Удалить привязку и вернуть стандартную модель</label>@endif
@foreach(['x'=>'X','y'=>'Y','z'=>'Z'] as $axis=>$axisLabel)
<label>Поворот {{$axisLabel}}, ° <input type="number" name="scene_rotation_{{$axis}}" min="-360" max="360" step="1" value="{{old('scene_rotation_'.$axis,$scene['rotation_'.$axis]??0)}}"></label>
@endforeach
<label>Масштаб <input type="number" name="scene_scale" min="0.1" max="10" step="0.1" value="{{old('scene_scale',$scene['scale']??1)}}"></label>
</div><div class="cms-settings-panel" id="editor-form"><h3>Форма на странице</h3><label>Встроенная форма<select name="form_slug"><option value="">Без формы</option>@foreach($forms as $form)<option value="{{$form->slug}}" @selected(old('form_slug',$module==='pages'?($record?->blocks['form_slug']??null):($record?->meta['form_slug']??null))===$form->slug)>{{$form->title}}</option>@endforeach</select></label><small>Форма выводится внутри публичной страницы, ответы попадают в общий отчёт.</small></div></aside></div>
</form>
@endsection