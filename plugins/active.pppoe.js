/**
 * Radius Monitor Active PPPPoE
 * Made by Maizil <https://github.com/maizil41>
 */
$(document).ready(function(){function loadActiveUsers(){$.getJSON("../backend/ppp.active.php",function(data){var usersHtml="";$("#total-users").text(data.total_users);$.each(data.users,function(index,user){var row="<tr>"+"<td><center>"+user.clientName+"</td>"+"<td><center>"+user.username+"</td>"+"<td><center>"+user.password+"</td>"+"<td><center>"+user.ip+"</td>"+"<td><center>"+user.mac+"</td>"+"<td><center>"+user.plan+"</td>"+"<td><center>"+user.uptime+"</td>"+"<td><center>"+user.totalTime+"</td>"+"<td><center>"+user.upload+"</td>"+"<td><center>"+user.download+"</td>"+"<td><center>"+user.traffic+"</td>"+"</tr>";usersHtml+=row});$("#tFilter tbody").html(usersHtml);$(".main-container").show();$("#loading").hide()}).fail(function(){console.error("Error loading active users data.")})}
loadActiveUsers();setInterval(loadActiveUsers,5000)})