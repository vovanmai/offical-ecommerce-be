@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Thiết lập website</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form id="create-website-setting-form" class="form-horizontal">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-cog"></i> Thiết lập website</h3>
                            <div class="box-tools pull-right">
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div>
                                <div class="col-md-5">
                                    <div class="form-group" style="margin-bottom: 30px">
                                        <label>
                                            Tên công ty<span class="required"></span>
                                        </label>
                                        <div class="field-container">
                                            <input type="text" name="company_name" class="form-control" value="{{ $setting->company_name ?? null }}">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 30px">
                                        <label>
                                            Mã số thuế công ty<span class="required"></span>
                                        </label>
                                        <div class="field-container">
                                            <input type="text" name="company_tax_code" class="form-control" value="{{ $setting->company_tax_code ?? null }}">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 30px">
                                        <label>
                                            Hotline<span class="required"></span>
                                        </label>
                                        <div class="field-container">
                                            <input type="text" name="hotline" class="form-control" value="{{ $setting->hotline ?? null }}">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 30px">
                                        <label>
                                            Tên hotline<span class="required"></span>
                                        </label>
                                        <div class="field-container">
                                            <input type="text" name="hotline_name" class="form-control" value="{{ $setting->hotline_name ?? null }}">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 30px">
                                        <label>
                                            Email công ty<span class="required"></span>
                                        </label>
                                        <div class="field-container">
                                            <input type="text" name="company_email" class="form-control" value="{{ $setting->company_email ?? null }}">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 30px">
                                        <label>
                                            Địa chỉ công ty<span class="required"></span>
                                        </label>
                                        <div class="field-container">
                                            <textarea class="form-control" name="company_address" style="width: 100%" rows="5">{{ $setting->company_address ?? null }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group @error('company_website_domain') has-error @enderror" style="margin-bottom: 30px">
                                        <label>
                                            Địa chỉ tên miền website công ty<span class="required"></span>
                                        </label>
                                        <div class="field-container">
                                            <input type="text" name="company_website_domain" class="form-control" value="{{ $setting->company_website_domain ?? null }}">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 30px">
                                        <label>
                                            Đường dẫn Fanpage Facebook<span class="required"></span>
                                        </label>
                                        <div class="field-container">
                                            <input type="text" name="link_fan_page_facebook" class="form-control" value="{{ $setting->link_fan_page_facebook ?? null }}">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 30px">
                                        <label>
                                            Lượt truy cập trang chủ<span class="required"></span>
                                        </label>
                                        <div class="field-container">
                                            <input type="text" disabled name="total_view" class="form-control" value="{{ number_format($setting->total_view ?? 0) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 col-md-offset-1">
                                    <div class="form-group" style="margin-bottom: 30px">
                                        <label>
                                            Header banner<span class="required"></span>
                                        </label>
                                        <div class="field-container">
                                            <div id="dropzone-header-banner" class="dropzone">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 30px">
                                        <label>
                                            Chiều rộng header banner (đơn vị px hoặc %)<span class="required"></span>
                                        </label>
                                        <div class="field-container">
                                            <input type="text" name="header_banner_width" class="form-control" value="{{ $setting->header_banner_width ?? null }}">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 30px">
                                        <label>
                                            Chiều cao header banner (đơn vị px hoặc %)<span class="required"></span>
                                        </label>
                                        <div class="field-container">
                                            <input type="text" name="header_banner_height" class="form-control" value="{{ $setting->header_banner_height ?? null }}">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 30px">
                                        <label>
                                            FB fan page script<span class="required"></span>
                                        </label>
                                        <div class="field-container">
                                            <textarea class="form-control" name="fb_fan_page_script" style="width: 100%" rows="5">{{ $setting->fb_fan_page_script ?? null }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 30px">
                                        <label>
                                             Zalo fan page chat script<span class="required"></span>
                                        </label>
                                        <div class="field-container">
                                            <textarea class="form-control" name="zalo_fan_page_chat_script" style="width: 100%" rows="5">{{ $setting->zalo_fan_page_chat_script ?? null }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 30px">
                                        <label>
                                            Goole map địa chỉ công ty<span class="required"></span>
                                        </label>
                                        <div class="field-container">
                                            <textarea class="form-control" name="google_map_address_company" style="width: 100%" rows="5">{{ $setting->google_map_address_company ?? null }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer text-center">
                            <div class="text-center">
                                <span class="button-create">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-check"></i>Cập nhật</button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>

    </section>
    <!-- /.content -->
@endsection

@push('script')
    <script>
        let headerBanner = null
        let removedHeaderBanner = false
        $(function() {
            $("#create-website-setting-form").validate({
                rules: {
                    company_name: {
                        maxlength: 255,
                    },
                    company_tax_code: {
                        maxlength: 20,
                    },
                    hotline: {
                        maxlength: 20,
                    },
                    hotline_name: {
                        maxlength: 20,
                    },
                    company_email: {
                        maxlength: 255,
                    },
                    company_address: {
                        maxlength: 255,
                    },
                    company_website_domain: {
                        maxlength: 255,
                    },
                    link_fan_page_facebook: {
                        maxlength: 255,
                    },
                },
                highlight: function(element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element).closest('.form-group').removeClass('has-error');
                },
                messages: {
                    company_name: {
                        maxlength: "Không được quá 255 ký tự",
                    },
                    company_tax_code: {
                        maxlength: "Không được quá 20 ký tự",
                    },
                    hotline: {
                        maxlength: "Không được quá 20 ký tự",
                    },
                    hotline_name: {
                        maxlength: "Không được quá 20 ký tự",
                    },
                    company_email: {
                        maxlength: "Không được quá 255 ký tự",
                    },
                },
                errorPlacement: function($error, $element) {
                    $error.appendTo($element.closest(".form-group").find('.field-container'));
                },
                invalidHandler: function(form, validator) {
                    toastr.error('Dữ liệu nhập không hợp lệ.', 'Lỗi');
                },
                submitHandler: function(form) {
                    const data = {
                        company_name: $("input[name='company_name']").val(),
                        company_tax_code: $("input[name='company_tax_code']").val(),
                        hotline: $("input[name='hotline']").val(),
                        hotline_name: $("input[name='hotline_name']").val(),
                        company_email: $("input[name='company_email']").val(),
                        header_banner: headerBanner,
                        is_remove_header_banner: removedHeaderBanner ? 1 : 0,
                        company_address: $("textarea[name='company_address']").val(),
                        company_website_domain: $("input[name='company_website_domain']").val(),
                        link_fan_page_facebook: $("input[name='link_fan_page_facebook']").val(),
                        header_banner_width: $("input[name='header_banner_width']").val(),
                        header_banner_height: $("input[name='header_banner_height']").val(),
                        fb_fan_page_script: $("textarea[name='fb_fan_page_script']").val(),
                        zalo_fan_page_chat_script: $("textarea[name='zalo_fan_page_chat_script']").val(),
                        google_map_address_company: $("textarea[name='google_map_address_company']").val(),
                    }
                    $.ajax({
                        data: data,
                        type: 'POST',
                        url: "{{ route('admin.website_setting.update') }}",
                        cache: false,
                        success: function(response)
                        {
                            toastr.success('Thiết lập thành công.', 'Thành công')
                        },
                        error: function(error) {
                            if (error.status === 422) {
                                toastr.error(error.responseJSON.errors[0], 'Lỗi')
                            } else {
                                toastr.error("Máy chủ bị lỗi.", 'Lỗi')
                            }
                        }
                    });
                }
            });
        });


        Dropzone.autoDiscover = false;

        $("#dropzone-header-banner").dropzone(            {
            maxFiles: 1,
            renameFile: function (file) {
                return file.name;
            },
            acceptedFiles: ".jpg,.jpeg,.jpg,.png,.gif,.webp,.svg",
            dictDefaultMessage: "Bạn có thể kéo ảnh hoặc click để chọn",
            dictRemoveFile: 'Xóa',
            addRemoveLinks: true,
            uploadMultiple: false,
            autoProcessQueue: true,
            timeout: 60000,
            url: '/admin/upload-file',
            params: {
                key: "header_banner_"
            },
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (file, response) {
                headerBanner = response.data
            },
            error: function (file, response) {
                return false;
            },
            accept: function(file, done) {
                done()
            },
            init : function() {
                var myDropZone = this;
                myDropZone.on('maxfilesexceeded', function(file) {
                    toastr.error("Header banner tối đa là 1 ảnh.", 'Lỗi');
                    myDropZone.removeFile(file);
                });

                let header_banner = {!! isset($setting['header_banner']) ? json_encode($setting['header_banner']) : "''" !!};

                if(header_banner) {
                    let callback = null; // Optional callback when it's done
                    let crossOrigin = null; // Added to the `img` tag for crossOrigin handling
                    let resizeThumbnail = true; // Tells Dropzone whether it should resize the image first
                    myDropZone.displayExistingFile(header_banner, header_banner.url, callback, crossOrigin, resizeThumbnail);
                    myDropZone.options.maxFiles = 0
                }
            },
            removedfile: function (file) {
                let myDropzone = this;
                file.previewElement.remove()
                if(typeof(file.upload) == 'object') {
                    if(file.accepted) {
                        removeImageOnServer(JSON.parse(file.xhr.response).data.store_name)
                    }
                } else {
                    myDropzone.options.maxFiles = 1
                    removedHeaderBanner = true
                }
                headerBanner = null
            },
        });
    </script>
@endpush
