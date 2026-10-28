@extends('layouts.app')
@section('title','Профком — ЧМУ')
@section('content')
@foreach($blocks as $block) @php($id=$block['id'])
@if($id==='hero')<section class="legacy-hero"><p class="eyebrow">Профсоюзная организация</p><h1>{{$block['title']}}</h1><p>{{$block['text']??'Профсоюзная организация работников Чебоксарского музыкального училища.'}}</p></section>
@elseif($id==='committee')<section class="legacy-section"><p class="eyebrow">Организация</p><h2>{{$block['title']}}</h2><div class="prose">{!!nl2br(e($block['text']??'Состав профсоюзного комитета редактируется в CMS.'))!!}</div><div class="document-list">@foreach($documentGroups['committee']??[] as $doc)<a href="{{asset('storage/'.$doc->file_path)}}" target="_blank" rel="noopener">{{$doc->title}} →</a>@endforeach</div></section>
@elseif($id==='commission')<section class="legacy-dark"><div><p class="eyebrow">Контроль</p><h2>{{$block['title']}}</h2></div><div><div class="prose">{!!nl2br(e($block['text']??'Состав ревизионной комиссии редактируется в CMS.'))!!}</div><div class="document-list">@foreach($documentGroups['commission']??[] as $doc)<a href="{{asset('storage/'.$doc->file_path)}}" target="_blank" rel="noopener">{{$doc->title}} →</a>@endforeach</div></div></section>
@elseif($id==='documents')<section class="block"><h2>{{$block['title']}}</h2><div class="document-list">@forelse($documents as $doc)<a href="{{asset('storage/'.$doc->file_path)}}" target="_blank" rel="noopener"><b>{{$doc->title}}</b><em>Открыть →</em></a>@empty<p>Документы пока не опубликованы.</p>@endforelse</div></section>
@elseif($id==='contacts')<section class="legacy-contacts"><div><p class="eyebrow">Связь</p><h2>{{$block['title']}}</h2></div><div><div class="prose">{!!nl2br(e($block['text']??'Контактная информация редактируется в конструкторе страницы.'))!!}</div><a href="{{route('contacts')}}">Общие контакты училища →</a></div></section>@endif
@endforeach
@endsection