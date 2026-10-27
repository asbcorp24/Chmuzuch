@extends('layouts.admin')
@section('title','Отчёт по форме — CMS ЧМУ')
@section('content')
<header class="admin-top"><div><a href="/admin/form-builder" class="admin-back">← Формы</a><small>Ответы формы</small><h1>Отчёт</h1></div><div class="editor-actions"><button>CSV</button><button>XLSX</button><button>Печать / PDF</button></div></header>
<section class="report-head"><div><small>Форма</small><h2>{{$slug}}</h2></div><div><label>Период<input type="date"></label><span>—</span><label><input type="date"></label><button>Применить</button></div></section>
<section class="report-kpis"><article><small>Ответов</small><b>—</b><span>за выбранный период</span></article><article><small>Сегодня</small><b>—</b><span>новых ответов</span></article><article><small>Заполнение</small><b>—</b><span>статистика формы</span></article></section>
<section class="report-tools"><input placeholder="Поиск в ответах…"><button>Фильтры полей</button><button>Колонки</button></section>
<div class="report-table-wrap"><table class="report-table"><thead><tr><th>#</th><th>Дата</th><th>ФИО</th><th>E-mail</th><th>Телефон</th><th>Статус</th><th></th></tr></thead><tbody>@for($i=1;$i<=6;$i++)<tr><td>{{$i}}</td><td>—</td><td>Ответ {{$i}}</td><td>—</td><td>—</td><td><span class="status-live">Получен</span></td><td>→</td></tr>@endfor</tbody></table></div>
<section class="report-summary"><div><h2>Сводка по полям</h2><p>Для вариантов выбора здесь будут автоматически строиться количества и проценты ответов. Для числовых полей — минимум, максимум и среднее.</p></div><div class="report-bars"><span style="--v:72%">Вариант 1 <i></i><b>72%</b></span><span style="--v:48%">Вариант 2 <i></i><b>48%</b></span><span style="--v:31%">Вариант 3 <i></i><b>31%</b></span></div></section>
@endsection