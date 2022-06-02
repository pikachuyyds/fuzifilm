function showthumbnailimg() {
    // Check file size
    var contestThumbnailSize = contestThumbnail.files.item(0).size;
    var contestThumbnailFile = Math.round((contestThumbnailSize / 1024));
    if (contestThumbnailFile >= 10240) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'The size of this image is too large, Please select image that is less than 10MB',
          })
    } else if (contestThumbnailFile >=0){
        newThumbnailPreview.src = URL.createObjectURL(event.target.files[0]);
        document.getElementById('divThumbnailPreview').style.display = "block";
        var imagename =document.getElementById('contestThumbnail').value
        window.tempimage = URL.createObjectURL(event.target.files[0]);
        document.getElementById('displayThumbnailLabel').innerHTML = "Filename : "+imagename.split("\\").pop();
        document.getElementById('displayThumbnailLabel').style.display = "inline-block";
    }}


function showPaymentBox(){
    var modal = document.getElementById("myModal");
    var span = document.getElementById("close");
    modal.style.display = "block";
    (document.getElementById('cc-number')).setAttribute('required', '');
    (document.getElementById('cc-expires')).setAttribute('required', '');
    (document.getElementById('cc-cvc')).setAttribute('required', '');
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
    modal.style.display = "none";
    (document.getElementById('cc-number')).removeAttribute('required');
    (document.getElementById('cc-expires')).removeAttribute('required');
    (document.getElementById('cc-cvc')).removeAttribute('required');
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        (document.getElementById('cc-number')).removeAttribute('required');
        (document.getElementById('cc-expires')).removeAttribute('required');
        (document.getElementById('cc-cvc')).removeAttribute('required');
    }
    }
}

function onlyNumberKey(evt) {
    var ccvalue= document.getElementById("cc-number");
    if (ccvalue.value.length >0){
        if (ccvalue.value.length ==4 || ccvalue.value.length ==9 || ccvalue.value.length ==14) {
            ccvalue.value += " ";
        }
    }
    var ccdate= document.getElementById("cc-expires");
    if (ccdate.value.length >0){
        if (ccdate.value.length ==2) {
            ccdate.value += "/";
        }
    }
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
    return true;
}

