<div>
    @if($user->hasRole('admin') || $user->hasRole('user'))
    <button data-modal-target="logout-modal" data-modal-toggle="logout-modal" class="flex items-center gap-3 hover:text-blue-500"><i class="fa-solid fa-right-from-bracket"></i>Log Out</button>
        <div class="flex">
            @foreach($items as $item)
                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 m-3">
                    <a href="#">
                        <img class="rounded-t-lg" src="/docs/images/blog/image-1.jpg" alt="" />
                    </a>
                    <div class="p-5">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $item->name }}</h5>
                        </a>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $item->description }}</p>
                        <button wire:click="selectItem({{ $item->id }})"
                                @click="$dispatch('open-loan-modal')"
                                data-modal-target="add-loan-modal"
                                data-modal-toggle="add-loan-modal"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                            Rent
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </button>
                    </div>
                </div>

            @endforeach
        </div>
        <livewire:create-loan />
    @endif


    @if($user->hasRole('admin') || $user->hasRole('operator'))
    <button data-modal-target="logout-modal" data-modal-toggle="logout-modal" class="flex items-center gap-3 hover:text-blue-500"><i class="fa-solid fa-right-from-bracket"></i>Log Out</button>
    <button data-modal-target="add-item-modal" data-modal-toggle="add-item-modal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><i class="fa-solid fa-right-from-bracket"></i>Add Item</button>
    <div class="mt-8 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
        <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Loan Requests</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3">Peminjam</th>
                    <th class="px-6 py-3">Barang</th>
                    <th class="px-6 py-3">Tanggal Pinjam</th>
                    <th class="px-6 py-3">Tanggal Kembali</th>
                    <th class="px-6 py-3">Tujuan</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @if ($loans)
                @foreach($loans as $loan)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{ $loan->borrower->full_name }}</td>
                    @foreach($details as $detail)
                        <td class="px-6 py-4">{{ $detail->item->name ?? 'No' }}</td>
                    @endforeach
                    <td class="px-6 py-4">{{ $loan->loan_date }}</td>
                    <td class="px-6 py-4">{{ $loan->planned_return_date }}</td>
                    <td class="px-6 py-4">{{ Str::limit($loan->purpose, 20) }}</td>
                    <td class="px-6 py-4">
                    <span class="px-2 py-1 text-sm rounded-full
                        @if($loan->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($loan->status == 'approved') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ $loan->status }}
                    </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($loan->status == 'pending')
                            <div class="flex gap-2">
                                <button wire:click="approveLoan({{ $loan->id }})"
                                        class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                    Accept
                                </button>
                                <button wire:click="rejectLoan({{ $loan->id }})"
                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                    Reject
                                </button>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <livewire:add-item />
    @endif

    <div id="logout-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="logout-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to log out?</h3>
                    <button wire:click.prevent="logout" data-modal-hide="logout-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Yes, I'm sure
                    </button>
                    <button data-modal-hide="logout-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
