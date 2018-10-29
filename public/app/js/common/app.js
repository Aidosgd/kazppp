$(document.body).on('submit', 'form', function (e) {
    if ($(this).hasClass('ajax-submit')) {
        e.preventDefault();
        var blockType = $(this).data('block-type');
        var blockElem = $(this).data('block-element');
        return submitForm($(this), blockElem, blockType);
    }
});

$(document.body).on('click', '.ajax-get', function (e) {
    e.preventDefault();

    var url = $(this).attr('href');

    $.ajax({
        method: 'get',
        url: url,
        dataType: 'json',
        beforeSend: function () {

        },
        success: function (data) {

            if (data.response.functions) {

                $.each(data.response.functions, function (index, value) {
                    window[value](data);
                });
            }
        },
        error: function (data) {

        },
        complete: function () {

        }
    });
});

var submitForm = function (form, blockElement, blockType) {
    var url = form.attr('action');
    var method = form.attr('method');
    var formData = new FormData(form[0]);
    var formId = form.attr('id');
    var blockElem = $(blockElement);

    $.ajax({
        method: method,
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
        beforeSend: function () {
            resetValidationErrors();
            mask(blockElem, blockType);
        },
        success: function (data) {

            if (data.response.redirect_url) {
                location.replace(data.response.redirect_url);
            }

            if (data.response.functions) {

                $.each(data.response.functions, function (index, value) {
                    window[value](data);
                });
            }

            if (data.response.message) {
                showMessage(
                    data.response.message.header,
                    data.response.message.message,
                    data.response.message.type
                )
            }
        },
        error: function (data) {
            //console.log(data.status);
            unmask(blockElem, blockType);
            if (data.status == 422) {
                validationFail(data.responseJSON, formId);
            }
            switch (data.status) {
                case 403:
                    // console.log(data.responseJSON.error.action);
                    if (data.responseJSON.error.action == 'message') {
                        showMessage(
                            data.responseJSON.error.message_data.header,
                            data.responseJSON.error.message_data.message,
                            data.responseJSON.error.message_data.type
                        )
                    }
                    break;
            }
        },
        complete: function () {
            unmask(blockElem, blockType);
        }
    });
};


$(document.body).on('click', '.role-item', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');

    $.ajax({
        method: 'get',
        url: url,
        beforeSend: function () {

        },
        success: function (data) {
            $("#roleFormPlaceholder").html(data);
        },
        error: function (data) {

        },
        complete: function () {

        }
    });
});

$(document.body).on('click', '.category-item', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');

    $.ajax({
        method: 'get',
        url: url,
        beforeSend: function () {

        },
        success: function (data) {
            $("#categoryFormPlaceholder").html(data);
        },
        error: function (data) {

        },
        complete: function () {

        }
    });
});

var closeModal = function (response) {
    $(response.response.targetModal).modal('hide');
};

var updateTableRow = function (response) {
    $(response.response.tableId).find(response.response.rowId).fadeOut(function () {
        $(this).replaceWith(response.response.adminItem).fadeIn();
        showNotify('Успех', 'Админ изменен', 'success');
    });
};

var updateRolesList = function (response) {
    $("#rolesListPlaceholder").prepend(response.response.roleItem);
    toEmptyField = document.getElementById('name');
    toEmptyField.value = '';
};

var updateCategoriesList = function (response) {
    $("#categoriesListPlaceholder").prepend(response.response.categoryItem);
    toEmptyField = document.getElementById('name');
    toEmptyField.value = '';
};

var updateSelectOption = function (response) {

    var options = response.response.categoryOptions;

    $('#parent_id').find('option').remove();
    $('#parent_id')
        .append($("<option></option>")
            .attr("value",'')
            .text('Корневая'));
    $.each(options, function(key, value) {
        $('#parent_id')
            .append($("<option></option>")
                .attr("value",key)
                .text(value));
    });
};

var initScroll = function () {
    mApp.initComponents();
};


var mask = function (elem, blockType) {

    blockType = (blockType) ? blockType : 'element';

    if (blockType == 'page') {
        mApp.blockPage({
            overlayColor: '#000000',
            type: 'loader',
            state: 'success',
            // message: 'Please wait...'
        });
        return;
    }
    if (!elem.hasClass('busy')) {
        elem.addClass('busy');
    }
};

var showMessage = function (header, message, type) {
    swal(header, message, type);
};

var showNotify = function (title, message, type) {

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    switch (type) {
        case 'success':
            toastr.success(message, title);
            break;
        case 'info':
            toastr.info(message, title);
            break;
        case 'warning':
            toastr.warning(message, title);
            break;
        case 'error':
            toastr.error(message, title);
            break;
    }
};


var unmask = function (elem, blockType) {
    if (blockType == 'page') {
        mApp.unblockPage();
        return;
    }

    if (elem.hasClass('busy')) {
        elem.removeClass('busy');
    }
};

