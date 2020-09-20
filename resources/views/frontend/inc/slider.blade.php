<!-- Slider -->
<div id="indexCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#indexCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#indexCarousel" data-slide-to="1"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img src="{{asset('assets/web/newface/images/background.png')}}" alt="...">
            <div class="carousel-caption">
                <h1>What is Lorem Ipsum?</h1>
                <h3>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
            </div>
            <span class="overlay"></span>
        </div>
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#indexCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#indexCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
