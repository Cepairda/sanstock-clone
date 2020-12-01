<!-- Page Footer -->
<section class="pre-footer-corporate">

    <div class="container">
        <div class="row">

            <div class="col-sm-6 col-md-10 col-lg-3">
                <img src="<?php echo e(asset('images/site/logo-150x150.jpg')); ?>" alt="" width="125">
                <p style="font-size: 14px"><?php echo __('footer desc'); ?></p>
            </div>

            <div class="col-sm-6 col-md-3 col-lg-3">
                <h5><?php echo e(__('Categories')); ?></h5>
                <ul class="list-sm">
                    <?php ($categories = $categories ?? \App\Category::joinLocalization()->get()->toTree()); ?>

                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e(route('site.resource', $category->slug)); ?>"><?php echo $category->getData('name'); ?></a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>

            <div class="col-sm-6 col-md-5 col-lg-3">
                <h5><?php echo e(__('Information')); ?></h5>
                <ul class="list-sm">
                    <li><a href="/for-user"><?php echo e(__('For user')); ?></a></li>
                    <li><a href="/sitemap"><?php echo e(__('Sitemap')); ?></a></li>
                    <li><a href="/blog"><?php echo e(__('Blog')); ?></a></li>
                    <li><a href="/contacts"><?php echo e(__('Contacts')); ?></a></li>
                </ul>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3">
                <h5><?php echo e(__('About us')); ?></h5>
                <ul class="list-sm">
                    <li><a href="/about-us"><?php echo e(__('About us')); ?></a></li>
                    <li><a href="/documentation"><?php echo e(__('Documentation')); ?></a></li>
                    <li><p style="font-size: 20px; color: #000"><?php echo e(__('Get in Touch')); ?></ps></li>
                    <li><a style="font-size: 20px; color: #000" href="mail:0800212008">0800 212 008</a></li>
                </ul>
            </div>

        </div>
    </div>

</section>
<!-- Footer -->
<footer class="footer-corporate" style="border-top: 1px solid #888; background-color: #f8f8f8; color: #000;">
    <div class="container">
        <div class="row">
            <div class="footer-corporate__inner">
                <p class="rights">©&nbsp;<?php echo e(date('Y')); ?> LIDZ. <?php echo e(__('copy')); ?></p>
            </div>
        </div>
    </div>
</footer>
<?php /**PATH C:\OpenServer\domains\lidz.com.ua.local\resources\views/site/components/footer.blade.php ENDPATH**/ ?>