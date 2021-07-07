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

// Filter by select
$(".filter-by").on("change", function() {
    optionText = this.options[this.selectedIndex].text;
    selectedFilter = $(".selected-filter");
    selectedFilter.text(optionText);
    $(".search-filter-input").val("");
    $(".search-filter-input").attr("placeholder", "Enter exam " + optionText);
    $(".filter-value").val(optionText.toLowerCase());
});

// Search by ajax
$(document).on("keyup", ".search-filter-input", function(e) {
    document.getElementById("search-form").submit = function() {
        $.ajax({
            url: "/exams/search",
            type: "POST",
            data: new FormData(this),
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,

            success: function(data) {
                let examsHolder = document.querySelector(".exams-holder");
                let now = new Date();
                let content = "";
                for (exam of data.exams) {
                    examDate = new Date(exam[7]);
                    content += `<tr>
                                    <td>${exam[1]}</td>
                                    <td>${exam[2]}</td>
                                    <td>${exam[3]}</td>
                                    <td>${exam[4]}</td>
                                    <td>${exam[5]}</td>
                                    <td>${exam[6]}</td>
                                    <td>${exam[7]}</td>
                                    <td>
                                    ${
                                        examDate > now
                                            ? '<form action="/exams/' +
                                              exam[0] +
                                              '" method="POST"><input type="hidden" name="_token" value="' +
                                              exam[7] +
                                              '"><input type="hidden" name="_method" value="DELETE"><button class="btn btn-danger">Delete</button></form> <button class="btn edit-exam-btn">Edit</button>'
                                            : '<button class="btn btn-primary">Analysis</button> <button class="btn btn-success">Students grades</button>'
                                    }
                                    </td>
                                </tr>`;
                }

                examsHolder.innerHTML = content;
            }
        });
    };

    document.getElementById("search-form").submit();
});
