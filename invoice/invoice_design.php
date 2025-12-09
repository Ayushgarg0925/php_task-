<?php 
include '../common/backend_invoice_design.php';

?>

<head>
  <style>
    body {
        font-family: 'Arial', sans-serif;
    }

    .invoice-container {
        max-width: 800px;
        margin: 50px auto;
    }

    .invoice-header {
        background-color: #f8f9fa;
        padding: 20px;
        border-bottom: 1px solid #dee2e6;
        text-align: center;
    }

    .invoice-body {
        padding: 10px;
    }

    .invoice-footer {
        padding: 5px;
        border-top: 1px solid #dee2e6;
    }

    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }
  </style>
  <title>Invoice</title>
</head>


<body>

    <div class="container invoice-container">
        <div class="row">
            <div class="col-12">
                <div class="invoice-header">
                    <h2 class="text-center">Invoice</h2>
                    <p class="text-center">Invoice Number: SAN-<?php echo $a;?></p>
                    <p class="text-center">Invoice Date :- <?php echo $date;?></p>
                </div>
            </div>
        </div>

        <div class="row" style="display:flex; ">
            <div class="col-6">
                <h5>From:</h5>
                <address>
                    <strong>SAN SOFTWARE</strong><br>
                    419, 4th Floor,<br>
                    M3M Urbana, Sector 67<br>
                    Gurugram, <br>
                    Haryana 122018
                </address>
            </div>

            <div class="col-6 text-right">
                <h5>To:</h5>
                <address>
                    <Strong><?php echo $client_name;?></Strong><br>
                    <?php echo $address;?><br>
                    <?php echo $client_no;?><br>
                    <?php echo $client_email;?>
                </address>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-12">
                <div class="invoice-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Item</th>
                                <th scope="col" class="text-right">Price</th>
                                <th scope="col" class="text-right">Quantity</th>
                                <th scope="col" class="text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <?php echo $output;?>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="invoice-footer">
                    <p class="text-right"><strong>Total Amount &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>  
                    <strong><?php echo $total_amount;?>.00</strong></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div>
                    <p class="text-center">Thank You!</p>
                    <p class="text-center">Phone: 0124-4310736 | Support: 0124-4310735</p>
                </div>
            </div>
        </div>
    </div>
</body>