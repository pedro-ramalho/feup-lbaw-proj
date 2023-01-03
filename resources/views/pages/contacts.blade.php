@extends('layouts.app')

@section('content')
<section id="contacts-content">
    <main>
        <h1>Contacts </h1>
        <p>You can contact us in these platforms: </p>
        <div class="services">
            <div class="content content-facebook">
                <div class="fab fa-facebook"></div>
                <h2>Facebook</h2>
                <p>@feup_lbaw22124</p>
                <a href="#">Visit</a>
            </div>
            <div class="content content-instagram">
                <div class="fab fa-instagram"></div>
                <h2>Instagram</h2>
                <p>@lbaw221244</p>
                <a href="#">Visit</a>
            </div>
            <div class="content content-gmail">
                <div class="fab fa-google"></div>
                <h2>Gmail</h2>
                <p>lbaw22124@gmail.com</p>
                <a href="#">Visit</a>
            </div>
            <div class="content content-linkedin">
                <div class="fab fa-linkedin"></div>
                <h2>LinkedIn</h2>
                <p>/LBAW_22124</p>
                <a href="#">Visit</a>
            </div>
        </div>
    </main>       
</section>
@endsection

