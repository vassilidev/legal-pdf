@extends('layouts.backoffice')

@section('content')
    <div class="container">
        <form action="{{ route('admin-css.update') }}" method="POST">
            @csrf

            @session('success')
                <div class="alert alert-success">
                    {{ $value }}
                </div>
            @endsession

           <div>
               <label for="content">Content</label>
               <textarea class="form-control" name="content" id="content" cols="30" rows="10">{{ $content }}</textarea>
           </div>

            <button type="submit" class="btn btn-success">Save admin.css</button>
        </form>
    </div>
@endsection