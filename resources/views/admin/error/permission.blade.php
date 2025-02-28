@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Bạn không có quyền truy cập
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="error-page">
            <h2 class="headline text-red">403</h2>

            <div class="error-content">
                <h3><i class="fa fa-warning text-red"></i> Bạn không có quyền truy cập. Vui lòng liên hệ đến Admin của hệ thống.</h3>
                <p>
                    Vui lòng <a href="{{ route('admin.post.list') }}">quay lại trang chủ</a>
                </p>

{{--                <form class="search-form">--}}
{{--                    <div class="input-group">--}}
{{--                        <input type="text" name="search" class="form-control" placeholder="Search">--}}

{{--                        <div class="input-group-btn">--}}
{{--                            <button type="submit" name="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i>--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- /.input-group -->--}}
{{--                </form>--}}
            </div>
        </div>
        <!-- /.error-page -->

    </section>
    <!-- /.content -->
@endsection
