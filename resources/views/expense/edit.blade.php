@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <livewire:expense.edit-expense :expense="$expense" />
    </div>
</div>
@endsection
