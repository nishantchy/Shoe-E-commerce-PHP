const btn = document.getElementById('sub');
function validation(){
    const fname = document.getElementById('fname').value;
    const lname = document.getElementById('lname').value;
    const email = document.getElementById('email').value;
    const pass = document.getElementById('pass').value;
    const cpass = document.getElementById('cpass').value;
    const para = document.getElementById('para');

    if(fname==""){
    alert("Please enter your first name");
    return false;
    }
    else if(lname==""){
    alert("Please enter your last name");
    return false;
    }
    else if(pass==""){
    alert("Please enter your password");
    return false;
    }
    else if(pass.length<8){
    alert("Atleast 8 character are required");
    return false; 
   }
   else if(pass !== cpass){
    alert("Passwords do not match");
    return false;
   }
   var mailformat = /^\w+([\.]?\w+)*@\w+([\.]?\w+)*(\.\w{2,3})+$/;
    if(!email.match(mailformat)){
    alert('Invalid email format');
    return false;
    }
    else if(email=""){
    alert("Please enter your email");
    return false;
    }
    else{
        // document.write();
        alert(fname);
        return true;
    }
} 
btn.onclick = () => validation();