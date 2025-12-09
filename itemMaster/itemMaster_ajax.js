function click_all_item() { $("#reset").click(); $("#hidden_item_field").val(""); $("#profile-tab").html("Add Item") }
// function ===============================================================================================================
function item_validation() {
     var validation = true;
    // item name============================================================
    var item = document.getElementById("item_name").value;
    var itemErr = document.getElementById("item_nameErr");
    const minLength = 3;
    const maxLength = 30;
    const namePattern = regex = /^[a-zA-Z ]{2,30}$/;
    if (item.trim() === "") {
        itemErr.innerHTML = "name required ";
        $('#item_nameErr').show().fadeOut(2000);
        return validation = false;
    }
    else if (!item.match(namePattern)) {
        itemErr.innerHTML = "invalid item name ";
        $('#user_nameErr').show().fadeOut(2000);
        return validation = false;
    }
    else if (item.length < minLength) {
        itemErr.innerHTML = " At least " + minLength + " characters long.";
        $('#item_nameErr').show().fadeOut(2000);
        return validation = false;

    } else if (item.length > maxLength) {
        itemErr.innerHTML = " Max  " + maxLength + " characters long.";
        $('#item_nameErr').show().fadeOut(2000);
        return validation = false;
    }
    else {
        itemErr.textContent = "";
    };
    // item description ============================================================
    var item_d = document.getElementById("item_description").value;
    var item_dErr = document.getElementById("item_descriptionErr");
    const des_maxLength = 150;
    if (item_d == "") {
        item_dErr.innerHTML = "Address is required";
        $('#item_descriptionErr').show().fadeOut(2000);
        return validation = false;
    }
    else if (item_d.length > des_maxLength) {
        item_dErr.innerHTML = " Max  " + des_maxLength + " characters long.";
        $('#item_descriptionErr').show().fadeOut(2000);
        return validation = false;
    }
    else{
        item_dErr.textContent = "";
    }
    // item price ============================================================
    var item_price = document.getElementById("item_price").value;
    var item_priceErr = document.getElementById("item_priceErr");
    var price_maxLength=6;
    if (item_price.trim() === "") {
        item_priceErr.innerHTML = "price is required!";
        $('#item_priceErr').show().fadeOut(2000);
        return validation = false;
    }
    const numericValue = Number(item_price);
    if (isNaN(numericValue)) {
        item_priceErr.innerHTML = "Invalid price";
        $('#item_priceErr').show().fadeOut(2000);
        return validation = false;
    }
    else if (item_price.length > price_maxLength) {
        item_priceErr.innerHTML = " Max Item price 9,99,999.00 ";
        $('#item_priceErr').show().fadeOut(2000);
        return validation = false;
    }
    else{item_priceErr.textContent = "";}
    
    return validation;
}
function resetFormFields() {
    var form = $('#item_form_id');
    var formInput = form.find('input,select,textarea')
    formInput.val('');
    $("#h_input").val("")
    $("#output").fadeOut(0.5);
    $("#profile-tab").html("Add Item")
    
    // $('#form_id input[type=radio]').prop('checked', false);
    // $('#form_id input[type=checkbox]').prop('checked', false);
}
function page(){
    resetFormFields()
                // show_user_master_data()
                $("#home-tab").addClass("active show")
                $("#home").addClass("active show")
                $("#profile-tab").removeClass("active")
                $("#profile").removeClass("active")
                
}
var loadimage = function (event) {
    // console.log(event.target.files);
    var output = document.getElementById("output");
    output.src = URL.createObjectURL(event.target.files[0]);
    document.getElementById("output").style.display = "block";
}

// onclick event =====================================================================================================

function insert_item_master() {
    var form = document.getElementById('item_form_id');
    var formData = new FormData(form);
    formData.append("type", 'insert_item');
    
    var val = item_validation()
    if (val == true) {
        $.ajax({
            type: "POST",
            url: "php_itemMaster.php",
            dataType: 'json',
            contentType: false,
            processData: false,
            cache: false,
            data: formData,
            success: function (data) {
                if (data.statuscode == 140){
                    toastr.warning(data.message);
                }
                else if (data.statuscode == 150){
                    page()
                    toastr.success(data.message);
                    show_itemRec()
                }
                else if (data.statuscode == 155){
                    toastr.warning(data.message);
                }
            },
            error: function (data) {
                toastr.error(data.message);
            }
        })
    }

}
function sort_table(fn){
    var field_name = document.getElementById("hid_field_sorting").value;
    if (field_name == 'asc'){
        document.getElementById('hid_field_sorting').value='desc'; 
    }
    else{
        document.getElementById('hid_field_sorting').value='asc'; 
    }
    show_itemRec(1,fn);
}
function show_itemRec(page='1',column_name='s_no') {
    let recordsPerPage = $("#recordsPerPage").val();
    let sorting = $('#hid_field_sorting').val();

    let search_item = $("#search_item_name").val();
    let search_item_description = $("#search_item_description").val();
    let search_item_price = $("#search_item_price").val();
    $.ajax({
        type: "POST",
        url: "php_itemMaster.php",
        data: {
            page: page,
            search_item:search_item,
            search_item_description:search_item_description,
            search_item_price:search_item_price,
            
            recordsPerPage: recordsPerPage,
            
            type: 'show_item',
            column_name:column_name,
            sorting:sorting
        },
        dataType: 'json',
        success: function (data) {
            $("#show_item_data").html(data.table);
            $("#pagination").html(data.pagination);

        },
        error: function (data) {
            toastr.error(data.message);
            
        }
    })
}
show_itemRec()
function reset_page(){
show_itemRec()
}
function editItem(id){
    $.ajax({
        type: "POST",
        url: "php_itemMaster.php",
        data: {
            id: id,
            type: 'editItem'
        },
        dataType: 'json',
        success: function (data) {
            $("#profile-tab").addClass("active show")
            $("#profile-tab").html("Update Item")
            $("#profile").addClass("active show")
            $("#home-tab").removeClass("active")
            $("#home").removeClass("active")
     

            $("#hidden_item_field").val(data[0]['s_no'])
            $("#item_name").val(data[0]['item_name'])
            $("#item_description").val(data[0]['item_description'])
            $("#item_price").val(data[0]['item_price'])
            $("#hid_img").val(data[0]['item_file'])
            $("#output").attr("src",data[1])
            
            $('#output').show();          
        },
        error: function (e) {
            console.log("this is error", e)
        }
    })
}
function deleteItem(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "php_itemMaster.php",
                data: {
                    id: id,
                    type: 'deleteItem'
                },
                dataType: 'json',
                success: function (data) {
                    if (data.statuscode == 155) {
                        // debugger
                        Swal.fire({
                            title: "Deleted!",
                            text: data.message,
                            icon: "success"
                          });
                          show_itemRec()
                    }
                    else if (data.statuscode == 160) {
                        Swal.fire({
                            title: "Deleted!",
                            text: data.message,
                            icon: "error"
                          });
                    }
                   
                },
                error: function (data) {
                    toastr.error(data.message);
                }
            })
          
        }
      });


}