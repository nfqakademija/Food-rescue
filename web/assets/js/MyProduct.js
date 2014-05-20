var productListUrl = '/' + window.location.pathname.split('/')[1] + '/productslist/'
$.ajax({
    url: productListUrl,
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


$(".editable_tr").click(function() {
    var ID=$(this).attr('id');
    $("#pro_quantity_"+ID).hide();
    $("#pro_end_date_"+ID).hide();
    $("#pro_quantity_input_"+ID).show();
    $("#pro_end_date_input_"+ID).show();
} ).change(function() {
    var ID=$(this).attr('id');
    var quantity=$("#pro_quantity_input_"+ID).val();
    var endDate=$("#pro_end_date_input_"+ID).val();
    var dataString = 'id='+ ID +'&quantity='+quantity+'&endDate='+endDate;

    if (quantity.length > 0 && endDate.length > 0) {
        $.ajax( {
            type: "POST",
            url: '/' + window.location.pathname.split('/')[1] + '/myproductsedit/',
            data: dataString,
            cache: false,
            success: function(html)
            {
                $("#pro_quantity_"+ID).html(quantity);
                $("#pro_end_date_"+ID).html(endDate);
            }
        });
    }
});
// Edit input box click action
$(".edit-input").mouseup(function()
{
    return false
});

// Outside click action
$(document).mouseup(function()
{
    $(".edit-input").hide();
    $(".edit-text").show();
});
$(document).ready(function()
{
    $(".edit-input").hide();
    $(".edit-text").show();
});


function timestapmToDate(timestamp) {
    var date = new Date(timestamp * 1000);
    var year = date.getFullYear();
    var month = date.getMonth();
    var day = date.getDay();
    return year + '-' + month + '-' + day;
};
