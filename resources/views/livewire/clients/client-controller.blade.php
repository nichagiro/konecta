<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clientes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="my-4 px-4">
                    <x-jet-input wire:model="search" type="search" class="float-right p-2 placeholder-blue-500" placeholder="Buscar"></x-jet-input>
                    <x-jet-button wire:target="ModaCreateClient" wire:loading.attr="disabled" wire:click="ModaCreateClient" class="p-2 mr-2  bg-blue-500 hover:bg-blue-700">
                        <div wire:target="ModaCreateClient" wire:loading>
                            <x-sppiner></x-sppiner>
                        </div>
                        <span wire:target="ModaCreateClient" wire:loading.class="ml-4">Crear</span>
                    </x-jet-button>
                </div>
                <table class="min-w-max w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal text-center">
                            <th class="py-3 px-6 text-left">Nombre</th>
                            <th class="hidden sm:table-cell py-3 px-6 text-center">Documento</th>
                            <th class="hidden sm:table-cell py-3 px-6 text-center">Email</th>
                            <th class="hidden sm:table-cell py-3 px-6 text-center">Dirección</th>
                            <th class="py-3 px-6 text-center">Accion</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($clients as $client)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="mr-2">
                                            <span>{{$client->name}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden sm:table-cell py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <div class="mr-2">
                                            <span>{{$client->document}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden sm:table-cell py-3 px-6 text-center">
                                    <div class="flex items-center justify-center">
                                        <span>{{$client->email}}</span>
                                    </div>
                                </td>
                                <td class="hidden sm:table-cell  py-3 px-6 text-center">
                                    <span class="text-xs">{{$client->direccion}}</span>                                
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        {{-- read --}}
                                        <div wire:loading.class="hover:text-green-500" wire:target="OpenModalView" wire:click="OpenModalView({{$client}})" class="hover:cursor-pointer w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </div>
                                        {{-- update --}}
                                        <div wire:loading.class="hover:text-green-500" wire:target="OpenModalUpdate" wire:click="OpenModalUpdate({{$client}})" class="hover:cursor-pointer w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </div>
                                        {{-- delete --}}
                                        <div wire:loading.class="hover:text-green-500" wire:target="OpenModalDelete" wire:click="OpenModalDelete({{$client}})" class="hover:cursor-pointer w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="lg:w-10/12 p-6">
                    {{$clients->links()}}
                </div>
            </div>
        </div>
    {{-- ModalUpdate --}}
    @if ($modal_update)
        <x-modal-component title="{{$client_active['name']}}">
            <div class="p-2">
                <div class="my-2">
                    <x-jet-label>Nombre</x-jet-label>
                    <x-jet-input type="text" wire:model.defer="client_active.name" class="p-2" value="{{$client_active['name']}}"></x-jet-input>
                    <x-jet-input-error class="text-xs text-red-400 italic" for="client_active.name"></x-jet-input-error>
                </div>
                <div class="my-2">
                    <x-jet-label>Documento</x-jet-label>
                    <x-jet-input type="text" wire:model.defer="client_active.document" class="p-2" value="{{$client_active['document']}}"></x-jet-input>
                    <x-jet-input-error class="text-xs text-red-400 italic" for="client_active.document"></x-jet-input-error>
                </div>
                <div class="my-2">
                    <x-jet-label>Email</x-jet-label>
                    <x-jet-input type="email" wire:model.defer="client_active.email" class="p-2" value="{{$client_active['email']}}"></x-jet-input>
                    <x-jet-input-error class="text-xs text-red-400 italic" for="client_active.email"></x-jet-input-error>
                </div>
                <div class="my-2">
                    <x-jet-label>Dirección</x-jet-label>
                    <x-jet-input type="text" wire:model.defer="client_active.direccion" class="p-2" value="{{$client_active['direccion']}}"></x-jet-input>
                    <x-jet-input-error class="text-xs text-red-400 italic" for="client_active.direccion"></x-jet-input-error>
                </div>
                <div class="mt-4 mb-2">
                    <x-jet-button wire:target="CloseModal" wire:loading.attr="disabled" class="px-4 bg-gray-500 p-3 ml-3 rounded-lg text-white hover:bg-teal-400" wire:click="CloseModal">Cancelar</x-jet-button>                      
                    <x-jet-button wire:target="UpdateClient" wire:loading.attr="disabled" class="px-4 bg-purple-500 p-3 ml-3 rounded-lg text-white hover:bg-purple-700" wire:click="UpdateClient()">
                        <div wire:target="UpdateClient" wire:loading>
                            <x-sppiner></x-sppiner>
                        </div>
                        <span wire:target="UpdateClient" wire:loading.class="ml-4">Actualizar</span>
                    </x-jet-button>                      
                </div>
            </div>
        </x-modal-component>
    @endif
    {{-- Modal Delete --}}
    @if ($modal_delete)
    <x-modal-component title="Eliminar Cliente">
        <div class="p-2">
            <div class="my-2">
                <x-jet-label>Seguro que desea eliminar a 
                    <span class="text-bold">
                        {{$client_active['name']}} 
                    </span>?
                </x-jet-label>
            </div>
            <div class="mt-4 mb-2">
                <x-jet-button wire:target="CloseModal" wire:loading.attr="disabled" class="px-4 bg-gray-500 p-3 ml-3 rounded-lg text-white hover:bg-teal-400" wire:click="CloseModal">Cancelar</x-jet-button>                      
                <x-jet-button wire:target="DeleteClient" wire:loading.attr="disabled" class="px-4 bg-red-500 p-3 ml-3 rounded-lg text-white hover:bg-red-700" wire:click="DeleteClient()">
                    <div wire:target="DeleteClient" wire:loading>
                        <x-sppiner></x-sppiner>
                    </div>
                    <span wire:target="DeleteClient" wire:loading.class="ml-4">Eliminar</span>
                </x-jet-button>                      
            </div>
        </div>
    </x-modal-component>
    @endif
    {{-- Modal View --}}
    @if ($modal_view)
    <x-modal-component :title="$client_active['name']">
        <div class="p-2">
            <div class="my-2">
                <x-jet-label>Nombre</x-jet-label>
                <b class="text-indigo-400">{{$client_active['name']}}</b>
            </div>
            <div class="my-2">
                <x-jet-label>Documento</x-jet-label>
                <b class="text-indigo-400">{{$client_active['document']}}</b>
            </div>
            <div class="my-2">
                <x-jet-label>Email</x-jet-label>
                <b class="text-indigo-400">{{$client_active['email']}}</b>
            </div>
            <div class="my-2">
                <x-jet-label>Dirección</x-jet-label>
                <b class="text-indigo-400">{{$client_active['direccion']}}</b>
            </div>
            <div class="mt-4 mb-2">
                <x-jet-button wire:target="CloseModal" wire:loading.attr="disabled" class="px-4 bg-purple-500 p-3 ml-3 rounded-lg text-white hover:bg-purple-700" wire:click="CloseModal()">OK</x-jet-button>                      
            </div>
        </div>
    </x-modal-component>
    @endif
    {{-- modal create --}}
    @if ($modal_create)
        <x-modal-component title="Crear Usuario">
            <div class="p-2">
                <div class="my-3">
                    <x-jet-label>Nombre</x-jet-label>
                    <x-jet-input type="text" wire:model.defer="client.name" class="p-2"></x-jet-input>
                    <x-jet-input-error class="text-xs text-red-400 italic" for="client.name"></x-jet-input-error>
                </div>
                <div class="my-3">
                    <x-jet-label>Document</x-jet-label>
                    <x-jet-input type="text" wire:model.defer="client.document" class="p-2"></x-jet-input>
                    <x-jet-input-error class="text-xs text-red-400 italic" for="client.document"></x-jet-input-error>
                </div>
                <div class="my-3">
                    <x-jet-label>Email</x-jet-label>
                    <x-jet-input type="email" wire:model.defer="client.email" class="p-2"></x-jet-input>
                    <x-jet-input-error class="text-xs text-red-400 italic" for="client.email"></x-jet-input-error>                
                <div class="my-3">
                    <x-jet-label>Direccion</x-jet-label>
                    <x-jet-input type="text" type="text" wire:model.defer="client.direccion" class="p-2"></x-jet-input>
                    <x-jet-input-error class="text-xs text-red-400 italic" for="client.direccion"></x-jet-input-error>
                </div>
                <div class="mt-4 mb-2">
                    <x-jet-button wire:target="CloseModal" wire:loading.attr="disabled" class="px-4 bg-gray-500 p-3 ml-3 rounded-lg text-white hover:bg-teal-400" wire:click="CloseModal">Cancelar</x-jet-button>                      
                    <x-jet-button wire:target="CreateClient" wire:loading.attr="disabled" class="px-4 bg-purple-500 p-3 ml-3 rounded-lg text-white hover:bg-purple-700" wire:click="CreateClient()">
                        <div wire:target="CreateClient" wire:loading>
                            <x-sppiner></x-sppiner>
                        </div>
                        <span wire:target="CreateClient" wire:loading.class="ml-4">Crear</span>
                    </x-jet-button>                      
                </div>
            </div>
        </x-modal-component>
    @endif    
    </div>
</div>
