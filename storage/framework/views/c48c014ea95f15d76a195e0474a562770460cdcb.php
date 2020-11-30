
<?php $__env->startSection('body_class', 'product'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <?php $__currentLoopData = $product->category->ancestors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ancestor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><a href="<?php echo e(route('site.resource', $ancestor->slug)); ?>"><?php echo e($ancestor->name); ?></a></li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <li><a href="<?php echo e(route('site.resource', $product->category->slug)); ?>"><?php echo e($product->category->name); ?></a></li>
    <li class="active"><?php echo e($product->name); ?></li>
<?php $__env->stopSection(); ?>

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
                        <h4><?php echo e($product->getData('name') ?? 'Lorem ipsum dolor sit amet.'); ?></h4>
                        <p class="product-code"><span>Код товара:</span>9615</p>   
                        <p class="product-text"><?php echo e($product->description); ?></p>
                        <p class="product-price"><span><?php echo e($product->getDetails('price')); ?></span></p>
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

            </div>
        </div>
    </section>

    <section class="section-sm bg-white">
        <div class="container">
          <div class="row">
            <div class="col-12">
                <!-- Bootstrap tabs-->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Описание</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Характеристики</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">Lorem ipsum dolor sit amet.</div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
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