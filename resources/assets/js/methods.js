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