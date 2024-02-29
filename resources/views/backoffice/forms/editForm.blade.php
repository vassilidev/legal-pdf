@extends('layouts.backoffice')

@section('content')
    <section class="container">
        <div class="card my-4">
            <div class="card-header">
                Form builder
            </div>
            <div class="card-body">
                <livewire:update-form :form="$form"/>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Form Render
            </div>
            <div class="card-body" id="render"></div>
        </div>
    </section>
@endsection