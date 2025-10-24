@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">
    <div class="row justify-content-center">
        <div class="col-md-6 p-4 bg-light bg-opacity-50 rounded border border-1">
           <livewire:work.create-work />
        </div>
        
    </div>
</div>
@endsection
