<?php
namespace App\Http\Middleware;
use Closure;
class RequireRole {
 public function handle($request,Closure $next,...$roles){
  $user=$request->user();
  abort_unless($user && $user->is_active && in_array($user->role,$roles,true),403);
  return $next($request);
 }
}