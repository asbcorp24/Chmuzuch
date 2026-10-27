<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\LearningOffer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
class LearningOfferController extends Controller {
 private function scope(string $scope): string {abort_unless(in_array($scope,['dshi','additional'],true),404);return $scope;}
 public function index(string $scope): View {$scope=$this->scope($scope);return view('admin.learning.index',['scope'=>$scope,'items'=>LearningOffer::scope($scope)->orderBy('sort')->orderBy('title')->paginate(30)]);}
 public function edit(string $scope,string $id='new'): View {$scope=$this->scope($scope);$record=$id==='new'?null:LearningOffer::scope($scope)->findOrFail($id);return view('admin.learning.edit',compact('scope','record'));}
 public function save(Request $r,string $scope,string $id='new'): RedirectResponse {$scope=$this->scope($scope);$d=$r->validate(['title'=>'required|string|max:255','slug'=>'nullable|string|max:255','kind'=>'nullable|string|max:255','age'=>'nullable|string|max:255','hours'=>'nullable|string|max:100','format'=>'nullable|string|max:255','audience'=>'nullable|string|max:255','symbol'=>'nullable|string|max:20','description'=>'nullable|string','sort'=>'nullable|integer|min:0','is_active'=>'nullable|boolean']);$d['scope']=$scope;$d['slug']=Str::slug($d['slug']?:$d['title']);$d['is_active']=$r->boolean('is_active');$record=$id==='new'?new LearningOffer:LearningOffer::scope($scope)->findOrFail($id);$record->fill($d)->save();return redirect()->route('admin.learning.index',$scope)->with('success','Программа сохранена');}
 public function destroy(string $scope,LearningOffer $offer): RedirectResponse {$scope=$this->scope($scope);abort_unless($offer->scope===$scope,404);$offer->delete();return back()->with('success','Программа удалена');}
}