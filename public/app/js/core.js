let settings = {
    blockUi: {
        type: 'page',
        'element': ''
    },

    progressBarSelector: "#progressBar"
};

let handleClick = function () {

    $(document.body).on('click', '.handle-click', function (e) {
        e.preventDefault();

        var type = $(this).data('type');

        switch (type) {
            case 'triggerHiddenInput':
                let input = $("#" + $(this).data('input-id'));
                triggerHiddenInput(input);
                break;

            case 'ajax-get':
                var url = $(this).attr('href');
                var blockElem = $(this).data('block-element');
                ajaxGet(url, blockElem);
                break;

            case 'delete-table-row':

                var url = $(this).attr('href');
                var title = $(this).data('confirm-title');
                var message = $(this).data('confirm-message');
                var cancelBtnText = $(this).data('cancel-text');
                var confirmBtnText = $(this).data('confirm-text');
                swal({
                    title: title,
                    text: message,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: cancelBtnText,
                    confirmButtonText: confirmBtnText
                }).then((result) => {
                    if (result.value) {
                        ajaxGet(url)
                    }
                })
                break;

            case 'confirm':
                var url = $(this).attr('href');
                var title = $(this).data('confirm-title');
                var message = $(this).data('confirm-message');
                var cancelBtnText = $(this).data('cancel-text');
                var confirmBtnText = $(this).data('confirm-text');
                var blockElem = $(this).data('block-element');

                let needUrlFollow = $(this).data('follow-url');
                swal({
                    title: title,
                    text: message,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: cancelBtnText,
                    confirmButtonText: confirmBtnText
                }).then((result) => {
                    if (result.value) {
                        if (needUrlFollow)
                        {
                            ajaxGet(url, blockElem)
                        }
                    }
                });

                break;

            case 'modal':
                var url = $(this).attr('href');
                let modal = $($(this).data('modal'));

                if (!$($(this).data('modal')).hasClass('custom-modal')) {
                    modal.modal('show');
                } else {
                    modal.show();
                }

                loadContentInModal(url, modal)
                break;
        }
    });
}

let loadContentInModal = function (url, modal) {
    modal.find('.modal-title').html('...');
    modal.find('.modal-body').html('...');

    ajaxGet(url, modal.find('.modal-body'));
}

let updateModalContent = function (modal, modalTitle, modalBody) {
    $(modal).find('.modal-title').html(modalTitle);
    $(modal).find('.modal-body').html(modalBody);
    $(modal).find('.modal-body').removeClass('busy');
}

let triggerHiddenInput = function (input) {
    input.val('');
    input.trigger('click');

}

let handlePaginationClick = function () {
    $(document.body).on('click', '.pagination .page-link', function (e) {
        e.preventDefault()
        let url = $(this).attr('href');
        let table = $("#" + $(this).closest('.pagination_placeholder').data('table-id'));
        loadContentInTable(url, table);
    });
}

let handleLoadContentInTable = function () {

    $.each($('.ajax-content'), function () {

        let url = $(this).attr('data-ajax-content-url');

        loadContentInTable(url, $(this));

    })

}

let loadContentInTable = function (url, table) {

    $.ajax({
        method: 'get',
        url: url,
        dataType: 'json',

        beforeSend: function () {
            blockUI();
        },

        success: function (response) {
            table.find('tbody').html(response.tableData);

            if (response.pagination) {
                table.closest('.box').find('.pagination_placeholder').html(response.pagination);
            }

        },

        error: function (response) {
            console.log(response);
        },
        complete: function () {
            unblockUi();
        }

    });
}

