<div>
    <!-- Live as if you were to die tomorrow. Learn as if you were to live forever. - Mahatma Gandhi -->
</div><div class="flex justify-between items-center bg-zinc-900 text-white p-4">

    <div class="flex items-center">
        <a href="#">
            <div class="flex items-center">
                <img src="{{ asset('assets/images/favicon.png') }}" class="w-8 h-8 me-2" alt="Logo">
                <h3 class="text-2xl uppercase">{{ config('app.name') }}</h3>
            </div>
        </a>
    </div>

    <div>
        <button id="dropdownBtn" class="bg-cyan-800 text-white text-lg cursor-pointer p-1 px-8 rounded-lg hover:bg-cyan-700">
            <span><i class="fa-regular fa-circle-user me-2"></i>{{ auth()->user()->email }}</span>
        </button>
        <div id="dropdownMenu" class="hidden absolute right-4 mt-2 w-48 bg-white text-zinc-700 rounded-xl shadow-lg z-10 p-2">
            <a href="{{ route('change.password') }}" class="block px-4 py-2 rounded-lg hover:bg-zinc-200"><i class="fa-solid fa-unlock-keyhole me-2"></i>Alterar senha</a>
            <hr class="my-2">
            <a href="{{ route('logout') }}" class="block px-4 py-2 rounded-lg hover:bg-zinc-200"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Sair</a>
        </div>
    </div>

</div>

<script>
    const btn = document.querySelector("#dropdownBtn");
    const menu = document.querySelector("#dropdownMenu");
    document.addEventListener('click', function(e) {
        if (btn.contains(e.target)) {
            menu.classList.toggle('hidden');
        } else if (!menu.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });
</script>
