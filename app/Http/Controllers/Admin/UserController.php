<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
class UserController extends Controller {
 private function allowed(Request $r): void {abort_unless($r->user()?->role==='super_admin',403);}
 public function index(Request $r){$this->allowed($r);return view('admin.users.index',['users'=>User::orderBy('name')->get()]);}
 public function edit(Request $r,$id='new'){$this->allowed($r);return view('admin.users.edit',['user'=>$id==='new'?null:User::findOrFail($id)]);}
 public function save(Request $r,$id='new'){$this->allowed($r);$u=$id==='new'?new User:User::findOrFail($id);$d=$r->validate(['name'=>'required|max:255','email'=>['required','email','max:255',Rule::unique('users','email')->ignore($u->id)],'role'=>'required|in:super_admin,content_manager,editor','password'=>'nullable|min:10']);$d['is_active']=$r->boolean('is_active');if($id==='new'&&!$r->filled('password'))return back()->withErrors(['password'=>'Для нового пользователя задайте пароль.'])->withInput();if($r->filled('password'))$d['password']=Hash::make($d['password']);else unset($d['password']);if($u->exists&&$u->role==='super_admin'&&$u->is_active&&(!$d['is_active']||$d['role']!=='super_admin')&&User::where('role','super_admin')->where('is_active',true)->count()<=1)return back()->withErrors(['role'=>'Нельзя отключить последнего активного главного администратора.'])->withInput();if($u->exists&&$u->id===$r->user()->id&&(!$d['is_active']||$d['role']!=='super_admin'))return back()->withErrors(['role'=>'Нельзя отключить собственную учётную запись главного администратора.'])->withInput();$u->fill($d)->save();return redirect()->route('admin.users.index')->with('success','Пользователь сохранён');}
 public function destroy(Request $r,User $user){$this->allowed($r);abort_if($user->id===$r->user()->id,422);abort_if($user->role==='super_admin'&&$user->is_active&&User::where('role','super_admin')->where('is_active',true)->count()<=1,422,'Нельзя удалить последнего активного главного администратора.');$user->delete();return back();}
}