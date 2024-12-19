/**
 * Radius Monitor Check Ping
 * Author : Maizil <https://github.com/maizil41>
 */
window.onload=function(){const host='google.com';const resultDiv=document.getElementById('result');resultDiv.innerHTML='Check Ping...';fetch(`../backend/check_ping.php?host=${host}`) .then(response=>response.json()) .then(data=>{const packetLoss=data.packetLoss;const avgTime=data.avgTime;resultDiv.innerHTML=` Host : ${host}<br>Packet Loss : ${packetLoss}%<br>Respond : ${avgTime}ms `}) .catch(error=>{resultDiv.innerHTML='Ping failed.'})};