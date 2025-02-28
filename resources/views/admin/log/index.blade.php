@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Server log</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-fw fa-list-ul"></i>Log server</h3>
                        <div class="box-tools pull-right">
                            <a href="{{ route('admin.log.index') }}" type="button" class="btn btn-success"><i class="fa fa fa-refresh"></i>
                                Làm mới
                            </a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div style="margin-bottom: 25px">Size: <span>{{ round(($size ?? 0) / 1024 / 1024, 2) }} Mb</span></div>
                        <pre style="height: 700px; overflow: scroll">{{ $content ?? '' }}</pre>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>

    </section>
    <!-- /.content -->
@endsection
