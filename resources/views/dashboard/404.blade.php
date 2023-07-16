@extends('layouts.template')
@section('content')
 <!-- App Header -->
 <div class="appHeader no-border">
    <div class="left">
        <a href="#" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">
        404 Page
    </div>
    <div class="right">
    </div>
</div>
<!-- * App Header -->

<!-- App Capsule -->
<div id="appCapsule">

    <div class="section">
        <div class="splash-page mt-5 mb-5">
            <h1>404</h1>
            <h2 class="mb-2">Page not found!</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam aliquam.
            </p>
        </div>
    </div>

    <div class="fixed-bar">
        <div class="row">
            <div class="col-6">
                <a href="#" class="btn btn-lg btn-outline-secondary btn-block goBack">Go Back</a>
            </div>
            <div class="col-6">
                <a href="app-pages.html" class="btn btn-lg btn-primary btn-block">Try Again</a>
            </div>
        </div>
    </div>

</div>
<!-- * App Capsule -->

@endsection
