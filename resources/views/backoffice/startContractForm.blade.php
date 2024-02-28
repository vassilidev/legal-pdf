@extends('layouts.backoffice')

@section('content')
    <div class="container">
        <livewire:display-contract-form :contract="$contract"/>
    </div>
@endsection
