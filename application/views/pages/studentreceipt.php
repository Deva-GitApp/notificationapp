<?php
$CI = & get_instance();
$CI->load->model('receipt_model');
$CI->load->library('usersupport');
?>
<div class="container">
    <h5 class="mt-3"><b><u>Receipt Details</u></b></h5>
    <?php
    if (!empty($receipt_details[0]['receipt_id'])) {
        ?>
        <ul class="nav nav-tabs mt-3 mb-3" id="myTab" role="tablist">

            <?php
            $i = 0;
            foreach ($receipt_details as $key => $value) {
                ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= ($i == 0) ? 'active' : '' ?>" id="home-tab" data-bs-toggle="tab" data-bs-target="#r<?= $value['receipt_no'] ?>" type="button" role="tab" aria-controls="r<?= $value['receipt_no'] ?>" aria-selected="<?= ($i == 0) ? 'true' : 'false' ?>">Receipt No : <?= $value['receipt_no'] ?></button>
                </li>
                <?php
                $i++;
            }
            ?>


        </ul>
        <div class="tab-content" id="myTabContent">

            <?php
            $i = 0;
            foreach ($receipt_details as $key => $value) {
                $user_det = $value['fk_student_id'] . '-' . $value['receipt_id'];
                $enc = $this->usersupport->encrypt_decrypt('encrypt', $user_det);
                ?>
                <div class="tab-pane fade <?= ($i == 0) ? 'show active' : '' ?>" id="r<?= $value['receipt_no'] ?>" role="tabpanel" aria-labelledby="r<?= $value['receipt_no'] ?>-tab">
                    <h4 class="text-center pt-1 pb-1"><u>Fee Receipt</u> <a href="<?= base_url('pdfpreview/') . $enc ?>" target="_blank" style="float:right"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a></h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">Programme :</th>
                                    <td><?= $value['course_name'] ?></td>
                                    <th>Receipt No :</th>
                                    <td><?= $value['receipt_no']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Batch :</th>
                                    <td><?= $value['batch'] ?></td>
                                    <th scope="row">Date :</th>
                                    <td><?= date('Y-m-d', strtotime($value['receipt_date'])) ?></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <h4 class="text-center pt-3 pb-3">
                        Received with thanks from <?= $value['student_name'] . ' / ' . $value['batch'] . date('Y-m-d', strtotime($value['receipt_date'])) ?>
                    </h4>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>S.no</th>
                                <th>Code</th>
                                <th>Towards</th>
                                <th>Amount ( in Rs )</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $subrec_details = $CI->receipt_model->get_receiptsub_details($value['receipt_id']);
                            $receipt_total = array_sum(array_column($subrec_details, 'receipt_detail_amount'));
                            $i = 1;
                            foreach ($subrec_details as $key => $subrec) {
                                ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $subrec['receipt_detail_no']; ?></td>
                                    <td><?= $subrec['receipt_detail_head']; ?></td>
                                    <td><?= $subrec['receipt_detail_amount']; ?></td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <th class="text-end">Total</th>
                                <td><?= $receipt_total; ?></td>
                            </tr>
                        </tfoot>
                    </table>
                    <br>
                    <h6 class="pt-1 pb-3"><b><?= $value['receipt_des']; ?></b></h6>
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-3 pb-1 fs-6"><b>Mode</b></div>
                                <div class="col-3"><?= $value['receipt_mode']; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-3 pb-1 fs-6"><b>Date</b></div>
                                <div class="col-3"><?= date('Y-m-d', strtotime($value['receipt_date'])) ?></div>
                            </div>
                            <div class="row">
                                <div class="col-3 pb-1 fs-6"><b>Transaction no / DD no</b></div>
                                <div class="col-3"><?= date('Y-m-d', strtotime($value['receipt_date'])) ?></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <h6 class="pt-1 pb-3 text-center"><b>SRI RAMACHANDRA<br> INSTITUTE OF HIGHER EDUCATION AND RESEARCH</b></h6>
                            <p class="fs-6 text-center"> ( Deemed to be University ) </p>
                            <p class="fs-6 text-center"><b>Authorized Signatory</b></p>
                        </div>
                    </div>
                    <div class="row">
                        <h6 class="pt-3 pb-2 text-center"><b>(Electronically generated. No Signature required)</b></h6>
                    </div>
                </div>
                <?php
                $i++;
            }
            ?>
        </div>
        <?php
    } else {
        ?>
        <h6 class="mt-3 mb-2">No Data Available</h6>
        <?php
    }
    ?>

</div>