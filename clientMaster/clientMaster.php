<!DOCTYPE html>
<html lang="en">
<?php include '../common/head.php'; ?>


<body class="g-sidenav-show  bg-gray-100">
    <?php include '../common/aside.php'; ?>

    <main class="main-content position-relative mt-1 border-radius-lg ">
        <!-- Navbar -->
        <?php include '../common/navbar.php'; ?>

        <!-- ==================================================== user master start ====================================================== -->
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" style="color:black;" onclick="click_all_client()"
                        data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home"
                        aria-selected="true">All
                        Client</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" style="color:black;" data-bs-toggle="tab"
                        data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                        aria-selected="false">Add Client</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">

                <!-- all client start  -->
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <form method="POST"
                        class="container mt-4 shadow border d-flex align-items-center justify-content-start"
                        enctype="multipart/form-data">
                        <table class="w-75">
                            <tr>
                                <td>
                                    <div class="search">
                                        <input type="hidden" name="client_hid_inp">
                                        <label for="search_c_name">Client Name</label><span
                                            id="s_client_nameErr"></span><br>
                                        <input type="text" class="form-control" name="search_c_name" id="search_c_name">
                                    </div>
                                </td>
                                <td>
                                    <div class="search">
                                        <label for="search_c_email">Email</label><span
                                            id="s_client_emailErr"></span><br>
                                        <input type="email" class="form-control" name="search_c_email"
                                            id="search_c_email">
                                    </div>
                                </td>
                                <td>
                                    <div class="search">
                                        <label for="search_c_mobile_no">Mobile Number</label><span
                                            id="s_client_noErr"></span><br>
                                        <input type="text" class="form-control" name="search_c_mobile_no"
                                            id="search_c_mobile_no" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <button type="button" name="submit" class="btn btn search_btn_style" id="search_client_data"
                                    style="background-color:#ff7600;color:white;"
                                    onclick="show_data()">Search</button>

                                    <!-- <input type="reset" name="reset_all" class="btn btn border search_btn_style"
                                        onmouseout="reset_page()" value="Reset"> -->
                                        <button type="submit" class="btn btn border search_btn_style">Reset</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <br>
                    <br>
                    <label for="pagination_client_page">Records per Page:</label>
                    <select class="border" name="pagination_client_page" id="pagination_client_page"
                        onchange="show_data()">
                        <option value="3">3</option>
                        <option value="6">6</option>
                        <option value="9">9</option>
                    </select>
                    <div>
                        <table class="container shadow border table table-striped">
                            <thead>
                                <tr class="">
                                    <th class="table_h" onclick="sort_table('id')">S.no</th>
                                    <th class="table_h td-no" onclick="sort_table('name')">Client Name</th>
                                    <th class="table_h td-no" onclick="sort_table('mobile_no')">Mobile Number</th>
                                    <th class="table_h" onclick="sort_table('email')">Email</th>
                                    <th class="table_h">Address</th>
                                    <!-- <th class="table_h" onclick="sort_table('state')">State</th>
                                    <th class="table_h" onclick="sort_table('cities')">City</th> -->
                                    <th class="table_h" colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody id="show_client_data">
                            </tbody>
                        </table>
                    </div>
                    <div id="pagination" style="display: flex; align-items: center; justify-content: center; gap: 5px;">
                    </div>
                    <input type="hidden" name="hid_field" id="hid_field" value="asc">

                </div>
                <!-- all user end  -->
                <!-- add user start -->
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <form method="POST"
                        class="container mt-4 shadow border d-flex align-items-center justify-content-start"
                        enctype="multipart/form-data" id="client_form" style="height: 230px !important;">
                        <table class="w-75">
                            <tr>
                                <td>
                                    <div class="client_name add_style">
                                        <input type="hidden" name="client_hid_inp" id="client_hid_inp">
                                        <label for="client_name">Client Name</label><span class="err">* &nbsp; <span
                                                id="client_nameErr"></span></span><br>
                                        <input type="text" class="form-control" name="client_name" id="client_name" maxlength="30">
                                    </div>
                                </td>
                                <td>
                                    <div class="client_email add_style">
                                        <label for="client_email">Email</label><span class="err">* &nbsp; <span
                                                id="client_emailErr"></span></span><br>
                                        <input type="email" class="form-control" name="client_email" id="client_email"maxlength="40">
                                    </div>
                                </td>
                                <td>
                                    <div class="client_mobile_no add_style">
                                        <label for="client_mobile_no">Mobile Number</label><span class="err">* &nbsp;
                                            <span id="client_mobile_noErr"></span></span><br>
                                        <input type="text" class="form-control" name="client_mobile_no"
                                            id="client_mobile_no" minlength="10" maxlength="10"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>
                                </td>


                            </tr>
                            <tr>
                                <td>
                                    <div class="client_address add_style">
                                        <label for="client_address">Address</label><span class="err">* &nbsp; <span
                                                id="client_addressErr"></span></span><br>
                                        <input type="text" class="form-control " name="client_address"
                                            id="client_address" maxlength="100">
                                    </div>
                                </td>
                                <td>
                                    <div class="client_state add_style">
                                        <label for="client_state">State</label> <span class="err">* &nbsp; <span
                                                id="stateErr"></span></span><br>
                                        <select name="client_state" id="client_state" onchange="gcities()"
                                            class="form-control">

                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="client_city add_style">
                                        <label for="client_city">City</label> <span class="err">* &nbsp; <span
                                                id="citiesErr"></span></span><br>
                                        <select name="client_city" id="client_city" class="form-control">
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <button type="button" name="submit" id="submit" onclick=client_insertrec();
                                    class="btn btn add_style_btn" style="background-color:#ff7600;color:white; ">Submit</button>

                                    <button type="reset" id="reset" class="btn btn border add_style_btn"
                                        onclick="resetFormField()">Reset</button>
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
    <script src="clientMaster_ajax.js"></script>

</body>

</html>