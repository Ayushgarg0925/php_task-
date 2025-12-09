$(document).ready(function() {
    var el = $('#client_name_invoice');
    el.on('keydown', function(event) {
        const key = event.key;
        if (key === "Backspace" || key === "Delete") {
            $('#client_hid_id_invoice').val('')
            $('#client_email_invoice').val('')
            $('#client_no_invoice').val('')
            $('#client_address_invoice').val('')
        }
    });
});


function remove_item(event,a) { 
    const key = event.key;
    if (key === "Backspace" || key === "Delete") {
        $(a).closest('.clone').find(".item_hid_id_name").val('')
        $(a).closest('.clone').find(".item_price_id").val('')
        $(a).closest('.clone').find(".item_quantity_id").val('')
        $(a).closest('.clone').find(".item_amount_id").val('')
    }
}

function click_invoice() { 
    $(".reset").click(); 
    $("#invoice_hidden_input").val(""); 
    $("#client_hid_id_invoice").val(""); 
    $(".item_hid_id_name").val(""); 
    $("#profile-tab").html("Add Invoice") 
    $(".clone:gt(0)").remove();


}

function show_invoice_id() {
    $.ajax({
        type: "POST",
        url: "php_invoice.php",
        data: {
            type: 'invoice_no'
        },
        dataType: 'json',
        success: function (data) {
            $("#invoice_no").val('SAN-'+data.data)
            invoice_date()
        }
    })
}
show_invoice_id()

function invoice_date() {
    let now = new Date();
    let today = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate();
    $("#invoice_date").val(today);
    $(".clone:gt(0)").remove();
}
invoice_date()

function client_name_input() {
    $('#client_name_invoice').autocomplete({
        source: function (request, response) {
            $.ajax({
                type: "POST",
                url: "php_invoice.php",
                data: {
                    type: 'show_client',
                    c_name: request.term
                },
                dataType: 'JSON',
                success: function (data) {
                    if (data.success && data.statuscode === 200) {
                        response($.map(data.data, function (item) {
                            return {
                                label: item.name,
                                value: item.name,
                                id: item.id,
                                email: item.email,
                                Mobile_number: item.mobile_no,
                                state: item.state,
                                city: item.cities
                            };
                        }));
                    } else {
                        console.error(data.message);
                    }
                },

            })
        }, minLength: 0,
        select: function (event, ui) {
            $("#client_name_invoice").val(ui.item.label);
            $("#client_hid_id_invoice").val(ui.item.id);
            $("#client_email_invoice").val(ui.item.email);
            $("#client_no_invoice").val(ui.item.Mobile_number);
            $("#client_address_invoice").val(ui.item.state + ', ' + ui.item.city);
        }
    })
}

function item_neme_fun() {
    $('.item_name_invoiec').autocomplete({
        source: function (request, response) {
            $.ajax({
                type: "POST",
                url: "php_invoice.php",
                data: {
                    type: 'show_item',
                    c_name: request.term
                },
                dataType: 'json',
                success: function (data) {
                    if (data.success && data.statuscode === 200) {
                        response($.map(data.data, function (item) {
                            return {
                                label: item.item_name,
                                value: item.item_name,
                                price: item.item_price,
                                s_no: item.s_no,
                            };
                        }));
                    } else {
                        console.error(data.message);
                    }
                },

            })
        }, minLength: 0,
        select: function (event, ui) {
            $(this).closest('.clone').find(".item_name_invoiec").val(ui.item.label);
            $(this).closest('.clone').find(".item_price_id").val(ui.item.price);
            $(this).closest('.clone').find(".item_hid_id_name").val(ui.item.s_no);
            $(this).closest('.clone').find(".item_quantity_id").val(1);

            var item_Q = $(this).closest('.clone').find('.item_quantity_id').val();

            var amount = parseFloat(ui.item.price) * parseFloat(item_Q);

            $(this).closest('.clone').find('.item_amount_id').val(amount);
            calc();

        }
    })
}

