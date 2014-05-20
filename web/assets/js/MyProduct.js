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
                $("#addMyProductUnits").html(ui.item.units);
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
    dayNamesMin: ['Pr', 'An', 'Tr', 'Kt', 'Pn', 'Š', 'S'],
    dateFormat: 'yy/mm/dd'
});

$(".edit-endDate").datepicker({
    monthNames: ['Sausis', 'Vasaris', 'Kovas', 'Balandis', 'Gegužė', 'Birželis', 'Liepa', 'Rugpjūtis', 'Rugsėjis', 'Spalis', 'Lapkritis', 'Gruodis'],
    dayNamesMin: ['Pr', 'An', 'Tr', 'Kt', 'Pn', 'Š', 'S'],
    dateFormat: 'yy/mm/dd'
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
            success: function(_result)
            {

                if(_result.length < 1) {
                    $('#edit_table_errors').html('');
                    $("#pro_quantity_"+ID).html(quantity);
                    $("#pro_end_date_"+ID).html(endDate);
                } else {
                    var result = jQuery.parseJSON(_result);
                    var errorString = "";
                    result.forEach(function(err) {
                       errorString = errorString + " " + err;
                    });
                    $('#edit_table_errors').html(errorString);
                }
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
$('.ui-icon-trash').click(function() {
   var ID = $(this).attr('id').split('_')[1];
   var name= $('#pro_name_' + ID).text();
    console.log(ID);
   if (confirm('Ar tikrai norite ištrinti produktą ' + name)) {
        var url = '/' + window.location.pathname.split('/')[1] + '/myproductsdelete/';
       $.ajax({
          url: url,
          type: 'POST',
          data:'id=' + ID,
          success: function(response) {
              if (response == 'deleted'){
                  $('#'+ ID).hide();
              }
          }
       });
   }
});

function timestapmToDate(timestamp) {
    var date = new Date(timestamp * 1000);
    var year = date.getFullYear();
    var month = date.getMonth();
    var day = date.getDay();
    return year + '/' + month + '/' + day;
};
