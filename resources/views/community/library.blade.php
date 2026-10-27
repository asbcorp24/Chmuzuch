@extends('layouts.app')
@section('title','Библиотека — ЧМУ')
@section('content')
@foreach($blocks as $block) @php($id=$block['id'])
@if($id==='hero')<section class="library-hero"><div><p class="eyebrow">Библиотека</p><h1>Музыкальное знание <i>в каждом формате</i></h1><p>Нотный фонд, учебная и методическая литература и электронные ресурсы.</p></div><div class="library-mark"><span>𝄞</span><small>НОТНЫЙ ФОНД</small></div></section>
@elseif($id==='collections')<section class="library-collections">@foreach([['Нотный фонд','Партитуры, клавиры и произведения.','𝄞'],['Учебная литература','Учебники и пособия.','A'],['Методический фонд','Методические разработки.','M'],['Периодика','Журналы и сборники.','P']] as $item)<article><span>{{$item[2]}}</span><h3>{{$item[0]}}</h3><p>{{$item[1]}}</p></article>@endforeach</section>
@elseif($id==='digital')<section class="library-digital"><div><p class="eyebrow">Онлайн</p><h2>{{$block['title']}}</h2><p>Проверенные электронные библиотечные и образовательные ресурсы.</p></div></section>
@elseif($id==='documents')<section class="library-rules"><div><h2>{{$block['title']}}</h2></div><div>@forelse($documents as $doc)<a href="{{asset('storage/'.$doc->file_path)}}">{{$doc->title}} <span>→</span></a>@empty<p>Документы пока не опубликованы.</p>@endforelse</div></section>@endif
@endforeach
@endsection