var validationFail = function (errors, formId) {
    for (input in errors.errors) {
        console.log(errors.errors[input]);

        var formGroup = $("#" + formId + " *[id='" + input + "']").closest('.form-group');
        // console.log(formGroup);
        formGroup.addClass('has-error');

        for (message in errors.errors[input]) {
            formGroup.find('.help-block').append(' ' + errors.errors[input][message]);
        }
    }
};

var resetValidationErrors = function () {
    $('.form-group').find('.help-block').html('');
    $('.form-group').removeClass('has-error');
};

var loadContentInTable = function (url, tableId) {

    if (tableId && url) {

        var table = $("#" + tableId);
        mask(table);
        $.getJSON(url, function (data) {

            table.find('tbody').html(data.tableData);
            $(".pagination_placeholder").html(data.pagination)
            scrollToTop();

        }).always(function () {
            unmask(table);
        });
    } else {
        $(".table-has-content").each(function () {

            if ($(this).attr('id')) {
                var tableId = $(this).attr('id');

                if ($("#" + tableId).length) {
                    var url = (url) ? url : $("#" + tableId).data('url');
                    var table = $("#" + tableId);

                    if (url) {
                        mask(table);
                        $.get(url, function (data) {
                            table.find('tbody').html(data.tableData);
                            $(".pagination_placeholder").html(data.pagination);
                            scrollToTop();
                        }).always(function () {
                            unmask(table);
                        });
                    } else {
                        console.log('Url in table with id ' + tableId + ' is not defined');
                    }
                }
            }
        });
    }
};

var scrollToTop = function () {
    $("html, body").animate({scrollTop: 0}, "fast");
};

$(document).ready(function () {

    loadContentInTable();
});

$(document.body).on('click', '.show-filter', function (e) {
    e.preventDefault();
    $(".filter").toggle('fast');
});

$(document.body).on('submit', '.filter-form', function (e) {
    e.preventDefault();
    var url = $(this).attr('action') + '?' + $(this).serialize();
    var table = $(this).data('table');
    loadContentInTable(url, table);
});

$(document.body).on('click', '.pagination li a', function (e) {
    e.preventDefault();

    var url = $(this).attr('href');
    var tableId = $(this).closest('.pagination_placeholder').data('table-id');

    return loadContentInTable(url, tableId);

});


// works with modals
$(document.body).on('click', '.has-modal-content', function (e) {
    e.preventDefault();
    var modal = $($(this).data('modal'));
    var url = $(this).data('modal-content-url');
    var blockElement = modal.find('.modal-body');

    $.ajax({
        method: 'get',
        url: url,
        dataType: 'json',

        beforeSend: function () {
            modal.find('.modal-content .modal-title').html('Загрузка');
            modal.find('.modal-content .modal-body').html('');
            mask(blockElement);
            modal.modal('show');
        },
        success: function (data) {

            modal.find('.modal-content .modal-title').html(data.response.modalTitle);
            modal.find('.modal-content .modal-body').html(data.response.modalContent);

            if (data.response.functions) {

                $.each(data.response.functions, function (index, value) {
                    window[value](data);
                });
            }
        },
        error: function (data) {
            console.log(data.status);
            unmask(blockElement);
        },
        complete: function () {
            unmask(blockElement);
        }
    });
});
var handleCategoryUpdate = function (response) {
    $("#categoriesListPlaceholder").find(response.response.itemIdClass).replaceWith(response.response.categoryHtml);
    showNotify('Успех', 'Категория изменена', 'success');
};

$(document.body).on('click', '.add-look', function (e) {
    e.preventDefault();
    // $("#addLookForm").find('.look-file-input').trigger('click');
    $(document.body).find('.look-file-input').trigger('click');
});

$(document.body).on('change', '.look-file-input', function (e) {
    e.preventDefault();
    $("#addLookForm").submit();

});

function resetFormFields(data) {
    var input = $(data.response.idForm).clearForm();
}

var initProgress = function () {
    if ($("#progressBar").length)
    {
        $("#progressBar").fadeIn();
        $("#progressBar").find('.progress-bar').css('width', '0%');

    }
}

var updateBlock = function (data) {
    $(data.response.blockId).html(data.response.blockData);

};

var closeModal = function (data) {
    $(data.response.targetModal).modal('hide');
};

var showMessage = function (header, message, type) {
    swal(header, message, type);
};

$(document.body).on('click', '.delete-item', function (e) {
    e.preventDefault();
    let url = $(this).attr('href');
    var title = $(this).data('confirm-title');
    var message = $(this).data('confirm-message');
    swal({
        title: title,
        text: message,
        icon: "warning",
        buttons: true,
        dangerMode: true,
        buttons: ["Отмена!", "Да, удалить!"],
    })
        .then((willDelete) => {
        if (willDelete) {
            removeItemOfElement(url);
        }
    }
)
});