let ajaxGet = function (url, blockElem) {
    $.ajax({
        method: 'get',
        url: url,
        dataType: 'json',

        beforeSend: function () {
            if (blockElem) {
                $(blockElem).addClass('busy');
            } else {

                blockUI();
            }

        },

        success: function (response) {

            switch (response.type) {
                case 'update-table-row':
                    updateTableRow($(response.table), $(response.row), response.content)
                    break;

                case 'delete-table-row':
                    deleteTableRow($(response.table), $(response.row));
                    break;

                case 'delete-block':
                    $(response.block).fadeOut(function () {
                        $(this).remove();
                    });
                    break;

                case 'updateModal':
                    updateModalContent(response.modal, response.modalTitle, response.modalContent);
                    break;

                case 'reloadTable':
                    loadContentInTable(response.tableContentUrl, $(response.tableId))
                    break;
            }

            if (response.functions) {
                $.each(response.functions, function (index, value) {
                    runFunction(value, response);
                });
            }

        },

        error: function (response) {

        },
        complete: function () {
            if (blockElem) {
                $(blockElem).removeClass('busy');
            } else {

                unblockUi();
            }

        }

    });
}

let ajaxPost = function (form) {

    let url = form.attr('action');
    let formId = form.attr('id');
    let formData = new FormData(form[0]);


    settings.blockUi.type = form.data('ui-block-type');
    settings.blockUi.element = form.data('ui-block-element');
    let progressBar = form.data('progress-bar');

    $.ajax({
        method: 'post',
        url: url,
        data: formData,
        dataType: 'json',
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        xhr: function () {
            let xhr = new window.XMLHttpRequest();
            //Upload progress
            xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    let percentComplete = evt.loaded / evt.total * 100;
                    updateProgress(progressBar, percentComplete);
                }
            }, false);

            return xhr;
        },

        beforeSend: function () {

            blockUI();
            validationReset();
            initProgress();
        },

        success: function (response) {
            switch (response.type) {
                case 'redirect':
                    location.replace(response.redirect_url);
                    break;

                case 'prepend-table-row':
                    prependTableData($(response.table), response.content);
                    break;

                case 'update-table-row':
                    updateTableRow($(response.table), $(response.row), response.content);
                    break;

                case 'reloadTable':
                    loadContentInTable(response.tableContentUrl, $(response.tableId))
                    break;

                case 'updateModal':
                    updateModalContent(response.modal, response.modalTitle, response.modalContent);
                    break;

                case 'updateBlock':
                    $(response.blockForUpdate).replaceWith(response.blockForUpdateContent);
                    break;

                case 'notify':
                    showNotify(response.notify_message, response.notify_type)
                    break;
            }

            if (response.functions) {
                $.each(response.functions, function (index, value) {
                    runFunction(value, response);
                });
            }
        },

        error: function (response) {

            if (response.status == 419) {
                location.refresh();
            }

            if (response.status == 422) {
                validationFail(response.responseJSON, formId);
            }

            if (response.responseJSON && response.responseJSON.type) {
                if (response.responseJSON.type == 'alert') {
                    showAlert(response.responseJSON.header, response.responseJSON.message, response.responseJSON.alert_type)
                }
            }

            unblockUi();

        },
        complete: function () {

            unblockUi();
            resetProgress(progressBar);
        }
    });
}

let initProgress = function () {
    $(settings.progressBarSelector).find('.progress-bar').css('width', '0%');
    $(settings.progressBarSelector).find('.progress-bar').css('opacity', 1);

}

let updateProgress = function (progressBar, percent) {

    $(progressBar).find('.progress-bar').css('width', percent + '%');
}

let resetProgress = function (progressBar) {
    $(progressBar).find('.progress-bar').fadeOut();
    setTimeout(function () {
        $(progressBar).find('.progress-bar').css('width', 0);
        $(progressBar).find('.progress-bar').fadeIn();
    }, 2000);

}

let validationFail = function (response, formId) {
    for (input in response.errors) {

        let formGroup = $("#" + formId + " *[id='" + input + "']").closest('.form-group');

        formGroup.addClass('has-error');

        for (message in response.errors[input]) {
            formGroup.find('.help-block').append(' ' + response.errors[input][message]);
        }
    }
}

let validationReset = function () {
    $('.form-group').find('.help-block').html('');
    $('.form-group').removeClass('has-error');
}

