@extends('layouts.app')
@section('title','Об училище — ЧМУ')
@section('content')
@foreach($blocks as $block) @php($id=$block['id'])
@if($id==='hero')<section class="about-hero"><div><p class="eyebrow">Чебоксарское музыкальное училище им. Ф. П. Павлова</p><h1>{{$block['title']}}</h1><p>История, люди, традиции, образовательная среда и культурная жизнь училища.</p></div><div class="about-monogram">Ч<br><span>МУ</span></div></section>
@elseif($id==='map')<section class="about-map"><a href="/about/history"><b>История</b></a><a href="/about/pavlov"><b>Ф. П. Павлов</b></a><a href="/about/leadership"><b>Руководство</b></a><a href="/teachers"><b>Педагогический состав</b></a><a href="/about/structure"><b>Структура</b></a><a href="/about/facilities"><b>Материальная база</b></a></section>
@elseif($id==='departments')<section class="block"><div class="section-head"><h2>{{$block['title']}}</h2><a href="/departments">Все →</a></div><div class="about-departments">@foreach($departments->take(6) as $d)<a href="{{route('departments.show',$d->slug)}}"><span>→</span><h3>{{$d->title}}</h3></a>@endforeach</div></section>
@elseif($id==='collectives')<section class="block"><div class="section-head"><h2>{{$block['title']}}</h2><a href="/collectives">Все →</a></div><div class="collective-strip">@foreach($collectives as $c)<a href="{{route('collectives.show',$c->slug)}}"><h3>{{$c->title}}</h3><span>→</span></a>@endforeach</div></section>
@elseif($id==='pride')<section class="block pride-zone"><div><h2>{{$block['title']}}</h2></div><div class="pride-links"><a href="/pride">Наша гордость →</a><a href="/laureates">Лауреаты и дипломанты →</a><a href="/gratitudes">Нас благодарят →</a></div></section>
@else<section class="block"><h2>{{$block['title']}}</h2>@if($id==='history')<a href="/about/history">Открыть историю →</a>@elseif($id==='pavlov')<a href="/about/pavlov">Ф. П. Павлов →</a>@elseif($id==='facilities')<a href="/about/facilities">Инфраструктура →</a>@endif</section>@endif
@endforeach
@endsection