function loadContentInTableInit(data){
    loadContentInTable(data.response.loadUrl, data.response.tableId);
}

function removeAttachmentForm(data) {
    showNotify('Успех', data.response.success, 'success');
    let form = $(data.response.attachmentFormId);
    form.remove();
}

var updateList = function (data) {
    $(data.response.tableId).prepend(data.response.tr);

    if ($(".no-data-placeholder").length)
    {
        $(".no-data-placeholder").fadeOut(function () {
            $(this).remove();
        })
    }
    showNotify('Успех', data.response.success, 'success');

};

var destroyProgress = function () {
    if ($("#progressBar").length)
    {
        $("#progressBar").fadeOut(function () {
            $("#progressBar").find('.progress-bar').css('width', '0%');
        });

    }
    editor.addCommand("showFileManager", {
        exec: function(edt) {
            showFiles(edt);

        }
    });
};

function loadMedia(data) {
    let mediaBlock = $(data.response.mediaBlock);
    mediaBlock.empty();
    mediaBlock.prepend(data.response.media);
}

$(document.body).on('click', '.update-item', function (e) {
    e.preventDefault();
    let url = $(this).attr('href');
    $.get(url, function (data) {
        loadMedia(data)
    });
});

var updateModalBody = function (data) {
    console.log(data.response.modal);
    $(data.response.modal).find('.modal-body').html(data.response.modalContent);
};


function resetFormFields(data) {
    $(data.response.idForm).clearForm();
}

var updateSelectOption = function (response) {
    var options = response.response.options;
    $('#parent_id').find('option').remove();
    $('#parent_id')
        .append($("<option></option>")
            .attr("value",'')
            .text('Корневая'));
    $.each(options, function(key, value) {
        $('#parent_id')
            .append($("<option></option>")
                .attr("value",key)
                .text(value));
    });
};


$(document.body).on('click', '.category-edit', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');

    $.ajax({
        method: 'get',
        url: url,
        dataType: 'json',

        beforeSend: function () {

        },
        success: function (data) {
            $("#categoryFormPlaceholder").html(data.response.formData);
        },
        error: function (data) {

        },
        complete: function () {

        }
    });

});



function removeItemOfElement(url) {
    $.get(url, function (data) {
        showNotify('Успех', data.response.success, 'success');
        $(data.response.table).find(data.response.tr).remove();
    });
}

$(document.body).on('click', '.edit-item', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    simpleAjax(url);
});

$(document.body).on('click', '.up-menu-item', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    simpleAjax(url);
});

$(document.body).on('click', '.down-menu-item', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    simpleAjax(url);
});

$(document.body).on('click', '.delete-menu-item', function (e) {

    e.preventDefault();
    var url = $(this).attr('href');

    swal({
        title: 'Вы уверены, что хотите удалить?',
        text: '',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Удалить!',
        cancelButtonText: 'Отмена'
    }).then((result) => {
        if (result.value) {
        simpleAjax(url);
    } else if (result.dismiss === swal.DismissReason.cancel) {

    }
})
});

function simpleAjax(url) {
    $.get(url, function (data) {
        console.log(data);
        if (data.response.redirect_url) {
            location.replace(data.response.redirect_url);
        }
        if (data.response.functions) {
            $.each(data.response.functions, function (index, value) {
                window[value](data);
            });
        }
    });
}

var updateProgressBar = function (percent) {
    if ($("#progressBar").length)
    {
        $("#progressBar").find('.progress-bar').css('width', percent + '%');
    }
}

var prependTableRow = function (data) {
    $(data.response.tableId).find('tbody').prepend(data.response.item);
}

var updateTableRow = function (data) {
    $(data.response.tableId).find(data.response.rowId).fadeOut(function () {
        $(this).replaceWith(data.response.item).fadeIn();
        showNotify('Успех', 'Страница изменена', 'success');
    });
};




    $(document.body).on('click', '.handle-click', function (e) {
        e.preventDefault();
        let type = $(this).data('type');

        switch (type)
        {
            case 'triggerHiddenInput':
                let input = $("#" + $(this).data('input-id'));
                triggerHiddenInput(input);
                break;

            case 'ajax-get':
                var url = $(this).attr('href');
                ajaxGet(url);
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
                var needUrlFollow = $(this).data('follow-url');

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
                            ajaxGet(url)
                        }

                    }
                })
                break;

            case 'modal':
                var url = $(this).attr('href');
                var modal = $($(this).data('modal'));
                modal.modal('show');
                loadContentInModal(url, modal)
                break;
        }
    });


$(document.body).on('click', '.openFileBrowser', function (e) {
    e.preventDefault();
    var input = $(this).data('input-id');
    $(input).val('');
    $(input).trigger('click');
});

$(document.body).on('change', '#hiddenInputFile', function (e) {
    $(this).closest('form').submit();
});

$(document.body).on('click','.non-scrollable', function (e){
    e.preventDefault();
    return false;
});

