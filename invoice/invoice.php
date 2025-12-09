<!DOCTYPE html>
<html lang="en">
<?php include '../common/head.php'; ?>


<body class="g-sidenav-show  bg-gray-100">
    <?php include '../common/aside.php'; ?>
    <main class="main-content position-relative mt-1 border-radius-lg">
        <!-- Navbar -->
        <?php include '../common/navbar.php'; ?>
        
        
        <!-- ==================================================== invoice master start ====================================================== -->
        
        <!-- ==============================email box start ========================================== -->
        <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel"
        aria-hidden="true">
        
        <?php include '../common/spinner.php'; ?>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="emailModalLabel">Send Email</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="closeEmailModal()" style="border: none;background: transparent;">
                            <span aria-hidden="true" style="font-size: larger;">&times;</span>
                        </button>
                    </div>
                    <form id="emailForm" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipientEmail">Recipient Email</label>
                                <input type="hidden" name="email_hid_inp" id="email_hid_inp">
                                <input type="hidden" name="date" id="date">
                                <input type="email" class="form-control" id="recipientEmail" name="recipientEmail" maxlength="40"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="emailSubject">Subject</label>
                                <input type="text" class="form-control" id="emailSubject" name="emailSubject" maxlength="150" required>
                            </div>
                            <div class="form-group">
                                <label for="emailBody">Email Body</label>
                                <textarea class="form-control" id="emailBody" name="emailBody" rows="4" maxlength="300"
                                    required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn border shadow" data-dismiss="modal"
                                onclick="closeEmailModal()">Close</button>
                            <button type="button" class="btn btn shadow" style="background-color:#ff7600;color:white;"
                                onclick="sendEmail();">Send Email</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- ==============================email box end ========================================== -->
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" style="color:black;" data-bs-toggle="tab"
                        data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"
                        onclick="click_invoice();">All
                        Invoice</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" style="color:black;" data-bs-toggle="tab"
                        data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                        aria-selected="false">Add Invoice</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <!-- all invoice start  -->
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <form method="POST"
                        class="container mt-4 shadow border d-flex align-items-center justify-content-start"
                        enctype="multipart/form-data">
                        <table class="w-100">
                            <tr>
                                <td>
                                    <div class="search">
                                        <label for="s_invoice_no">Invoice No</label><span
                                            id="s_invoice_noErr"></span><br>
                                        <input type="text" class="form-control" name="s_invoice_no" id="s_invoice_no" value="SAN-">
                                    </div>
                                </td>
                                <td>
                                    <div class="search">
                                        <label for="s_i_name">Client Name</label><span id="s_i_nameErr"></span><br>
                                        <input type="text" class="form-control" name="s_i_name" id="s_i_name">
                                    </div>
                                </td>
                                <td>
                                    <div class="search">
                                        <label for="s_i_email">Email </label><span></span><br>
                                        <input type="email" class="form-control" name="s_i_email" id="s_i_email">
                                    </div>
                                </td>
                                <td>
                                    <div class="search">
                                        <label for="s_i_date">Date </label><span></span><br>
                                        <input type="date" class="form-control" name="s_i_date" id="s_i_date">
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <div class="search">
                                        <label for="s_mobile_no">Mobile Number</label><span></span><br>
                                        <input type="text" class="form-control" name="s_mobile_no" id="s_mobile_no"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>
                                </td>
                                <td>
                                    <div class="search">
                                        <label for="s_totel_amount">Total Amount</label><span></span><br>
                                        <input type="text" class="form-control text_right" name="s_totel_amount" id="s_totel_amount"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>
                                </td>
                                <td class="pt-4" style="">
                                    <label></label><span></span><br>
                                       <button type="button" name="submit" class="btn btn search_btn_style"
                                        style="background-color:#ff7600;color:white;"
                                        onclick="show_invoice_record()">Search</button>

                                        <!-- <button type="reset" id="reset" class="btn btn border search_btn_style"
                                    onmouseout="reset_page();" style="margin-left: 10px;">Reset</button> -->
                                    <button type="submit" class="btn btn border search_btn_style">Reset</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <br>
                    <br>
                    <span>
                        <label for="recordsPerPage">Records per Page:</label>
                        <select id="recordsPerPage" class="border" name="recordsPerPage"
                            onchange="show_invoice_record()">
                            <option value='3'>3</option>
                            <option value='6'>6</option>
                            <option value='9'>9</option>
                        </select>
                    </span>
                    <table class="container shadow border table table-striped">
                        <thead>
                            <tr class="">
                                <th class="table_h" onclick="sort_table('id')">Invoice Id</th>
                                <th class="table_h" onclick="sort_table('id')">Invoice No</th>
                                <th class="table_h" onclick="sort_table('created_date')">Date</th>
                                <th class="table_h" onclick="sort_table('name')">Client Name</th>
                                <th class="table_h" onclick="sort_table('email')">Email</th>
                                <th class="table_h">Mobile Number</th>
                                <th class="table_h td-no mx-5" onclick="sort_table('total_amount')">Total Amount</th>
                                <th class="table_h">Action</th>
                                <th class="table_h">PDF</th>
                                <th class="table_h">Gmail</th>
                            </tr>
                        </thead>
                        <tbody id="show_invoice_data">
                        </tbody>
                    </table>
                    <div id="pagination" style="display: flex; align-items: center; justify-content: center; gap: 5px;">
                    </div>
                    <input type="hidden" name="hid_field" id="hid_field" value="asc">
                </div>
                <!-- all invoice end  -->
                <!-- add invoice start -->
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <form method="POST"
                        class="container mt-4 shadow border d-flex align-items-center justify-content-center"
                        enctype="multipart/form-data" id="invoice_form_id">
                        <table class="w-100">
                            <tr>
                                <td class="w-25">
                                    <div class="invoice_no add_style">
                                        <input type="hidden" name="invoice_hidden_input" id="invoice_hidden_input"
                                            class="invoice_hidden_input">
                                        <label for="invoice_no">Invoice No</label><span id="invoice_noErr"></span><br>
                                        <input type="text" class="form-control" name="invoice_no" id="invoice_no"
                                            readonly>
                                    </div>
                                </td>
                                <td class="w-25">
                                    <div class="invoice_date add_style">
                                        <label for="invoice_date">Invoice Date</label><span
                                            id="invoice_dateErr"></span><br>
                                        <input type="date" class="form-control" name="invoice_date" id="invoice_date">
                                    </div>
                                </td>
                                <td class="w-25"></td>
                                <td class="w-25"></td>
                            </tr>
                            <tr>
                                <td class="w-25">
                                    <div class="client_name_invoice add_style">
                                        <input type="hidden" name="client_hid_id_invoice" id="client_hid_id_invoice" class="client_hid_id_invoice">
                                        <label for="client_name_invoice">Client Name</label><span class="err"> *
                                            &nbsp;</span> <br>
                                        <input type="text" class="form-control" name="client_name_invoice"
                                            id="client_name_invoice" oninput="client_name_input()" maxlength="30">
                                    </div>
                                </td>
                                <td class="w-25">
                                    <div class="client_email_invoice add_style">
                                        <label for="client_email_invoice">Email</label><span
                                            id="client_email_invoiceErr"></span><br>
                                        <input type="text" class="form-control" name="client_email_invoice"
                                            id="client_email_invoice" readonly>
                                    </div>
                                </td>
                                <td class="w-25">
                                    <div class="client_no_invoice add_style">
                                        <label for="client_no_invoice">Phone no.</label><span
                                            id="client_no_invoiceErr"></span><br>
                                        <input type="text" class="form-control" name="client_no_invoice"
                                            id="client_no_invoice" readonly>
                                    </div>
                                </td>
                                <td class="w-25">
                                    <div class="client_address_invoice add_style">
                                        <label for="client_address_invoice">Address</label><span
                                            id="client_address_invoiceErr"></span><br>
                                        <input type="text" class="form-control" name="client_address_invoice"
                                            id="client_address_invoice" readonly>
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="4">
                                    <div class="my-4 border rounded">
                                        <table class="container table table-striped " id="itemTable">
                                            <thead>
                                                <tr class="">
                                                    <th class="table_h">Item Name<span class="err"> * &nbsp;</span></th>
                                                    <th class="table_h">Item Price</th>
                                                    <th class="table_h">Item Quantity</th>
                                                    <th class="table_h">Amount</th>
                                                    <th class="table_h">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="invoice_add_item">
                                                <tr class="add_list clone">
                                                    <td class="table_h">
                                                        <input type="hidden" name="item_hid_id_name[]"
                                                            id="item_hid_id_name" class="item_hid_id_name">
                                                        <input type="text" class="form-control item_name_invoiec"
                                                            name="item_name_invoiec[]" oninput="item_neme_fun(this)" onkeydown="remove_item(event,this)" maxlength="30">
                                                    </td>
                                                    <td class="table_h"><input type="text"
                                                            class="form-control text_right  item_price_id" name="item_price_id[]" oninput="calc(this);this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                                                            readonly></td>
                                                    <td class="table_h"><input type="number" min="1" 
                                                            class="form-control text_right item_quantity_id"
                                                            name="item_quantity_id[]" oninput="calc(this);this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"></td>
                                                    <td class="table_h"><input type="text"
                                                            class="form-control text_right item_amount_id" name="item_amount_id[]" oninput="calc(this);this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                                                            readonly></td>
                                                    <td class="table_h"
                                                        style="display: flex;align-items: center;justify-content: center;height: 65px;">
                                                        <button type='button'
                                                            class="delete_row  bg-transparent border-0" onclick="deleterow(this)">
                                                            <i class='fa-regular fa-trash-can' style='color:red;'>
                                                            </i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="">
                                    <button type="button" id="" onclick="addMore()" class="btn btn border addMore">Add
                                        More</button>
                                </td>
                                <td></td>
                                <td align="right"><label for="total_amount" class="table_h ">Total Amount:</label></td>
                                <td class="">
                                    <input type="text" name="total_amount" class="form-control text_right add_style" id="total_amount" oninput="calc(this);this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                                        readonly>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" align="right">
                                    <div>
                                        <button type="button" name="submit" id="submit" onclick=invoice_insert();
                                            class="btn btn m-2"
                                            style="background-color:#ff7600;color:white; ">Submit</button>

                                        <button type="reset" id="reset" class="btn btn border reset m-2"
                                            onclick="show_invoice_id();">Reset</button>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <!-- add user start -->
            </div>
        </div>
        <!-- ======================================================== INVOICE master end ================================================== -->



    </main>
    <?php include '../common/script.php'; ?>
   

    <script src="invoice_ajax.js"></script>

    <script>
    $(".delete_row:first").hide()
    function addMore() {
        var $clonedRow = $(".invoice_add_item tr:first").clone();
        $clonedRow.find('input').val('');
        $clonedRow.find('.delete_row').show();
        $clonedRow.insertAfter(".add_list:last");
    }
    function deleterow(e) {
        $(e).parent().parent().remove();
        calc(e)
    }
    </script>



</body>
  


</html>