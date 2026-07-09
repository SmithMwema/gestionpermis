<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <div class="p-4 md:p-8 min-h-screen bg-[#F4F7FE]">
        <div class="bg-white rounded-[3.5rem] shadow-2xl min-h-[calc(100vh-64px)] flex flex-col overflow-hidden border border-white">
            
            <div class="p-8 md:p-12 flex justify-between items-center border-b border-gray-50 bg-gray-50/20">
                <div>
                    <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tighter italic">Console Administration</h2>
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mt-1">Gestion du personnel et des accès Division</p>
                </div>

                <!-- BOUTON AJOUTER UTILISATEUR -->
                <button onclick="document.getElementById('modal-create').classList.toggle('hidden')" class="bg-blue-900 hover:bg-black text-white px-8 py-3 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl transition-all">
                    + Ajouter un Agent
                </button>
            </div>

            <!-- ZONE STATS (Garder tes stats existantes ici...) -->
            <div class="p-8 lg:p-12 overflow-y-auto flex-1">
                
                @if(session('status'))
                    <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-2xl font-bold text-xs uppercase border border-green-200">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- TABLEAU DE GESTION -->
                <div class="bg-white rounded-[3rem] border border-gray-100 shadow-sm overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-slate-800 text-white text-[9px] font-black uppercase tracking-widest">
                            <tr>
                                <th class="px-8 py-5">Nom / Email</th>
                                <th class="px-8 py-5">Rôle / Territoire</th>
                                <th class="px-8 py-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($allUsers as $u)
                            <tr class="hover:bg-blue-50/20 transition-all">
                                <td class="px-8 py-6">
                                    <span class="text-sm font-black text-slate-800 uppercase">{{ $u->name }}</span>
                                    <p class="text-[10px] text-slate-400 font-bold lowercase">{{ $u->email }}</p>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col gap-1">
                                        <span class="bg-amber-100 text-amber-700 px-2 py-0.5 rounded text-[8px] font-black uppercase w-fit">{{ $u->role }}</span>
                                        @if($u->territoire)<span class="text-[8px] font-bold text-blue-400 uppercase italic">📍 {{ $u->territoire }}</span>@endif
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex justify-end gap-2">
                                        <!-- Formulaire de mise à jour rôle -->
                                        <form action="{{ route('admin.users.update', $u) }}" method="POST" class="inline-flex gap-2">
                                            @csrf @method('PATCH')
                                            <select name="role" class="text-[9px] font-black uppercase rounded-lg border-gray-100 py-1">
                                                <option value="titulaire" {{ $u->role == 'titulaire' ? 'selected' : '' }}>Titulaire</option>
                                                <option value="secretaire" {{ $u->role == 'secretaire' ? 'selected' : '' }}>Secrétaire</option>
                                                <option value="geologue" {{ $u->role == 'geologue' ? 'selected' : '' }}>Géologue</option>
                                                <option value="chef_division" {{ $u->role == 'chef_division' ? 'selected' : '' }}>Chef Div.</option>
                                                <option value="ministre" {{ $u->role == 'ministre' ? 'selected' : '' }}>Ministre</option>
                                                <option value="agent_territorial" {{ $u->role == 'agent_territorial' ? 'selected' : '' }}>Territorial</option>
                                            </select>
                                            <button type="submit" class="w-8 h-8 bg-blue-900 text-white rounded-lg shadow hover:bg-black"><i class="fas fa-save"></i></button>
                                        </form>

                                        <!-- BOUTON SUPPRESSION (RÉPARÉ) -->
                                        <form action="{{ route('admin.users.destroy', $u) }}" method="POST" onsubmit="return confirm('Supprimer ce compte définitivement ?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-8 h-8 bg-red-100 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DE CRÉATION CACHÉE -->
    <div id="modal-create" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[100] flex items-center justify-center p-4">
        <div class="bg-white rounded-[3rem] p-10 max-w-lg w-full shadow-2xl border border-white">
            <h3 class="text-xl font-black text-slate-800 uppercase mb-6 italic italic border-b pb-4 text-center">Inscrire un nouvel Agent</h3>
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="text" name="name" placeholder="Nom complet" class="w-full rounded-xl border-gray-100 bg-gray-50 text-sm font-bold" required>
                <input type="email" name="email" placeholder="Email institutionnel" class="w-full rounded-xl border-gray-100 bg-gray-50 text-sm font-bold" required>
                <div class="grid grid-cols-2 gap-4">
                    <input type="password" name="password" placeholder="Mot de passe" class="w-full rounded-xl border-gray-100 bg-gray-50 text-sm" required>
                    <input type="password" name="password_confirmation" placeholder="Confirmer" class="w-full rounded-xl border-gray-100 bg-gray-50 text-sm" required>
                </div>
                <select name="role" class="w-full rounded-xl border-gray-100 bg-gray-50 text-xs font-black uppercase">
                    <option value="secretaire">Secrétaire</option>
                    <option value="geologue">Géologue</option>
                    <option value="chef_division">Chef de Division</option>
                    <option value="ministre">Ministre Provincial</option>
                    <option value="agent_territorial">Agent Territorial</option>
                </select>
                <div class="flex gap-4 pt-6">
                    <button type="button" onclick="document.getElementById('modal-create').classList.add('hidden')" class="flex-1 bg-gray-100 text-gray-400 font-bold py-3 rounded-xl uppercase text-[10px]">Annuler</button>
                    <button type="submit" class="flex-1 bg-blue-900 text-white font-bold py-3 rounded-xl uppercase text-[10px] shadow-lg shadow-blue-900/30">Créer le compte</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>