<?php

namespace App\Http\Livewire\Clients;

use App\Models\client;
use Livewire\Component;
use Livewire\WithPagination;

class ClientController extends Component
{
    use WithPagination;

    public $client_active;
    public $modal_update = false;
    public $modal_delete = false;
    public $modal_view = false;
    public $modal_create;
    // Filtro
    public $search;
    protected $queryString = ['search'];
    // variable para crear cliente
    public $client = [];
    // validate
    protected $rules = [
        'client.name' => 'required|min:6',
        'client.email' => 'required|email',
        'client.document' => 'required|min:7',
        'client.direccion' => 'required|min:3',
    ];

    public function render()
    {
        $clients = client::where('name','like', '%'.$this->search.'%')
        ->orWhere('document','like', '%'.$this->search.'%')
        ->orWhere('direccion','like', '%'.$this->search.'%')
        ->orWhere('email','like', '%'.$this->search.'%')
        ->latest('id')
        ->paginate(15);

        return view('livewire.clients.client-controller', compact('clients'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function OpenModalUpdate($client){
        
        $this->client_active = $client;
        $this->modal_update = true;

    }

    public function CloseModal(){
        $this->reset();
    }

    public function UpdateClient(){

        $this->validate([
            'client_active.name' => 'required|min:6',
            'client_active.email' => 'required|email',
            'client_active.document' => 'required|min:7',
            'client_active.direccion' => 'required|min:3',
        ]);

        $client = client::find($this->client_active['id']);

        try {

            $client->update($this->client_active);
        
            $this->dispatchBrowserEvent('toastOK',['name'=>'Actualizado']);
    
            
        } catch (\Throwable $th) {

            $this->dispatchBrowserEvent('error',['name'=>'No se pudo actualizar']);

        }
        
        $this->CloseModal();
        $this->reset();

    }

    public function OpenModalDelete($client){

        $this->client_active = $client;
        $this->modal_delete = true;

    }

    public function DeleteClient(){

        try {
            
            client::destroy($this->client_active);

            $this->dispatchBrowserEvent('toastOK', ['name' => 'Se elimino el cliente']);

            
        } catch (\Throwable $th) {
            
            $this->dispatchBrowserEvent('error',['name' => 'No se pudo eliminar']);

        }

        $this->reset();

    }

    public function OpenModalView($client){

        $this->client_active = $client;
        $this->modal_view = true;

    }

    public function ModaCreateClient(){

        $this->modal_create = true;


    }

    public function CreateClient () {

        $this->validate();

        try {

            client::create($this->client);

            $this->CloseModal();
            $this->dispatchBrowserEvent('toastOK', ['name' => 'Se creo el cliente']);
            
        } catch (\Throwable $th) {
            
            $this->dispatchBrowserEvent('error',['name' => 'No se pudo crear el cliente']);

        }

    }

}
