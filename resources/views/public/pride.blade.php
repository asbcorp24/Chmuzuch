@extends('layouts.app')
@section('title','Наша гордость — ЧМУ')
@section('content')
<section class="honor-hero"><p class="eyebrow">Чебоксарское музыкальное училище</p><h1>Наша <i>гордость</i></h1><p>Люди и достижения, которыми гордится училище.</p></section><nav class="edu-nav"><a href="/pride">Наша гордость</a><a href="/laureates">Лауреаты и дипломанты</a><a href="/gratitudes">Нас благодарят</a><a href="/achievements">Все достижения</a></nav>
<section class="block"><div class="achievement-grid">@forelse($items as $item)<article>@if($item->image)<img src="{{asset('storage/'.$item->image)}}" alt="{{$item->person_name?:$item->title}}">@else<div class="avatar-placeholder">✦</div>@endif<small>{{$item->year}}</small><h3>{{$item->person_name?:$item->title}}</h3><p>{{$item->description}}</p></article>@empty<div class="empty-state">Материалы раздела готовятся к публикации.</div>@endforelse</div>{{$items->links()}}</section>
@endsection