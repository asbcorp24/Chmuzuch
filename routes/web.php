<?php
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

// Публичная архитектура первого этапа.
// Контроллеры подключаются по мере реализации модулей.
Route::view('/news', 'sections.placeholder')->defaults('section','Новости')->name('news.index');
Route::view('/events', 'sections.placeholder')->defaults('section','Афиша')->name('events.index');
Route::view('/departments', 'sections.placeholder')->defaults('section','Отделения')->name('departments.index');
Route::view('/teachers', 'sections.placeholder')->defaults('section','Преподаватели')->name('teachers.index');
Route::view('/collectives', 'sections.placeholder')->defaults('section','Творческие коллективы')->name('collectives.index');
Route::view('/applicants', 'sections.placeholder')->defaults('section','Абитуриенту')->name('applicants');
Route::view('/students', 'sections.placeholder')->defaults('section','Студенту')->name('students');
Route::view('/dshi', 'sections.placeholder')->defaults('section','ДШИ')->name('dshi');
Route::view('/additional-education', 'sections.placeholder')->defaults('section','Дополнительное образование')->name('additional');
Route::view('/official', 'sections.placeholder')->defaults('section','Сведения об образовательной организации')->name('official');
Route::view('/contacts', 'sections.placeholder')->defaults('section','Контакты')->name('contacts');
