function comparepwd()
{
var empt = document.forms["form1"]["pwd"].value;
var empt1 = document.forms["form1"]["pwd-repeat"].value;

if (empt != empt1)
{
alert("Passwords do not match!!");
return false;
}
}