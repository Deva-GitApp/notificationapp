<?php
function array_search_inner($array, $attr, $val, $strict = FALSE)
{
    // Error is input array is not an array
    if (!is_array($array)) return FALSE;
    // Loop the array
    foreach ($array as $key => $inner) {
        // Error if inner item is not an array (you may want to remove this line)
        if (!is_array($inner)) return FALSE;
        // Skip entries where search key is not present
        if (!isset($inner[$attr])) continue;
        if ($strict) {
            // Strict typing
            if ($inner[$attr] === $val) return $key;
        } else {
            // Loose typing
            if ($inner[$attr] == $val) return $key;
        }
    }
    // We didn't find it
    return NULL;
}
?>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script> -->
<div class="container">
    <h5 class="mt-3"><b><u>Notification Details</u></b></h5>
    <?php
    $pdfname = '';
    if (!empty($student_data) && !empty($notification_details)) {
        $pdfname = 'APPL-' . $student_data['student_barcode'] . '-' . $notification_details[0]['session_name'];
        //var_dump($student_data);
        //var_dump($notification_details);
    ?>
        <div class="d-flex justify-content-center pb-3">
            <a href="javascript:void(0)" id="buttonpdfdownload" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download PDF</a>
        </div>
        <div class="pdfsec" id="makepdf">
            <div class="receiptoutcont pt-3">
                <div class="receiptinnercont">
                    <div class="receiptheader">
                        <div class="row pb-4">
                            <div class="col-md-6">
                                <div class="recheadlogo">
                                    <img class="img-fluid" src="<?= base_url('admin_assets/dist/img') ?>/new-sriher-logo.png" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="receipthead text-center">UNIVERSITY EXAMINATION FEE NOTIFICATION - DECEMBER 2022 </h6>
                            </div>
                        </div>
                    </div>
                    <div class="lblsec">
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                if ($student_data['student_name'] != NULL) {
                                ?>
                                    <div class="lbsecinner">
                                        <div class="left">
                                            <div class="lbl">
                                                Candidate's Name
                                            </div>
                                        </div>
                                        <div class="right">
                                            <div class="lbl">
                                                <?= strtoupper($student_data['student_name']) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <?php
                                if ($student_data['student_dob'] != NULL) {
                                ?>
                                    <div class="lbsecinner">
                                        <div class="left">
                                            <div class="lbl">
                                                Date of Birth
                                            </div>
                                        </div>
                                        <div class="right">
                                            <div class="lbl">
                                                <?= date('d/m/Y', strtotime($student_data['student_dob'])) ?>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                }
                                ?>
                                <?php
                                if ($student_data['course_name'] != NULL) {
                                ?>
                                    <div class="lbsecinner">
                                        <div class="left">
                                            <div class="lbl">
                                                programme
                                            </div>
                                        </div>
                                        <div class="right">
                                            <div class="lbl">
                                                <?= $student_data['course_name']; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php
                                if ($student_data['student_barcode'] != NULL) {
                                ?>
                                    <div class="lbsecinner">
                                        <div class="left">
                                            <div class="lbl">
                                                Regn. No.
                                            </div>
                                        </div>
                                        <div class="right">
                                            <div class="lbl regno">
                                                <?= $student_data['student_barcode']; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                                <div class="lbsecinner">
                                    <div class="left">
                                        <div class="lbl">
                                            Semester
                                        </div>
                                    </div>
                                    <div class="right">
                                        <div class="lbl">
                                            <?= $notification_details[0]['yersemhead']; ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="lbsecinner">
                                    <div class="left">
                                        <div class="lbl">
                                            College
                                        </div>
                                    </div>
                                    <div class="right">
                                        <div class="lbl">
                                            SRI RAMACHANDRA FACULTY OF AUDIOLOGY AND SPEECH LANGUAGE PATHOLOGY
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="receiptdescont">
                        <table class="table table-bordered" style="border-color:#000">
                            <thead>
                                <tr>
                                    <th class="text-center">SEMESTER</th>
                                    <th class="text-center">COURS CODE</th>
                                    <th class="text-center">Result in Group</th>
                                    <th class="text-center">COURSE TITLE FOR WHICH APPEARING</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($notification_details as $notification) {




                                ?>
                                    <tr>
                                        <td><?= $notification['yersemhead']; ?></td>
                                        <td><?= $notification['course_code']; ?></td>
                                        <td></td>
                                        <td><?= $notification['course_name']; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                        <table class="table table-bordered" style="max-width: 500px;border-color:#000">
                            <?php
                            $processing_fees = ($notification_details[0]['appfees'] != 0) ? $notification_details[0]['appfees'] : 0;
                            $marksheet_fees = ($notification_details[0]['msfees'] != 0) ? $notification_details[0]['msfees'] : 0;
                            $provcertificate_fees = ($notification_details[0]['pcfees'] != 0) ? $notification_details[0]['pcfees'] : 0;
                            $dissertation_fees = ($notification_details[0]['disfees'] != 0) ? $notification_details[0]['disfees'] : 0;
                            $consolitedmarksheet_fees = ($notification_details[0]['cmfees'] != 0) ? $notification_details[0]['cmfees'] : 0;
                            $covacation_fees = ($notification_details[0]['covfees'] != 0) ? $notification_details[0]['covfees'] : 0;
                            $total_amount = intval($processing_fees) + intval($provcertificate_fees) + intval($consolitedmarksheet_fees) + intval($marksheet_fees) + intval($dissertation_fees) + intval($covacation_fees);

                            $exam_fees_ary = array();
                            $prac_fees_ary = array();
                            $exam_fees_inner = array();
                            $prac_fees_inner = array();
                            /*               $exam_fees_inner['exam_fee_val_count'] = 500; */

                            /* var_dump($notification_details);
                            if(in_array(500, $exam_fees_inner)){
                                echo 'true';
                            }else{
                                echo 'false';
                            }
 */



                            foreach ($notification_details as $key => $notification) {
                                $course_code =  $notification['course_code'];
                                $paper_fees =  $notification['paper_fees'];

                                if (strpos($course_code, 'CT') !== false) {
                                    if (in_array($notification['paper_fees'], $exam_fees_inner)) {
                                        $ary_key = array_search_inner($exam_fees_ary, 'exam_fee_val', $paper_fees);
                                        if (isset($exam_fees_ary[$ary_key])) {
                                            $exam_fees_ary[$ary_key]['exam_fee_val'] = $notification['paper_fees'];
                                            $exam_fees_ary[$ary_key]['exam_fee_val_count'] += 1;
                                        } else {
                                            echo 'c - ' . $key . '<br>';
                                            $exam_fees_inner['exam_fee_val'] = $notification['paper_fees'];
                                            $exam_fees_inner['exam_fee_val_count'] = 1;
                                            array_push($exam_fees_ary, $exam_fees_inner);
                                        }
                                    } else {
                                        $ary_key = array_search_inner($exam_fees_ary, 'exam_fee_val', $paper_fees);
                                        if (isset($exam_fees_ary[$ary_key])) {
                                            $exam_fees_ary[$ary_key]['exam_fee_val'] = $notification['paper_fees'];
                                            $exam_fees_ary[$ary_key]['exam_fee_val_count'] += 1;
                                        } else {
                                            $exam_fees_inner['exam_fee_val'] = $notification['paper_fees'];
                                            $exam_fees_inner['exam_fee_val_count'] = 1;
                                            array_push($exam_fees_ary, $exam_fees_inner);
                                        }
                                    }
                                } else {
                                    if (in_array($notification['paper_fees'], $prac_fees_inner)) {
                                        $ary_key = array_search_inner($prac_fees_ary, 'prac_fee_val', $paper_fees);
                                        if (isset($prac_fees_ary[$ary_key])) {
                                            $prac_fees_ary[$ary_key]['prac_fee_val'] = $notification['paper_fees'];
                                            $prac_fees_ary[$ary_key]['prac_fee_val_count'] += 1;
                                            //array_push($prac_fees_ary, $exam_fees_inner);
                                        } else {
                                            $prac_fees_inner['prac_fee_val'] = $notification['paper_fees'];
                                            $prac_fees_inner['prac_fee_val_count'] = 1;
                                            array_push($prac_fees_ary, $prac_fees_inner);
                                        }
                                    } else {

                                        $ary_key = array_search_inner($prac_fees_ary, 'prac_fee_val', $paper_fees);
                                        if (isset($prac_fees_ary[$ary_key])) {
                                            $prac_fees_ary[$ary_key]['prac_fee_val'] = $notification['paper_fees'];
                                            $prac_fees_ary[$ary_key]['prac_fee_val_count'] += 1;
                                        } else {
                                            $prac_fees_inner['prac_fee_val'] = $notification['paper_fees'];
                                            $prac_fees_inner['prac_fee_val_count'] = 1;
                                            array_push($prac_fees_ary, $prac_fees_inner);
                                        }
                                    }
                                }
                            }
                            // var_dump($exam_fees_ary);
                            // var_dump($prac_fees_ary);




                            ?>
                            <thead>
                                <tr>
                                    <th class="text-center">Fee Particulars</th>
                                    <th class="text-center">Amount (Rs.)</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>Examination Fee
                                        <span class="rsmulcont">
                                            <?php
                                            $exam_feestotal = array();
                                            foreach ($exam_fees_ary as $exam_fees) {
                                                array_push($exam_feestotal, intval($exam_fees['exam_fee_val']) * $exam_fees['exam_fee_val_count']);
                                            ?>
                                                <span>( Rs . <?= $exam_fees['exam_fee_val'] ?> x <?= $exam_fees['exam_fee_val_count'] ?> )</span><br>
                                            <?php
                                            }
                                            ?>
                                        </span>
                                    </td>
                                    <td class="txtrght"><?= moneyFormatIndia(array_sum($exam_feestotal)) ?></td>

                                </tr>
                                <tr>
                                    <td>Practical Fees
                                        <span class="rsmulcont">
                                            <?php
                                            $prac_feestotal = array();
                                            foreach ($prac_fees_ary as $prac_fees) {
                                                array_push($prac_feestotal, intval($prac_fees['prac_fee_val']) * $prac_fees['prac_fee_val_count']);
                                            ?>
                                                <span>( Rs . <?= $prac_fees['prac_fee_val'] ?> x <?= $prac_fees['prac_fee_val_count'] ?> )</span><br>
                                            <?php
                                            }
                                            ?>
                                        </span>
                                    </td>
                                    <td class="txtrght"><?= moneyFormatIndia(array_sum($prac_feestotal)) ?></td>
                                </tr>

                                <?php
                                if ($provcertificate_fees != 0) {
                                ?>
                                    <tr>
                                        <td>Provisional Certificate Fees</td>
                                        <td><?= $provcertificate_fees; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <?php
                                if ($processing_fees != 0) {
                                ?>
                                    <tr>
                                        <td>Application Fees</td>
                                        <td class="txtrght"><?= moneyFormatIndia($processing_fees); ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <?php
                                if ($marksheet_fees != 0) {
                                ?>
                                    <tr>
                                        <td>Marksheet Fees</td>
                                        <td class="txtrght"><?= moneyFormatIndia($marksheet_fees); ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <?php
                                if ($dissertation_fees != 0) {
                                ?>
                                    <tr>
                                        <td>Dissertation Fees</td>
                                        <td class="txtrght"><?= moneyFormatIndia($dissertation_fees); ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <?php
                                if ($covacation_fees != 0) {
                                ?>
                                    <tr>
                                        <td>Consolidated Fees</td>
                                        <td class="txtrght"><?= moneyFormatIndia($covacation_fees); ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <?php
                                if ($consolitedmarksheet_fees != 0) {
                                ?>
                                    <tr>
                                        <td>Convacation Fees</td>
                                        <td class="txtrght"><?= moneyFormatIndia($consolitedmarksheet_fees); ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><b class="pull-right">TOTAL</b></td>
                                    <td class="txtrght"><?= moneyFormatIndia($total_amount + array_sum($exam_feestotal) + array_sum($prac_feestotal)); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="recnotesec">
                        <h5 class="notehead">NOTE: </h5>
                        <p class="notetxt">1) The student will be permitted to appear for the examination, subject to fulfilment of eligibility criteria</p>
                        <p class="notetxt">2) The candidate is advised to represent through HOD / Course Chairperson / Principal / Dean, if any discrepancy is found in the particulars furnished in this form.</p>
                        <p class="notetxt">3) Contact Student section / Accounts section for any further clarificatio</p>
                        <h5 class="inshead text-center">Instructions regarding fee remittance through RTGS / NEFT mode</h5>
                        <p class="inssubhead"><u>Details to be filled in the remittance challan:</u> </p>
                        <table class="table table-bordered recnotetbl">
                            <thead>
                                <tr>
                                    <th>Beneficiary Name</th>
                                    <th class="descclr">SRI RAMACHANDRA INSTITUTE OF HIGHER EDUCATION AND RESEARCH - <?= (!empty($student_data['student_name'])) ? $student_data['student_name'] : ''  ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Beneficiary Account No.</td>
                                    <td class="descclr">SRUA0219034</td>
                                </tr>
                                <tr>
                                    <td>IFS code to be used for remittance </td>
                                    <td class="descclr">CIUB0000300</td>
                                </tr>
                                <tr>
                                    <td>Bank Name</td>
                                    <td class="descclr">CITY UNION BANK</td>
                                </tr>
                                <tr>
                                    <td>Branch</td>
                                    <td class="descclr">AYYAPPANTHANGAL, CHENNAI - 600 056</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    <?php } else {
    ?>
        <h4>No Data Available</h4>
    <?php
    }
    ?>
</div>
<script type="text/javascript">
    var button = document.getElementById("buttonpdfdownload");
    var makepdf = document.getElementById("makepdf");
    button.addEventListener("click", function() {
        html2pdf().set({
            html2canvas: {
                scale: 4
            }
        }).from(makepdf).save("<?= $pdfname ?>");
    });
</script>