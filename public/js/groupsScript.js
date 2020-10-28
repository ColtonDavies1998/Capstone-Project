window.addEventListener('load', (event) => {

    //Event listeners for the buttons that will display the overlays
    document.getElementById("addGroupsBtn").addEventListener("click", overlayOn);
    document.getElementById("cancelOverlayBtn").addEventListener("click", overlayOff);
    document.getElementById("cancelDelete").addEventListener("click", cancelDeletion);
    document.getElementById("cancelEdit").addEventListener("click", cancelEdit);

    //This function is called when the button to add a new project is clicked. This displays the add project overlay
    function overlayOn(){
        document.getElementById("overlay").style.display ="block";
    }

    //This functions clears the fields in the new project overlay and also hides the overlay
    function overlayOff(){
        document.getElementById("overlay").style.display ="none";

        document.getElementById("ProjectNameInput").value = '';
        document.getElementById("ProjectImageInput").value = '';
        document.getElementById("ProjectDescription").value = '';
    }

    //This button hides the delete project overlay
    function cancelDeletion(){
        document.getElementById("confirmationOverlay").style.display = "none";
    }

    //This function is called when the edit overlay is cancelled and the overlay is hidden
    function cancelEdit(){
        document.getElementById("editNameOverlay").style.display = "none";
    }


});


