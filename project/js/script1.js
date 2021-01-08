$("#searchitem").on('keypress', function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13' && $('#searchitem').val() != ""){
        event.preventDefault();
        $('#searchmodal').modal('show');
    }
});
$("table#table tbody").on('click', 'button', function(){
    $(this).closest('tr').remove();
    $('#totalamount').html((parseFloat($('#totalamount').html()) - $(this).closest('tr').find('#total').html()).toFixed(2));
    $('#subtotal').val((parseFloat($('#subtotal').val()) - $(this).closest('tr').find('#total').html()).toFixed(2));
});
$("table#table tbody").on('blur', 'td', function(){
    var total = $(this).closest('tr').find('#total');
    $('#totalamount').html(parseFloat($('#totalamount').html()) - total.html());
    var disc = parseFloat($(this).closest('tr').find('#disc').html());
    var price = parseFloat($(this).closest('tr').find('#price').html()) * parseFloat($(this).closest('tr').find('#qty').html());
    var discprice = (disc == 0)?price : price - (price * (disc / 100));
    $(this).closest('tr').find(total).html(discprice.toFixed(2));
    discprice = (parseFloat($('#totalamount').html()) + discprice).toFixed(2);
    $('#totalamount').html(discprice);
    $('#subtotal').val($('#totalamount').html());
});
$("table#modaltable tbody").on('blur', 'td', function(){
    if($(this).closest('tr').find('#qty').html() == 0){
        $(this).closest('tr').css("background-color", "#fff");
        $(this).closest('tr').find('#minus').hide();
        $(this).closest('tr').find('#plus').show();
    }else{
        $(this).closest('tr').css("background-color", "#bdd4ff");
        $(this).closest('tr').find('#plus').hide();
        $(this).closest('tr').find('#minus').removeAttr('hidden');
        $(this).closest('tr').find('#minus').show();
    }
});
$('table#modaltable tbody').on('click', 'button', function(){
    if($(this).closest('tr').find('#qty').html() == 0){
        $(this).closest('tr').css("background-color", "#bdd4ff");
        $(this).closest('tr').find('#qty').html(1);
        $(this).closest('tr').find('#plus').hide();
        $(this).closest('tr').find('#minus').removeAttr('hidden');
        $(this).closest('tr').find('#minus').show();
    }else if($(this).closest('tr').find('#qty').html() != 0){
        $(this).closest('tr').css("background-color", "#fff");
        $(this).closest('tr').find('#qty').html(0);
        $(this).closest('tr').find('#minus').hide();
        $(this).closest('tr').find('#plus').show();
    }
});
// $('#reset').on
$('#idsearch').on('click', function(){
    $('#id_trans').removeAttr('readonly');
});
$('#totaldisc').on('change', function(){
        var total = $('#subtotal').val() * ($('#totaldisc').val()/100);
        $('#totaldiscpr').val(total.toFixed(2));
        var disctotal = $('#subtotal').val() - total;
        $('#totalamount').html(disctotal.toFixed(2));
});
$('table#modaltable tbody').on('blur', 'td', function(){
    var total = $(this).closest('tr').find('#total');
    var disc = parseFloat($(this).closest('tr').find('#disc').html());
    var price = parseFloat($(this).closest('tr').find('#price').html()) * parseFloat($(this).closest('tr').find('#qty').html());
    var discprice = (disc == 0)?price : price - (price * (disc / 100));
    $(this).closest('tr').find(total).html(discprice.toFixed(2));
});




























// ======================TO DO========================
// *PHP ARRAY OR DATABASE TRANSACTION
// ^ON LOAD OF PURCHASE PAGE, TRANS ROW IS CREATED IN DB
// RESET ALL ITEMS IN TRANS
// *AJAX ID TRANS SEARCH
// *AJAX ITEM SEARCH
// *AJAX ITEM SEARCH RESULTS
// *DATABASE CRUD
// *PROCEED TRANSACTION PAGE
