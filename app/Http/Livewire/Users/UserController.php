<?php

namespace App\Http\Livewire\Users;

use App\Http\Controllers\imgStorageController;
use App\Models\rol;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;


class UserController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search;
    protected $queryString = ['search'];
    public $user_active;
    public $modal_view = false;
    public $modal_update = false;
    public $modal_delete = false;
    public $modal_create = false;
    public $rols;
    public $photo;

    // variables para crear user
    public $name;
    public $email;
    public $rol;
    public $pass;

    protected $rules = [
        "name" => "required|min:6",
        "email" => "required|email",
        "rol" => "required|numeric",
        "pass" => "required|min:8",
        "photo" => "required|image|size:1024"
    ];

    public function render()
    {
        $users = User::join('rols','rols.id', '=', 'users.rols_id')
        ->select('users.id','users.name', 'users.email','users.profile_photo_path',
        'rols.id as id_rol', 'rols.name as name_rol')
        ->where('users.name','like', '%'.$this->search.'%')
        ->orWhere('users.email','like', '%'.$this->search.'%')
        ->latest('id')
        ->paginate(15);

        return view('livewire.users.user-controller', compact('users'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function OpenModalView($user){

        $this->user_active = $user;
        $this->modal_view = true;

    }

    public function CloseModal(){

        $this->reset();

    }

    public function OpenModalUpdate($user){
        
        $this->user_active = $user;
        $this->rols = rol::all();
        $this->modal_update = true;

    }

    public function UpdateUser(){

        $this->validate([
            "user_active.name" => "required|min:6",
            "user_active.email" => "required|email",
            "user_active.id_rol" => "required|numeric",
        ]);

        $url = $this->user_active['profile_photo_path'];

        if ($this->photo) {
            try {

                imgStorageController::UpdateImg($url);
                $img = $this->photo->store('public/profile-photos');
                $url = str_replace('public','',$img);


            } catch (\Throwable $th) {
                
                $this->dispatchBrowserEvent('error',['name'=>'error al guardar la foto']);

            }
        }
        
        

            $user = User::find($this->user_active['id']);


            try {
                
                $user->update([
                    "rols_id" => $this->user_active['id_rol'],
                    "name" => $this->user_active['name'],
                    "email" => $this->user_active['email'],
                    "profile_photo_path" => $url
                ]);

                $this->dispatchBrowserEvent('toastOK',['name'=> $this->user_active['name'].' Actualizado']);


            } catch (\Throwable $th) {

                $this->dispatchBrowserEvent('error',['name'=>'No se actualizo']);

            }

        $this->CloseModal();

    }

    public function OpenModalDelete($user){

        $this->user_active = $user;
        $this->modal_delete = true;

    }

    public function DeleteUser(){

        try {

            $url = '/public'.$this->user_active['profile_photo_path'];

            Storage::delete($url);
            
            User::destroy($this->user_active);

            $this->dispatchBrowserEvent('toastOK', ['name' => 'Se elimino el Usuario']);

            
        } catch (\Throwable $th) {
            
            $this->dispatchBrowserEvent('error',['name' => 'No se pudo eliminar']);

        }

        $this->CloseModal();

    }

    public function ModalCreateUser(){

        $this->rols = rol::all();
        $this->modal_create = true;

    }

    public function CreateUser(){

        $this->validate();

        try {

            $img = $this->photo->store('public/profile-photos');
            $url = str_replace('public','',$img);

            User::create([
                "rols_id" => $this->rol,
                "name" => $this->name,
                "email" => $this->email,
                "profile_photo_path" => $url,
                "password" => Hash::make($this->pass)
            ]);

            $this->CloseModal();
            $this->dispatchBrowserEvent('toastOK', ['name' => 'Se creo el usuario']);
            
        } catch (\Throwable $th) {
            
            $this->dispatchBrowserEvent('error',['name' => 'No se pudo crear']);

        }

    }

}


