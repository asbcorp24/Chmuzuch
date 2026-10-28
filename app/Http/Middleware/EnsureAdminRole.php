<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
class EnsureAdminRole {
 public function handle(Request $request, Closure $next, ...$roles) {
  abort_unless($request->user() && $request->user()->is_active && in_array($request->user()->role,$roles,true),403);
  return $next($request);
 }
}
