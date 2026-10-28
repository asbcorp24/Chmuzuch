@extends('layouts.app')
@section('title','Обратная связь — ЧМУ')
@section('content')
<section class="feedback-hero"><div><p class="eyebrow">Обратная связь</p><h1>{{$page->title?:'Напишите нам'}}</h1><p>{{$page->excerpt?:'Задайте вопрос училищу. Контактные данные нужны для ответа.'}}</p></div><div class="feedback-mark"><span>↗</span><small>ЧМУ · ОБРАТНАЯ СВЯЗЬ</small></div></section>
@if($page->content)<section class="block"><div class="prose">{!!nl2br(e($page->content))!!}</div></section>@endif
<section class="feedback-wrap"><aside><p class="eyebrow">Связаться</p><h2>Ваш вопрос</h2><p>Обращения сохраняются в CMS и доступны ответственным сотрудникам.</p><a href="{{route('contacts')}}">Контакты училища →</a><a href="{{route('privacy')}}">Политика обработки данных →</a></aside>
<div class="feedback-form-card">
@if(session('form_success'))<div class="form-success">{{session('form_success')}}</div>@endif
@if($form)<form action="{{route('forms.submit',$form->slug)}}" method="post">@csrf
@foreach($form->fields??[] as $field) @php $name=$field['name']??null; $type=$field['type']??'text'; @endphp @if($name)<div class="feedback-field"><label>{{$field['label']??$name}} @if($field['required']??false)<b>*</b>@endif</label>@if($type==='textarea')<textarea name="{{$name}}" rows="7" @required($field['required']??false)>{{old($name)}}</textarea>@else<input name="{{$name}}" type="{{$type==='email'?'email':($type==='tel'?'tel':'text')}}" value="{{old($name)}}" @required($field['required']??false)>@endif @error($name)<small>{{$message}}</small>@enderror</div>@endif @endforeach
<label class="feedback-consent"><input type="checkbox" name="privacy" value="1" required><span>Я даю согласие на обработку персональных данных в соответствии с <a href="{{route('privacy')}}">политикой обработки персональных данных</a>.</span></label><div class="feedback-submit"><button type="submit">Отправить сообщение <span>→</span></button></div></form>
@else<div class="empty-state"><h3>Форма временно недоступна</h3><p>Администратор может создать и активировать форму со slug <b>feedback</b> в конструкторе форм.</p><a href="{{route('contacts')}}">Контакты училища →</a></div>@endif
</div></section>
<section class="feedback-help"><div><p class="eyebrow">Перед обращением</p><h2>Возможно, ответ уже есть</h2></div><div class="feedback-links"><a href="{{route('applicants')}}"><span>01</span><b>Поступление</b><small>Абитуриенту →</small></a><a href="{{route('students')}}"><span>02</span><b>Обучение</b><small>Студенту →</small></a><a href="{{route('schedule')}}"><span>03</span><b>Расписание</b><small>Открыть →</small></a><a href="{{route('official')}}"><span>04</span><b>Документы</b><small>Сведения →</small></a></div></section>
@endsection