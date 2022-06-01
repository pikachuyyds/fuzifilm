function showthumbnailimg() {
    // Check file size
    var contestThumbnailSize = requestModificationThumbnail.files.item(0).size;
    var contestThumbnailFile = Math.round((contestThumbnailSize / 1024));
    if (contestThumbnailFile >= 10240) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'The size of this image is too large, Please select image that is less than 10MB',
          })
    } else if (contestThumbnailFile >=0){
        modificationThumbnailPreview.src = URL.createObjectURL(event.target.files[0]);
        document.getElementById('divThumbnailPreview').style.display = "block";
        var imagename =document.getElementById('requestModificationThumbnail').value
        window.tempimage = URL.createObjectURL(event.target.files[0]);
        document.getElementById('displayThumbnailLabel').innerHTML = "Filename : "+imagename.split("\\").pop();
        document.getElementById('displayThumbnailLabel').style.display = "inline-block";
    }}

function displayUploadButton(){
    var selectedType = (document.getElementById("requestModificationType")).value;
    if(selectedType=="thumbnailimage")
			{
                document.getElementById('requestModificationThumbnailSection').style.display = "inline-block";
				(document.getElementById('requestModificationThumbnail')).setAttribute('required', '');
                document.getElementById('requestModificationSubmit').style.display = "none";
                document.getElementById('requestModificationSubmit2').style.display = "block";
			}else
			{
                document.getElementById('requestModificationThumbnailSection').style.display = "none";
				(document.getElementById('requestModificationThumbnail')).removeAttribute('required');
                document.getElementById('requestModificationSubmit').style.display = "block";
                document.getElementById('requestModificationSubmit2').style.display = "none";
			}
}

