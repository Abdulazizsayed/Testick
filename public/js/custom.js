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

// Edit question content
$(document).on(
    "click",
    ".question-header .edit-question-btn, .answer .edit-answer-btn",
    function() {
        parent = $(this).parent();
        parent.attr("hidden", true);

        editForm = parent.next();
        editForm.attr("hidden", false);
        editForm
            .children()
            .eq(3)
            .focus();
    }
);

// Discard editing question
$(
    ".edit-question-form .discard-changing-question, .edit-answer-form .discard-changing-question"
).on("click", function() {
    parent = $(this).parent();
    parent.attr("hidden", true);

    parent.prev().attr("hidden", false);
});

// Edit question ajax
$(".edit-question-form").on("submit", function(e) {
    e.preventDefault();
    let question_id = this["id"].value;
    let form = this;

    $.ajax({
        url: "/questions/updateExamQuestion/" + question_id,
        type: "POST",
        data: new FormData(this),
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,

        success: function(data) {
            if (data.success == true) {
                // console.log($(form));
                $(form).attr("hidden", true);
                questionContent = $(form)
                    .prev()
                    .first();

                questionContent.attr("hidden", false);
                questionContent
                    .children()
                    .eq(0)
                    .html(data.content);
                questionContent.addClass("bg-success");
            } else {
                $(form).attr("hidden", true);
                questionContent = $(form)
                    .prev()
                    .first();

                questionContent.attr("hidden", false);
                questionContent.addClass("bg-danger");
            }
        }
    });
});

// Edit answer ajax
$(".edit-answer-form").on("submit", function(e) {
    e.preventDefault();
    let answer_id = this["id"].value;
    let form = this;

    $.ajax({
        url: "/answers/updateQuestionAnswer/" + answer_id,
        type: "POST",
        data: new FormData(this),
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,

        success: function(data) {
            if (data.success == true) {
                $(form).attr("hidden", true);
                questionContent = $(form)
                    .prev()
                    .first();

                questionContent.attr("hidden", false);
                questionContent.html(
                    data.content + '<i class="fa fa-edit edit-answer-btn"></i>'
                );
                questionContent.addClass("bg-success");
            } else {
                $(form).attr("hidden", true);
                questionContent = $(form)
                    .prev()
                    .first();

                questionContent.attr("hidden", false);
                questionContent.addClass("bg-danger");
            }
        }
    });
});

// Check if the question is t/f to enable true or false answers only
$(".add-question .type").on("change", function() {
    // console.log(this["value"]);
    if (this["value"] == "Parent") {
        $(".add-question .answers .answer input").attr("disabled", true);
    } else {
        $(".add-question .answers .answer input").attr("disabled", false);
    }
});

// Add answer to question
let answersCounter = 1;
$(".add-answer").on("click", function() {
    answersCounter++;
    newAnswer = `
    <hr>
    <div class="row answer">
        <div class="col-8">
            <div>
                <div>
                    <label for="answer${answersCounter}">Answer ${answersCounter}</label>
                </div>
                <div>
                    <input id="answer${answersCounter}" name="answer${answersCounter}" type="text" class="form-control" answer${answersCounter}="answer${answersCounter}" required autocomplete="answer${answersCounter}" autofocus>
                </div>
                <div class="mt-3">
                    <input class="form-check-input form-control" type="checkbox" id="ch${answersCounter}" name="ch${answersCounter}" value="${answersCounter}">
                    <label class="form-check-label" for="ch${answersCounter}">
                        Correct?
                    </label>
                </div>
            </div>
        </div>
    </div>
    `;
    $(".answers").append(newAnswer);
});
