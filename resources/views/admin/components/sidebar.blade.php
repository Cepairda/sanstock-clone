<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard.index') }}" class="brand-link">
        <img src="{{ asset('images/admin/logo.png') }}"
             alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">SANDI+ CMS</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{--{{ auth()->user()->avatar_url }}--}}" class="img-circle elevation-2">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{--{{ auth()->user()->surname }} {{ auth()->user()->name }}--}}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../../index.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v1</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../index2.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v2</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../index3.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v3</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @if (contains_access('admin.import-export'))
                    <li class="nav-item">
                        <a href="{{ route('admin.import-export') }}" class="nav-link">
                            <i class="nav-icon fa fa-users"></i>
                            <p>
                                Импорт/Экспорт
                            </p>
                        </a>
                    </li>
                @endif
                @if (contains_access('admin.users.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-users"></i>
                            <p>
                                Пользователи
                            </p>
                        </a>
                    </li>
                @endif
                @if (contains_access('admin.roles.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.roles.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-unlock"></i>
                            <p>
                                Роли
                            </p>
                        </a>
                    </li>
                @endif
                @if (contains_access('admin.mysql-backup.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.mysql-backup.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-sync"></i>
                            <p>
                                Backup БД
                            </p>
                        </a>
                    </li>
                @endif
                @if (contains_access('admin.categories.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.categories.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-list"></i>
                            <p>
                                Категории
                            </p>
                        </a>
                    </li>
                @endif
                @if (contains_access('admin.products.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.products.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-list"></i>
                            <p>
                                Товары
                            </p>
                        </a>
                    </li>
                @endif
                @if (contains_access('admin.characteristics.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.characteristics.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                Характеристики
                            </p>
                        </a>
                    </li>
                @endif
                @if (contains_access('admin.characteristic-groups.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.characteristic-groups.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                Группы Характеристик
                            </p>
                        </a>
                    </li>
                @endif
                @if (contains_access('admin.partners.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.partners.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-handshake"></i>
                            <p>
                                Партнёры
                            </p>
                        </a>
                    </li>
                @endif
                @if (contains_access('admin.html-blocks.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.html-blocks.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-code"></i>
                            <p>
                                HTML blocks
                            </p>
                        </a>
                    </li>
                @endif
                @if (contains_access('admin.blog-tags.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.blog-tags.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-tags"></i>
                            <p>
                                Теги блога
                            </p>
                        </a>
                    </li>
                @endif
                @if (contains_access('admin.blog-categories.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.blog-categories.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-list"></i>
                            <p>
                                Категории блога
                            </p>
                        </a>
                    </li>
                @endif
                @if (contains_access('admin.blog-posts.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.blog-posts.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-list"></i>
                            <p>
                                Статьи блога
                            </p>
                        </a>
                    </li>
                @endif
                @if (contains_access('admin.pages.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.pages.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-newspaper"></i>
                            <p>
                                Страницы
                            </p>
                        </a>
                    </li>
                @endif
                @if (contains_access('admin.sale-points.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.sale-points.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-shopping-cart"></i>
                            <p>
                                Точки продаж
                            </p>
                        </a>
                    </li>
                @endif
                @if (contains_access('admin.comments.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.comments.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-comment"></i>
                            <p>
                                Комментарии
                            </p>
                        </a>
                    </li>
                @endif
                @if (contains_access('admin.reviews.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.reviews.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-comment"></i>
                            <p>
                                Отзывы
                            </p>
                        </a>
                    </li>
                @endif

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Настройки
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (contains_access('admin.icons.index'))
                            <li class="nav-item">
                                <a href="{{ route('admin.icons.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Иконки</p>
                                </a>
                            </li>
                        @endif
                        @if (contains_access('admin.robots.index'))
                            <li class="nav-item">
                                <a href="{{ route('admin.robots.index') }}" class="nav-link">
                                    <i class="fa fa-robot nav-icon"></i>
                                    <p>Robots.txt</p>
                                </a>
                            </li>
                        @endif
                        @if (contains_access('admin.translations.index'))
                            <li class="nav-item">
                                <a href="{{ route('admin.translations.index') }}" class="nav-link">
                                    <i class="fa fa-language nav-icon"></i>
                                    <p>Файлы переводов</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
