<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Hash;
class UserController extends Controller
{
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index(Request $request)
{
$data = User::orderBy('id','DESC')->paginate(5);
return view('users.show_users',compact('data'))
->with('i', ($request->input('page', 1) - 1) * 5);
}


/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
$roles = Role::pluck('name','name')->all();

return view('users.Add_user',compact('roles'));

}
/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Request $request)
{
$this->validate($request, [
'name' => 'required',
'email' => 'required|email|unique:users,email',
'password' => 'required|same:confirm-password',
'roles_name' => 'required'
]);

$input = $request->all();


$input['password'] = Hash::make($input['password']);

$user = User::create($input);
$user->assignRole($request->input('roles_name'));
return redirect()->route('users.index')
->with('success','تم اضافة المستخدم بنجاح');
}

/**
* Display the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function show($id)
{
$user = User::find($id);
return view('users.show',compact('user'));
}
/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function edit($id)
{
$user = User::find($id);
$roles = Role::pluck('name','name')->all();
$userRole = $user->roles->pluck('name','name')->all();
return view('users.edit',compact('user','roles','userRole'));
}
/**
* Update the specified resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function update(Request $request, $id)
{
$this->validate($request, [
'name' => 'required',
'email' => 'required|email|unique:users,email,'.$id,
'password' => 'same:confirm-password',
'roles' => 'required'
]);
$input = $request->all();
if(!empty($input['password'])){
$input['password'] = Hash::make($input['password']);
}else{
$input = array_except($input,array('password'));
}
$user = User::find($id);
$user->update($input);
DB::table('model_has_roles')->where('model_id',$id)->delete();
$user->assignRole($request->input('roles'));
return redirect()->route('users.index')
->with('success','تم تحديث معلومات المستخدم بنجاح');
}
/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function destroy(Request $request)
{

 
  $get_users = User::find($request->user_id);
 
  foreach($get_users->roles_name as $roles){
    if($roles == "owner"){
       Storage::disk('upload_owner')->delete($get_users->upload_img);
    }else{
      Storage::disk('upload_users')->delete($get_users->upload_img);
    }
  }
 User::find($request->user_id)->delete();
 return redirect()->route('users.index')->with('success','تم حذف المستخدم بنجاح');
}


public function Upload_file_owner(Request $request){
  $validated = $request->validate([
    'upload_file_owner' => 'required',
  ],[
    'upload_file_owner.required' => "عفوا يجب رفع المرفق",
  ]);
  

  if($request->hasfile('upload_file_owner')) {
    $img = $request->file('upload_file_owner');
    $img_name = $img->getClientOriginalName();
    $id = $request->id;

    $get_user = User::find($id);
    $get_user->upload_img = $img_name;
    $get_user->save();
    $request->upload_file_owner->move(public_path('owner_img/') , $img_name);
    session()->flash('upload_file_success');
    return redirect('/users');

  }
}
}
