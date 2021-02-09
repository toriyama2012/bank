function showBranch(path) {
    document.location.href = path;
}

function ensureDeleteBranch(idform) {
    if (confirm("Are you sure you want to delete this Branch? This will delete the Branch and its relations. Continue?")) {
        $('#'+idform).submit();
    }
}

function addBranch(path) {
    document.location.href = path;
}

function showCustomer(path) {
    document.location.href = path;
}

function ensureDeleteCustomer(idform) {
    if (confirm("Are you sure you want to delete this Customer? This will delete the Customer. Continue?")) {
        $('#'+idform).submit();
    }
}

function addCustomer(path) {
    document.location.href = path;
}

function validateTransferUsers(formId, ajaxRoute) {
    var _token = $("input[name='_token']").val();
    var amount = $("#amount").val();
    var customer_from_id = $("#customer_from_id").val();
    var customer_to_id = $("#customer_to_id").val();

    if (customer_from_id == customer_to_id) {
        alert('The transfer can not be made using the same user as origin and destinatary');
        return;
    }

    if (amount < 1) {
        alert('The transfer needs at least one dollar to be transfered for been processed');
        return;
    }

    var data = {_token: _token, amount: amount, customer_from_id: customer_from_id, customer_to_id: customer_to_id};

    $.ajax({
        url: ajaxRoute,
        type:'POST',
        data: data,
        success: function(data) {
            if (data.success.ok) {
                $('#'+formId).submit();
            }
        },
        error: function() {
            alert('There is something wrog in the transfer and it can not be made');
        }
    });
}