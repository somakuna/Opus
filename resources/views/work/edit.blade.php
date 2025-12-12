@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">
    <div class="row justify-content-center">
        <div class="col-md-6 p-4 bg-light bg-opacity-50">
            @livewire('work.edit-work', ['work' => $work])
        </div>
        
    </div>
</div>
@endsection
