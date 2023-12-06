// JavaScript Document
function login_user(){
document.getElementById('errordiv').innerHTML ="<img src='loader/wheel.gif' style='height:60px' />";
var email = document.getElementById('email').value;
if(email=='')
{
document.getElementById('email').style.border="1px solid red";
document.getElementById('email').focus();
return false;
}
document.getElementById('email').style.border="1px solid green";
var password = document.getElementById('password').value;
if(password=='')
{
document.getElementById('password').style.border="1px solid red";
document.getElementById('password').focus();
return false;
}	
document.getElementById('password').style.border="1px solid green";

$.post("login/login.php",{email:email,password:password},function(data){
$("#errordiv").html(data);});
}