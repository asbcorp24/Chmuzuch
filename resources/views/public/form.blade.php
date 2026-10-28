@extends('layouts.app')
@section('title',$form->title.' — ЧМУ')
@section('content')
<section class="public-hero"><div><p class="eyebrow">Онлайн-форма</p><h1>{{$form->title}}</h1><p>{{$form->description}}</p></div></section>
<section class="block"><form method="POST" action="{{route('forms.submit',$form->slug)}}" class="public-dynamic-form">@csrf
@if(session('form_success'))<div class="form-success">{{session('form_success')}}</div>@endif
@if($errors->any())<div class="form-errors">Проверьте заполнение обязательных полей.</div>@endif
@foreach($form->fields??[] as $field)<label>{{$field['label']??$field['name']}}@if($field['required']??false)<b>*</b>@endif
@if(($field['type']??'text')==='textarea')<textarea name="{{$field['name']}}" @required($field['required']??false)>{{old($field['name'])}}</textarea>
@elseif(($field['type']??'text')==='select')<select name="{{$field['name']}}" @required($field['required']??false)><option value="">Выберите</option>@foreach($field['options']??[] as $option)<option @selected(old($field['name'])===$option)>{{$option}}</option>@endforeach</select>
@else<input type="{{in_array($field['type']??'text',['email','tel'])?$field['type']:'text'}}" name="{{$field['name']}}" value="{{old($field['name'])}}" @required($field['required']??false)>@endif
@error($field['name'])<small>{{$message}}</small>@enderror</label>@endforeach
<label class="consent-row"><input type="checkbox" name="privacy" value="1" required><span>Я даю согласие на обработку персональных данных и принимаю политику конфиденциальности.</span></label><button type="submit">Отправить</button></form></section>
@endsection