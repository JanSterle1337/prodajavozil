
showPhotos(1);


function showPhotos(pht) {
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200){
            let data = JSON.parse(this.responseText);
            console.log("neki");
            console.log("neki " + data);
        }
    }
}

function displayPhotos(data) {
    let galleryWrapper = document.getElementById("gallery-wrap");
    console.log(galleryWrapper);
}