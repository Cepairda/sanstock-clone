
<?php $__env->startSection('body_class', 'product'); ?>
<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('site.components.breadcrumbs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <section class="section-sm bg-white">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-5">
                    <!-- Slick Carousel-->
                    <div class="slick-slider carousel-parent" data-arrows="false" data-loop="false" data-dots="false" data-swipe="true" data-items="1" data-child="#child-carousel" data-for="#child-carousel" data-photo-swipe-gallery="gallery">
                        <div class="item">
                            <a class="img-thumbnail-variant-2"
                               href="<?php echo e(asset('images/site/21689.jpg')); ?>"
                               data-photo-swipe-item=""
                               data-size="2000x2000">
                                <figure>
                                    <img src="<?php echo e(asset('images/site/21689.jpg')); ?>" alt="" width="535" height="535"/>
                                </figure>
                                <div class="caption"><span class="icon icon-lg linear-icon-magnifier"></span></div></a>
                        </div>
                        <div class="item">
                            <a class="img-thumbnail-variant-2"
                               href="<?php echo e(asset('images/site/21689.jpg')); ?>"
                               data-photo-swipe-item=""
                               data-size="2000x2000">
                                <figure>
                                    <img src="<?php echo e(asset('images/site/21689_1.jpg')); ?>" alt="" width="535" height="535"/>
                                </figure>
                                <div class="caption"><span class="icon icon-lg linear-icon-magnifier"></span></div></a>
                        </div>
                    </div>
                    <div class="slick-slider" id="child-carousel" data-for=".carousel-parent" data-arrows="false" data-loop="false" data-dots="false" data-swipe="true" data-items="3" data-xs-items="4" data-sm-items="4" data-md-items="4" data-lg-items="5" data-slide-to-scroll="1">
                        <div class="item"><img src="<?php echo e(asset('images/site/21689.jpg')); ?>" alt="" width="89" height="89"/>
                        </div>
                        <div class="item"><img src="<?php echo e(asset('images/site/21689_1.jpg')); ?>" alt="" width="89" height="89"/>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-7">
                    <div class="product-single">
                        <h4><?php echo e($product->getData('name')); ?></h4>
                        <p class="product-price"><span>45.00</span></p>
                        <p class="product-text">Смеситель для кухни Lidz 12 32 015F-8 изготовлен из нержавеющей стали. Благодаря никелированной брашированной поверхности имеет оригинальный внешний вид. Выполнен в современном сдержанном стиле. Такой смеситель не только удобен и практичен, но и идеально дополнит интерьер кухни.</p>
                        <div class="mt-5" style="display: flex; align-items: center;">
                            <button class="button button-primary button-icon" type="submit"><span><?php echo e(__('Where buy')); ?></span></button>
                            <span class="icon icon-md linear-icon-heart ml-4" data-toggle="tooltip" data-original-title="Add to Wishlist" style="display: block; height: 100%;font-size: 35px; line-height: 1.5; cursor: pointer"></span>
                        </div>
                        <ul class="product-meta mt-5">
                            <li>
                                <dl class="list-terms-minimal">
                                    <dt>SKU</dt>
                                    <dd>256</dd>
                                </dl>
                            </li>
                            <li>
                                <dl class="list-terms-minimal">
                                    <dt>Category</dt>
                                    <dd>
                                        <ul class="product-categories">
                                            <li><a href="single-product.html">Living Room</a></li>
                                            <li><a href="single-product.html">Dining room</a></li>
                                            <li><a href="single-product.html">Bedroom</a></li>
                                            <li><a href="single-product.html">Office</a></li>
                                        </ul>
                                    </dd>
                                </dl>
                            </li>
                            <li>
                                <dl class="list-terms-minimal">
                                    <dt>Tags</dt>
                                    <dd>
                                        <ul class="product-categories">
                                            <li><a href="single-product.html">Modern</a></li>
                                            <li><a href="single-product.html">Table</a></li>
                                        </ul>
                                    </dd>
                                </dl>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12">
                    <!-- Bootstrap tabs-->
                    <div class="tabs-custom tabs-horizontal" id="tabs-1">
                        <!-- Nav tabs-->
                        <ul class="nav-custom nav-custom-tabs nav-custom__align-left">
                            <li class="active"><a href="#tabs-1-1" data-toggle="tab">DESCRIPTION</a></li>
                            <li><a href="#tabs-1-2" data-toggle="tab">ADDITIONAL INFORMATION</a></li>
                            <li><a href="#tabs-1-3" data-toggle="tab">REVIEWS (1)</a></li>
                        </ul>
                    </div>
                    <div class="tab-content text-left">
                        <div class="tab-pane fade in active" id="tabs-1-1">
                            <h5>Product Description</h5>
                            <p>This lovely collection features tight back & seat cushions, and motion reclining mechanism for extra comfort.</p>
                            <ul class="list-marked">
                                <li>Guarantee</li>
                                <li>Luxury Chair Design</li>
                                <li>Quilted Detail, Stud Edging & Satin Ring</li>
                                <li>Protective Plugs To Look After Your Floors</li>
                                <li>These Product Are Available In Any Quantity</li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="tabs-1-2">
                            <h5>Additional Information</h5>
                            <table class="table-product-info">
                                <tbody>
                                <?php $__currentLoopData = $product->characteristics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $characteristic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($characteristic->name); ?></td>
                                        <td><?php echo e($characteristic->value); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tabs-1-3">
                            <div class="range range-60">
                                <div class="cell-xs-12">
                                    <h5>1 review for ITALIAN FURNITURE CONTEMPORARY ALLUMEN GLASS TABLE</h5>
                                    <div class="box-comment box-comment__product">
                                        <div class="unit unit-xs-horizontal unit-spacing-md">
                                            <div class="unit__left">
                                                <div class="box-comment__icon"><span class="icon linear-icon-man"></span></div>
                                            </div>
                                            <div class="unit__body">
                                                <div class="box-comment__body">
                                                    <h6>Adam Smith</h6>
                                                    <time datetime="2017">- Jan.20, 2016</time>
                                                    <p>This is a great online store.</p>
                                                    <ul class="rating-list">
                                                        <li><span class="icon linear-icon-star icon-secondary-4"></span></li>
                                                        <li><span class="icon linear-icon-star icon-secondary-4"></span></li>
                                                        <li><span class="icon linear-icon-star icon-secondary-4"></span></li>
                                                        <li><span class="icon linear-icon-star icon-secondary-4"></span></li>
                                                        <li><span class="icon linear-icon-star icon-gray-4"></span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cell-sm-8">
                                    <h5>Add a review</h5>
                                    <p>Your email address will not be published. Required fields are marked *</p>
                                    <h6>Your Rating</h6>
                                    <ul class="rating-list">
                                        <li><span class="icon linear-icon-star icon-gray-4"></span></li>
                                        <li><span class="icon linear-icon-star icon-gray-4"></span></li>
                                        <li><span class="icon linear-icon-star icon-gray-4"></span></li>
                                        <li><span class="icon linear-icon-star icon-gray-4"></span></li>
                                        <li><span class="icon linear-icon-star icon-gray-4"></span></li>
                                    </ul>
                                    <!-- RD Mailform-->
                                    <form class="rd-mailform rd-mailform_style-1 text-left" data-form-output="form-output-global" data-form-type="contact" method="post" action="bat/rd-mailform.php">
                                        <div class="form-wrap form-wrap_icon linear-icon-man">
                                            <input class="form-input" id="contact-name" type="text" name="name" data-constraints="@Required">
                                            <label class="form-label" for="contact-name">Your name *</label>
                                        </div>
                                        <div class="form-wrap form-wrap_icon linear-icon-envelope">
                                            <input class="form-input" id="contact-email" type="email" name="email" data-constraints="@Email  @Required">
                                            <label class="form-label" for="contact-email">Your e-mail *</label>
                                        </div>
                                        <div class="form-wrap form-wrap_icon linear-icon-telephone">
                                            <input class="form-input" id="contact-phone" type="text" name="phone" data-constraints="@Numeric">
                                            <label class="form-label" for="contact-phone">Your phone *</label>
                                        </div>
                                        <div class="form-wrap form-wrap_icon linear-icon-feather">
                                            <textarea class="form-input" id="contact-message" name="message" data-constraints="@Required"></textarea>
                                            <label class="form-label" for="contact-message">Your message *</label>
                                        </div>
                                        <button class="button button-primary" type="submit">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Divider-->
    <div class="shell">
        <div class="divider"></div>
    </div>

    

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OpenServer\domains\lidz.com.ua.local\resources\views/site/product/show.blade.php ENDPATH**/ ?>