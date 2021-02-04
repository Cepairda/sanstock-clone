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
                <li class="nav-item">
                    <a href="{{ route('admin.import-export') }}" class="nav-link">
                        <i class="nav-icon fa fa-users"></i>
                        <p>
                            Импорт/Экспорт
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-users"></i>
                        <p>
                            Пользователи
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.roles.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-unlock"></i>
                        <p>
                            Роли
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.mysql-backup.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-sync"></i>
                        <p>
                            Backup БД
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-list"></i>
                        <p>
                            Категории
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.products.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-list"></i>
                        <p>
                            Товары
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.characteristics.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Характеристики
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.characteristic-groups.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Группы Характеристик
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.partners.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-list"></i>
                        <p>
                            Партнёры
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.blog-categories.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-list"></i>
                        <p>
                            Категории блога
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.blog-posts.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-list"></i>
                        <p>
                            Статьи блога
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pages.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-list"></i>
                        <p>
                            Страницы
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.sale-points.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-shopping-cart"></i>
                        <p>
                            Точки продаж
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.comments.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-comment"></i>
                        <p>
                            Комментарии
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reviews.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-comment"></i>
                        <p>
                            Отзывы
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Настройки
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.icons.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Иконки</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
