@extends('layouts.app')

@section('main')
<div class="cover">
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-12">
                <div class="cover-bg text-center">
                    {{-- <img src="/images/dac-logo.png" class="logo" alt=""> --}}
                    <h1>Welcome to {{ config('app.name') }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid bg-grey">
    <div class="row">
        <div class="col-sm-4">
            <img src="/images/dac-logo.png" class="img-fluid ml-5" alt="">
        </div>
        <div class="col-sm-8">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-12">
                    <h2>Our Values</h2><br>
                    <h4><strong>MISSION:</strong> Our mission it to help customers' pets live long, happy and healthy lives. We believe that a key element to a healthy pet is a great relationship with your veterinarian. Everyone at Dawney Animal Clinic is committed to professional, caring, personalized service. We takes our pride in our dedication to the highest standards in veterinary medicine. We have a full-service clinic offering state-of-the-art veterinary medical technology.
                    </h4><br>
                    <p><strong>VISION:</strong> DAC aims to ensure that we are recognized by our offering of a full range medical services to the pets, and providing the highest standards in veterinary medicine.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="kilimanjaro_area">
        <!-- Top Footer Area Start -->
        <div class="foo_top_header_one section_padding_100_70">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="kilimanjaro_part">
                            <h5>About Us</h5>
                            <p>We specialize in surgery and personalized pet care. If you have a new puppy or kitten, we are here to guide you along the way and recommend the appropriate vaccinations as well as when to spay or neuter your pet. We are an exceptional facility with state of the art veterinary equipment which we utilize to facilitate the very best care for your pets.</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="kilimanjaro_part">
                            <h5>Where to find us?</h5>
                            <p>80 Perpetual Help St, Penafrancia Ave, Naga City, Camarines Sur 4400 Philippines <br>
                                <a href="https://www.google.com/maps/place/Dawney+Animal+Clinic+Naga/@13.6364404,123.1971054,16z/data=!4m5!3m4!1s0x0:0xc42df55ec764f9d!8m2!3d13.6356107!4d123.1977405">Google Maps</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="kilimanjaro_part">
                            <h5>Social Links</h5>
                            <ul class="kilimanjaro_social_links">
                                <li><a href="https://www.facebook.com/Dawney-Animal-Clinic-Naga-469007536828530/"><i class="fa fa-facebook" aria-hidden="true"></i> Facebook</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="kilimanjaro_part">
                            <h5>Quick Contact</h5>
                            <div class="kilimanjaro_single_contact_info">
                                <h5 class="mb-2">Veterinarian:</h5>
                                <p>
                                    <a href="https://www.thefilipinovet.com/veterinarians/dawney-maria-kathleen-ranola-2014003425/">
                                        Maria Kathleen R. Dawney, D.V.M.
                                    </a>
                                </p>
                            </div>
                            <div class="kilimanjaro_single_contact_info">
                                <h5 class="mb-2">Phone:</h5>
                                <p>+639 95 971 5245</p>
                            </div>
                            <div class="kilimanjaro_single_contact_info">
                                <h5 class="mb-2">Email:</h5>
                                <p>support@dawneyanimalclinic.xyz<br> emergency@dawneyanimalclinic.xyz</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Bottom Area Start -->
        <div class=" kilimanjaro_bottom_header_one section_padding_50 text-center">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <p>© All Rights Reserved by <a href="#">{{ config('app.name')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <style>
        .py-4{
            padding: 0 !important;
        }
        </style>


{{--
<div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">TEST</div>

                    <div class="card-body">
                        TETS
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    @endsection
