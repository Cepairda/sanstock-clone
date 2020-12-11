@extends('layouts.site')
@section('body_class', 'certificates')
@section('meta_title', __('Documentation'))
@section('meta_description',  __('Documentation'))

@section('breadcrumbs')
    <li><a href="{{ route('site.documentations') }}">{{ __('Documentation') }}</a></li>
    <li class="active">{{ __('Certificates') }}</li>
@endsection
@section('content')

    @include('site.components.breadcrumbs', ['title' => __('Certificates')])

    <section class="section-md">
        <div class="container">
            <div class="row">
                <h2 class="col-12 text-center" style="padding-bottom: 25px">{{ __('Certificates') }}</h2>
                <div class="col-12 pt-5">

                    <div class="certificatesList">
                        <a href="https://b2b-sandi.com.ua/files/shares/certificates/lidz-gigienicheskoe-zakljuchenie-1.pdf" target="_blank" class="certificateLink">

                            <img class="img-data-path" src="https://b2b-sandi.com.ua/photos/shares/certificates/lidz-gigienicheskoe-zakljuchenie-1.png" data-src="https://b2b-sandi.com.ua/photos/shares/certificates/lidz-gigienicheskoe-zakljuchenie-1.png">
                            <span class="certificateTitle">LIDZ санитарное заключение</span>
                        </a>
                        <a href="https://b2b-sandi.com.ua/files/shares/certificates/19_03_2021_Lidz_Sertifikat_-_Smesiteli__Vodonagrevateli_protochnyye.pdf" target="_blank" class="certificateLink">

                            <img class="img-data-path" src="https://b2b-sandi.com.ua/photos/shares/certificates/19_03_2021_Lidz_Sertifikat_-_Smesiteli__Vodonagrevateli_protochnyye.png" data-src="https://b2b-sandi.com.ua/photos/shares/certificates/19_03_2021_Lidz_Sertifikat_-_Smesiteli__Vodonagrevateli_protochnyye.png">
                            <span class="certificateTitle">LIDZ сертификат. Водонагреватели проточные (смесители)</span>
                        </a>
                        <a href="https://b2b-sandi.com.ua/files/shares/certificates/LIDZ_Zaklyucheniye_gosudarstvennoy_sanitarno-epidemiologicheskoy_ekspertizy.pdf" target="_blank" class="certificateLink">

                            <img class="img-data-path" src="https://b2b-sandi.com.ua/photos/shares/certificates/LIDZ_Zaklyucheniye_gosudarstvennoy_sanitarno-epidemiologicheskoy_ekspertizy.png" data-src="https://b2b-sandi.com.ua/photos/shares/certificates/LIDZ_Zaklyucheniye_gosudarstvennoy_sanitarno-epidemiologicheskoy_ekspertizy.png">
                            <span class="certificateTitle">Lidz Мойки кухонные. Заключение государственной санитарно-эпидемиологической экспертизы</span>
                        </a>
                        <a href="https://b2b-sandi.com.ua/files/shares/certificates/13_09_2025__Lidz_Dushevyye_kabiny__dushevyye_boksy__gidroboksy__shtory_dlya_vannoy__dveri_dushevyye_steklyannyye__Zaklyucheniye_gosudarstvennoy_sanitarno-epidemiologicheskoy_ekspertizy.pdf" target="_blank" class="certificateLink">

                            <img class="img-data-path" src="https://b2b-sandi.com.ua/photos/shares/certificates/13_09_2025__Lidz_Dushevyye_kabiny__dushevyye_boksy__gidroboksy__shtory_dlya_vannoy__dveri_dushevyye_steklyannyye__Zaklyucheniye_gosudarstvennoy_sanitarno-epidemiologicheskoy_ekspertizy.png" data-src="https://b2b-sandi.com.ua/photos/shares/certificates/13_09_2025__Lidz_Dushevyye_kabiny__dushevyye_boksy__gidroboksy__shtory_dlya_vannoy__dveri_dushevyye_steklyannyye__Zaklyucheniye_gosudarstvennoy_sanitarno-epidemiologicheskoy_ekspertizy.png">
                            <span class="certificateTitle">Lidz Душевые кабины, душевые боксы, гидробоксы, шторы для ванной, двери душевые стеклянные. Заключение государственной санитарно-эпидемиологической экспертизы</span>
                        </a>
                        <a href="https://b2b-sandi.com.ua/files/shares/certificates/23_09_21_Lidz____________________________________________________________________________.pdf" target="_blank" class="certificateLink">

                            <img class="img-data-path" src="https://b2b-sandi.com.ua/photos/shares/certificates/23_09_21_Lidz____________________________________________________________________________.png" data-src="https://b2b-sandi.com.ua/photos/shares/certificates/23_09_21_Lidz____________________________________________________________________________.png">
                            <span class="certificateTitle">Lidz Сушки для волос (фены) и сушилки для рук. Сертификат и декларация о соответствии</span>
                        </a>
                        <a href="https://b2b-sandi.com.ua/files/shares/certificates/Vyvod__Aksessuary_dlya_vannoy_komnaty__zerkala__sifony__komplektuyushchiye_i_zapchasti_.pdf" target="_blank" class="certificateLink">

                            <img class="img-data-path" src="https://b2b-sandi.com.ua/photos/shares/certificates/Vyvod__Aksessuary_dlya_vannoy_komnaty__zerkala__sifony__komplektuyushchiye_i_zapchasti_.png" data-src="https://b2b-sandi.com.ua/photos/shares/certificates/Vyvod__Aksessuary_dlya_vannoy_komnaty__zerkala__sifony__komplektuyushchiye_i_zapchasti_.png">
                            <span class="certificateTitle">Lidz Аксессуары для ванной комнаты, зеркала, сифоны, комплектующие и запчасти. Заключение государственной санитарно-эпидемиологической экспертизы.</span>
                        </a>
                        <a href="https://b2b-sandi.com.ua/files/shares/certificates/04_12_2020_Lidz_Smesiteli_sensornyye__Sertifikat_sootvetstviya_.pdf" target="_blank" class="certificateLink">

                            <img class="img-data-path" src="https://b2b-sandi.com.ua/photos/shares/certificates/04_12_2020_Lidz_Smesiteli_sensornyye__Sertifikat_sootvetstviya_.png" data-src="https://b2b-sandi.com.ua/photos/shares/certificates/04_12_2020_Lidz_Smesiteli_sensornyye__Sertifikat_sootvetstviya_.png">
                            <span class="certificateTitle">Lidz Смесители сенсорные. Сертификат и декларация о соответствии</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
