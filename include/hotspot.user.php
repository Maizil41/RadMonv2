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

        if (isMacAddress($username)) {
            continue;
        }

        $name = htmlspecialchars($row['contactperson']);
        $usermac = htmlspecialchars($row['mac_address']);
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
                <input type='checkbox' class='delete-checkbox' value='" . htmlspecialchars($username) . "'>&nbsp;&nbsp;
                <span class='fa fa-trash text-danger pointer' onclick=\"deleteUser('" . htmlspecialchars($username) . "')\"></span>&nbsp;&nbsp;
                <span class='fa fa-refresh text-warning pointer' onclick=\"resetuser('" . htmlspecialchars($username) . "')\"></span>
            </td>
            <td><center>
                <select class='group-item-m dropd pd-2' id='selectPrinter" . $row['username'] . "'>
                    <option value='printTickets1.php'>1</option>
                    <option value='printTickets2.php'>2</option>
                    <option value='printTickets3.php'>3</option>
                    <option value='printTickets4.php'>4</option>
                </select>
                <span class='fa fa-qrcode pointer' style='cursor:pointer;' onclick=\"printTicket('" . $row['username'] . "', '" . $row['planName'] . "')\"></span>
              </center></td>
            <td><center>$name</td>
            <td><center>$username</td>
            <td><center>$usermac</td>
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
        <tr><td colspan='11'><center>Tidak ada data</center></td></tr>";
}
echo "<script>function printTicket(username,planName){var selectElement=document.getElementById('selectPrinter'+username);var selectedPrinter=selectElement.value;var url='../voucher/'+selectedPrinter+'?type=batch&plan='+encodeURIComponent(planName)+'&accounts=Username,Password||'+encodeURIComponent(username)+',Accept';var newWindow=window.open(url,'_blank','width=800,height=600,scrollbars=yes');newWindow.onload=function(){newWindow.print()}}</script>";
echo "<script>document.getElementById('deleteSelected').addEventListener('click',function(){const checkboxes=document.querySelectorAll('.delete-checkbox:checked');const selectedUsers=Array.from(checkboxes).map(checkbox=>checkbox.value);if(selectedUsers.length===0){alert('Tidak ada pengguna yang dipilih.');return}
if(confirm('Apakah Anda yakin ingin menghapus pengguna yang dipilih?')){fetch('../backend/delete_selected.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({users:selectedUsers})}).then(response=>response.json()).then(data=>{if(data.success){location.reload()}else{alert('Gagal menghapus pengguna.')}}).catch(error=>console.error('Error:',error))}});</script>";
echo "<script>document.getElementById('checkAll').addEventListener('change',function(){const checkboxes=document.querySelectorAll('.delete-checkbox');const isChecked=this.checked;checkboxes.forEach(checkbox=>{checkbox.checked=isChecked})});</script>";
?>