<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Załaduj raport z banku BGŻ
        </h2>
    </x-slot>

    @include('inc.messages')
    <div class="pl-12 pr-12 mt-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           @include('import.form')

           <h1 class="text-3xl md:text-4xl font-medium mb-2 mt-20">Raporty</h1>
           
            @forelse(auth()->user()->reports as $report)
              @if($loop->first)  
                <div class="pl-20 pr-20 pt-10 pb-10 bg-blue-100">
                  <div class="bg-white p-6 rounded-lg shadow-lg mb-5" id="avg-data">
                    <h2 class="text-2xl font-bold mb-2 text-gray-800">
                      Średnie dane
                    </h2> 
                    <hr>
                    <div class="mt-3">
                       <p><b>Średnie wydatki:</b> {{ round(auth()->user()->reports->avg('expenses'), 2) }}zł </p>
                       <p><b>Średnie wpływy:</b> {{ round(auth()->user()->reports->avg('salary'), 2)  }}zł </p>
                       <p><b>Średni okres raportu w dniach:</b> {{ auth()->user()->reports->avg('days_duration') }} </p>
                    </div>
                    <button class="bg-red-500 text-white font-bold py-2 px-4 rounded float-right relative bottom-10" onclick="document.querySelector('#avg-data').remove()">
                      Ukryj
                    </button>
                  </div>
              @endif
                  <div class="bg-white p-6 rounded-lg shadow-lg mb-5 {{$report->balance >= 0 ? 'border-green-200' : 'border-red-200' }} border-2">
                  <h2 class="text-2xl font-bold mb-2 text-gray-800">
                    {{ $report->name ?? "Raport #". $report->id }}
                  </h2> 
                  <b class="text-{{$report->balance >=0 ? 'green' : 'red'}}-700">Bilans {{ $report->balance }}zł</b>
                  <hr>
                  <div class="mt-3">
                     <p><b>Wydatki:</b> {{ $report->expenses }}zł </p>
                     <p><b>Wpływy:</b> {{ $report->salary }}zł </p>
                     <p><b>Czynsz:</b> {{ $report->rent }}zł </p>
                     <p><b>Okres:</b> od {{ $report->start_date }} do {{ $report->end_date }} - {{ $report->human_duration }} 
                      <b>({{ $report->days_duration }} dni)</b> 
                     </p>
                  </div>
                  
                  <form action="{{ route('reports.destroy', ['report' => $report->id]) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="bg-red-500 text-white font-bold py-2 px-4 rounded float-right relative bottom-10">
                      Usuń raport
                    </button>
                  </form>

                  <a class="bg-blue-500 text-white font-bold py-2 px-4 rounded float-right relative bottom-10 mr-2" href="{{ route('reports.show', ['report' => $report->id]) }}">
                    Podgląd operacji
                  </a>
                </div>

              @if($loop->last)
              </div>
              @endif
           @empty
            <p>Nie dodano jeszcze żadnych raporów </p>
           @endforelse
        </div>
    </div>
</x-app-layout>
