<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-blue-900 uppercase tracking-tighter italic">Inscription</h2>
        <p class="text-gray-400 text-xs font-bold uppercase mt-1">Devenir Titulaire de Permis</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label class="text-[10px] font-black uppercase text-blue-900 ml-2">Nom complet / Raison Sociale</label>
            <x-text-input id="name" class="block mt-1 w-full border-gray-200 rounded-xl" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <label class="text-[10px] font-black uppercase text-blue-900 ml-2">Adresse Email Professionnelle</label>
            <x-text-input id="email" class="block mt-1 w-full border-gray-200 rounded-xl" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label class="text-[10px] font-black uppercase text-blue-900 ml-2">Mot de passe</label>
            <x-text-input id="password" class="block mt-1 w-full border-gray-200 rounded-xl" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label class="text-[10px] font-black uppercase text-blue-900 ml-2">Confirmer le mot de passe</label>
            <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-200 rounded-xl" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-8">
            <x-primary-button class="w-full justify-center py-4 bg-amber-500 hover:bg-blue-900 text-blue-900 hover:text-white rounded-xl text-sm font-black transition duration-300">
                CRÉER MON COMPTE
            </x-primary-button>
        </div>

        <div class="mt-6 text-center">
            <a class="text-xs font-black text-blue-900 hover:underline uppercase tracking-tighter" href="{{ route('login') }}">
                Déjà inscrit ? Connectez-vous
            </a>
        </div>
    </form>
</x-guest-layout>