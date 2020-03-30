window.onload = function() {
// Onload event of Javascript
// Initializing timer variable
var x = 3;
var y = document.getElementById("timer");
// Display count down for 20s
setInterval(function() {
if (x <= 4 && x >= 1) {
x--;
// y.innerHTML = '' + x + '';
 y.innerHTML = x ;  
if (x == 1) {
x = 4;
}
}
}, 1000);
// Form Submitting after 20s
var auto_refresh = setInterval(function() {
submitform();
}, 3000);
// Form submit function
function submitform() {
//alert('Form is submitting.....');
document.getElementById("form1").submit();
}
}    