@extends('layouts.app')
@section('title', 'Manajemen User')

@section('content')
<style>
    @keyframes fadeSlideUp {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-card { animation: fadeSlideUp 1.2s cubic-bezier(0.16, 1, 0.3, 1) both; }
</style>

{{-- Header --}}
<div class="flex items-center justify-between mb-6 animate-card" style="animation-delay: 0ms;">
    <div class="flex items-center gap-3">
        <div class="bg-white p-2.5 rounded-xl shadow-sm border border-gray-100 text-[#1a2f6e]">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-extrabold text-[#1a2f6e]">Manajemen User</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola akses dan akun pengguna sistem inventaris.</p>
        </div>
    </div>
    
    <a href="{{ route('users.create') }}"
       class="bg-[#2548cc] text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-sm hover:bg-blue-800 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah User
    </a>
</div>

{{-- Main Content --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-card" style="animation-delay: 200ms;">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50/80 border-b border-gray-100">
                <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-4">User</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Role & Status</th>
                    <th class="px-6 py-4">Terdaftar</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $user)
                <tr class="hover:bg-blue-50/50 transition-colors duration-200 group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            {{-- Avatar --}}
                            <div class="w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center bg-blue-100 text-[#1a2f6e] font-bold border-2 border-white shadow-sm overflow-hidden">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                @endif
                            </div>
                            <div>
                                <div class="font-bold text-gray-900 flex items-center gap-2 text-sm">
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                        <span class="bg-blue-100 text-blue-600 px-1.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">Anda</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2 text-gray-500 font-medium">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            {{ $user->email }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider
                            {{ $user->role === 'super_admin' ? 'bg-purple-100 text-purple-700 border border-purple-200' : 'bg-blue-100 text-blue-700 border border-blue-200' }}">
                            @if($user->role === 'super_admin')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                Super Admin
                            @else
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Admin
                            @endif
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500 font-medium">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-1 opacity-70 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('users.edit', $user) }}" class="p-2 text-gray-400 hover:text-[#2548cc] hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </a>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->name }}?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            <p class="font-medium text-gray-500">Belum ada user yang terdaftar</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection