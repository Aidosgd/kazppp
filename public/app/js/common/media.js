$(document.body).on('click', '.add-photo', function (e) {
    e.preventDefault();
    $(document.body).find('.form-input-image').trigger('click');
});

$(document.body).on('change', '.form-input-image', function (e) {
    e.preventDefault();
    $("#formImage").submit();
});

$(document.body).on('submit', '#formImage', function (e) {
    e.preventDefault();
    var url = $(this).attr('action');
    var formData = new FormData($(this)[0]);
    var method = $(this).attr('method');
    let blockSelector = ".www";

    $.ajax({
        method: method,
        url: url,
        data: formData,
        dataType: 'json',
        async: true,
        cache: false,
        contentType: false,
        processData: false,

        beforeSend: function () {
            // mask(blockSelector)
        },
        success: function (data) {

            // console.log(data);
            $(".media-block").empty();
            $(".media-block").prepend(data.response.media);
            // updateTableRow(data.table_row)
            initCrop();
        },
        error: function (response) {
            if (response.status == 419) {
                location.reload();
            }

            if (response.status == 422) {
                alert('Один или несколько файлов невалидны');
            }
        },
        complete: function () {
            // unmask(blockSelector)
            $("#addLookForm").find('.look-file-input').val('');
        }

    });
});

$(document.body).on('click', '.delete-media-data', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    var title = $(this).data('title');
    var self = $(this);
    swal({
        title: 'Вы уверены, что хотите удалить?',
        text: '',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Удалить!',
        cancelButtonText: 'Отмена'
    }).then((result) => {
        if (result.value) {
        self.parent().parent().fadeOut();
        $.get(url, function (data) {
        });
    } else if (result.dismiss === swal.DismissReason.cancel) {

    }
})
});


$(document.body).on('click', '.make-main-image', function (e) {

    e.preventDefault();
    var url = $(this).attr('href');
    var title = $(this).data('title');
    var self = $(this);
    swal({
        title: 'Сделать главной?',
        text: '',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Подтвердить',
        cancelButtonText: 'Отмена'
    }).then((result) => {
        if (result.value) {
        $.get(url, function (data) {
            $(".media-block").find('.make-main-image').show();
            $(self).fadeOut();
        });

    } else if (result.dismiss === swal.DismissReason.cancel) {

    }
})
});