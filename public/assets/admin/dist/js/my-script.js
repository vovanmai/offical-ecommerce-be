toastr.options.preventDuplicates = true;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.reset-form-admin').click(function () {
    let uri = window.location.toString();
    if (uri.indexOf("?") > 0) {
        let clean_uri = uri.substring(0, uri.indexOf("?"));
        window.history.replaceState({}, document.title, clean_uri);
    }
})

function resetSearchForm (uri) {
    window.location = uri
}

$("#form-search-admin").validate({
    rules: {
        name: {
            maxlength: 25,
        },
        email: {
            maxlength: 25,
        }
    },
    messages:
        {
            name: {
                maxlength: "Tên không được lớn hơn 25 ký tự."
            },
            email: {
                maxlength: "Email không được quá 25 ký tự."
            }
        }
});

// Define rules for validation
$.validator.addMethod("extension", function(value, element, param)
{
    const extensions = param.split('|')

    return !value || extensions.includes(value.split('.').pop())
});

$.validator.addMethod("in", function(value, element, param)
{
    const values = param.split(',')
    return !value || values.includes(value)
});

$.validator.addMethod("required_with", function(value, element, param)
{
    const otherField = $(`input[name="${param}"]`).val().trim()

    return otherField == '' || value != '';
}, 'Không được rỗng.');

$.validator.addMethod("equal_to", function(value, element, param)
{
    const otherField = $(`input[name="${param}"]`).val().trim()

    return otherField == '' || value == '' || otherField == value;
});

$.validator.addMethod('filesize', function (value, element, param)
{
    return !element.files[0] || element.files[0].size <= param
}, 'Kích thước tệp không được lớn hơn {0} bytes.');

$.extend($.validator.messages, {
    required: "Không được rỗng.",
    maxlength: "Không được vượt quá {0} ký tự.",
    range: "Vui lòng nhập trong khoảng từ {0} đến {1}.",
    min: "Không được nhỏ hơn {0}.",
    max: "Không đươc vượt quá {0}.",
    digits: "Vui lòng nhập số nguyên.",
});

function removeImageOnServer(storeName) {
    $.ajax({
        type: 'DELETE',
        data: {
            store_name: storeName
        },
        dataType: "JSON",
        url: "/admin/delete-file?",
        success: function(response)
        {
            console.log("Remove file image success")
        },
        error: function(error) {
            toastr.error("Có lỗi trong khi truy cập đến máy chủ.", 'Lỗi');
        }
    });
}

function updateQueryString(object)
{
    const url = new URL(window.location);
    Object.entries(object).forEach(([key, value]) => {
        url.searchParams.set(key, value);
    })
    window.history.pushState({}, '', url);
}

function getQuery(){
    var url = document.location.search;
    if (url === '') return []
    var qs = url.substring(url.indexOf('?') + 1).split('&');
    for(var i = 0, result = {}; i < qs.length; i++){
        qs[i] = qs[i].split('=');
        result[qs[i][0]] = decodeURIComponent(qs[i][1]);
    }
    return result;
}
$('input[type="checkbox"].flat-red').iCheck({
    checkboxClass: 'icheckbox_flat-green',
    radioClass: 'iradio_flat-green'
});


function copyLink(element) {
    // Get the text field
    const copyText = $(element).attr('href')
    // Copy the text inside the text field
    navigator.clipboard.writeText(copyText);
    toastr.success("Sao chép thành công", 'Thành công')
}

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

$(".category input:checkbox").on('click', function() {
    // in the handler, 'this' refers to the box clicked on
    var $box = $(this);
    if ($box.is(":checked")) {
        // the name of the box is retrieved using the .attr() method
        // as it is assumed and expected to be immutable
        var group = "input:checkbox[name='" + $box.attr("name") + "']";
        // the checked state of the group/box on the other hand will change
        // and the current value is retrieved using .prop() method
        $(group).prop("checked", false);
        $box.prop("checked", true);
    } else {
        $box.prop("checked", false);
    }
});


$(".file-into-ckeditor input").on('change', function(e) {
    $('.file-into-ckeditor .loading').show()
    ///// Your code
    const file = $(this).prop('files')[0]

    const size = (file.size / (1024*1024)).toFixed(2);

    if (size > 100) {
        toastr.warning("", `Tệp của bạn tải lên khá lớn ${size} Mb. Vui lòng chờ.`)
    }

    var formData = new FormData();

    formData.append('file', file);

    $.ajax({
        data: formData,
        type: 'POST',
        url: "/admin/upload-into-ckeditor",
        processData: false,
        contentType: false,
        cache:false,
        success: function(response)
        {
            $('.file-into-ckeditor .loading').hide()
            const selection = editor.model.document.selection;
            const cursorPosition = selection.getFirstPosition();
            editor.model.change(writer => {
                writer.insertText(response.data.url, cursorPosition);
            });
        },
        error: function(error) {
            $('.file-into-ckeditor .loading').hide()
            toastr.error("Máy chủ bị lỗi.", 'Lỗi')
        }
    });
});
