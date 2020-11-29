
<?php $__env->startSection('body_class', 'home'); ?>
<?php $__env->startSection('content'); ?>

    <section class="home-carousel">
        <div class="owl-carousel owl-theme home__carousel">
            <div class="item">
                <img class="item__img" src="<?php echo e(asset('images/site/home-slider/slide-1.jpg')); ?>" alt="slide-3">
                <div class="container item__desc">
                    <div class="row">
                        <div class="col-12">
                            <p class="item__desc--title">Высокое качество,<br>доступное каждому</p>
                            <a class="button button-primary item__desc--link" href="#">Подробнее</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="item">
                <img class="item__img" src="<?php echo e(asset('images/site/home-slider/slide-1.jpg')); ?>" alt="slide-1">
                <div class="container item__desc" style="">
                    <div class="row">
                        <div class="col-12">
                            <p class="item__desc--title">Высокое качество,<br>доступное каждому</p>
                            <a class="button button-primary item__desc--link" href="#">Подробнее</a>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- <div class="item">
                <img class="item__img" src="<?php echo e(asset('images/site/home-slider/slide-2.jpg')); ?>" alt="slide-2">
                <div class="container item__desc">
                    <div class="row">
                        <div class="col-12">
                            <p class="item__desc--title">Высокое качество,<br>доступное каждому</p>
                            <a class="button button-primary item__desc--link" href="#">Подробнее</a>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </section>

    <section class="home-popular-categories section-lg">
        <div class="container">
            <div class="row">
                <h4 class="col-12 text-center">Популярные категории</h4>
                <div class="col-4 popular-category">
                    <a class="popular-category__inner" href="#">
                        <img class="popular-category__inner--image" src="<?php echo e(asset('images/site/home-popular-category/branded_packaging.png')); ?>" alt="Category name">
                        <p class="popular-category__inner--name">Смесители</p>
                    </a>
                </div>
                <div class="col-4 popular-category">
                    <a class="popular-category__inner" href="#">
                        <img class="popular-category__inner--image" src="<?php echo e(asset('images/site/home-popular-category/branded_packaging.png')); ?>" alt="Category name">
                        <p class="popular-category__inner--name">Полотенцесушители</p>
                    </a>
                </div>
                <div class="col-4 popular-category">
                    <a class="popular-category__inner" href="#">
                        <img class="popular-category__inner--image" src="<?php echo e(asset('images/site/home-popular-category/branded_packaging.png')); ?>" alt="Category name">
                        <p class="popular-category__inner--name">Душевые кабины</p>
                    </a>
                </div>
                <div class="col-4 popular-category">
                    <a class="popular-category__inner" href="#">
                        <img class="popular-category__inner--image" src="<?php echo e(asset('images/site/home-popular-category/branded_packaging.png')); ?>" alt="Category name">
                        <p class="popular-category__inner--name">Аксессуары</p>
                    </a>
                </div>
                <div class="col-4 popular-category">
                    <a class="popular-category__inner" href="#">
                        <img class="popular-category__inner--image" src="<?php echo e(asset('images/site/home-popular-category/branded_packaging.png')); ?>" alt="Category name">
                        <p class="popular-category__inner--name">Кухонные мойки</p>
                    </a>
                </div>
                <div class="col-4 popular-category">
                    <a class="popular-category__inner" href="#">
                        <img class="popular-category__inner--image" src="<?php echo e(asset('images/site/home-popular-category/branded_packaging.png')); ?>" alt="Category name">
                        <p class="popular-category__inner--name">Сифоны и трапы</p>
                    </a>
                </div>
            </div>
        </div>
    </section>

    

    <section class="home-bn-info section-lg" style=" padding-top: 225px;  padding-bottom: 225px;background-image: url(<?php echo e(asset('images/site/home-slider/slide-3.jpg')); ?>); background-position: center;">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-6 text-center">
                    <p class="" style="text-align: center; font-size: 64px; line-height: 1.2; color: #000; font-weight: 100;">Лучшее решение<br>для вашего дома</p>
                    <a class="button button-primary item__desc--link" href="#">Подробнее</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section-lg bg-white text-center">
        <div class="shell">
            <h4>Статьи</h4>
            <div class="range range-60 range-sm-center">
                <div class="cell-sm-6 cell-md-4">
                    <?php echo $__env->make('site.components.post', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="cell-sm-6 cell-md-4">
                    <?php echo $__env->make('site.components.post', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="cell-sm-6 cell-md-4">
                    <?php echo $__env->make('site.components.post', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OpenServer\domains\lidz.com.ua.local\resources\views/site/home/index.blade.php ENDPATH**/ ?>