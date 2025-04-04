@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Trang bị lỗi
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="error-page">
            <h2 class="headline text-red">500</h2>

            <div class="error-content">
                <h3><i class="fa fa-warning text-red"></i> Có một lỗi gì đó trong khi truy cập đến máy chủ.</h3>

                <p>
                    Vui lòng <a>quay lại trang chủ</a>
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
