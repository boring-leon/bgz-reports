<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Transfery dla raportu #{{ $report->id }}
        </h2>
    </x-slot>

    @include('inc.messages')
    <div class="pl-12 pr-12 mt-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           @foreach($report->transfers as $transfer)
           <div class="bg-white p-6 rounded-lg shadow-lg mb-5">
            <h2 class="text-2xl font-bold mb-2  {{$transfer->kwota >= 0 ? 'text-green-800' : 'text-red-800' }}">
                {{ $transfer->kwota. $transfer->waluta }}, 
                {{ $transfer->data_zlecenia_operacji }} {{ $transfer->data_realizacji !==$transfer->data_zlecenia_operacji ? " zrealizowano ".$transfer->data_realizacji : ""}}
            </h2>
            
            
            <form action="{{ route('reports.transfer_destroy', ['transfer' => $transfer->id]) }}" method="POST">
              @method('DELETE')
              @csrf
              <button class="bg-red-500 text-white font-bold py-2 px-4 rounded float-right relative bottom-10">
                Usuń transfer
              </button>
            </form>

            <a class="bg-blue-500 text-white font-bold py-2 px-4 rounded float-right relative bottom-10 mr-2">
              Podgląd operacji
            </a>
          </div>
           @endforeach
        </div>
    </div>
</x-app-layout>