let showAlert = function (header, message, type) {
    swal({
        type: type,
        title: header,
        text: message,

    })
}

let showNotify = function (message, type) {

    $.notify({
        // options
        message: message
    }, {
        // settings
        type: type,
        newest_on_top: true,
        placement: {
            from: "top",
            align: "right"
        },

        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },

    });
}

let prependTableData = function (table, data) {
    table.find('tbody').prepend(data);
}

let updateTableRow = function (table, row, data) {

    table.find(row).fadeOut(function () {
        $(this).replaceWith(data);
        $(this).fadeIn();
    });
}

let deleteTableRow = function (table, row) {
    table.find(row).fadeOut(function () {
        $(this).remove();

    });
}

let runFunction = function (functionName, response) {
    switch (functionName) {
        case 'closeModal':
            closeModal(response);
            break;

        case 'initEditor':
            initEditor();
            break;
        case 'initCrop':
            initCrop();
            break;
        case 'replaceImg':
            replaceImg(response);

    }
}



let closeModal = function (data) {
    if ($(data.modal_for_close).hasClass('custom-modal')) {
        $(data.modal_for_close).hide();
    } else {
        $(data.modal_for_close).modal('hide');
    }

}

let blockUI = function () {

    switch (settings.blockUi.type) {
        case 'page':
            blockPage();
            break;

        case 'element':
            $(settings.blockUi.element).addClass('busy');
            break;
    }
}

let unblockUi = function () {
    switch (settings.blockUi.type) {
        case 'page':
            $('body').unblock();
            break;

        case 'element':
            $(settings.blockUi.element).removeClass('busy');
            break;
    }

}

let blockPage = function (options) {

    let el = $('body');

    options = $.extend(true, {
        opacity: 0.1,
        overlayColor: '#000000',
        state: 'primary',
        type: 'loader',
        centerX: true,
        centerY: true,
        message: 'Processing...',
        shadow: true,
        width: 'auto'
    }, options);

    let params = {
        message: '<div style="border: 1px solid #D2D6DE; border-radius: 5px; background-color: #fff; padding: 5px; color: #777777;">Processing <i class="fa fa-spinner fa-spin"></i></div>',
        centerY: options.centerY,
        centerX: options.centerX,
        css: {
            top: '30%',
            left: '50%',
            border: '0',
            padding: '0',
            backgroundColor: 'none',
            width: options.width
        },
        overlayCSS: {
            backgroundColor: options.overlayColor,
            opacity: options.opacity,
            cursor: 'wait'
        },

        onUnblock: function () {
            if (el) {
                el.css('position', '');
                el.css('zoom', '');
            }
        }
    };

    params.css.top = '50%';
    $.blockUI(params);
}

let initDatePicker = function () {
    $('.dp').datepicker({
        autoclose: true,
        format: 'dd.mm.yyyy'
    })
}

let initEditor = function () {
    $('.editor').each(function () {
        editor = CKEDITOR.replace($(this).attr('id'), {
            height: 500
        });

        editor.ui.addButton('ImageManager', {
            label: "Менеджер изображений",
            command: 'showImageManager',
            toolbar: 'insert',
            icon: '/app/js/vendors/ckeditor/image_file.png'
        });

        editor.addCommand("showImageManager", {
            exec: function (edt) {
                showObjects(edt);
            }
        });


    });
};



let initCrop = function () {
    myCropper();
};



$(document).ready(function () {

    $('body').on('submit', 'form', function (e) {

        if ($(this).hasClass('ajax')) {
            e.preventDefault();

            ajaxPost($(this));
        }

        if ($(this).hasClass('filter-form')) {

            e.preventDefault();
            let url = $(this).attr('action') + '?' + $(this).serialize();
            let table = $(this).data('table');
            loadContentInTable(url, $(table));

        }
    });

    $('body').on('change', '#fileInput', function (e) {
        $(this).closest('form').submit();
    });


    handleLoadContentInTable();
    handlePaginationClick();
    handleClick();
    initDatePicker();
    initEditor();
});




