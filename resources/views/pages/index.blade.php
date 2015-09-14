@extends('layouts.site')

@section('navbar-brand')
@show

@section('content')

<div class="hero">
    <div class="container">
        <h1 class="logo" title="Nimbus">Nimbus</h1>

        <h2 class="text-center">Powerfully Simple File-sharing</h2>
    </div>
</div>

<div class="container">

    <div class="row">
        <div class="col-md-6 col-md-offset-2 cta">
            <img src="/img/dragdrop.png" width="100px" alt=""/>

            <h3>Simple Drag &amp; Drop</h3>

            <p>By simply dragging and dropping your files onto your browser Nimbus lets you instantly and securely share anything.</p>
        </div>

    </div>


    <div class="row">

        <div class="col-md-6 col-md-offset-4 cta alt">
            <img src="/img/cloud.png" width="100px" alt=""/>

            <h3>Bring Your Own Storage</h3>

            <p>Take control of how and where your content gets stored by hooking up your own Dropbox, Copy or Amazon S3 cloud storage (even more providers on the way).</p>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6 col-md-offset-2 cta">
            <img src="/img/padlock.png" width="100px" alt=""/>

            <h3>Secure-as</h3>

            <p>Password-protection, download limits and automatic expiry helps you to protect your content.</p>
        </div>

    </div>


    <div class="row">
        <div class="col-md-6 col-md-offset-4 cta alt">
            <img src="/img/creditcard.png" width="100px" alt=""/>

            <h3>Monetise <span class="label label-default">COMING SOON</span></h3>

            <p>Connect your <a href="https://stripe.com" target="_blank">Stripe</a> account and start making money from your content.  Use Nimbus as a secure storefront for your digital downloads, with just a small 2% (plus Stripe fees) commission on any sale you make.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="well">
                <h3>Free to use and easy to get started</h3>

                <p>Get started in 30 seconds and upload up to 10 files per share (called a Droplet). Hook up your own cloud storage for free and use Nimbus without limits.</p>

                <p>Apart from the 2% commission on sales, Nimbus is free to use.  We may decide to add a little unobtrusive advertising at some point, but you'll never be asked for your credit card details.</p>

                <p class="text-center"><a href="{{ route('register_path') }}" class="btn btn-default btn-lg">Get Started!</a></p>
            </div>

        </div>
    </div>


</div>
@endsection