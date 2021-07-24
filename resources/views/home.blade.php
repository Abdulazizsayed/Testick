@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <script>
        function myFunction() {
            var x = document.getElementById("ptestick");
            var y = document.getElementById("arrtestick");
            if (x.style.display === "none") {
                x.style.display = "block";
                y.innerHTML=("&#8595;");

            } else {
                x.style.display = "none";
                y.innerHTML=("&#8594;");
            }
        }
        function myFunction1() {
            var x = document.getElementById("pcourse");
            var y = document.getElementById("arrcourse");
            if (x.style.display === "none") {
                x.style.display = "block";
                y.innerHTML=("&#8595;");

            } else {
                x.style.display = "none";
                y.innerHTML=("&#8594;");
            }
        }
        function myFunction2() {
            var x = document.getElementById("pexams");
            var y = document.getElementById("arrexams");
            if (x.style.display === "none") {
                x.style.display = "block";
                y.innerHTML=("&#8595;");

            } else {
                x.style.display = "none";
                y.innerHTML=("&#8594;");
            }
        }
        function myFunction3() {
            var x = document.getElementById("pqbank");
            var y = document.getElementById("arrpqbank");
            if (x.style.display === "none") {
                x.style.display = "block";
                y.innerHTML=("&#8595;");

            } else {
                x.style.display = "none";
                y.innerHTML=("&#8594;");
            }
        }
        function myFunction4() {
            var x = document.getElementById("pea");
            var y = document.getElementById("arrea");
            if (x.style.display === "none") {
                x.style.display = "block";
                y.innerHTML=("&#8595;");

            } else {
                x.style.display = "none";
                y.innerHTML=("&#8594;");
            }
        }
        function myFunction5() {
            var x = document.getElementById("pabout");
            var y = document.getElementById("arrabout");
            if (x.style.display === "none") {
                x.style.display = "block";
                y.innerHTML=("&#8595;");

            } else {
                x.style.display = "none";
                y.innerHTML=("&#8594;");
            }
        }

    </script>
<div class="container home">
    @if (session('status'))
        <div class="alert {{session('class') ? session('class') : 'alert-success'}}">
            {{ session('status') }}
        </div>
    @endif
    <section>
        <div>
            <div style=" display: inline-block;"><header>Testick</header></div>
            <div style="margin-left: 5% ;display: inline-block;"><h1 onclick="myFunction()" id="arrtestick" class="section"> &#8594;</h1></div>
        </div>
        <p style="display: none" id="ptestick">This System provides to you special services to make it easy for you as a teacher to create and correcting exams with any type of questions.</p>
    </section>
    <hr>
    <section>
        <div>
              <div style=" display: inline-block;"><header>Courses</header></div>
              <div style="margin-left: 5% ;display: inline-block;"><h1 onclick="myFunction1()" id="arrcourse" class="section"> &#8594;</h1></div>
        </div>
        <p style="display: none" id="pcourse">in this page you can announce your students and review course details and members in this course if TAs or students.</p>
    </section>
    <hr>
    <section>

        <div>
            <div style=" display: inline-block;"><header>Exams</header></div>
            <div style="margin-left: 5% ;display: inline-block;"><h1 onclick="myFunction2()" id="arrexams" class="section"> &#8594;</h1></div>
        </div>
        <p style="display: none" id="pexams">this page is helping you as a teacher to create exams manually or automatically and specify its date and time for students.</p>
    </section>
    <hr>
    @if (Auth::user()->role == 1)
        <section>
            <div>
                <div style=" display: inline-block;"> <header>Question Banks</header></div>
                <div style="margin-left: 5% ;display: inline-block;"><h1 onclick="myFunction3()" id="arrpqbank" class="section"> &#8594;</h1></div>
            </div>
            <p style="display: none" id="pqbank">in this page you can add question banks or edit or delete an old ones and can access every single question to edit or delete.</p>
        </section>
    @endif
    <hr>
    <section>
        <div>
            <div style=" display: inline-block;"><header>Exams Analysis</header></div>
            <div style="margin-left: 5% ;display: inline-block;"><h1 onclick="myFunction4()" id="arrea" class="section"> &#8594;</h1></div>
        </div>
        <p style="display: none" id="pea">in this page we helped you to show the statistics of exams immediately after exam is finished and also can get statistics of past exams.</p>
    </section>
    <hr>
    <section>
        <div>
            <div style=" display: inline-block;"><header>About</header></div>
            <div style="margin-left: 5% ;display: inline-block;"><h1 onclick="myFunction5()" id="arrabout" class="section"> &#8594;</h1></div>
        </div>
        <p style="display: none" id="pabout">june 2021-Testick</p>
    </section>

</div>
@endsection
