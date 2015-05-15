$(document).ready(function () {
    bindDeleteRowHandler();
});

function yesNoCellStyle(value, row, index) {
    var styles = {
        'Yes': 'success',
        'No': 'danger'
    }

    console.log(styles[value]);

    return {
        classes: styles[value]
    };
}

function bindDeleteRowHandler() {
    $('.deleteRow').bind('ajax:success', function (data, status, xhr) {
        this.parentNode.parentElement.remove();
    });

    $('.deleteRow').bind('ajax:error', function (data, status, xhr) {
        console.log(status)
        sweetAlert('删除失败', 'Error: ' + status.status, 'error')
    });
}