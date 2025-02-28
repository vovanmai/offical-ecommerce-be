@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Trang không được tìm thấy
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-yellow"> 404</h2>

            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Trang không được tìm thấy!</h3>

                <p>
                    We could not find the page you were looking for.
                    Meanwhile, you may <a href="{{ route('admin.admins.list') }}">return to home</a> or try using the search form.
                </p>

                <form class="search-form">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search">
                        <div class="input-group-btn">
                            <button type="submit" name="submit" class="btn btn-warning btn-flat">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.input-group -->
                </form>
            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>
    <!-- /.content -->
@endsection
