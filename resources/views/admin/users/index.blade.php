@extends('layouts.admin')
@section('title','Пользователи — CMS')
@section('content')
<header class="admin-top"><div><a href="/admin" class="admin-back">← Панель</a><small>Доступ</small><h1>Пользователи CMS</h1></div><a class="admin-primary" href="{{route('admin.users.edit','new')}}">+ Пользователь</a></header>
@if(session('success'))<div class="admin-flash">{{session('success')}}</div>@endif
<section class="admin-list">@foreach($users as $user)<div class="admin-row"><a href="{{route('admin.users.edit',$user->id)}}"><span><b>{{$user->name}}</b><small>{{$user->email}}</small></span><span>{{['super_admin'=>'Главный администратор','content_manager'=>'Контент-менеджер','editor'=>'Редактор'][$user->role]??$user->role}}</span><span>{{$user->is_active?'Активен':'Отключён'}}</span><b>Изменить</b></a>@if(auth()->id()!==$user->id)<form method="POST" action="{{route('admin.users.destroy',$user)}}">@csrf @method('DELETE')<button onclick="return confirm('Удалить пользователя?')">×</button></form>@endif</div>@endforeach</section>
@endsection