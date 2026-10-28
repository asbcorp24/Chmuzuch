@extends('layouts.app')
@section('title','Деятельность училища — ЧМУ')
@section('content')
@foreach($blocks as $block)
@if(($block['id']??'')==='hero')<section class="activity-hero"><p class="eyebrow">Чебоксарское музыкальное училище</p><h1>{{$block['title']}}</h1><p>Основные направления образовательной, творческой, научной и общественной деятельности.</p></section>
@elseif(($block['id']??'')==='directions')<section class="activity-grid">@foreach([['Образовательная деятельность','/education'],['Творческая деятельность','/collectives'],['Научная и проектная деятельность','/science'],['Практическая подготовка','/practice'],['Студенческая жизнь','/student-life'],['Дополнительное образование','/additional-education'],['Конкурсы','/competitions'],['Федеральные олимпиады','/federal-competitions']] as $i=>$item)<a href="{{$item[1]}}"><span>0{{$i+1}}</span><h2>{{$item[0]}}</h2><b>Открыть →</b></a>@endforeach</section>
@endif
@endforeach
@endsection