function calc(e) {
    $('.clone').each(function () {
        var item_Q = $(e).closest('.clone').find('.item_quantity_id').val();
        var item_P = $(e).closest('.clone').find('.item_price_id').val();
        var amount = parseFloat(item_P) * parseFloat(item_Q);
        $(e).closest('.clone').find('.item_amount_id').val(amount+'.00');
        if (item_Q==''){
            $(e).closest('.clone').find('.item_amount_id').val(0+'.00');
        }
    });
    var total_amount = 0;
    $('.item_amount_id').each(function () {
        total_amount += parseFloat($(this).val()) || 0;
    });
    $('#total_amount').val(total_amount+'.00');
   
}

function resetFormField() {

    var form = $('#invoice_form_id');
    var formInput = form.find('input,select,textarea')
    formInput.val('');
    $("#client_hid_id_invoice").val("")
    $("#item_hid_id_name").val("")
    $(".clone:gt(0)").remove();
}
function page() {
    resetFormField()
    show_invoice_id()
    $("#home-tab").addClass("active show")
    $("#home").addClass("active show")
    $("#profile-tab").removeClass("active")
    $("#profile-tab").html("Add Invoice")
    $("#profile").removeClass("active")
}

// function delete_btn_1(e){
//     $(e).parent().parent().remove();
//     calculation();
// }
// function deleteAll() {
//     $('.delete-btn:gt(0)').each(function() {
//         delete_btn_1(this);
//     });
// }

function invoice_insert() {
    var form = document.getElementById('invoice_form_id');
    var formData = new FormData(form);
    formData.append("type", 'insert_invoiceMaster');
    $.ajax({
        type: "POST",
        url: "php_invoice.php",
        dataType: 'JSON',
        contentType: false,
        processData: false,
        cache: false,
        data: formData,
        success: function (data) {
            if (data.statuscode == 200) {
                page()
                show_invoice_record()
                toastr.success(data.message);
            }
            else if (data.statuscode == 250) {
                toastr.warning(data.message);
            }
            else if (data.statuscode == 303) {
                toastr.warning(data.message);
            }
        },
        
        error: function (data) {
            toastr.error(data.message);
        }
    })
}

function sort_table(fn) {
    var field_name = document.getElementById("hid_field").value;
    if (field_name == 'asc') {
        document.getElementById('hid_field').value = 'desc';
    }
    else {
        document.getElementById('hid_field').value = 'asc';
    }
    show_invoice_record(1, fn);
}
function show_invoice_record(page = '1', column_name = 'id') {
    let recordsPerPage = $("#recordsPerPage").val();
    let s_invoice_no = $("#s_invoice_no").val();
    let s_i_name = $("#s_i_name").val();
    let s_i_email = $("#s_i_email").val();
    let s_mobile_no = $("#s_mobile_no").val();
    let s_totel_amount = $("#s_totel_amount").val();
    let s_i_date = $("#s_i_date").val();
    let sorting = $('#hid_field').val();
    $.ajax({
        type: "POST",
        url: "php_invoice.php",
        data: {
            type: 'invoice_record',
            page: page,
            recordsPerPage: recordsPerPage,
            s_invoice_no: s_invoice_no,
            s_i_name: s_i_name,
            s_i_email: s_i_email,
            s_mobile_no: s_mobile_no,
            s_totel_amount: s_totel_amount,
            s_i_date: s_i_date,

            column_name: column_name,
            sorting: sorting

        },
        dataType: 'json',
        success: function (data) {
            $("#show_invoice_data").html(data.table)
            $("#pagination").html(data.pagination)
        },
        error: function (data) {
            console.log(data)
        }
    })
}
show_invoice_record()

