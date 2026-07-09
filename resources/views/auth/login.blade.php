<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-blue-900 uppercase tracking-tighter italic">Connexion</h2>
        <p class="text-gray-400 text-xs font-bold uppercase mt-1">Accès sécurisé au cadastre minier</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="relative">
            <label class="text-[10px] font-black uppercase text-blue-900 ml-2">Adresse Email</label>
            <x-text-input id="email" class="block mt-1 w-full border-gray-200 focus:ring-amber-500 rounded-xl bg-gray-50" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label class="text-[10px] font-black uppercase text-blue-900 ml-2">Mot de passe</label>
            <x-text-input id="password" class="block mt-1 w-full border-gray-200 focus:ring-amber-500 rounded-xl bg-gray-50" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-4 px-2">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-900 shadow-sm focus:ring-amber-500" name="remember">
                <span class="ms-2 text-xs font-bold text-gray-500 italic">{{ __('Rester connecté') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-xs font-black text-amber-600 hover:underline" href="{{ route('password.request') }}">
                    Oublié ?
                </a>
            @endif
        </div>

        <div class="mt-8">
            <x-primary-button class="w-full justify-center py-4 bg-blue-900 hover:bg-amber-600 rounded-xl text-sm font-black transition duration-300 shadow-lg">
                ENTRER DANS MON ESPACE
            </x-primary-button>
        </div>

        <!-- Lien Inscription -->
        <div class="mt-8 text-center border-t pt-6">
            <span class="text-xs text-gray-400 font-bold">Nouveau demandeur (Titulaire) ?</span>
            <br>
            <a href="{{ route('register') }}" class="mt-2 inline-block text-blue-900 font-black text-sm uppercase underline underline-offset-4 hover:text-amber-600 transition">
                Créer un compte maintenant
            </a>
        </div>
    </form>
</x-guest-layout>