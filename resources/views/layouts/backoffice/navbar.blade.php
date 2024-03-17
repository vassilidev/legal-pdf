<nav class="navbar navbar-expand-lg bg-white mb-4 p-2">
    <div class="container-fluid">
        <a class="navbar-brand ms-3" href="#">
            <img src="https://wizardx-app.legalplace.fr/static/media/logo-lp.5d53c4af.svg" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                @role('Super Admin')
                <a class="nav-link" href="{{ App\Filament\Resources\ContractResource::getUrl(); }}">Contracts</a>
                @endrole
            </div>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <form method="POST" id="localeForm" action="{{ route('update.lang') }}">
                        @csrf

                        <select name="locale" class="form-select" id="localeSelect">
                            @foreach(config('filament-translation-manager.locales') as $locale)
                                <option value="{{ $locale }}" @selected(app()->getLocale() == $locale)>
                                    {{ Str::upper($locale) }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

@push('js')
    <script>
        document.getElementById('localeSelect').addEventListener('change', function () {
            document.getElementById('localeForm').submit();
        });
    </script>
@endpush
