<table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
    <tbody>
        <tr>
            <td>
                <img src="<?= base_url('admin_assets') ?>/dist/img/logo.jpg">
            </td>
        </tr>
        <tr>
            <td height="1" style="background:#ccc;line-height:1px;font-size:1px">&nbsp;</td>
        </tr>
        <tr>
            <td style="background:#f8f7f5">
                <table width="450" border="0" cellspacing="0" cellpadding="0" align="center">
                    <tbody>
                        <tr>
                            <td width="200">
                                <div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#333;padding:10px 0">Name</div>
                            </td>
                            <td width="250">
                                <div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#333;padding:10px 0"><?= $student_name; ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#333;padding:10px 0">Email</div>
                            </td>
                            <td>
                                <div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#333;padding:10px 0">
                                    <?= $user_mail; ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#333;padding:10px 0">Registration Number</div>
                            </td>
                            <td>
                                <div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#333;padding:10px 0">
                                    <?= $student_barcode; ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#333;padding:10px 0">Course </div>
                            </td>
                            <td>
                                <div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#333;padding:10px 0">
                                    <?= $course_name; ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#333;padding:10px 0">LOGIN URL</div>
                            </td>
                            <td>
                                <div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#333;padding:10px 0">
                                    <a href="<?= $url ?>" target="_blank" >Click here View Details</a>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td height="1" style="background:#ccc;line-height:1px;font-size:1px">&nbsp;</td>
        </tr>
        <tr>
            <td style="background:#f8f7f5">
                <a href="https://www.sriramachandra.edu.in/" target="_blank" >sriramachandra.edu.in</a>                
            </td>
        </tr>
    </tbody>
</table>