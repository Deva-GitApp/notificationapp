<html lang="en">

    <head>
        <link href="<?= base_url('admin_assets') ?>/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"  crossorigin="anonymous">
        <link href="<?= base_url('admin_assets') ?>/dist/css/main.css" rel="stylesheet"  crossorigin="anonymous">
        <link rel="stylesheet" href="<?php echo base_url('admin_assets'); ?>/bower_components/font-awesome/css/font-awesome.min.css">

        <!-- html2pdf CDN-->
        <script src=
                "https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js">
        </script>

        <style>
            .container {
                position: relative;
                display: table;
                margin: 0 auto;
                max-width: 800px;
            }

            .card {
                box-sizing: content-box;
                width: 700px;
                /*height: 150px;*/
                padding: 30px;
                /*border: 1px solid black;*/
                font-style: sans-serif;
                /*background-color: #f0f0f0;*/
            }

            #button {
                /*                background-color: #4caf50;
                                border-radius: 5px;
                                margin-left: 650px;
                                margin-bottom: 5px;
                                color: white;*/
            }
            .btncus{
                position: absolute;
                top: 20px;
                right: 50px;
                z-index: 99;
            }

            h2 {
                text-align: center;
                color: #24650b;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <button id="button" class="btn btn-primary btncus"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download PDF</button>
            <div class="card" id="makepdf">
                <?= $html ?>
            </div>

        </div>

        <script>
            var button = document.getElementById("button");
            var makepdf = document.getElementById("makepdf");

            button.addEventListener("click", function () {
                html2pdf().from(makepdf).save('<?= $pdf_name ?>');
            });
        </script>
    </body>

</html>