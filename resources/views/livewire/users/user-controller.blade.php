<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="my-4 px-4">
                    <x-jet-input wire:model="search" type="search" class="float-right p-2 placeholder-blue-500" placeholder="Buscar"></x-jet-input>
                    <x-jet-button wire:target="ModalCreateUser" wire:loading.attr="disabled" wire:click="ModalCreateUser" class="p-2 mr-4  bg-blue-500 hover:bg-blue-700">
                            <div wire:target="ModalCreateUser" wire:loading>
                                <x-sppiner></x-sppiner>
                            </div>
                            <span wire:loading.class="ml-4" wire:target="ModalCreateUser">Crear</span>
                    </x-jet-button>
                </div>
                <table class="min-w-max w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Usuario</th>
                            <th class="hidden sm:table-cell  py-3 px-6 text-left">Nombre</th>
                            <th class="hidden sm:table-cell  py-3 px-6 text-center">Email</th>
                            <th class="hidden sm:table-cell  py-3 px-6 text-center">Rol</th>
                            <th class="py-3 px-6 text-center">Accion</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($users as $user)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="mr-2">
                                            <img class="rounded-full h-16 w-16" src="{{$user->profile_photo_url}}" alt="{{$user->name}}">
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden sm:table-cell  py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <div class="mr-2">
                                            <span>{{$user->name}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden sm:table-cell  py-3 px-6 text-center">
                                    <div class="flex items-center justify-center">
                                        <span>{{$user->email}}</span>
                                    </div>
                                </td>
                                <td class="hidden sm:table-cell  py-3 px-6 text-center">
                                    @if ($user->id_rol == 1)
                                        <span class="bg-indigo-400 text-indigo-700 py-1 px-3 rounded-full text-xs">{{$user->name_rol}}</span>
                                    @else
                                        <span class="bg-pink-400 text-pink-700 py-1 px-3 rounded-full text-xs">{{$user->name_rol}}</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        {{-- read --}}
                                        <div  wire:loading.class="hover:text-green-500" wire:target="OpenModalView" wire:click="OpenModalView({{$user}})" class="hover:cursor-pointer w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </div>
                                        @if($user->id_rol != 1 & Auth::user()->rols_id == 1)                                            
                                            {{-- update --}}
                                            <div  wire:loading.class="hover:text-green-500" wire:target="OpenModalUpdate" wire:click="OpenModalUpdate({{$user}})" class="hover:cursor-pointer w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </div>
                                            {{-- delete --}}
                                            <div  wire:loading.class="hover:text-green-500" wire:target="OpenModalDelete" wire:click="OpenModalDelete({{$user}})" class="hover:cursor-pointer w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="lg:w-10/12 p-6">
                    {{ $users->links()}}
                </div>
            </div>
        </div>
    {{-- Modal View --}}
    @if ($modal_view)
    <x-modal-component :title="$user_active['name']">
        <div class="p-2 flex flex-wrap">
            <div class="w-1/2">
                <img class="rounded-full h-16 w-16" src="{{$user_active['profile_photo_url']}}" alt="{{$user_active['name']}}">
            </div>
            <div class="w-1/2">
                <div class="my-2">
                    <x-jet-label>Nombre</x-jet-label>
                    <b class="text-indigo-400">{{$user_active['name']}}</b>
                </div>
                <div class="my-2">
                    <x-jet-label>Email</x-jet-label>
                    <b class="text-indigo-400">{{$user_active['email']}}</b>
                </div>
                <div class="my-2">
                    <x-jet-label>Rol</x-jet-label>
                    <b class="text-indigo-400">{{$user_active['name_rol']}}</b>
                </div>
            </div>
            <hr>
            <div class="mt-4 mb-2">
                <x-jet-button class="px-4 bg-purple-500 p-3 ml-3 rounded-lg text-white hover:bg-purple-700" wire:click="CloseModal()">OK</x-jet-button>                      
            </div>
        </div>
    </x-modal-component>
    @endif
    {{-- ModalUpdate --}}
    @if ($modal_update)
        <x-modal-component title="{{$user_active['name']}}">
            <div class="p-2">
                <div class="my-3">
                    {{-- Si se cargo una foto --}}
                    @if ($photo)
                        <img class="rounded-full h-24 w-24" src="{{ $photo->temporaryUrl() }}">
                    @else
                    {{-- la foto que ya tenia o el avatar --}}
                        @if ($user_active['profile_photo_path'])
                            <img wire:model.defer="user_active.profile_photo_path" class="rounded-full h-24 w-24" src="http://127.0.0.1:8000/storage/{{$user_active['profile_photo_path']}}" alt="{{$user_active['name']}}">
                        @else
                            <img wire:model.defer="user_active.profile_photo_path" class="rounded-full h-24 w-24" src="{{$user_active['profile_photo_url']}}" alt="{{$user_active['name']}}">
                        @endif
                    @endif
                </div>
                <div class="my-3">
                    <x-jet-label>Nombre</x-jet-label>
                    <x-jet-input type="text" wire:model.defer="user_active.name" class="p-2" value="{{$user_active['name']}}"></x-jet-input>
                    <x-jet-input-error class="text-xs text-red-400 italic" for="user_active.name"></x-jet-input-error>
                </div>
                <div class="my-3">
                    <x-jet-label>Rol</x-jet-label>
                    <select wire:model.defer="user_active.id_rol">
                        <option value="{{$user_active['id_rol']}}" selected>{{$user_active['name_rol']}}</option>
                        @foreach ($rols as $rol)
                            @if ($rol->id != $user_active['id_rol'])
                                <option value="{{$rol->id}}">{{$rol->name}}</option>
                            @endif
                        @endforeach
                    </select>
                    <x-jet-input-error class="text-xs text-red-400 italic" for="user_active.id_rol"></x-jet-input-error>
                </div>
                <div class="my-3">
                    <x-jet-label>Email</x-jet-label>
                    <x-jet-input type="email" wire:model.defer="user_active.email" class="p-2" value="{{$user_active['email']}}"></x-jet-input>
                    <x-jet-input-error class="text-xs text-red-400 italic" for="user_active.email"></x-jet-input-error>
                </div>
                <div class="my-3">
                    <x-jet-label>Nueva imagen</x-jet-label>
                    <input class="p-2" type="file" wire:model="photo">
                </div>
                <div class="mt-4 mb-2">
                    <x-jet-button class="px-4 bg-gray-500 p-3 ml-3 rounded-lg text-white hover:bg-teal-400" wire:click="CloseModal">Cancelar</x-jet-button>                      
                    <x-jet-button class="px-4 bg-purple-500 p-3 ml-3 rounded-lg text-white hover:bg-purple-700" wire:click="UpdateUser">
                        <div wire:target="UpdateUser" wire:loading>
                            <x-sppiner></x-sppiner>
                        </div>
                        <span wire:target="UpdateUser" wire:loading.class="ml-4">Actualizar</span>
                    </x-jet-button>                      
                </div>
            </div>
        </x-modal-component>
    @endif
    {{-- modal create --}}
    @if ($modal_create)
        <x-modal-component title="Crear Usuario">
            <div class="p-2">
                <div class="my-3">
                    {{-- Si se cargo una foto --}}
                    @if ($photo)
                        <img class="rounded-full h-24 w-24" src="{{ $photo->temporaryUrl() }}">
                    @endif
                    <x-jet-label>imagen</x-jet-label>
                    <input class="p-2" type="file" wire:model="photo"> 
                    <div wire:target="photo" wire:loading>
                        <small class="ml-4 italic text-indigo-500">cargando...</small>
                    </div>
                    <x-jet-input-error class="text-xs text-red-400 italic" for="photo"></x-jet-input-error>                   
                </div>
                <div class="my-3">
                    <x-jet-label>Nombre</x-jet-label>
                    <x-jet-input type="text" wire:model.defer="name" class="p-2"></x-jet-input>
                    <x-jet-input-error class="text-xs text-red-400 italic" for="name"></x-jet-input-error>
                </div>
                <div class="my-3">
                    <x-jet-label>Rol</x-jet-label>
                    <select wire:model.defer="rol">
                        <option value="">Seleccione</option>
                        @foreach ($rols as $rol)
                            <option value="{{$rol->id}}" selected>{{$rol->name}}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error class="text-xs text-red-400 italic" for="rol"></x-jet-input-error>
                </div>
                <div class="my-3">
                    <x-jet-label>Email</x-jet-label>
                    <x-jet-input type="email" wire:model.defer="email" class="p-2"></x-jet-input>
                    <x-jet-input-error class="text-xs text-red-400 italic" for="email"></x-jet-input-error>
                </div>
                <div class="my-3">
                    <x-jet-label>Contraseña</x-jet-label>
                    <x-jet-input type="password" wire:model.defer="pass" class="p-2"></x-jet-input>
                    <x-jet-input-error class="text-xs text-red-400 italic" for="pass"></x-jet-input-error>
                </div>
                <div class="mt-4 mb-2">
                    <x-jet-button wire:target="CloseModal" wire:loading.attr="disabled" wire:click="CloseModal" class="px-4 bg-gray-500 p-3 ml-3 rounded-lg text-white hover:bg-teal-400"   >Cancelar</x-jet-button>                      
                    <x-jet-button wire:target="CreateUser" wire:loading.attr="disabled" wire:click="CreateUser" class="px-4 bg-purple-500 p-3 ml-3 rounded-lg text-white hover:bg-purple-700">
                        <div wire:target="CreateUser" wire:loading>
                            <x-sppiner></x-sppiner>
                        </div>
                        <span wire:target="CreateUser" wire:loading.class="ml-4">Actualizar</span>
                    </x-jet-button>                      
                </div>
            </div>
        </x-modal-component>
    @endif
    {{-- modal delete --}}
    @if ($modal_delete)
    <x-modal-component title="Eliminar Cliente">
        <div class="p-2">
            <div class="my-2">
                <x-jet-label>Seguro que desea eliminar a 
                    <span class="text-bold">
                        {{$user_active['name']}} 
                    </span>?
                </x-jet-label>
            </div>
            <div class="mt-4 mb-2">
                <x-jet-button wire:target="CloseModal" wire:loading.attr="disabled" class="px-4 bg-gray-500 p-3 ml-3 rounded-lg text-white hover:bg-teal-400" wire:click="CloseModal">Cancelar</x-jet-button>                      
                <x-jet-button wire:target="DeleteUser" wire:loading.attr="disabled" class="px-4 bg-red-500 p-3 ml-3 rounded-lg text-white hover:bg-red-700" wire:click="DeleteUser">
                    <div wire:target="DeleteUser" wire:loading>
                        <x-sppiner></x-sppiner>
                    </div>
                    <span wire:target="DeleteUser" wire:loading.class="ml-4">Eliminar</span>
                </x-jet-button>                      
            </div>
        </div>
    </x-modal-component>
    @endif
    </div>
</div>
