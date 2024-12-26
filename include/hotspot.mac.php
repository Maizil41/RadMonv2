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
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $username = htmlspecialchars($row['username']);

        $name = htmlspecialchars($row['user_alias']);
        $ip = htmlspecialchars($row['ip_address']);
        $cost = htmlspecialchars(money($row['planCost']));
        $plan = htmlspecialchars($row['planName']);
        $group = htmlspecialchars($row['groupname']);
        $totalTime = htmlspecialchars(time2str($row['total_session_time']));
        $traffic = htmlspecialchars(toxbyte($row['total_input_octets'] + $row['total_output_octets']));
        $status = htmlspecialchars($row['status']);

        $statusClass = '';
        switch (true) {
            case strpos($status, 'ONLINE') !== false:
                $statusClass = 'fa fa-check-circle text-success';
                $title = 'Online';
                break;
            case strpos($status, 'EXPIRED') !== false:
                $statusClass = 'fa fa-ban text-danger';
                $title = 'Expired';
                break;
            case strpos($status, 'OFFLINE') !== false:
                $statusClass = 'fa fa-times-circle text-secondary';
                $title = 'Offline';
                break;
        }

        echo"
            <td><center>
                <span class='fa fa-trash text-danger pointer' onclick=\"deleteUser('" . htmlspecialchars($username) . "')\"></span>&nbsp;&nbsp;
                <span class='fa fa-refresh text-warning pointer' onclick=\"resetuser('" . htmlspecialchars($username) . "')\"></span>
            </td>
            <td><center>$name</td>
            <td><center>$username</td>
            <td><center>$ip</td>
            <td><center>$cost</td>
            <td><center>$plan</td>
            <td><center>$totalTime</td>
            <td><center>$traffic</td>
            <td><center><span class='$statusClass' title='$title'> $title</span></td>
        </tr>";
    }
} else {
    echo "
        <tr><td colspan='9'><center>Tidak ada data</center></td></tr>";
}
?>