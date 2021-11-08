<x-layout>
    <div class="w-full md:w-1/2 shadow p-4 mx-auto mt-5 rounded">
        <h1 class="font-bold text-xl uppercase">
            Register
        </h1>
        @if (session('success'))
        <div class="p-2 bg-green-300 rounded font-bold text-green-900">
            Register Successfully!
        </div>
        @endif
        <form action="/register" method="POST">
            @csrf
            <div class="my-2">
                <label for="" class="mb-2 block text-xs font-bold">Name</label>
                <input type="text" name="name" required class="p-2 border-4 border-green-400 w-full rounded">
            </div>
            <div class="my-2">
                <label for="" class="mb-2 block text-xs font-bold">Email</label>
                <input type="email" name="email" required class="p-2 border-4 border-green-400 w-full rounded">
                @error('email')
                <div class="text-xs font-bold uppercase text-red-500">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="my-2">
                <label for="" class="mb-2 block text-xs font-bold">Password</label>
                <input type="password" name="password" required class="p-2 border-4 border-green-400 w-full rounded">
            </div>
            <button class="p-2 bg-green-400 font-bold rounded uppercase text-white w-full">
                Register
            </button>
            <div class="text-center my-2">
                Alreay have an account? <a href="/nova/login" class="text-green-400">click here to login</a>
            </div>
        </form>
    </div>
</x-layout>
