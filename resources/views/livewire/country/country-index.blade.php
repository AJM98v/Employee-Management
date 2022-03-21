<div class="relative p-10 bg-gray-300" x-data="{
            modal: false,
            message: true
    }" @close.window.debounse.300ms="modal =false" @edit.window.debounse.100ms="modal =true">
    <div class="flex justify-between w-[60%] mx-auto block bg-gray-400 p-2">

        <div class="flex items-center">
            <input type="search" placeholder="Search box" name="search" id="search" wire:model.debounse.1000ms='search'
                   class="p-2 mr-2 placeholder-gray-600 border-none rounded outline-none">

            <svg role="status" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                 viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg" wire:loading.delay.long>
                <path
                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                    fill="currentColor"></path>
                <path
                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                    fill="currentFill"></path>
            </svg>

        </div>

        <button @click="modal=true"
                class="w-24 py-2 text-white transition-all duration-200 ease-in rounded shadow cursor-pointer shadow-gray-500 bg-sky-700 hover:bg-blue-600">
            Create
        </button>
    </div>
    <table class="mx-auto block  w-[60%] p-5 ">
        <tr class="text-white bg-gray-800">
            <th class="w-6/12">Countryname</th>

            <th class="w-6/12">Operation</th>
        </tr>
        @forelse($countries as $country)
            <tr class="transition-all duration-75 ease-in bg-white cursor-pointer hover:bg-gray-200">
                <td>{{$country->name}}</td>
                <td>
                    <button wire:click='edit({{$country->id}})'
                            class="w-24 py-2 text-sm text-white transition-all duration-200 ease-in bg-yellow-700 rounded shadow cursor-pointer shadow-gray-500 hover:bg-orange-600">
                        Edit
                    </button>

                    <button wire:click="delete({{$country->id}})"
                            class="w-24 py-2 text-sm text-white transition-all duration-200 ease-in rounded shadow cursor-pointer shadow-gray-500 bg-rose-700 hover:bg-red-600">
                        Delete
                    </button>
                </td>
            </tr>

        @empty
            <tr class="w-full">
                <td class="w-full">No Result...</td>
            </tr>

        @endforelse
    </table>

    <div>

    </div>

    <div x-show="modal" x-transition.opacity.delay..200ms
         class="translate-x-[-50%] translate-y-[-50%] absolute top-[50%] left-[50%] bg-gray-300  p-4 rounded-xl shadow-gray-500 shadow drop-shadow">
        @if($editMode)
            <form class="grid grid-cols-2 gap-3" wire:submit.prevent="update()">
                @else
                    <form class="grid grid-cols-2 gap-3" wire:submit.prevent="store()">
                        @endif

                        @csrf
                        <label for="name">Name</label>
                        <input type="text" wire:model="name" id="name">
                        <label for="code">Country Code</label>
                        <input type="text" wire:model="code" id="code">
                        <button type="submit" @click="message = true"
                                class="w-40 py-2 text-white rounded shadow bg-sky-700 shadow-gray-500">@if($editMode)
                                Update @else Save @endif Country
                        </button>

                    </form>
                    <button @click="modal=false; $wire.defualt()"  class=" mt-2 w-20 py-1 text-white bg-gray-800 rounded-xl">Close</button>


                @foreach($errors->all() as $error)
                        <h5 class="mt-1 text-sm font-bold text-center text-rose-800">{{$error}}</h5>
            @endforeach

    </div>

    @if(\Illuminate\Support\Facades\Session::has('message'))
        <div class="absolute bottom-2 right-2 bg-green-800 text-white font-bold p-2 text-sm rounded-xl" x-init="setTimeout(()=>{message = false},3000)" x-show="message" x-transition.duration.300ms>
            <span>{{\Illuminate\Support\Facades\Session::get('message')}}</span>
        </div>
    @endif


</div>
