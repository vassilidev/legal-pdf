@extends('layouts.backoffice')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Form builder
                    </div>
                    <div class="card-body">
                        <livewire:update-form :form="$form"/>
                    </div>
                </div>
            </div>
            <div class="col-4">
               <div class="card">
                   <div class="card-header">
                       Form Render
                   </div>
                   <div class="card-body" id="render"></div>
               </div>
            </div>
        </div>
    </section>
@endsection