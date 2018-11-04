function hideErrorDiv(fieldID) {
    if ($("#" + fieldID).val()) {
        $("#" + fieldID).siblings(".alert-error").hide();
    }
}

$('input,select').click(function(){
    $(this).siblings(".alert-error").hide('slow');
});