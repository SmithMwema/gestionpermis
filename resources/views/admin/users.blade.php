<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-blue-900 uppercase">Gestion des Utilisateurs et Rôles</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm rounded-lg">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 uppercase text-xs">
                            <th class="p-3">Nom</th>
                            <th class="p-3">Email</th>
                            <th class="p-3">Rôle Actuel</th>
                            <th class="p-3">Attribuer un nouveau rôle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-b text-sm">
                            <td class="p-3">{{ $user->name }}</td>
                            <td class="p-3">{{ $user->email }}</td>
                            <td class="p-3">
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded font-bold uppercase text-[10px]">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="p-3">
                                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" class="text-xs border-gray-300 rounded">
                                        <option value="titulaire" {{ $user->role == 'titulaire' ? 'selected' : '' }}>Titulaire</option>
                                        <option value="secretaire" {{ $user->role == 'secretaire' ? 'selected' : '' }}>Secrétaire</option>
                                        <option value="geologue" {{ $user->role == 'geologue' ? 'selected' : '' }}>Géologue</option>
                                        <option value="chef_division" {{ $user->role == 'chef_division' ? 'selected' : '' }}>Chef Division</option>
                                        <option value="ministre" {{ $user->role == 'ministre' ? 'selected' : '' }}>Ministre</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    <button type="submit" class="bg-blue-900 text-white px-3 py-1 rounded text-xs">Valider</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>