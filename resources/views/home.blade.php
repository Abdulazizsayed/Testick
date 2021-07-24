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
        <p style="display: none" id="ptestick">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Mollitia, voluptate amet! Vitae molestiae explicabo magnam dolor ratione dolores sequi consectetur eius architecto, neque, quibusdam iusto nostrum debitis odit? Consectetur, eum?</p>
    </section>
    <hr>
    <section>
        <div>
              <div style=" display: inline-block;"><header>Courses</header></div>
              <div style="margin-left: 5% ;display: inline-block;"><h1 onclick="myFunction1()" id="arrcourse" class="section"> &#8594;</h1></div>
        </div>
        <p style="display: none" id="pcourse">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Mollitia, voluptate amet! Vitae molestiae explicabo magnam dolor ratione dolores sequi consectetur eius architecto, neque, quibusdam iusto nostrum debitis odit? Consectetur, eum?</p>
    </section>
    <hr>
    <section>

        <div>
            <div style=" display: inline-block;"><header>Exams</header></div>
            <div style="margin-left: 5% ;display: inline-block;"><h1 onclick="myFunction2()" id="arrexams" class="section"> &#8594;</h1></div>
        </div>
        <p style="display: none" id="pexams">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Mollitia, voluptate amet! Vitae molestiae explicabo magnam dolor ratione dolores sequi consectetur eius architecto, neque, quibusdam iusto nostrum debitis odit? Consectetur, eum?</p>
    </section>
    <hr>
    @if (Auth::user()->role == 1)
        <section>
            <div>
                <div style=" display: inline-block;"> <header>Question Banks</header></div>
                <div style="margin-left: 5% ;display: inline-block;"><h1 onclick="myFunction3()" id="arrpqbank" class="section"> &#8594;</h1></div>
            </div>
            <p style="display: none" id="pqbank">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Mollitia, voluptate amet! Vitae molestiae explicabo magnam dolor ratione dolores sequi consectetur eius architecto, neque, quibusdam iusto nostrum debitis odit? Consectetur, eum?</p>
        </section>
    @endif
    <hr>
    <section>
        <div>
            <div style=" display: inline-block;"><header>Exams Analysis</header></div>
            <div style="margin-left: 5% ;display: inline-block;"><h1 onclick="myFunction4()" id="arrea" class="section"> &#8594;</h1></div>
        </div>
        <p style="display: none" id="pea">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Mollitia, voluptate amet! Vitae molestiae explicabo magnam dolor ratione dolores sequi consectetur eius architecto, neque, quibusdam iusto nostrum debitis odit? Consectetur, eum?</p>
    </section>
    <hr>
    <section>
        <div>
            <div style=" display: inline-block;"><header>About</header></div>
            <div style="margin-left: 5% ;display: inline-block;"><h1 onclick="myFunction5()" id="arrabout" class="section"> &#8594;</h1></div>
        </div>
        <p style="display: none" id="pabout">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Mollitia, voluptate amet! Vitae molestiae explicabo magnam dolor ratione dolores sequi consectetur eius architecto, neque, quibusdam iusto nostrum debitis odit? Consectetur, eum?</p>
    </section>

</div>
@endsection
