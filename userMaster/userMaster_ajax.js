function click_all_user(){$("#reset").click();$("#h_input").val("");$("#profile-tab").html("Add User")}
function validation() {
    let validation = true;
    // name ============================================================
    var name = document.getElementById("user_name").value;
    var nameErr = document.getElementById("user_nameErr");
    const namePattern = regex = /^[a-zA-Z ]{2,30}$/;
    // debugger
    if (name.trim() === '') {
        nameErr.innerHTML = "name required ";

        $('#user_nameErr').show().fadeOut(2000);
        return validation = false;
    }
    else if (!name.match(namePattern)) {
        nameErr.innerHTML = "invalid name";
        $('#user_nameErr').show().fadeOut(2000);
        return validation = false;
    }
    else {
        nameErr.textContent = "";
    };

    // email============================================================
    var email = document.getElementById("email").value;
    var emailErr = document.getElementById("emailErr_i");
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    var maxLength1 = 40;
    console.log(email)
    console.log(emailErr)
    if (email == '') {
        emailErr.innerHTML = "email required ";
        $('#emailErr_i').show().fadeOut(2000);
        return validation = false;
    }
    else if (!email.match(emailPattern)) {
        emailErr.innerHTML = "invalid Email";
        $('#emailErr_i').show().fadeOut(2000);
        return validation = false;
    }
    else if (email.length > maxLength1) {
        emailErr.innerHTML = " Max  " + maxLength1 + " characters long.";
        $('#emailErr_i').show().fadeOut(2000);
        return validation = false;
      }
    else {
        emailErr.textContent = "";
    };
    // mobile number ============================================================
    var mobile_no = document.getElementById("mobile_no").value;
    var noErr = document.getElementById("noErr");
    const noPattern = /^([7,9]{11}$)|(^[7-9][0-9]{9}$)/;

    if (mobile_no == '') {
        noErr.innerHTML = " mobile no required ";
        $('#noErr').show().fadeOut(2000);
        return validation = false;
    }
    else if (!mobile_no.match(noPattern)) {
        noErr.innerHTML = "invalid mobile no";
        $('#noErr').show().fadeOut(2000);
        return validation = false;
    }
    else {
        noErr.textContent = "";
    };

    //  password ===========================================================
    var password = document.getElementById("pwd").value;
    var pwdErr = document.getElementById("pwdErr");
    var max_len_pwd=10;
    if (password.length > max_len_pwd) {
        pwdErr.innerHTML = " Max  " + max_len_pwd + " characters long.";
        $('#pwdErr').show().fadeOut(2000);
        return validation = false;
      }
    else {
        pwdErr.textContent = "";
    };
    return validation;
}
function resetFormFields() {
    var form = $('#userMaster_form');
    var formInput = form.find('input,select,textarea')
    formInput.val('');
    $("#h_input").val("")
    // $('#form_id input[type=radio]').prop('checked', false);
    // $('#form_id input[type=checkbox]').prop('checked', false);
}
function page(){
    resetFormFields()
                show_user_master_data()
                $("#home-tab").addClass("active show")
                $("#home").addClass("active show")
                $("#profile-tab").removeClass("active")
                $("#profile").removeClass("active")
}
function sort_table(fn){
    var field_name = document.getElementById("hid_field").value;
    if (field_name == 'asc'){
        document.getElementById('hid_field').value='desc'; 
    }
    else{
        document.getElementById('hid_field').value='asc'; 
    }
    show_user_master_data(1,fn);
}
// =================================================================== on click function ===================================================================================

function show_user_master_data(page='1',column_name='id') {

    let s_name = $('#search_fname').val();
    let s_email = $('#search_email').val();
    let s_phoneno = $('#search_mobile_no').val();

    let recordsPerPage = $("#recordsPerPage").val();
    let sorting = $('#hid_field').val();

    $.ajax({
        type: "POST",
        url: "php_userMaster.php",
        data: {
            type: 'show',
            page: page,
            recordsPerPage: recordsPerPage,
            s_name:s_name,
            s_email:s_email,
            s_phoneno:s_phoneno,
            
            column_name:column_name,
            sorting:sorting,
            
        },
        dataType: 'JSON',
        success: function (data) {
            $("#show_data").html(data.table);
            $("#pagination").html(data.pagination);
        }
    })
};
show_user_master_data()

function insert_user_master() {
    var form = document.getElementById('userMaster_form');
    var formData = new FormData(form);
    formData.append("type", 'insert_userMaster');
    var val = validation()
    if (val == true) {
        $.ajax({
            type: "POST",
            url: "php_userMaster.php",
            dataType: 'json',
            contentType: false,
            processData: false,
            cache: false,
            data: formData,
            success: function (data) {
                if (data.statuscode == 150) {
                    toastr.warning(data.message);
                    // $("#emailErr_i").html(data.message)
                    $('#emailErr_i').show().fadeOut(2000);
                    
                }
                else if (data.statuscode == 180) {
                    // $("#pwdErr").html(data.message)
                    // $('#pwdErr').show().fadeOut(2000);
                    toastr.warning(data.message);
                }
                else if (data.statuscode == 200) {
                    page()
                    toastr.success(data.message);
                }
                else if (data.statuscode == 250) {
                    page()
                    toastr.success(data.message);
                    
                    $("#profile-tab").html("Add User")
                }
            },
            error: function (data) {
                toastr.success("this is error",data.message)
            }
        })
    }
}

function user_deleterec(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        customClass: 'swal-wide',
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: "php_userMaster.php",
            data: {
                id: id,
                type: 'delete'
            },
            dataType: 'json',
            success: function (data) {
                if (data.statuscode == 200) {
                    Swal.fire({
                        // title: "Deleted!",
                        text: data.message,
                        // icon: "success"
            
                      });
                    show_user_master_data()        
                }
                else if (data.statuscode == 400){
                    Swal.fire({
                        title: "Deleted!",
                        text: data.message,
                        icon: "success"
            
                      });
                    show_user_master_data()
                }
            }
        })
        }
      });
}

function user_editrec(id) {
    $.ajax({
        type: "POST",
        url: "php_userMaster.php",
        data: {
            id: id,
            type: 'edit_userMaster_row'
        },
        dataType: 'json',
        success: function (data) {
            $("#profile-tab").addClass("active show")
            $("#profile-tab").html("Update User")
            $("#profile").addClass("active show")
            $("#home-tab").removeClass("active")
            $("#home").removeClass("active")

            $("#h_input").val(data['id'])
            $("#user_name").val(data['name'])
            $("#email").val(data['email_id'])
            $("#mobile_no").val(data['mobile_no'])
            $("#hid_pwd").val(data['PASSWORD'])

        }
    })
}

function reset_page(){
    show_user_master_data()
}