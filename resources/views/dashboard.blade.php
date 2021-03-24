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

           <h1 class="text-3xl md:text-4xl font-medium mb-2 mt-20"> Raporty </h1>
           
            @forelse(auth()->user()->reports as $report)
            <div class="p-20 bg-blue-100">
                <div class="bg-white p-6 rounded-lg shadow-lg mb-5 {{$report->balance >= 0 ? 'border-green-200' : 'border-red-200' }} border-2" id="report_{{$report->id}}">
                  <h2 class="text-2xl font-bold mb-2 text-gray-800">Raport #{{ $report->id }}</h2>
                  @if($report->balance >=0)
                    <b class="text-green-700">Bilans: {{ $report->balance }}zł</b>
                  @else
                  <b class="text-red-700">Bilans {{ $report->balance }}</b>
                  @endif
                  <hr>
                  <div class="mt-3">
                     <p>Wydatki: {{ $report->expenses }}zł </p>
                     <p>Wpływy: {{ $report->salary }}zł </p>
                     <p>Czynsz: {{ $report->rent }}zł </p>
                     <p>Okres: {{ $report->start_date }} - {{ $report->start_date }} - {{ $report->duration }} </p>
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
              </div>
           @empty
            <p>Nie dodano jeszcze żadnych raporów </p>
           @endforelse
        </div>
    </div>
</x-app-layout>
