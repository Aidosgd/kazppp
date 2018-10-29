var handleRoleUpdate = function (response) {
    $("#rolesListPlaceholder").find(response.response.itemIdClass).replaceWith(response.response.roleHtml);
    showNotify('Успех', 'Роль изменена', 'success');
};


var updateAdminList = function (response) {
    $("#adminsList").prepend(response.response.adminItem);
    showNotify('Успех', 'Админ добавлен', 'success');
};

var updateRow = function (response) {
    $(response.response.tableId).find(response.response.rowId).fadeOut(function () {
        $(this).replaceWith(response.response.rowItem).fadeIn();
        showNotify('Успех', 'Изменено', 'success');
    });
};