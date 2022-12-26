<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<?php
$CI = &get_instance();
$CI->load->model('receipt_model');
$CI->load->library('usersupport');
?>
<?php
if (isset($hallticket_details_ary[0][0]['hall_ticket_preview_status'])) {
    if ($hallticket_details_ary[0][0]['hall_ticket_preview_status'] == '1') {
?>
        <div class="container">
            <br>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <?php
                $i = 1;
                foreach ($user_session_details as $session_details) {
                    $session_details =  preg_replace('/\s+/', '', $session_details);
                ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?= ($i == '1') ? 'active' : '' ?>" id="<?= $session_details; ?>" data-bs-toggle="tab" data-bs-target="#<?= $session_details; ?>-pane" type="button" role="tab" aria-controls="<?= $session_details; ?>-pane" aria-selected="true"><?= $session_details; ?></button>
                    </li>
                <?php
                    $i++;
                }
                ?>



            </ul>
            <div class="tab-content" id="myTabContent">
                <?php
                $j = 1;
                foreach ($hallticket_details_ary as $hallticket_details) {
                    $mysession = preg_replace('/\s+/', '', $hallticket_details[0]['mysession']);
                ?>
                    <div class="tab-pane fade <?= ($j == '1') ? 'show active' : '' ?>" id="<?= $mysession  ?>-pane" role="tabpanel" aria-labelledby="<?= $mysession  ?>-tab" tabindex="0">
                        <h5 class="mt-3"><b><u>Hall Ticket Details</u></b></h5>

                        <div id="makepdf" class="p-2 container">
                            <div class="justify-content-center border-bottom">
                                <?php
                                $user_det = $hallticket_details[0]['student_id'] . '$' . $hallticket_details[0]['mysession'];
                                $enc = $this->usersupport->encrypt_decrypt('encrypt', $user_det);
                                ?>
                                <h5 class="text-center">Hall Ticket - <?= $hallticket_details[0]['fullmonthyear'] ?> <a href="<?= base_url('hallticketpreview') ?>/<?= $enc ?>" target="_blank" style="float:right;"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Preview PDF</a></h5>


                            </div>
                            <div class="row">
                                <div class="col-7">
                                    <div class="row mb-0">
                                        <label class="col-sm-4 col-form-label pb-1">Candidate's Name</label>
                                        <p class="col-sm-4 col-form-label pb-1"> : <?= $hallticket_details[0]['student_name'] ?></p>
                                    </div>
                                    <div class="row mb-0">
                                        <label class="col-sm-4 col-form-label pb-2 pt-1 lh-1">Semester / Year </label>
                                        <p class="col-sm-4 col-form-label pb-2 pt-1 lh-1"> : <?= $hallticket_details[0]['yearsempart'] ?></p>

                                    </div>
                                    <div class="row mb-0">
                                        <label class="col-sm-4 col-form-label pb-2  pt-1 lh-1">Programme </label>
                                        <p class="col-sm-4 col-form-label pb-2  pt-1 lh-1"> : <?= $hallticket_details[0]['halltcketcourse_name'] ?></p>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="row mb-0">
                                        <label class="col-sm-4 col-form-label pb-1">Regn No : </label>
                                        <p class="col-sm-4 col-form-label pb-1"> : <?= $hallticket_details[0]['student_barcode'] ?></p>
                                    </div>
                                    <div class="row mb-0">
                                        <label class="col-sm-4 col-form-label pb-2  pt-1 lh-1">Date of Birth </label>
                                        <p class="col-sm-4 col-form-label pb-2 pt-1 lh-1"> : <?= date('d-m-Y', strtotime($hallticket_details[0]['dob'])); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Sem/Year</th>
                                            <th class="text-center">Sub-Code</th>
                                            <th class="text-center">Course</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Exam Time</th>
                                            <th class="text-center">Candidate's Signature </th>
                                            <th class="text-center">Hall Supdt. Signature</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($hallticket_details as $key => $value) {
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $value['yearsempart'] ?></td>
                                                <td class="text-center"><?= $value['course_code'] ?></td>
                                                <td class="text-center"><?= $value['halltcketcourse_name'] ?></td>
                                                <td class="text-center"><?= $value['examdate'] ?></td>
                                                <td class="text-center"><?= $value['examtime'] ?></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                            <div class="row border-bottom">
                                <div class="col-1" style="font-size: 12px; max-width: 70px;">
                                    <b>Notes : </b>
                                </div>
                                <div class="col-10">
                                    <ol class="cuslst p-0" style="font-size: 12px; font-weight: bold;">
                                        <li>The candidate shall take a printout of both pages of the hall ticket on white A4 sheet (front and back). </li>
                                        <li>This same printout of hallticket has to be used for the entire session. </li>
                                        <li>Only candidates in possession of the hall ticket and the identity card will be allowed entry into the examination hall. </li>
                                        <li>Read and strictly adhere to the instructions printed overleaf. </li>
                                        <li>Students shall follow the dress code of the university during all examinations.</li>
                                    </ol>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="row mb-0">
                                        <label class="col-sm-1 col-form-label pb-1">Date</label>
                                        <p class="col-sm-4 col-form-label pb-1"> : <?= date('d-m-Y') ?></p>
                                    </div>
                                    <div class="row mb-0">
                                        <div class="col-sm-6 p-3 border border-2 border-dark" style="margin-left: 10px;">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row mb-0">
                                        <div class="float-end" style="max-width: 300px; text-align: center;margin-left: auto">
                                            <img src="<?= base_url('admin_assets') ?>/inc/images/coe-signature.png" class="img-fluid pt-2 mt-2 mb-3" />
                                            <p class=""> Controller of Examinations</p>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="instruction">
                                    <h5 class="text-center mb-3"><u>INSTRUCTIONS TO THE CANDIDATES</u></h5>
                                    <ol class="" style="font-size: 13px; text-align: justify; line-height: normal;">

                                        <li class="pb-1">Any discrepancy noticed in the hall ticket with regard to the name, subject(s) and date(s) for which the candidate is registered
                                            should be brought immediately to the notice of the Controller of Examinations through the respective
                                            Dean/Principal/Coordinator/Student service section .</li>
                                        <li class="pb-1">The candidate should ascertain the scheme of theory, practical/clinical and oral examinations. The candidate is advised to be
                                            present for the specified examination at least 10 minutes before the commencement of the examination. Examination hall
                                            doors will be closed 10 minutes prior to the examination start time. After that candidates will be permitted after the start of
                                            the examination only.</li>
                                        <li class="pb-1">No candidate will be allowed to enter the examination hall after 30 minutes of commencement of the examination. Similarly, no candidate shall be allowed to leave the examination hall before 30 minutes lapse, after the commencement of the
                                            examination.</li>
                                        <li class="pb-1">Over coats, shoe and socks are not permitted inside the theory examination hall and the candidate should adhere the
                                            University prescribed dress code compulsorily. </li>
                                        <li class="pb-1">The candidate shall maintain perfect silence in the examination hall .</li>
                                        <li class="pb-1">The candidate is required to bring his/her own pens, pencils, scales, erasers, etc., in a transparent pouch . Only blue or black ball point pen/ink pens should be used while answering. </li>
                                        <li class="pb-1"> The candidate should read carefully the instructions given in page numbers 1 and 2 of the answer booklet, MCQ OMR sheet,
                                            MCQ question booklet and question paper as the case may be, before recording the req uired particulars / before commencing
                                            to answer.</li>
                                        <li class="pb-1">The candidates should check themselves, before answering, whether they have received the correct question paper. If not,
                                            immediately he/she should stand up and get the correct question paper pertaining to t he subject and the course/regulation
                                            for which he/she is appearing on that day.</li>
                                        <li class="pb-1"> Before starting to answer the paper, the candidate should write his/her registration number, year/semester, Program, Course
                                            and date of the examination only at the appropriate space provided in the first page of the answer book and shade the relevant ovals wherever applicable. The registration number and name should not be written anywhere else in the answer
                                            book or in any additional book(s) attached.</li>
                                        <li class="pb-1"> Except the signatures of the candidate and hall superintendent, no other signature/writing is permitted in the hall ticket. The
                                            number of additional sheets used and the questions answered should be written and shaded in the front page of the answer
                                            book compulsorily.</li>
                                        <li class="pb-1"> If a candidate mentions his/her name, registration number on any part of the answer book/sheets other than the one
                                            provided for or indicates any special mark or writes anything which may disclose or give any clue in any way revealing the
                                            identity of the candidate, he/ she will render himself/herself liable for disciplinary action besides the answer sheets being summarily rejected.</li>
                                        <li class="pb-1"> The candidate shall not carry any written/printed matter, any paper material, electronic devices, cell phone, pen drive, ipad , programmable calculator, any unauthorized data sheet/table into the examination hall or any other material which is
                                            considered objectionable and if any such items are found in his/her possession at any time after entry into the examination
                                            hall, the candidate shall be liable for disciplinary action. There is no facility for safe keeping of these devices outside. The
                                            university will not take any responsibility if a candidate keeps any valuables inside/outside the examination hall.</li>
                                        <li class="pb-1"> No candidate shall gesture unnecessaril y or pass any part/whole of answer papers/question papers to any other candidate.
                                            No candidate shall allow another candidate to copy from his/her answer paper or copy from the answer paper of another
                                            candidate. If found committing such malpractice, the inv olved candidates shall be liable for disciplinary action.</li>
                                        <li class="pb-1"> The candidate found guilty of using unfair means of any nature shall be liable for disciplinary action as per the provisions of
                                            the University Examination Manual.</li>
                                        <li class="pb-1"> The candidate shall hand over the MCQ question book and OMR sheet on completion of the specified time. Similarly the
                                            candidate shall hand over the answer book(s) to the hall superintendent/chief superintendent before leaving the examination
                                            hall.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php
                    $j++;
                }
                ?>



            </div>






        </div>
    <?php
    } else {
    ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12 pt-5 pb-5">
                    <h4 class="text-center">No Data Availbale</h4>
                </div>
            </div>
        </div>
    <?php
    }
} else {
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12 pt-5 pb-5">
                <h4 class="text-center">No Data Availbale</h4>
            </div>
        </div>
    </div>
<?php
}
?>