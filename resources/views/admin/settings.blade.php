@extends('layouts.admin')
@section('title','Настройки сайта — CMS ЧМУ')
@section('content')
<form method="POST" action="{{route('admin.settings.save')}}">@csrf<header class="admin-top"><div><a href="/admin" class="admin-back">← Панель</a><small>Системные настройки</small><h1>Настройки сайта</h1></div><button class="admin-primary">Сохранить</button></header>
@if(session('success'))<div class="admin-flash">{{session('success')}}</div>@endif
<div class="settings-grid">
@foreach($fields as $group=>$keys)<section class="settings-card"><h2>{{['general'=>'Сайт','contacts'=>'Контакты','social'=>'Социальные сети','seo'=>'SEO','appearance'=>'Оформление и 3D','privacy'=>'Cookie и персональные данные','footer'=>'Подвал'][$group]??$group}}</h2>
@foreach($keys as $key)<label><span>{{$key}}</span>@if(in_array($key,['tagline','default_description','cookie_text','footer_text']))<textarea name="{{$group}}[{{$key}}]" rows="3">{{data_get($settings,$group.'.'.$key)}}</textarea>@else<input name="{{$group}}[{{$key}}]" value="{{data_get($settings,$group.'.'.$key)}}">@endif</label>@endforeach
</section>@endforeach
</div></form>
@endsection