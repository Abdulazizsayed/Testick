// Preview image onEditProfile
let editProfileInput = document.querySelector(
    ".edit-profile .edit-profile-input"
);

function readURL(input, previewImg) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            previewImg.setAttribute("src", e.target.result);
            previewImg.hidden = false;
        };

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

if (editProfileInput) {
    editProfileInput.addEventListener("input", function() {
        readURL(
            this,
            document.querySelector(".edit-profile .edit-profile-form img")
        );
    });
}

// Trigger file input when clicking it's icon
$(document).on("click", ".select-image", function() {
    this.previousElementSibling.click();
});
