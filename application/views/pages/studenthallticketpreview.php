<?php
$CI = &get_instance();
$CI->load->model('receipt_model');
$CI->load->library('usersupport');
?>
<style>
    .tblcus {
        font-size: 12px !important;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

<div id="makepdf" class="p-4 container">


    <div class="justify-content-center border-bottom">
        <?php
        $pdfname = 'HT-' . $hallticket_details[0]['student_barcode'] . '-' . preg_replace('/\s+/', '', $hallticket_details[0]['mysession']);
        ?>
        <h5 class="text-center">Hall Ticket - <?= $hallticket_details[0]['fullmonthyear'] ?> </h5>


    </div>
    <div class="row">
        <div class="col-7 tblcus">
            <div class="row mb-0">
                <label class="col-sm-4 col-form-label pb-1" style="max-width:180px"><b>Candidate's Name</b></label>
                <p class="col-sm-6 col-form-label pb-1"> : &nbsp;&nbsp;&nbsp;<?= $hallticket_details[0]['student_name'] ?></p>

            </div>
            <div class="row mb-0">
                <label class="col-sm-4 col-form-label pb-2 pt-1 lh-1"><b>Semester / Year </b></label>
                <p class="col-sm-4 col-form-label pb-2 pt-1 lh-1"></p>

            </div>
            <div class="row mb-0">
                <label class="col-sm-4 col-form-label pb-2  pt-1 lh-1"><b>Programme </b></label>
                <p class="col-sm-4 col-form-label pb-2  pt-1 lh-1"> : &nbsp;&nbsp;&nbsp;<?= $hallticket_details[0]['halltcketcourse_name'] ?></p>
            </div>
        </div>
        <div class="col-5 tblcus">
            <div class="row mb-0">
                <label class="col-sm-4 col-form-label pb-1"><b>Regn No : </b></label>
                <p class="col-sm-4 col-form-label pb-1"> : &nbsp;&nbsp;&nbsp;<?= $hallticket_details[0]['student_barcode'] ?></p>
            </div>
            <div class="row mb-0">
                <label class="col-sm-4 col-form-label pb-2  pt-1 lh-1"><b>Date of Birth </b></label>
                <p class="col-sm-4 col-form-label pb-2 pt-1 lh-1"> : &nbsp;&nbsp;&nbsp;<?= date('d-m-Y', strtotime($hallticket_details[0]['dob'])); ?></p>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <table class="table table-bordered tblcus">
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
                        <td><?= $value['halltcketcourse_name'] ?></td>
                        <td class="text-center"><?= date('d-m-Y', strtotime($value['examdate'])); ?></td>
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
        <div class="col-11">
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
                    <img src="<?= base_url('admin_assets') ?>/inc/images/coe-signature.png" class="img-fluid pt-2 mt-2 mb-3" style="max-width:200px" />
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
<div class="d-flex justify-content-center">
    <a href="javascript:void(0)" id="buttonpdfdownload" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download PDF</a>
</div>

<script>
    var button = document.getElementById("buttonpdfdownload");
    var makepdf = document.getElementById("makepdf");
    button.addEventListener("click", function() {
        html2pdf().set({
            html2canvas: {
                scale: 4
            }
        }).from(makepdf).save('<?= $pdfname; ?>');
    });
</script>