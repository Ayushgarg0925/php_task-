<!DOCTYPE html>
<html lang="en">
<?php include '../common/head.php'; 
?>


<body class="g-sidenav-show  bg-gray-100">
    <?php include '../common/aside.php'; ?>
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <!-- navbar start -->
        <?php include '../common/navbar.php'; ?>
        <!-- navbar end -->
        <table class="container mt-5 w-75">
            <tr>
                <td class="p-2">
                    <div class="border shadow rounded p-2 m-2 a">
                        <a href="../userMaster/userMaster.php"
                            class="d-flex align-items-center justify-content-between">
                            <span>
                                <p id="user_count">
                                </p><br>
                                <div>User Master</div>
                            </span>
                            <span>
                            <!-- <i class="fa-regular fa-user" style="color: #ff7600;font-size: xxx-large;margin-right: 15px;"></i> -->
                            <i class="fa-solid fa-user" style="color: #ff7600;font-size: xxx-large;margin-right: 15px;"></i>
                            </span>
                        </a>
                    </div>
                </td>

                <td class="p-2">
                    <div class="border shadow rounded p-2 m-2 a">
                        <a href="../clientMaster/clientMaster.php" 
                            class="d-flex align-items-center justify-content-between">
                            <span>
                                <p id="client_count">
                                </p><br>
                                <div>Client Master</div>
                            </span>
                            <span>
                            <i class="fa-solid fa-users" style="color: #ff7600;font-size: xxx-large;margin-right: 15px;"></i>
                            </span>
                        </a>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="p-2">
                    <div class="border shadow rounded p-2 m-2 a">
                        <a href="../itemMaster/itemMaster.php" 
                            class="d-flex align-items-center justify-content-between">
                            <span>
                                <p id="item_count">
                                </p><br>
                                <div>Item Master</div>
                            </span>
                            <span>
                            <i class="fa-solid fa-sitemap" style="color: #ff7600;font-size: xxx-large;margin-right: 15px;"></i>
                            </span>
                        </a>
                    </div>
                </td>

                <td class="p-2">
                    <div class="border shadow rounded p-2 m-2 a">
                        <a href="../invoice/invoice.php" 
                            class="d-flex align-items-center justify-content-between">
                            <span>
                                <p id="invoice_count">
                                </p><br>
                                <div>Invoice Master</div>
                            </span>
                            <span>
                            <i class="fa-solid fa-file-invoice" style="color: #ff7600;font-size: xxx-large;margin-right: 15px;"></i>
                            </span>
                        </a>
                    </div>
                </td>

            </tr>
        </table>
    </main>


    <?php include '../common/script.php'; ?>
    <script src="../assets/js/ajax.js"></script>

</body>

</html>