<!DOCTYPE html>
<html lang="en">
<?php include '../common/head.php'; ?>


<body class="g-sidenav-show  bg-gray-100">
    <?php include '../common/aside.php'; ?>
    <main class="main-content position-relative mt-1 border-radius-lg ">
        <!-- Navbar -->
        <?php include '../common/navbar.php'; ?>


        <!-- ==================================================== item master start ====================================================== -->
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" style="color:black;" onclick="click_all_item()" data-bs-toggle="tab"
                        data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">All
                        Item</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" style="color:black;" data-bs-toggle="tab"
                        data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                        aria-selected="false">Add Item</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">

                <!-- all item start  -->
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <form method="POST"
                        class="container mt-4 shadow border d-flex align-items-center justify-content-start"
                        enctype="multipart/form-data">
                        <table class="w-75">
                            <tr>
                                <td>
                                    <div class="item_name1 search">
                                        <label for="search_item_name">Item Name</label><span id="s_item_nameErr"></span><br>
                                        <input type="text" class="form-control" name="search_item_name" id="search_item_name" >
                                    </div>
                                </td>
                                <td>
                                    <div class="item_name1 search">
                                        <label for="search_item_description">Item Description</label><span id="s_item_nameErr"></span><br>
                                        <input type="text" class="form-control" name="search_item_description" id="search_item_description" >
                                    </div>
                                </td>
                                <td>
                                    <div class="item_name1 search">
                                        <label for="search_item_price">Item Price</label><span id="s_item_nameErr"></span><br>
                                        <input type="text" class="form-control text_right" name="search_item_price" id="search_item_price" >
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    
                                    <button type="button" name="submit" class="btn btn search_btn_style"
                                    style="background-color:#ff7600;color:white;" onclick="show_itemRec()">Search</button>

                                    <!-- <input type="reset" name="reset_all" class="btn btn border search_btn_style"
                                            onmouseout="reset_page()" value="Reset"> -->
                                    <input type="submit" class="btn btn border search_btn_style" value="Reset">
                                </td>
                            </tr>
                        </table>
                    </form>
                    <br>
                    <br>
                    <span>
                        <label for="recordsPerPage">Records per Page:</label>
                        <select id="recordsPerPage" class="border" name="recordsPerPage"
                            onchange="show_itemRec()">
                            <option value='3'>3</option>
                            <option value='6'>6</option>
                            <option value='9'>9</option>
                        </select>
                    </span>
                    <table class="container shadow border table table-striped">
                        <thead>
                            <tr class="">
                                <th class="table_h" onclick="sort_table('s_no')">S.No</th>
                                <th class="table_h" onclick="sort_table('item_name')">Item Name</th>
                                <th class="table_h" onclick="sort_table('item_description')">Description</th>
                                <th class="table_h">Image</th>
                                <th class="table_h price_c_width" onclick="sort_table('item_price')">Price</th>
                                <th class="table_h_a"colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody id="show_item_data">
                        </tbody>
                    </table>
                    <div id="pagination" style="display: flex; align-items: center; justify-content: center; gap: 5px;">
                    </div>
                    <input type="hidden" name="hid_field" id="hid_field_sorting" value="asc">
                </div>
                <!-- all item end  -->
                <!-- add item start -->
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <form method="POST"
                        class="container mt-4 shadow border d-flex align-items-center justify-content-center"
                        enctype="multipart/form-data" id="item_form_id" style="height: 200px !important;">
                        <table class="w-100">
                            <tr>
                                <td>
                                    <div class="item_name add_style">
                                        <input type="hidden" class="form-control" name="hidden_item_field"
                                            id="hidden_item_field">
                                        <label for="item_name">Item Name</label><span class="err">* &nbsp;<span
                                                id="item_nameErr"></span></span><br>
                                        <input type="text" class="form-control" name="item_name" id="item_name" maxlength="30">
                                    </div>
                                </td>
                                <td>
                                    <div class="item_description add_style">
                                        <label for="item_description">Item Description</label><span class="err">*
                                            &nbsp;<span id="item_descriptionErr"></span></span><br>
                                        <input type="text" class="form-control" name="item_description"
                                            id="item_description" maxlength="150">
                                    </div>
                                </td>
                                <td>
                                    <div class="item_price add_style">
                                        <label for="item_price">Item Price</label><span class="err">* &nbsp;<span
                                                id="item_priceErr"></span></span><br>
                                        <input type="text" class="form-control text_right" name="item_price" id="item_price" maxlength=""
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>
                                </td>
                                <td>
                                    <div class="item_file add_style">
                                        <input type="hidden" name="hid_img" id="hid_img">
                                        <label for="file">Choose File</label><span class="err"> &nbsp;<span
                                                id="fileErr"></span></span><br>
                                        <input type="file" class="form-control" name="file" id="file"
                                            onchange="loadimage(event)" accept="image/*">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">
                                    <button type="button" name="submit" id="submit" onclick=insert_item_master();
                                        class="btn btn add_style_btn" style="background-color:#ff7600;color:white; ">Submit</button>

                                        <!-- <button type="reset" id="reset" class="btn btn border add_style_btn"
                                        onclick=resetFormFields();>Reset</button> -->
                                        <button type="reset" id="reset" class="btn btn border search_btn_style">Reset</button>
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div id="img">
                                        <img src="" style="width: 80px;margin: 13px 0px 0px 10px; display:none;"
                                            id="output" alt="preview">
                                    </div>
                                </td>
                            </tr>

                        </table>
                    </form>
                </div>
                <!-- add item start -->
            </div>
        </div>
        <!-- ======================================================== item master end ================================================== -->
    </main>
    <?php include '../common/script.php'; ?>
    <script src="itemMaster_ajax.js"></script>
</body>

</html>