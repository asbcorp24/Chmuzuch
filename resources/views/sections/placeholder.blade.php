@extends('layouts.app')
@section('title', ($section ?? 'Раздел').' — ЧМУ')
@section('content')<section class="section-hero"><p class="eyebrow">ЧМУ • цифровой портал</p><h1>{{ $section ?? 'Раздел' }}</h1><p>Раздел подключён к новой архитектуре сайта. Контент будет выводиться динамически из собственной CMS.</p></section>@endsection