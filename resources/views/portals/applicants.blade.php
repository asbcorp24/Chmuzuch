@extends('layouts.app')
@section('title','Абитуриенту — ЧМУ')
@section('content')
@foreach($blocks as $block) @php($id=$block['id'])
@if($id==='hero')<section class="applicant-hero"><div><p class="eyebrow">Приёмная кампания</p><h1>{{$block['title']}}</h1><p>Информация для поступления в Чебоксарское музыкальное училище.</p></div></section>
@elseif($id==='steps')<section class="admission-dashboard">@foreach(['Выбери специальность','Подготовь документы','Пройди испытания','Следи за рейтингом'] as $i=>$x)<article><small>0{{$i+1}}</small><b>{{$x}}</b></article>@endforeach</section>
@elseif($id==='programs')<section class="block"><h2>{{$block['title']}}</h2><div class="specialty-list">@foreach($programs as $p)<article><span>{{$p->code}}</span><h3>{{$p->title}}</h3><div><small>{{$p->qualification}}</small><a href="{{route('education.program',$p->slug)}}">Подробнее →</a></div></article>@endforeach</div></section>
@elseif($id==='documents')<section class="block"><h2>{{$block['title']}}</h2><div class="document-list">@forelse($documents as $d)<a href="{{asset('storage/'.$d->file_path)}}"><b>{{$d->title}}</b><em>Открыть →</em></a>@empty<p>Документы пока не опубликованы.</p>@endforelse</div></section>
@elseif($id==='contact')<section class="block applicant-contact"><div><h2>{{$block['title']}}</h2><p>Обращения принимаются через формы сайта.</p></div><a href="/feedback">Задать вопрос →</a></section>
@else<section class="block"><h2>{{$block['title']}}</h2></section>@endif
@endforeach
@endsection