/**
 * Radius Monitor Active PPPPoE
 * Author : Maizil <https://github.com/maizil41>
 */
$(document).ready(function(){function loadActiveUsers(){$.getJSON("../backend/ppp.active.php",function(data){var usersHtml="";$("#total-users").text(data.total_users);if(data.users.length===0){usersHtml="<tr><td colspan='11'><center>Tidak ada data</center></td></tr>"}else{$.each(data.users,function(index,user){var row="<tr>"+"<td><center>"+user.clientName+"</center></td>"+"<td><center>"+user.username+"</center></td>"+"<td><center>"+user.password+"</center></td>"+"<td><center>"+user.ip+"</center></td>"+"<td><center>"+user.mac+"</center></td>"+"<td><center>"+user.plan+"</center></td>"+"<td><center>"+user.uptime+"</center></td>"+"<td><center>"+user.totalTime+"</center></td>"+"<td><center>"+user.upload+"</center></td>"+"<td><center>"+user.download+"</center></td>"+"<td><center>"+user.traffic+"</center></td>"+"</tr>";usersHtml+=row})}
$("#tFilter tbody").html(usersHtml);$(".main-container").show();$("#loading").hide()}).fail(function(){console.error("Error loading active users data.")})}
loadActiveUsers();setInterval(loadActiveUsers,5000)})