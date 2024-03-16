<nav class="navbar navbar-expand-lg bg-white mb-4 p-2">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
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
        </div>
    </div>
</nav>