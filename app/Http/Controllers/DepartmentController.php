<?php
namespace App\Http\Controllers;
use Illuminate\View\View;
class DepartmentController extends Controller {
 public function show(string $slug): View {
  $items=config('departments',[]);
  abort_unless(isset($items[$slug]),404);
  return view('departments.show',['slug'=>$slug,'department'=>$items[$slug]]);
 }
}