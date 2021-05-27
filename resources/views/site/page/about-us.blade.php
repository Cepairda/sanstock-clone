@extends('layouts.site')
@section('body_class', 'about')
@section('meta_title', __('About'))
@section('meta_description', __('About'))
@section('breadcrumbs')
    <li class="breadcrumb-item active"
        itemprop="itemListElement"
        itemscope itemtype="https://schema.org/ListItem"
    >
        <span itemprop="name">
            {{ __('About us') }}
        </span>
        <meta itemprop="position" content="2"/>
    </li>
@endsection
@section('content')

    <main class="main-container bgc-gray">
        @include('site.components.breadcrumbs', ['title' => __('Contacts')])
        <main>
            <div class="container">
                <div class="row">
                    <div class="col-12" style="font-size: 16px">
                        <h1 class="mb-4">О нас</h1>
                        <p class="mb-4">Интернет-магазин «Sandi Stock» является аналогом аутлета, который
                            специализируется на продаже сантехнических и теплотехнических изделий. Более 18 лет мы
                            занимаемся поставкой и продажей продукции на территории Украины, имеем колоссальный опыт и
                            знаем, что нужно потребителю.
                            «Sandi Stock» предлагает покупателям смесители и аксессуары, ванны и мойки,
                            полотенцесушители и санфаянс, радиаторы и насосы, бойлеры и котлы, газовые колонки и
                            полипропилен таких известных брендов, как Qtap, Lidz, Thermo Alliance, Womar и Taifu по
                            цене, ниже рыночной.
                            Как мы работаем</p>
                        <p class="mb-4">На нашей платформе «Sandi Stock» представлен товар, который имеет незначительные
                            дефекты, поэтому стоимость на него зачастую гораздо ниже, чем в обычных магазинах, а изъяны
                            не влияют на функциональность.
                            Каждое изделие, которое представлено в интернет-магазине «Sandi Stock» рассортирована по
                            сортам - от Сорт 0 до сорта 3. Соответственно от товаров с меньшими дефектами к большим.
                        </p>
                        <p class="mb-4">Интернет-магазин «Sandi Stock» заинтересован в том, чтобы предложить покупателю
                            продукцию, которая подойдет ему, поэтому предоставляем полное описание всех особенностей
                            изделий.
                            Например, в карточке товара каждого отдельного продукта находится не только описание
                            дефектов, но и детализированные фотографии. Также, каждая позиция имеет свой уникальный
                            штрих-код, который гарантирует, что к вам приедет именно та позиция, которую вы заказали на
                            сайте, выбирая по фотографии.</p>


                        <p>Наши принципы</p>
                        <ul>
                            <li>- Точность и корректность в предоставлении информации по товару</li>
                            <li>- Полные данные о товарах для принятия решения о покупке</li>
                            <li>- Быстрая отгрузка день в день (понедельник-четверг).</li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>

@endsection
