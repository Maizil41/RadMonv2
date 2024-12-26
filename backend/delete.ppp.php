<?php
/*
*******************************************************************************************************************
* Warning!!!, Tidak untuk diperjual belikan!, Cukup pakai sendiri atau share kepada orang lain secara gratis
*******************************************************************************************************************
* Author : @Maizil https://t.me/maizil41
*******************************************************************************************************************
* © 2024 Mutiara-Net By @Maizil
*******************************************************************************************************************
*/
require_once '../config/mysqli_db.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $user = mysqli_real_escape_string($conn, $_GET['id']);
    
    # $sqlIp = "SELECT value FROM radreply WHERE username = '$user' AND attribute = 'Framed-IP-Address' LIMIT 1";
    # $resultIp = mysqli_query($conn, $sqlIp);
    # if ($resultIp && mysqli_num_rows($resultIp) > 0) {
    #     $rowIp = mysqli_fetch_assoc($resultIp);
    #     $ip_address = $rowIp['value'];
    # }
    
    # $iprange = $ip_address . "-" . $ip_address;

    # $sqlBw = "SELECT 
    #             rbg.groupname,
    #             bw.rate_up,
    #             bw.rate_down
    #         FROM 
    #             radusergroup rbg
    #         JOIN 
    #             radgroupbw rgb ON rbg.groupname = rgb.groupname
    #         JOIN 
    #             bandwidth bw ON rgb.bw_id = bw.id
    #         WHERE 
    #             rbg.username = '$user';
    #         ";
    # $resultBw = mysqli_query($conn, $sqlBw);
    # if ($resultBw && mysqli_num_rows($resultBw) > 0) {
    #     $rowBw = mysqli_fetch_assoc($resultBw);
    #     $rate_up = $rowBw['rate_up'];
    #     $rate_down = $rowBw['rate_down'];
    # }

    # $dspeed = number_format(($rate_down / 1048576) * 125) . "kb/s";
    # $uspeed = number_format(($rate_up / 1048576) * 125) . "kb/s";

    # @shell_exec("iptables -D FORWARD -m iprange --dst-range $iprange -m hashlimit --hashlimit-above $dspeed --hashlimit-mode dstip --hashlimit-name $user -j DROP -m comment --comment $user");
    # @shell_exec("iptables -D FORWARD -m iprange --src-range $iprange -m hashlimit --hashlimit-above $uspeed --hashlimit-mode srcip --hashlimit-name $user -j DROP -m comment --comment $user");
    
    $sqlDeleteRadacct = "DELETE FROM radacct WHERE username = '$user'";
    $sqlDeleteRadcheck = "DELETE FROM radcheck WHERE username = '$user'";
    $sqlDeleteRadreply = "DELETE FROM radreply WHERE username = '$user'";
    $sqlDeleteUserBillInfo = "DELETE FROM userbillinfo WHERE username = '$user'";
    $sqlDeleteUserUserinfo = "DELETE FROM userinfo WHERE username = '$user'";
    $sqlDeleteUserRadusergroup = "DELETE FROM radusergroup WHERE username = '$user'";

    @mysqli_query($conn, $sqlDeleteRadacct);
    @mysqli_query($conn, $sqlDeleteRadcheck);
    @mysqli_query($conn, $sqlDeleteRadreply);
    @mysqli_query($conn, $sqlDeleteUserBillInfo);
    @mysqli_query($conn, $sqlDeleteUserUserinfo);
    @mysqli_query($conn, $sqlDeleteUserRadusergroup);
}

exit;
?>
