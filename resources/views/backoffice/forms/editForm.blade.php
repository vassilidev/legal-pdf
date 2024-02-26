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
    </section>
@endsection