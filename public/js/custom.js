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
    $(".search-filter-input").attr("placeholder", "Enter " + optionText);
    $(".filter-value").val(optionText.toLowerCase());
});

// Search exams by ajax
$(document).on("keyup", ".exams-index .search-filter-input", function(e) {
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
                // console.log(data);
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

// Search question banks by ajax
$(document).on("keyup", ".question-banks .search-filter-input", function(e) {
    document.getElementById("search-form").submit = function() {
        $.ajax({
            url: "/QB/search",
            type: "POST",
            data: new FormData(this),
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,

            success: function(data) {
                // console.log(data);
                let questionBanksHolder = document.querySelector(
                    ".question-banks-holder"
                );
                let content = "";
                for (questionBank of data.questionBanks) {
                    content += `<tr>
                                    <td>
                                        <a href='questionsbank/${questionBank[0]}'>${questionBank[1]}</a>
                                    </td>
                                    <td>${questionBank[2]}</td>
                                    <td>
                                        <a class="btn btn-success" href="QB/addQuestion/${questionBank[0]}">Add Question <i class="fa fa-plus fa-lg"></i></a>
                                        <form action="#"  enctype="multipart/form-data" method="post">
                                            <input type="hidden" name="_token" value="${questionBank[3]}">
                                            <button class="btn btn-primary">Update <i class="fa fa-edit fa-lg"></i></button>
                                            </form>
                                        <form action="/QB/delete/${questionBank[0]}"  enctype="multipart/form-data" method="post">
                                            <input type="hidden" name="_token" value="${questionBank[3]}">
                                            <button class="btn btn-danger">Delete <i class="fa fa-times fa-lg"></i></button>
                                        </form>
                                    </td>
                                </tr>`;
                }

                questionBanksHolder.innerHTML = content;
            }
        });
    };

    document.getElementById("search-form").submit();
});

// Search courses by ajax
$(document).on("keyup", ".courses .search-filter-input", function(e) {
    document.getElementById("search-form").submit = function() {
        $.ajax({
            url: "/course/search",
            type: "POST",
            data: new FormData(this),
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,

            success: function(data) {
                let coursesHolder = document.querySelector(".courses-holder");
                let content = "";
                for (course of data.courses) {
                    content += `<tr>
                                    <td>
                                        <a href="/course/teacher/memberList/${course[0]}">${course[1]}</a>
                                    </td>
                                    <td>${course[2]}</td>
                                    <td>${course[3]}</td>
                                    <td>${course[4]}</td>
                                </tr>`;
                }

                coursesHolder.innerHTML = content;
            }
        });
    };

    document.getElementById("search-form").submit();
});

// Search students grades by ajax
$(document).on("keyup", ".students-grades .search-filter-input", function(e) {
    document.getElementById("search-form").submit = function() {
        $.ajax({
            url: "/exams/grades/search",
            type: "POST",
            data: new FormData(this),
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,

            success: function(data) {
                let studentsHolder = document.querySelector(".students-holder");
                let content = "";

                for (student of data.students) {
                    content += `<tr>
                                    <td>${student[0]}</td>
                                    <td>${student[1]}</td>
                                    <td>
                                        <div class="btn btn-primary">Answers</div>
                                    </td>
                                </tr>`;
                }

                studentsHolder.innerHTML = content;
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

// Delete question from exam
$(document).on("click", ".delete-question-btn.exam-delete", function() {
    let question_id = $(this)
        .next()
        .val();
    let exam_id = $(this)
        .next()
        .next()
        .val();
    let question_holder = $(this)
        .parent()
        .parent();

    $.ajax({
        url: "/exams/deleteQuestion/" + question_id + "/" + exam_id,
        type: "POST",
        data: [],
        dataType: "JSON",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        cache: false,
        contentType: false,
        processData: false,

        success: function(data) {
            if (data.status == "success") {
                question_holder.attr("hidden", true);
            } else {
                alert("Question was not deleted!");
            }
        }
    });
});

// Delete question from DB
$(document).on(
    "click",
    ".delete-question-btn.question-bank-delete",
    function() {
        let question_id = $(this)
            .next()
            .val();
        let question_holder = $(this)
            .parent()
            .parent();

        $.ajax({
            url: "/questions/" + question_id,
            type: "POST",
            data: [],
            dataType: "JSON",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            cache: false,
            contentType: false,
            processData: false,

            success: function(data) {
                console.log(data);
                if (data.status == "success") {
                    question_holder.attr("hidden", true);
                } else {
                    alert("Question was not deleted!");
                }
            }
        });
    }
);

// Delete answer from DB
$(document).on("click", ".delete-answer-btn", function() {
    let answer_id = $(this)
        .next()
        .val();
    let answer_holder = $(this).parent();

    $.ajax({
        url: "/answers/" + answer_id,
        type: "POST",
        data: [],
        dataType: "JSON",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        cache: false,
        contentType: false,
        processData: false,

        success: function(data) {
            console.log(data);
            if (data.status == "success") {
                answer_holder.attr("hidden", true);
            } else {
                alert("answer was not deleted!");
            }
        }
    });
});

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
                $(form).attr("hidden", true);
                questionContent = $(form)
                    .prev()
                    .first();

                questionContent.attr("hidden", false);
                questionContent
                    .children()
                    .eq(0)
                    .html(data.content);
                if (data.weight) {
                    $(".weight").html(data.weight);
                } else {
                    $(".type").html(data.type);
                    $(".difficulty").html(data.difficulty);
                    $(".chapter").html(data.chapter);
                }
                questionContent.append(
                    "<i class='fa fa-check text-success fa-2x' title='Question Updated successfully'></i>"
                );
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
                questionContent.append(
                    "<i class='fa fa-check' title='Answer Updated successfully'></i>"
                );

                if (data.is_correct == true) {
                    questionContent.removeClass("text-danger");
                    questionContent.addClass("text-success");
                } else {
                    questionContent.removeClass("text-success");
                    questionContent.addClass("text-danger");
                }
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

// Get question analysis in specific exam
$(".analysis .question-analysis-form").on("submit", function(e) {
    e.preventDefault();

    $.ajax({
        url: "/exams/questionAnalysis",
        type: "POST",
        data: new FormData(this),
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,

        success: function(data) {
            $(".analysis .solved").html(data.solved + "%");
            $(".analysis .avg").html(data.avg);
            $(".analysis .question-weight").html(data.weight);
        }
    });
});

// Get chapter analysis in specific exam
$(".analysis .chapter-analysis-form").on("submit", function(e) {
    e.preventDefault();

    $.ajax({
        url: "/exams/chapterAnalysis",
        type: "POST",
        data: new FormData(this),
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,

        success: function(data) {
            $(".analysis .chapter-absorbtion").html(data.absorbtion + "%");
        }
    });
});

$(
    ".analysis .question-analysis-form .select, .analysis .chapter-analysis-form .select"
).on("change", function() {
    $(
        ".analysis .question-analysis-form, .analysis .chapter-analysis-form"
    ).submit();
});

// Enable weight input when choosing the question
$(".add-check-box").on("change", function() {
    console.log($(this).attr("checked"));
    $(this)
        .parent()
        .prev()
        .children()
        .prop("disabled", function(i, v) {
            return !v;
        });
});

// Add question randomly
let chs = 1;
$(document).on("click", ".add-question-randomly", function() {
    let randomQuestions =
        parseInt(
            $(this)
                .parent()
                .parent()
                .children()
                .eq(0)
                .val()
        ) + 1;

    let ch = $(this)
        .parent()
        .parent()
        .children()
        .eq(1)
        .val();

    $(this)
        .parent()
        .prev().append(`<div class="form-group row random-question" style="margin-left: 0px">
                            <div style="margin-left: 10px;">
                                <input name="ch${ch}w${randomQuestions}" id="ch${ch}w${randomQuestions}" type="number" required  autofocus class="form-control" placeholder="Enter the Weight">
                            </div>
                         

                            <div style="margin-left: 10px">
                                <select class="form-control" name="ch${ch}w${randomQuestions}Q${randomQuestions}Diff" id="ch${ch}w${randomQuestions}Q${randomQuestions}Diff" style="background-color: #1A034A;color: white;" required >
                                    <option value="" disabled selected >Difficulty</option>
                                    <option value="Easy">Easy</option>
                                    <option value="Med">Med</option>
                                    <option value="Hard">Hard</option>
                                </select>
                            </div>
                            <div style="margin-left: 20px">
                                <select class="form-control" name="ch${ch}w${randomQuestions}Q${randomQuestions}type" id="ch${ch}w${randomQuestions}Q${randomQuestions}type" style="background-color: #1A034A;color: white;" required >
                                    <option value="" disabled selected >Question Type</option>
                                    <option value="MSMCQ">MSMCQ</option>
                                    <option value="SSMCQ">SSMCQ</option>
                                    <option value="Essay">Essay</option>
                                    <option value="T/F">T/F</option>
                                    <option value="Parent">Parent</option>

                                </select>
                            </div>
                        </div>`);
    $(this)
        .parent()
        .parent()
        .children()
        .eq(0)
        .val(randomQuestions);
});

$(".add-chapter").on("click", function() {
    let options = ``;
    $(".select-chapters.first-select option").each(function(i) {
        if (i != 0) {
            options += `<option value="${$(this).val()}">${$(
                this
            ).val()}</option>`;
        }
    });

    chs++;
    $(
        ".chapters"
    ).append(`<div class="form-group row" style="margin-left: 0px;border: 2px solid gray;border-radius: 10px">
                <input type="number" class="questions-count" value="1" hidden>
                <input type="number" class="chs-count" value="${chs}" hidden>
                <div class="random-questions" style="margin-left: 25px;margin-top: 20px">
                    <div style="margin-left: 10px">
                        <select class="form-control select-chapters" name="ch${chs}" id="ch${chs}" style="background-color: #1A034A;color: white;width: 250px" required >
                            <option disabled selected>Chapter</option>
                            ${options}
                        </select>
                    </div>
                    <br>
                    <div class="form-group row random-question" style="margin-left: 0px">
                        <div style="margin-left: 10px;">
                            <input name="ch${chs}w1" id="ch${chs}w1" type="number" required  autofocus class="form-control" placeholder="Enter the Weight">
                        </div>
                      

                        <div style="margin-left: 10px">
                            <select class="form-control" name="ch${chs}w1Q1Diff" id="ch${chs}w1Q1Diff" style="background-color: #1A034A;color: white;" required >
                                <option value="" disabled selected >Difficulty</option>
                                <option value="Easy">Easy</option>
                                <option value="Med">Med</option>
                                <option value="Hard">Hard</option>
                            </select>
                        </div>
                        <div style="margin-left: 20px">
                            <select class="form-control" name="ch${chs}w1Q1type" id="ch${chs}w1Q1type" style="background-color: #1A034A;color: white;" required >
                                <option value="" disabled selected >Question Type</option>
                                <option value="MSMCQ">MSMCQ</option>
                                <option value="SSMCQ">SSMCQ</option>
                                <option value="Essay">Essay</option>
                                <option value="T/F">T/F</option>
                                <option value="Parent">Parent</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-center pb-3">
                    <div class="btn add add-question-randomly"><i class="fa fa-plus fa-lg"></i></div>
                </div>
            </div>`);
});

// Get chapters of specific question bank
$(".create-exam-randomly .select-question-bank").on("change", function() {
    let questionBank = this.options[this.selectedIndex].value;
    $.ajax({
        url: "/QB/chapters/" + questionBank,
        type: "POST",
        data: [],
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,

        success: function(data) {
            let chaptersSelect = $(".create-exam-randomly").find(
                ".select-chapters"
            );
            chaptersSelect.empty(); // remove old options
            chaptersSelect.append(`<option disabled selected>Chapter</option>`);
            $.each(data.chapters, function(key, value) {
                chaptersSelect.append(
                    `<option value="${value.chapter}">${value.chapter}</option>`
                );
            });
        }
    });
});
