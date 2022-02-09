/*function showReplies(komenterID,nestedLvl) {

    let replyDivs = document.getElem 
        console.log("showReplies");
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("reply" + komenterID).innerHTML = this.responseText;
                console.log(this.responseText);
            } else {
                console.log("Neki ne dela");
            }
        }
        xmlhttp.open("GET", "../logic/pridobiOdgovore.php?komentarID="+komenterID+"&nestedLvl="+nestedLvl,true);
        xmlhttp.send();
} 

function showReplyReplies(komentarID,nestedLvl,odgovorjenID) {
    
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let replyDiv = document.createElement("div");
            let random = Math.floor(Math.random() * (1000 - 100) + 100);
            replyDiv.id = "reply" + random;

            let reply = document.getElementsByClassName("reply")[0];
            reply.appendChild(replyDiv);
            document.getElementById(replyDiv.id).innerHTML = this.responseText;
            console.log(this.responseText);
        } else {
            console.log("Neki ne dela");
        }
    }
    xmlhttp.open("GET", "../logic/pridobiOdgovore.php?komentarID="+komentarID+"&nestedLvl="+nestedLvl+"&odgovorjenID="+odgovorjenID,true);
    xmlhttp.send();
}
*/

function showReplies(komentarID,nestedLvl) {

   
    console.log("Dela");
    let concatenatedString = "komentar" + komentarID;
    
    let replyWrapper = document.createElement("div");       //naredim wrapper za vse replie pod specificnim commentom
    replyWrapper.id="replies-wrapper"+komentarID;
    
    let specificComment = document.getElementById(concatenatedString);
    specificComment.appendChild(replyWrapper); 

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("replies-wrapper" + komentarID).innerHTML = this.responseText;
            console.log(this.responseText);
        } else {
            console.log("Neki ne dela");
        }
    }

    xmlhttp.open("GET", "../logic/pridobiOdgovore.php?komentarID="+komentarID+"&nestedLvl="+nestedLvl,true);
    xmlhttp.send();
}

function showReplyReplies(komentarID,nestedLvl,odgovorjenID) {
    console.log("Pod reply funkcija laufa");

    let concatenatedString = "reply" + odgovorjenID;

    let replyWrapper = document.createElement("div");
    replyWrapper.id = "replies-wrapper"+odgovorjenID+"nest"+nestedLvl;
    let specificReply = document.getElementById(concatenatedString);
    console.log(specificReply);
    specificReply.appendChild(replyWrapper);

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("replies-wrapper" + odgovorjenID+"nest"+nestedLvl).innerHTML = this.responseText;
           
        } else {
            
        }
    }

    xmlhttp.open("GET", "../logic/pridobiOdgovore.php?komentarID="+komentarID+"&nestedLvl="+nestedLvl+"&odgovorjenID="+odgovorjenID,true);
    xmlhttp.send();
}