@extends('layouts.app')

@section('content')

<nav id= "aboutus-content">
    <main>
        <h1>About Us</h1>
        <p id="intro">We're a group of four students who are currently attending the LBAW course.<br>
        During this semester, we were asked to create a Web Platform with a predefined theme using the knowledge<br>
        aquired in classes. For this project, our group decided to create a site calle "Rabbit", based on the <br>
        famous platform "Reddit".</p>
        <h2>Meet the team:</h2>
        <div class="staff_imgs">
            <div class="student">
                <img src="img/group/fabio_img.png" alt="Fábio Morais" style="width:100%">
                <div class="container">
                    <h4><b>Fábio Morais</b></h4>
                    <p>UP202008052</p>
                </div>
            </div>
            <div class="student">
                <img src="img/group/francisco_img.png" alt="Francisco Prada" style="width:100%">
                <div class="container">
                    <h4><b>Francisco Prada</b></h4>
                    <p>UP202004646</p>
                </div>
            </div>
            <div class="student">
                <img src="img/group/guilherme_img.png" alt="Guilherme Sequeira" style="width:100%">
                <div class="container">
                    <h4><b>Guilherme Sequeira</b></h4>
                    <p>UP202004648</p>
                </div>
            </div>
            <div class="student">
                <img src="img/group/pedro_img.png" alt="Pedro Ramalho" style="width:100%">
                <div class="container">
                    <h4><b>Pedro Ramalho</b></h4>
                    <p>UP202004715</p>
                </div>
            </div>
        </div>
    </main>
</nav>

@endsection