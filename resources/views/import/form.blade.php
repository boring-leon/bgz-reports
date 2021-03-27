<form method="POST" action="{{ route('import.store') }}" enctype='multipart/form-data'>
    @csrf

    <div class="mt-4">
        <x-label for="name" value="Nazwa raportu (opcjonalnie)" />
        <x-input id="name" name="name" type="text" placeholder="Nazwa raportu" value="{{ old('name') }}" />
    </div>

    @error('name')
    <div class="font-medium text-red-600">
        {{ $message }}
    </div>
    @enderror

    <div class="mt-4">
        <x-label for="rent" value="Czynsz" />
        <x-input id="rent" name="rent" type="number" step="0.01" placeholder="Czynsz" required value="{{ old('rent') }}" />
    </div>

    @error('rent')
    <div class="font-medium text-red-600">
        {{ $message }}
    </div>
    @enderror

    <div class="mt-4">
        <x-label for="report" value="Plik z raportem" />
        <x-input accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                    id="report"   
                    type="file"
                    name="report"
                    required
        />
    </div>

    @error('report')
        <div class="font-medium text-red-600">
            {{ $message }}
        </div>
    @enderror

    <div class="m4-4">
        <div class="justify-end mt-4">
            <x-button>
                {{ __('Prześlij') }}
            </x-button>
        </div>
    </div>
</form>