<?php
namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Page;
use Illuminate\View\View;

class CustomPageController extends Controller
{
    public function show(string $slug): View
    {
        $page = Page::published()->where('slug', $slug)->firstOrFail();
        $embeddedForm = !empty($page->blocks['form_slug'])
            ? Form::where('slug', $page->blocks['form_slug'])->where('is_active', true)->first()
            : null;
        return view('public.content-page', compact('page', 'embeddedForm'));
    }
}
