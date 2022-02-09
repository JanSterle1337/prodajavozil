function showReplies(komenterID,nestedLvl) {

   /* let replyDivs = document.getElem */
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