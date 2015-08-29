function checkLoginInDB(login) {
    var ajaxRequest;  // The variable that makes Ajax possible!

    try{
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    }catch (e){
        // Internet Explorer Browsers
        try{
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        }catch (e) {
            try{
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            }catch (e){
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }

    // Create a function that will receive data
    // sent from the server and will update
    // div section in the same page.
    ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
            var jsonObj = JSON.parse(ajaxRequest.responseText);
            var flagResult = jsonObj.status;
            var message = jsonObj.msg;

            var tag = document.getElementById('checkLogin');
            tag.innerHTML = message;

            if(flagResult) {
                tag.style.color = "green";

            } else {
                tag.style.color = "red";
                var loginTextTag = document.getElementById('loginValue');
                loginTextTag.value = '';

            }
            tag.style.fontSize = "10pt";

        }
    }

    var queryString = "?login=" + login;
    ajaxRequest.open("GET", "checkLogin.php" + queryString, true);
    ajaxRequest.send(null);
}