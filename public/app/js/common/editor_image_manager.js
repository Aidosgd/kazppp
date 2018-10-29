
var editor;
let url = $('meta[name="editor-objects-url"]').attr('content');
let filesUrl = $('meta[name="editor-files-url"]').attr('content');

let showObjects = function (edt) {
    editor = edt;
    loadData(url)
}

let showFiles = function (edt) {
    editor = edt;
    loadData(filesUrl);
}

let loadData = function (url) {
    $("#editorModal").find('.modal-body').html('');
    $("#editorModal").find('.modal-title').html('Загрузка');

    $.ajax({
        method: 'get',
        url: url,
        beforeSend: function () {
            $("#editorModal").modal('show');
        },
        success: function (response) {
            $("#editorModal").find('.modal-title').html(response.modalTitle);
            $("#editorModal").find('.modal-body').html(response.modalContent);
        },
        error: function () {

        },
        complete: function () {

        }
    });
}

$('body').on('click', '.insert-file', function(e) {
    e.preventDefault();
    let url = $(this).attr('href');

    $.ajax({
        method: 'get',
        url: url,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        beforeSend: function () {

        },
        success: function (response) {
            editor.insertHtml(response.injection,'unfiltered_html');
            $('#editorModal').modal('hide');
        },

        error: function (data) {

        },

        complete: function () {

        }
    });


});

$('body').on('click', '.close-custom-modal', function(e) {
    e.preventDefault();
    $(this).closest('.custom-modal').fadeOut();

});

