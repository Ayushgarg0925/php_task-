function click_all_client() { $("#reset").click(); $("#client_hid_inp").val(""); $("#profile-tab").html("Add Client") }

function client_validation() {
    let validation = true;
    // name ============================================================
    var name = document.getElementById("client_name").value;
    var nameErr = document.getElementById("client_nameErr");
    const namePattern = regex = /^[a-zA-Z ]{2,30}$/;
    if (name.trim() === "") {
      nameErr.innerHTML = "name required ";
      $('#client_nameErr').show().fadeOut(2000);
      return validation = false;
    }
    else if (!name.match(namePattern)) {
        nameErr.innerHTML = "invalid name";
        $('#client_nameErr').show().fadeOut(2000);
        return validation = false;
    }
    else {
      nameErr.textContent = "";
    };
  
    // email============================================================
    var email = document.getElementById("client_email").value;
    var emailErr = document.getElementById("client_emailErr");
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var maxLength1 = 40;
    if (email.trim() === "") {
      emailErr.innerHTML = "Email is required";
      $('#client_emailErr').show().fadeOut(2000);
      return validation = false;
    } 
    else if (!emailRegex.test(email)) {
      emailErr.innerHTML = "Invalid email address!";
      $('#client_emailErr').show().fadeOut(2000);
      return validation = false;
    } 
    else if (email.length > maxLength1) {
      emailErr.innerHTML = " Max  " + maxLength1 + " characters long.";
      $('#client_emailErr').show().fadeOut(2000);
      return validation = false;
    } else {
      emailErr.textContent = "";
    }
  
   
    // mobile number ============================================================
    var mobile_no = document.getElementById("client_mobile_no").value;
    var noErr = document.getElementById("client_mobile_noErr");
    var expr = /^(0|91)?[7-9][0-9]{9}$/;
    if (mobile_no.trim() === "") {
      noErr.innerHTML = "Number is required!";
      $('#client_mobile_noErr').show().fadeOut(2000);
      return validation = false;
    }
    const numericValue = Number(mobile_no);
    if (isNaN(numericValue)) {
      noErr.innerHTML = "Invalid Number";
      $('#client_mobile_noErr').show().fadeOut(2000);
      return validation = false;
    }
    if (!expr.test(mobile_no)) {
      noErr.innerHTML = "Invalid Mobile Number.";
      $('#client_mobile_noErr').show().fadeOut(2000);
      return validation = false;
    }
    noErr.textContent = "";
  
    // Address ============================================================
    var address = document.getElementById("client_address").value;
    var addressErr = document.getElementById("client_addressErr");
    if (address.trim() === "") {
      addressErr.innerHTML = "Address is required";
      $('#client_addressErr').show().fadeOut(2000);
      return validation = false;
    }
    addressErr.textContent = "";
  
    // state ============================================================
    var state = document.getElementById("client_state").value;
    var stateErr = document.getElementById("stateErr");
  
    if (state.trim() === "0") {
      stateErr.innerHTML = "State is required!";
      $('#stateErr').show().fadeOut(2000);
      return validation = false;
    }
    stateErr.textContent = "";
  
    // city ============================================================
    var city = document.getElementById("client_city").value;
    var citiesErr = document.getElementById("citiesErr");
  
    if (city.trim() === "0") {
      citiesErr.innerHTML = "City is required!";
      $('#citiesErr').show().fadeOut(2000);
      return validation = false;
    }
    citiesErr.textContent = "";
    return validation;
}
function resetFormField(){
    var form = $('#client_form');
    var formInput = form.find('input,select,textarea')
    formInput.val('');
    $("#client_hid_inp").val("")
    $("#profile-tab").html("Add Client")
}
function page(){
    resetFormField()
    show_data()
                $("#home-tab").addClass("active show")
                $("#home").addClass("active show")
                $("#profile-tab").removeClass("active")
                $("#profile").removeClass("active")
}
function gState() {
    $.ajax({
        type: "POST",
        url: "php_clientMaster.php",
        data: {
            type: 'state'
        },
        dataType: 'html',
        success: function (data) {
            $("#client_state").html(data);
        }
    })
} gState()
function gcities() {
    var id = $("#client_state").val()
    $.ajax({
        type: "POST",
        url: "php_clientMaster.php",
        data: {
            id: id,
            type: 'cities'
        },
        dataType: 'html',
        success: function (data) {
            $("#client_city").html(data);
        }
    })
}

function client_insertrec() {
    var form = document.getElementById('client_form');
    var formData = new FormData(form);
    formData.append("type", 'insert_clientMaster');
    var val =  client_validation();
    if (val == true){
    $.ajax({
        type: "POST",
        url: "php_clientMaster.php",
        dataType: 'json',
        contentType: false,
        processData: false,
        cache: false,
        data: formData,
        success: function (data) {
            if (data.statuscode == 140) {
                toastr.warning(data.message);
            }
            else if (data.statuscode == 150) {
                page()
                toastr.success(data.message);
            }
            else if (data.statuscode == 180) {
                page()
                toastr.success(data.message);
                
                $("#profile-tab").html("Add Client")
            }
            else if (data.statuscode == 300) {    
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
    var field_name = document.getElementById("hid_field").value;
    if (field_name == 'asc'){
        document.getElementById('hid_field').value='desc'; 
    }
    else{
        document.getElementById('hid_field').value='asc'; 
    }
    show_data(1,fn);
}

function show_data(page = '1',column_name='id') {
    var s_name = $("#search_c_name").val();
    var s_email = $("#search_c_email").val();
    var s_mobile_no = $("#search_c_mobile_no").val();
    let pagination_client_page = $("#pagination_client_page").val();
    let sorting = $('#hid_field').val();

    $.ajax({
        type: "POST",
        url: "php_clientMaster.php",
        data: {
            s_name:s_name,
            s_email:s_email,
            s_mobile_no:s_mobile_no,
            sorting:sorting,
            column_name:column_name,

            type: 's_data',
            page:page,
            pagination_client_page:pagination_client_page,

        },
        dataType: 'JSON',
        success: function (data) {
            $("#show_client_data").html(data.table);
            $("#pagination").html(data.pagination);
        }
    })
} show_data()

function delete_client_data(id) {
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
                url: "php_clientMaster.php",
                data: {
                    id: id,
                    type: 'delete'
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                    if (data.statuscode == 200) {
                        Swal.fire({
                            title: "Deleted!",
                            text: data.message,
                            icon: "success"
                          });
                        show_data()
                    }
                    else if (data.statuscode == 250) {
                        Swal.fire({
                            title: "Deleted!",
                            text: data.message,
                            icon: "error"
                          });
                        show_data()
                    }
                    
                    
                }
            })
        }
      });
}
function edit_client_data(id) {
    $.ajax({
        type: "POST",
        url: "php_clientMaster.php",
        data: {
            id: id,
            type: 'edit'
        },
        dataType: 'json',
        success: function (data) {
// console.log(data['state'])
            $("#profile-tab").addClass("active show")
            $("#profile-tab").html("Update Client")
            $("#profile").addClass("active show")
            $("#home-tab").removeClass("active")
            $("#home").removeClass("active")

            $("#client_hid_inp").val(data['id'])
            $("#client_name").val(data['name'])
            $("#client_email").val(data['email'])
            $("#client_mobile_no").val(data['mobile_no'])
          
            $("#client_address").val(data['address'])
            $("#client_state").val(data['state']).trigger("change")
            setTimeout(function () {
                $("#client_city").val(data['cities']);
            }, 100)
        }
    })
}
function reset_page(){
    show_data()
}
