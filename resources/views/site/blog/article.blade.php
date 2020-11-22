@extends('layouts.site')
@section('body_class', 'article')
@section('content')

    @include('site.components.breadcrumbs')
    <section class="section-xxl text-center" style="background-image: url({{ asset('images/site/Post-1.jpg') }}); background-repeat: no-repeat; background-position: center; background-size: cover;">
        <div class="shell nonstandart-post-header">
            <h2 style="color: #fff; text-transform: uppercase;">Преимущества смисителя для кухни с выдвежным изливом</h2>
            <div class="post-meta">
                <div class="group">
                    <div> <time datetime="2017" style="color: #fff">Jan.20, 2016</time></div>
                    <div class="meta-author" style="color: #fff">by Brian Williamson</div>
                </div>
            </div>
        </div>
    </section>
    <div class="section-md">
        <div class="shell">
            <div class="range range-60 range-xs-center">
                <div class="cell-md-8 section-divided__main">
                    <section class="section-sm post-single-body">
                        <p class="first-letter">After a hard day’s work, there’s nothing better than sitting and getting all comfortable and cozy in a soft, comfy chair. But finding a recliner that will perfectly fit your body and your budget at the same time (prices range from $250 to $5,000) isn’t as relaxing and easy. If we’re also adding quality, a decent lounger should last at least 10 years with regular use. Here’s how to pick one that won’t break down prematurely!</p>
                        <p>But how do you tell the quality by just taking a quick seat while at the store? Rocker recliners — think traditional La-Z-Boy — rock when upright and lower fully, usually by means of a hand lever. Their pricing usually starts at about $350 but expect to pay $600 and up for a well-built model. A trendier option these days for the space- or style-conscious are push-back models, which recline when you’re leaning back. They can cost as little as $250, but, on the downside, tend not to last as long as those with levers, since the mechanism gets more of a workout.</p><img src="images/about-1-886x668.jpg" alt="" width="886" height="668"/>
                        <p>Also new: wall-saver recliners, which will need only about six inches of space between chair and wall, compared to a foot or more needed for larger traditional versions (though the price is about the same).</p>
                        <p>Then again, there are specialty chairs, such as massage and electric recliners. The former can get quite expensive (from $800 to $5,000), and the latter are designed for people with mobility issues. Regardless of what type you pick, check that there’s no more than a five-inch gap between the seat and the open leg rest; otherwise, children or pets can get caught and injured. Same goes for the lever — make sure tiny hands (or your own fingers) can’t get stuck inside or pinched.</p>
                        <h4>SIT ON IT!</h4>
                        <p>Recliners are like shoes — people choose them based on their looks, and then suffer if they’re not comfortable enough. When you’re out there shopping, have family members who’ll spend the most time in the chair sit in it for five minutes or more. Ask yourself: Do my feet touch the floor when the back is upright? Does the headrest support my head and neck? How’s the cushioning? Inspect the seat and back for bumpy parts. And look for foam which has a density rate of 1.9 or higher (most furniture cushions range from 0.9 to 2.5), which will ensure that it keeps its shape longer. Test the chair’s footrest several times to make sure it’s easy to maneuver. Listen for squeaks, which may be telling signs for loose parts or improper alignment.</p><img src="images/about-2-886x668.jpg" alt="" width="886" height="668"/>
                        <h4>FOCUS ON FRAME!</h4>
                        <p>Repair experts say it’s usually the nonmoving parts of the recliner that get damaged or broken most often. So inspect the underside of the chair (or, if that’s not possible, ask to view photos, videos, or sample “cutaways” from the manufacturer). You want to see heavy-duty screws, not dinky ones or, worse, plastic fasteners. Don’t be fooled by a vague description like “all-wood construction,” which may be code for low-quality pressboard — too soft to withstand the back-and-forth motion of a recliner. Get the salesperson to clarify, and actually look at the bones: Hardwood, like birch or poplar, is superior, but be prepared to spend about $1,000 or maybe more. A decent second choice is plywood, starting at a low $300. Finally, with any recliner, check the manufacturer’s guarantee and opt for one that spans at least three years.</p>
                    </section>
                    <section class="section-sm">
                        <h5>Latest Posts</h5>
                        <div class="range range-60">
                            <div class="cell-sm-6">
                                <!-- Post classic-->
                                <article class="post-classic post-minimal"><img src="{{ asset('images/site/Post-1.jpg') }}" alt="" width="418" height="315"/>
                                    <div class="post-classic-title">
                                        <h5><a href="#">INTERESTING DESIGN FOR A DUAL-ACTION DESK DRAWER</a></h5>
                                    </div>
                                    <div class="post-meta">
                                        <div class="group"><a href="image-post.html">
                                                <time datetime="2017">Jan.20, 2016</time></a><a class="meta-author" href="image-post.html">by Brian Williamson</a></div>
                                    </div>
                                </article>
                            </div>
                            <div class="cell-sm-6">
                                <!-- Post classic-->
                                <article class="post-classic post-minimal"><img src="{{ asset('images/site/Post-1.jpg') }}" alt="" width="886" height="668"/>
                                    <div class="post-classic-title">
                                        <h5><a href="#">THE INTERSECTION OF LEFTOVERS AND HAND-CRAFTED FURNITURE</a></h5>
                                    </div>
                                    <div class="post-meta">
                                        <div class="group"><a href="image-post.html">
                                                <time datetime="2017">Jan.20, 2016</time></a><a class="meta-author" href="image-post.html">by Brian Williamson</a></div>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </section>
                    <section class="section-sm">
                        <!-- Blurb minimal-->
                        <article class="blurb">
                            <div class="unit unit-xs-horizontal unit-spacing-md">
                                <div class="unit__left"><img class="img-circle" src="images/timeline-1-109x109.jpg" alt="" width="109" height="109"/>
                                </div>
                                <div class="unit__body">
                                    <p class="blurb__title">About the author</p>
                                    <p class="small">Mary's interest in furniture and everything related to it began in her father's local chairs & tables store in Virginia... Starting off as his helper and accountant, she eventually grew fond of the whole thing and began to consider an option of starting her own furniture store in the big city. With her first store in Arlington in 1999, Mary's chain began to gradually expand, now consisting of more than 5 furniture stores nationwide...</p>
                                </div>
                            </div>
                        </article>
                    </section>
                </div>
            </div>
        </div>
    </div>

@endsection