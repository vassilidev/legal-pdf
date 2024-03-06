@extends('layouts.backoffice')

@section('content')
    <section class="container" style="max-width: 1400px !important;">
        <div class="row">
            <div class="col-lg">
                <div class="card my-4">
                    <div class="card-header">
                        Form builder
                    </div>
                    <div class="card-body">
                        <livewire:update-form :contract="$contract"/>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card my-4">
                    <div class="card-header">
                        Form Render
                    </div>
                    <div class="card-body" id="render"></div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Contract editor</div>
            <div class="card-body">
                <a class="btn btn-sm btn-primary mb-4" href="{{ route('survey.start', $contract) }}"
                   target="_blank">Public Form</a>
                <a class="btn btn-sm btn-primary mb-4" href="{{ route('pdf.contract', $contract) }}"
                   target="_blank">PDF Contract</a>
                <livewire:update-contract :contract="$contract"/>
            </div>
        </div>
    </section>
@endsection