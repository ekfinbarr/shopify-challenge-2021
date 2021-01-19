@extends('layouts.default')

@section('title')
{{ "About us " . config('app.name') }}
@endsection


@section('content')
<div class="tm-hero d-flex justify-content-center align-items-center" data-parallax="scroll" data-image-src="img/hero.jpg"></div>

    <div class="container-fluid tm-mt-60">
        <div class="row mb-4">
            <h2 class="col-12 tm-text-primary">
                About {{ config('app.name') }}
            </h2>
        </div>
        <div class="row tm-mb-74 tm-row-1640">            
            <div class="col-lg-5 col-md-6 col-12 mb-3">
                <img src="https://www.referralcandy.com/wp-content/uploads/2018/01/shopify-setup.jpg" alt="Image" class="img-fluid">
            </div>
            <div class="col-lg-7 col-md-6 col-12">
                <div class="tm-about-img-text">
                    <p class="mb-4">
                        Shopify is a complete commerce platform that lets you start, grow, and manage a business.
                        <br>
                        Create and customize an online store
                        <br>
                        Sell in multiple places, including web, mobile, social media, online marketplaces, brick-and-mortar locations, and pop-up shops
                    </p>
                    <p>
                        Shopify is completely cloud-based and hosted, which means you don’t have to worry about upgrading or maintaining software or web servers. This gives you the flexibility to access and run your business from anywhere with an internet connection.    
                    </p> 
                </div>                
            </div>
        </div>
        <div class="row tm-mb-50">
            <div class="col-md-6 col-12">
                <div class="tm-about-2-col">
                    <h2 class="tm-text-primary mb-4">
                        Can I use my own domain name with Shopify?
                    </h2>
                    <p class="mb-4">
                        Yes, you can use your own domain name with Shopify.
                        <br>
                        If you have an existing domain name, you can connect it to Shopify from your store’s admin. Learn more about connecting an existing domain to a Shopify store.
                        <br>
                        If you don’t have a domain name yet, you can either buy one through Shopify or a third-party provider.
                    </p>
                </div>                
            </div> 
            <div class="col-md-6 col-12">
                <div class="tm-about-2-col">
                    <h2 class="tm-text-primary mb-4">
                        Which languages does Shopify support?
                    </h2>
                    <p class="mb-4">
                        The customer-facing parts of your Shopify store, including ecommerce website, blog, checkout, and emails can be in any language if the theme supports it. Learn more and explore our themes.
                        <br>
                        The admin of your Shopify store is currently available in English, Chinese (Simplified), Chinese (Traditional), Czech, Danish, Dutch, Finnish, French, German, Italian, Japanese, Korean, Norwegian, Polish, Portuguese (Brazil), Portuguese (Portugal), Spanish, Swedish, Thai, and Turkish.
                    </p>
                </div>                
            </div>     
        </div> <!-- row -->
    </div> <!-- container-fluid, tm-container-content -->

@endsection