<div>
    <div class="container mx-auto p-4">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">User Management</h1>
                <button wire:click=""
                        data-modal-target="register-modal" data-modal-toggle="register-modal"                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    + Tambah User
                </button>
            </div>

            <!-- User Table -->
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Nama</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Email</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Role</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Aksi</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $user->username }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3">
                            <span class="px-2 py-1 text-sm rounded-full
                                @if($user->hasRole('admin')) bg-red-100 text-red-800
                                @elseif($user->hasRole('operator')) bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $user->getRoleNames()->first() }}
                            </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex space-x-2">
                                    <button wire:click="openEditModal({{ $user->id }})"
                                            class="text-yellow-600 hover:text-yellow-800">
                                        ✏️ Edit
                                    </button>
                                    <button wire:click="openDeleteModal({{ $user->id }})"
                                            class="text-red-600 hover:text-red-800">
                                        🗑️ Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Create/Edit Modal -->
            @if($showCreateModal || $showEditModal)
                <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg p-6 w-full max-w-md">
                        <h2 class="text-xl font-bold mb-4">
                            {{ $showCreateModal ? 'Tambah User Baru' : 'Edit User' }}
                        </h2>

                        <form wire:submit.prevent="{{ $showCreateModal ? 'createUser' : 'updateUser' }}">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                    <input type="text" wire:model="full_name"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('full_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                                    <input type="text" wire:model="username"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('username') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Role</label>
                                    <select wire:model="selectedRole"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @if($showCreateModal)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" wire:model="email"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Password</label>
                                        <input type="password" wire:model="password"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                @endif
                            </div>

                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" wire:click="closeModals"
                                        class="px-4 py-2 border rounded-md hover:bg-gray-100">
                                    Batal
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Delete Confirmation Modal -->
            @if($showDeleteModal)
                <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg p-6 w-full max-w-md">
                        <h2 class="text-xl font-bold mb-4">Konfirmasi Hapus</h2>
                        <p class="mb-6">Apakah Anda yakin ingin menghapus user ini?</p>

                        <div class="flex justify-end space-x-3">
                            <button wire:click="closeModals"
                                    class="px-4 py-2 border rounded-md hover:bg-gray-100">
                                Batal
                            </button>
                            <button wire:click="deleteUser"
                                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <livewire:register />
</div>
