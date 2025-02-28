@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small></small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('admin.dashboard.order')
        @include('admin.dashboard.user')
    </section>
    <!-- /.content -->
@endsection
@push('script')

@endpush
