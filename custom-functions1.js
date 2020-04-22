function comparenames() {
    var empt = document.forms["form1"]["host_name"].value;
    var empt1 = document.forms["form1"]["guest_name"].value;
    

    if (empt == empt1)
    {
        alert("Host and Guest names cannot match!");
        return false;
    }
   
}