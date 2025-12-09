<!DOCTYPE html>
<html lang="en">
<?php include '../common/head.php'; ?>


<body class="g-sidenav-show  bg-gray-100 ">
    <?php include '../common/aside.php'; ?>
    <main class="main-content position-relative mt-1 border-radius-lg ">
        <!-- Navbar -->
        <?php include '../common/navbar.php'; ?>
        <!-- ==================================================== user master start ====================================================== -->
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" style="color:black;" data-bs-toggle="tab"
                        data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"
                        onclick="click_all_user()">All
                        User</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" style="color:black;" data-bs-toggle="tab"
                        data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                        aria-selected="false">Add User</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">

                <!-- all user start  -->
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <form method="POST" id="search_form" class="container mt-4 shadow border d-flex align-items-center justify-content-start" enctype="multipart/form-data">
                        <table class="w-75 ">
                            <tr>
                                <td>
                                    <div class="search">
                                        <input type="hidden" name="">
                                        <label for="search_fname">User Name</label><span id="search_fname_err"></span><br>
                                        <input type="text" class="form-control" name="search_fname" id="search_fname">
                                    </div>
                                </td>
                                <td>
                                    <div class="search">
                                        <label for="search_email">Email</label><span id="search_emailErr"></span><br>
                                        <input type="email" class="form-control" name="search_email" id="search_email">
                                    </div>
                                </td>
                                <td>
                                    <div class="search">
                                        <label for="search_mobile_no">Mobile Number</label><span id="search_mobile_noErr"></span><br>
                                        <input type="text" class="form-control" name="search_mobile_no" id="search_mobile_no" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <button type="button" name="submit" class="btn btn search_btn_style" id="search_btn" onclick="show_user_master_data()" 
                                    style="background-color:#ff7600;color:white;" >Search</button>

                                    <!-- <input type="reset" name="reset_all" class="btn btn border search_btn_style"  onmouseout="reset_page()" value="Reset"> -->
                                    <button type="submit" class="btn btn border search_btn_style">Reset</button>

                                </td>
                            </tr>
                        </table>
                    </form>
                    <br>
                    <br>
                    <span>
                        <label for="recordsPerPage">Records per Page:</label>
                        <select id="recordsPerPage"class="border" name="recordsPerPage" onchange="show_user_master_data()">
                            <option value='3'>3</option>
                            <option value='6'>6</option>
                            <option value='9'>9</option>
                        </select>
                    </span>
                    <div class="table-container shadow border table table-striped">

                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th class="table_h" onclick="sort_table('id');asdf();">S.No<i class="fa-solid fa-up-long d-none up-a" style="color: #ff7600;"></i><i class="fa-solid fa-down-long d-none down-a" style="color: #ff7600;"></i></th>
                                    <th class="table_h" onclick="sort_table('name')">User Name</th>
                                    <th class="table_h" onclick="sort_table('email_id')">Email</th>
                                    <th class="table_h" onclick="sort_table('mobile_no')">Phone</th>
                                    <th class="table_h" colspan="2" style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">
                            </tbody>
                        </table>
                        <div id="pagination"
                            style="display: flex; align-items: center; justify-content: center; gap: 5px;">
                        </div>
                        <input type="hidden" name="hid_field" id="hid_field" value="asc">
                        
                    </div>
                    <!-- show data  -->
                </div>
                <!-- all user end  -->
                <!-- add user start -->
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <form method="POST"
                        class="container mt-4 shadow border d-flex align-items-center justify-content-center"
                        enctype="multipart/form-data" id="userMaster_form">
                        <table class="w-100">
                            <tr>
                                <td>
                                    <div class="fname1 add_style">
                                        <input type="hidden" name="h_input" id="h_input">
                                        <label for="user_name">User Name</label><span class="err">* &nbsp; <span
                                                id="user_nameErr"></span></span><br>
                                        <input type="text" class="form-control" name="user_name" id="user_name" maxlength="30">
                                    </div>
                                </td>
                                <td>
                                    <div class="email add_style">
                                        <label for="email">Email</label><span class="err">* &nbsp; <span
                                                id="emailErr_i"></span></span><br>
                                        <input type="email" class="form-control" name="email" id="email" maxlength="40">
                                    </div>
                                </td>
                                <td>
                                    <div class="mobile_no add_style">
                                        <label for="mobile_no">Mobile Number</label><span class="err">* &nbsp; <span
                                                id="noErr"></span></span><br>
                                        <input type="text" class="form-control" name="mobile_no" id="mobile_no" minlength="10" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>
                                </td>
                                <td>
                                    <div class="password add_style">
                                        <input type="hidden" name="hid_pwd" id="hid_pwd">
                                        <label for="pwd">Password</label><span class="err">* &nbsp; <span
                                                id="pwdErr"></span></span><br>
                                        <input type="password" class="form-control" name="pwd" id="pwd"
                                            placeholder="***********" maxlength="10">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <button type="button" name="submit" id="submit" onclick=insert_user_master();
                                    class="btn btn add_style_btn" style="background-color:#ff7600;color:white; ">Submit</button>
                                    
                                    <button type="reset" id="reset" class="btn btn border add_style_btn">Reset</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <!-- add user start -->
            </div>
        </div>
        <!-- ======================================================== user master end ================================================== -->
    </main>
    <?php include '../common/script.php'; ?>
    <script src="userMaster_ajax.js"></script>
</body>

</html>