function edit_invoice_data(id) {
    $.ajax({
        type: "POST",
        url: "php_invoice.php",
        data: {
            id: id,
            type: 'edit_invoice'
        },
        dataType: 'json',
        success: function (data) {
            $("#profile-tab").addClass("active show")
            $("#profile-tab").html("Update Invoice")
            $("#profile").addClass("active show")
            $("#home-tab").removeClass("active")
            $("#home").removeClass("active")
            var a = data.data.result_master_list[0];
            var b = data.data.result_list;


            $("#invoice_hidden_input").val(a.id)
            $("#invoice_no").val('SAN-'+a.id)
            $("#invoice_date").val(a.created_date)
            $("#client_hid_id_invoice").val(a.client_id)
            $("#total_amount").val(a.total_amount+'.00')
            
            $("#client_name_invoice").val(b[0].client_name)
            $("#client_email_invoice").val(b[0].client_email)
            $("#client_no_invoice").val(b[0].client_no)
            $("#client_address_invoice").val(b[0].address)
            
            clone1 = $('.clone')
            
            $('.item_hid_id_name',clone1).val(b[0].item_id)
            $('.item_name_invoiec',clone1).val(b[0].item_name)
            $('.item_price_id',clone1).val(b[0].price+'.00')
            $('.item_quantity_id',clone1).val(b[0].quentity)
            $('.item_amount_id',clone1).val(b[0].total+'.00')
            $('#itemTable').append(clone1);
            for (var i = 1; i < b.length; i++) {
                var item_data = b[i];
                var new_row=clone1.clone()
                $('.item_hid_id_name',new_row).val(item_data.item_id)
                $('.item_name_invoiec',new_row).val(item_data.item_name)
                $('.item_price_id',new_row).val(item_data.price+'.00')
                $('.item_quantity_id',new_row).val(item_data.quentity)
                $('.item_amount_id',new_row).val(item_data.total+'.00')
                $('.delete_row', new_row).show();
                $('#itemTable').append(new_row);
            }

        }
    })
}

function create_invoice(id) {
    $.ajax({
        type: "POST",
        url: "php_invoice.php",
        data: {
            id: id,
            type: 'create_invoice'
        },
        cache: false,
        dataType: 'html',
        success: function (data) {      
            // var linkSource = 'data:application/pdf;base64,' + data;
            // var downloadLink = document.createElement("a");
            // var fileName = 'invoice.pdf';
            // downloadLink.target = "_blank";
            // downloadLink.href = linkSource;
            // downloadLink.download = fileName;
            // downloadLink.click();

            const decodedContent = atob(data);
           const uint8Array = new Uint8Array(decodedContent.length);
            for (let i = 0; i < decodedContent.length; i++) {
              uint8Array[i] = decodedContent.charCodeAt(i);
            }
        
            const blob = new Blob([uint8Array], { type: 'application/pdf' });
        
            const dataUrl = URL.createObjectURL(blob);
        
            const w = window.open('about:blank');
            
            setTimeout(function(){ 
            const tempf= w.document.body.appendChild(w.document.createElement('iframe'))
                   tempf.src = dataUrl;
                   tempf.style.width = '100%';
                   tempf.style.height = '100%';
            }, 0); 
        },
        error: function (data) {
            console.log("data.message")
        }
    })
}

function openEmailModal(id,name,email,date) {
    $('#emailModal').modal('show');
    $('#email_hid_inp').val(id);
    $('#recipientEmail').val(email);
    $('#date').val(date);
    $('#emailSubject').val('Invoice Details');
    $('#emailBody').val("Hi "+ name +", Please Find your invoice. Thanks for choosing us.");   
}

function closeEmailModal() {
    $('#emailModal').modal('hide');
}
function sendEmail() {
    $("#spinner_parent").addClass("overlay");
    $("#spinner_child").addClass("cv-spinner");
    var form = document.getElementById('emailForm');
    var formData = new FormData(form);
    formData.append("type", 'sendEmail');
    $.ajax({
        type: "POST",
        url: "php_invoice.php",
        dataType: 'JSON',
        contentType: false,
        processData: false,
        cache: false,
        data: formData,
        success: function (data) {
            if (data.success == true) {
                closeEmailModal()
                $("#spinner_parent").removeClass("overlay");
                $("#spinner_child").removeClass("cv-spinner");
                Swal.fire({
                    title: "Mail has been Send!",
                    // text: "You clicked the button!",
                    icon: "success"
                  });
            }
        },
        error: function (data) {
            console.log(data)
        }
    })
}
function reset_page(){
    show_invoice_record()
}




// if ($('.item_amount_id').val()==NaN){
//     $('.item_amount_id').val(0)
// }else{
// $('.item_amount_id').val(amount)
// }