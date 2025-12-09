function validation(){
    let validation = true;
    // email============================================================
    var email = document.getElementById("email").value;
    var emailErr = document.getElementById("emailErr")
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
     if (email == '') {
         emailErr.innerHTML = " This feild is required ";
         return validation = false;
     } 
     else if (!email.match(emailPattern)) {
         emailErr.innerHTML = "invalid Email";
         return validation = false;
     } 
     else {
         emailErr.textContent = "";
     };  

    //  password ===========================================================
    var password = document.getElementById("password").value;
    var pwdErr = document.getElementById("pwdErr")
     if (password == '') {
        pwdErr.innerHTML = " This feild is required ";
        return validation = false;
    } 
    else {
        pwdErr.textContent = "";
    };
    return validation;    
}
function login() {
    var form = document.getElementById('form_id');
    var formData = new FormData(form);
    formData.append("type", 'login');
    let val = validation();
    if (val == true) {
        $.ajax({
            type: "POST",
            url: "main.php",
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            data: formData,
            success: function (data) {
            if (data.statuscode==150){
                $("#emailErr").html(data.message)
            }
            else if (data.statuscode==200){
               window.open('dashboard.php',"_self")
            }
            else if(data.statuscode1==300){
                $("#pwdErr").html("invalid password")
            }
            }
        })
    }    
}
function rows_count() {
        $.ajax({
            type: "POST",
            url: "main.php",
            dataType: "json",
            data:{
                type:'rows_count'
            },
            success: function (data) {
                // console.log(data.result)
                if (data.statuscode == 200){
                    $("#user_count").html(data.result['user_master'])
                    $("#client_count").html(data.result['client_master'])
                    $("#item_count").html(data.result['item_master'])
                    $("#invoice_count").html(data.result['invoice_master'])
                }
            },
            error: function (e) {
                console.log("error")
                console.log("this is error", e)
            }
        }) 
}
rows_count()

function add_side_style(e){
    // debugger
    // a = window.localStorage.getItem(e);
    window.localStorage.setItem("user",e);
     var a= window.localStorage.getItem("user")
     console.log(e)
    // sum=0
    // localStorage.setItem("0","e");  
    // e.forEach(myFunction);
    // function myFunction(item) {
    //  a = localStorage.getItem("0");  
    //   }
    // //   e.classList.add("active")
  }




