function showthumbnailimg() {
    // Check file size
    var contestThumbnailSize = contestThumbnail.files.item(0).size;
    var contestThumbnailFile = Math.round((contestThumbnailSize / 1024));
    if (contestThumbnailFile >= 20480) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'The size of this image is too large, Please select image that is less than 20MB',
          })
    } else if (contestThumbnailFile >=0){
        newThumbnailPreview.src = URL.createObjectURL(event.target.files[0]);
        document.getElementById('divThumbnailPreview').style.display = "block";
        var imagename =document.getElementById('contestThumbnail').value
        window.tempimage = URL.createObjectURL(event.target.files[0]);
        document.getElementById('displayThumbnailLabel').innerHTML = "Filename : "+imagename.split("\\").pop();
        document.getElementById('displayThumbnailLabel').style.display = "inline-block";
    }}

function button1(){
    document.getElementById('aContestRequestButton2').style.backgroundColor = "white";
    document.getElementById('aContestRequestButton2').style.color = "black";
    document.getElementById('aContestRequestButton1').style.backgroundColor = "#5B3E38";
    document.getElementById('aContestRequestButton1').style.color = "white";
    // contest page view
    document.getElementById('aContestDiv1').style.display = "flex";
    document.getElementById('aContestDiv2').style.display = "flex";
    document.getElementById('aContestDiv3').style.display = "inline";
    // form view
    document.getElementById('contestHeader').style.display = "none";
    document.getElementById('contestContainer').style.display = "none";
    // button 
    document.getElementById('btnContainer').style.display = "flex";
}

function button2(){
    document.getElementById('aContestRequestButton1').style.backgroundColor = "white";
    document.getElementById('aContestRequestButton1').style.color = "black";
    document.getElementById('aContestRequestButton2').style.backgroundColor = "#5B3E38";
    document.getElementById('aContestRequestButton2').style.color = "white";
    // contest page view
    document.getElementById('aContestDiv1').style.display = "none";
    document.getElementById('aContestDiv2').style.display = "none";
    document.getElementById('aContestDiv3').style.display = "none";
    // form view
    document.getElementById('contestHeader').style.display = "flex";
    document.getElementById('contestContainer').style.display = "block";
    // button 
    document.getElementById('btnContainer').style.display = "none";
}