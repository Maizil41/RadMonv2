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
        $clientName =  htmlspecialchars($row['contactperson']);
        $username = htmlspecialchars($row['username']);
        $password = htmlspecialchars($row['Password']);
        $ipAddress = htmlspecialchars($row['Framed_IP_Address']);
        $macAddress = htmlspecialchars($row['callingstationid']);
        $profile = htmlspecialchars($row['groupname']);
        $cost = htmlspecialchars(money($row['planCost']));
        $usage = htmlspecialchars(time2str($row['total_acctsessiontime']));
        $traffic = htmlspecialchars(toxbyte($row['total_acctinputoctets'] + $row['total_acctoutputoctets']));
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

        echo "<tr>
                <td><center>
                <span class='fa fa-trash text-danger pointer' onclick=\"deleteUser('" . htmlspecialchars($username) . "')\"></span>&nbsp;&nbsp;
                <span class='fa fa-refresh text-warning pointer' onclick=\"resetuser('" . htmlspecialchars($username) . "')\"></span>
                </td>
                <td><center>$clientName</td>
                <td><center>$username</td>
                <td><center>$password</td>
                <td><center>$ipAddress</td>
                <td><center>$macAddress</td>
                <td><center>$profile</td>
                <td><center>$cost</td>
                <td><center>$usage</td>
                <td><center>$traffic</td>
                <td><center><span class='$statusClass' title='$title'> $title</span></td>
              </tr>";
    }

} else {
    echo "<tr><td colspan='11'><center>Tidak ada data</center></td></tr>";
}

echo "</tbody></table></div>";

$conn->close();
?>