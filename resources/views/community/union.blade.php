@extends('layouts.app')
@section('title','Профком — ЧМУ')
@section('content')
@foreach($blocks as $block) @php($id=$block['id'])
@if($id==='hero')<section class="legacy-hero"><p class="eyebrow">Профсоюзная организация</p><h1>Профком <i>училища</i></h1><p>Профсоюзная организация работников Чебоксарского музыкального училища.</p></section>
@elseif($id==='committee')<section class="legacy-section"><p class="eyebrow">Организация</p><h2>{{$block['title']}}</h2><p>{{$block['text']??'Состав профсоюзного комитета публикуется и актуализируется администрацией сайта.'}}</p></section>
@elseif($id==='commission')<section class="legacy-dark"><div><p class="eyebrow">Контроль</p><h2>{{$block['title']}}</h2></div><div><p>{{$block['text']??'Актуальный состав ревизионной комиссии.'}}</p></div></section>
@elseif($id==='documents')<section class="block"><h2>{{$block['title']}}</h2><div class="document-list">@forelse($documents as $doc)<a href="{{asset('storage/'.$doc->file_path)}}"><b>{{$doc->title}}</b><em>Открыть →</em></a>@empty<p>Документы пока не опубликованы.</p>@endforelse</div></section>
@elseif($id==='contacts')<section class="legacy-contacts"><div><p class="eyebrow">Связь</p><h2>{{$block['title']}}</h2></div><div><p>{{$block['text']??'Контактная информация профкома будет опубликована администрацией.'}}</p></div></section>@endif
@endforeach
@endsection