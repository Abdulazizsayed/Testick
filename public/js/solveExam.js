// Exam timer
$(document).ready(function() {
    let duration = $(".exams-show .duration").val();
    let hoursHolder = $(".exams-show .hours"),
        minsHolder = $(".exams-show .mins"),
        secondsHolder = $(".exams-show .seconds");

    let now = new Date().getTime();
    let countDownDate = new Date(now + duration * 60 * 60000).getTime();

    let x = setInterval(function() {
        // Get today's date and time
        let now = new Date().getTime();

        // Find the distance between now and the count down date
        let distance = countDownDate - now;

        let hours = Math.floor(
            (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );
        let mins = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((distance % (1000 * 60)) / 1000);

        if (hours < 10) {
            hoursHolder.html("0" + hours);
        } else {
            hoursHolder.html(hours);
        }

        if (mins < 10) {
            minsHolder.html("0" + mins);
        } else {
            minsHolder.html(mins);
        }

        if (seconds < 10) {
            secondsHolder.html("0" + seconds);
        } else {
            secondsHolder.html(seconds);
        }

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            alert("Time out!");
            $(".exams-show form").submit();
        }
    }, 1000);
});

var formSubmitting = false;
var setFormSubmitting = function() {
    formSubmitting = true;
};

window.onload = function() {
    window.addEventListener("beforeunload", function(e) {
        if (formSubmitting) {
            return undefined;
        }

        var confirmationMessage =
            "If you left or reloaded the page you will lose the grade of the exam, submit the exam before leaving.";

        (e || window.event).returnValue = confirmationMessage; //Gecko + IE
        return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.
    });
};
