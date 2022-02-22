$('#datetimepicker1').datetimepicker({
  format: "DD-MM-YYYY HH:mm",
});

$('input[type=radio][name="trans[type]"]').change(function() {
    let toWallet = $("#toWallet");
    switch(this.value){
        case "0":
            showToWallet(false);
        break;
        case "1":
            showToWallet(false);
        break;
        case "2":
            showToWallet(true);
        break;
    }
});

$('input[type=checkbox][name="trans[withFee]"]').change(function() {
    let isChecked = $(this).is(':checked');
    let feeAmount = $('#trans_fee');

    if(isChecked){
        $(feeAmount).removeAttr('disabled');
    } else {
        $(feeAmount).attr('disabled','disabled');
    }
});

function showToWallet(toShow){
    let toWallet = $("#toWallet");
    let fromWallet = $("#fromWallet");
    let withFee = $('#withFeeDiv');
    let feeAmount = $('#feeAmount');

    if(toShow){
        toWallet.show();
        withFee.show();
        feeAmount.show();
        fromWallet.removeClass("col-lg-12").addClass("col-lg-6");
    } else {
        toWallet.hide();
        withFee.hide();
        feeAmount.hide();
        fromWallet.removeClass("col-lg-6").addClass("col-lg-12");
    }
}
