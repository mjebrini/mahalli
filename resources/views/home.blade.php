@extends('layouts.app')

@section('content')
<section class="content">
    <!-- Info boxes -->
    <div class="row">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    </div>
    <!-- /.row -->
</section>
@endsection
