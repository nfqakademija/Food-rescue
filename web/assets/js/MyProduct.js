$.ajax({
    url: "/app_dev.php/productslist/",
    contentType: "JSON",
    success: function(result) {
        $("#addProductForm_productName").autocomplete({
            source: result,
            select: function(event, ui) {
                $("#addProductForm_productName").val(ui.item.label);
                console.log("prodId " + ui.item.value);
                $("#addProductForm_productId").val(ui.item.value);
                $("#addMyProductUnits").val(ui.item.units);
                $("#addProductForm_endDate").val(timestapmToDate(ui.item.endDate))
                console.log(ui.item);
                console.log(timestapmToDate(ui.item.endDate))
                return false;
            },
            minLength: 2
        })
    }
});
$('#addProductForm_endDate').datepicker({
    monthNames: ['Sausis', 'Vasaris', 'Kovas', 'Balandis', 'Gegužė', 'Birželis', 'Liepa', 'Rugpjūtis', 'Rugsėjis', 'Spalis', 'Lapkritis', 'Gruodis'],
    dayNamesMin: ['Pr', 'An', 'Tr', 'Kt', 'Pn', 'Š', 'S']
});
$('#myProductsTable').editableTableWidget();

function timestapmToDate(timestamp) {
    var date = new Date(timestamp * 1000);
    var year = date.getFullYear();
    var month = date.getMonth();
    var day = date.getDay();
    return year + '-' + month + '-' + day;
};
