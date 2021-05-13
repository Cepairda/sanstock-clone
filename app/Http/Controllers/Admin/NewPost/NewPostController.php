<?php

namespace App\Http\Controllers\Admin\NewPost;

use App\NewPostAreas;
use App\NewPostDescriptions;
use App\NewPostSettlements;
use App\NewPostStreets;
use App\NewPostWarehouses;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class NewPostController
{

    private $data = [];

    private $next_page_url;

    private $arias_url = 'http://94.131.241.126/api/nova-poshta/areas';

    private $settlements_url = 'http://94.131.241.126/api/nova-poshta/cities';

    private $streets_url = 'http://94.131.241.126/api/nova-poshta/streets';

    private $warehouses_url = 'http://94.131.241.126/api/nova-poshta/warehouses';

    private $ru = 'ru';

    private $ua = 'uk';

    /**
     * New Post Import
     */
    public function importNewPost() {

        $this->importNewPostResources('area', $this->arias_url);

        $this->importNewPostResources('settlement', $this->settlements_url);

        $this->importNewPostResources('street', $this->streets_url);

        $this->importNewPostResources('warehouse', $this->warehouses_url);
    }

    /**
     * Import New Post Areas
     */
    public function importNewPostAreas() {
//info('Start Area Import Job');
        $this->importNewPostResources('area', $this->arias_url);
    }

    /**
     * Import New Post Settlements
     */
    public function importNewPostSettlements() {

        $this->importNewPostResources('settlement', $this->settlements_url);
    }

    /**
     * Import New Post Streets
     */
    public function importNewPostStreets() {

        $this->importNewPostResources('street', $this->streets_url);
    }

    /**
     * Import New Post Warehouses
     */
    public function importNewPostWarehouses() {

        $this->importNewPostResources('warehouse', $this->warehouses_url);
    }

    /**
     * Import New Post Resources
     * @param $resource_key
     * @param $url
     */
    private function importNewPostResources($resource_key, $url) {

        echo "===============$resource_key=================" . PHP_EOL;

        $this->setDefaultImportValues();

        $response = $this->sentRequest($url);

        if(is_array($response)) {

            $this->data = $response['data'];

            $this->next_page_url = $response['next_page_url'];

            echo count($this->data) . PHP_EOL;

            foreach ($this->data as $item):

                $this->saveNewPostResourcesInData($resource_key, $item);

            endforeach;

            if(!empty($this->next_page_url)) $this->importNewPostResources($resource_key, $this->next_page_url);
        }
    }

    /**
     * Set default value of parameters after getting New Post Resources
     */
    private function setDefaultImportValues() {

        $this->data = [];

        $this->next_page_url = null;
    }

    /**
     * Save New Post Resources in data
     * @param $resource_key
     */
    private function saveNewPostResourcesInData($resource_key, $data) {

        $details = [];
        $details[$this->ru] = [];
        $details[$this->ua] = [];

        $description = (isset($data['description']) && !empty($data['description'])) ? $data['description'] : '';
        $description_ru = (isset($data['description_ru']) && !empty($data['description_ru'])) ? $data['description_ru'] : '';

        if($resource_key === 'area') {

            $model = NewPostAreas::updateOrCreate(
                ['ref' => $data['ref']],
                ['ref' => $data['ref'], 'areas_center' => $data['areas_center'], 'status' => 1 ]
            );

            $details[$this->ru]['name'] = $description_ru;
            $details[$this->ua]['name'] = $description;

            $details[$this->ru]['type'] = '';
            $details[$this->ua]['type'] = '';

            $details[$this->ru]['search'] = $description_ru;
            $details[$this->ua]['search'] = $description;
        }

        if($resource_key === 'settlement') {

            $model = NewPostSettlements::updateOrCreate(
                ['ref' => $data['ref']],
                ['ref' => $data['ref'], 'area_ref' => $data['area'], 'settlement_type' => $data['settlement_type'] ]
            );

            $details[$this->ru]['name'] = $description_ru;
            $details[$this->ua]['name'] = $description;

            $settlement_type_description = (isset($data['settlement_type_description']) && !empty($data['settlement_type_description']))
                ? $data['settlement_type_description'] : '';

            $settlement_type_description_ru = (isset($data['settlement_type_description_ru']) && !empty($data['settlement_type_description_ru']))
                ? $data['settlement_type_description_ru'] : '';

            $details[$this->ru]['type'] = $settlement_type_description_ru;
            $details[$this->ua]['type'] = $settlement_type_description;

            $details[$this->ru]['search'] = trim($settlement_type_description_ru . ' ' . $description_ru);
            $details[$this->ua]['search'] = trim($settlement_type_description . ' ' . $description);

        }

        if($resource_key === 'street') {

            $model = NewPostStreets::updateOrCreate(
                ['ref' => $data['ref']],
                ['ref' => $data['ref'], 'streets_type_ref' => $data['streets_type_ref'], 'city_ref' => $data['city_ref'] ]
            );

            $details[$this->ru]['name'] = $description_ru;
            $details[$this->ua]['name'] = $description;

            $streets_type = (isset($data['streets_type']) && !empty($data['streets_type'])) ? $data['streets_type'] : '';
            $streets_type_ru = (isset($data['streets_type_ru']) && !empty($data['streets_type_ru'])) ? $data['streets_type_ru'] : '';

            $details[$this->ru]['type'] = $streets_type_ru;
            $details[$this->ua]['type'] = $streets_type;

            $details[$this->ru]['search'] = trim($streets_type_ru . ' ' . $description_ru);
            $details[$this->ua]['search'] = trim($streets_type . ' ' . $description);
        }

        if($resource_key === 'warehouse') {

            $model = NewPostWarehouses::updateOrCreate(
                ['ref' => $data['ref']],
                ['ref' => $data['ref'], 'city_ref' => $data['city_ref'], 'site_key' => $data['site_key'], 'type_of_warehouse' => $data['type_of_warehouse'] ]
            );

            $details[$this->ru]['name'] = $description_ru;
            $details[$this->ua]['name'] = $description;

            $details[$this->ru]['type'] = '';
            $details[$this->ua]['type'] = '';

            $details[$this->ru]['search'] = $description_ru;
            $details[$this->ua]['search'] = $description;
        }

        $details[$this->ru]['group'] = $resource_key;
        $details[$this->ua]['group'] = $resource_key;

        $details[$this->ru]['affiliated_id'] = $model->id;
        $details[$this->ua]['affiliated_id'] = $model->id;

        $this->saveNewPostDescriptions($this->ru, $details[$this->ru]);
        $this->saveNewPostDescriptions($this->ua, $details[$this->ua]);
    }

    /**
     * Save ru/uk description of New Post Resources
     * @param $locale
     * @param $data
     */
    private function saveNewPostDescriptions($locale, $data) {

        NewPostDescriptions::updateOrCreate(
            ['locale' => $locale, 'affiliated_id' => $data['affiliated_id'], 'group' => $data['group'], 'name' => $data['name'], 'type' => $data['type']],
            [
                'locale' => $locale,
                'affiliated_id' => $data['affiliated_id'],
                'group' => $data['group'],
                'name' => $data['name'],
                'type' => $data['type'],
                'search' => $data['search']
            ]
        );
    }

    /**
     * Get New Post Areas
     * @param Request|null $request
     * @return array
     */
    public function getAreas(Request $request = null): array
    {
        $search = (!empty($request)) ? $request->input('search') : null;

        $areas = NewPostAreas::where('status', 1)->get();

        $result = [];

        foreach($areas as $region):

            $result[(int)$region['id']] = [ 'ref' => $region['ref'] ];

        endforeach;

        $arrId = array_keys($result);

        $result = $this->descriptionMap('area', LaravelLocalization::getCurrentLocale(), $arrId, $result);

        $result = $this->searchResourceBySubstring($result, $search);

        return $result;
    }

    /**
     * Get New Post Settlements
     * @param Request $request
     * @return array
     */
    public function getSettlements($regionRef): array
    {

        #$area_ref = $request->input('area');
        $area_ref = $regionRef;

        #$search = $request->input('search');

        $settlements = NewPostSettlements::where('area_ref', $area_ref)->get();

        $result = [];

        foreach($settlements as $region):

            $result[(int)$region['id']] = [ 'ref' => $region['ref'] ];

        endforeach;

        $arrId = array_keys($result);

        //$locale = str_replace("uk", "ua", LaravelLocalization::getCurrentLocale());

        $result = $this->descriptionMap('settlement', LaravelLocalization::getCurrentLocale(), $arrId, $result);

        $result = $this->searchResourceBySubstring($result); #$search

        return $result;
    }

    /**
     * Get New Post Streets
     * @param Request $request
     * @return array
     */
    public function getStreets($cityRef): array
    {

        #$city_ref = $request->input('city');
        $city_ref = $cityRef;

        #$search = $request->input('search');

        $streets = NewPostStreets::where('city_ref', $city_ref)->get();

        $result = [];

        foreach($streets as $region):

            $result[(int)$region['id']] = [ 'ref' => $region['ref'] ];

        endforeach;

        $arrId = array_keys($result);

        //$locale = str_replace("uk", "ua", LaravelLocalization::getCurrentLocale());

        $result = $this->descriptionMap('street', LaravelLocalization::getCurrentLocale(), $arrId, $result);

        $result = $this->searchResourceBySubstring($result); #$search
        // dd($result);

        return $result;
    }

    /**
     * Get New Post Warehouses
     * @param Request $request
     * @return array
     */
    public function getWarehouses($cityRef): array
    {
        #$city_ref = $request->input('city');
        $city_ref = $cityRef;

        #$search = $request->input('search');

        $warehouses = NewPostWarehouses::where('city_ref', $city_ref)->get();

        $result = [];

        foreach($warehouses as $region):

            $result[(int)$region['id']] = [ 'ref' => $region['ref'] ];

        endforeach;

        $arrId = array_keys($result);

        //$locale = str_replace("uk", "ua", LaravelLocalization::getCurrentLocale());

        $result = $this->descriptionMap('warehouse', LaravelLocalization::getCurrentLocale(), $arrId, $result);

        $result = $this->searchResourceBySubstring($result); #$search
        // dd($result);

        return $result;
    }

    /**
     * Search needle Resource Item by sting
     * @param $resources
     * @param null $search
     */
    private function searchResourceBySubstring($resources, $search = null): array
    {

        $result = [];

        if(!empty($search)) {

            foreach($resources as $key => $data):

                if(isset($data['search']) && mb_stripos($data['search'], $search)) $result[$key] = $data;

            endforeach;
        }
        else return $resources;

        return $result;
    }

    /**
     * Get Resource description
     * @param $resource_key
     * @param $locale
     * @param $arrId
     * @param $resources
     * @return array
     */
    private function descriptionMap($resource_key, $locale, $arrId, $resources): array
    {
        // $locale = 'ru';
        $descriptions = NewPostDescriptions::where('group', $resource_key)->whereIn('affiliated_id', $arrId)->get()->toArray();

        $descriptionMap = [];

        foreach($descriptions as $data):

            if(isset($resources[(int)$data['affiliated_id']])) {

                if(!isset($descriptionMap[(int)$data['affiliated_id']])) $descriptionMap[(int)$data['affiliated_id']] = $resources[(int)$data['affiliated_id']];

                $descriptionMap[(int)$data['affiliated_id']]['locale'] = $locale ;

                if(($resource_key === 'area' || $resource_key === 'settlement' || $resource_key === 'warehouse') &&  $locale === $data['locale']) {

                    $descriptionMap[(int)$data['affiliated_id']]['name'] = str_replace(['просп. просп.'], ['просп.'], $data['name']);

                    $descriptionMap[(int)$data['affiliated_id']]['full_name'] = ($resource_key === 'settlement')
                        ? $data['type'] . ' ' . $data['name'] : $data['name'];
                }

                if(($resource_key === 'street') &&  $data['locale'] === $this->ua) {

                    $descriptionMap[(int)$data['affiliated_id']]['name'] = $data['name'];

                    $descriptionMap[(int)$data['affiliated_id']]['full_name'] = $data['type'] . ' ' . $data['name'];
                }

                if(!isset($descriptionMap[(int)$data['affiliated_id']]['search'])) {

                    $descriptionMap[(int)$data['affiliated_id']]['search'] = $data['search'];

                } else {

                    $descriptionMap[(int)$data['affiliated_id']]['search'] = $descriptionMap[(int)$data['affiliated_id']]['search'] . ' ' . $data['search'];

                }

                if(count($descriptionMap[(int)$data['affiliated_id']]) < 3) unset($descriptionMap[(int)$data['affiliated_id']]);
            }

        endforeach;

        return $descriptionMap;
    }

    /**
     * Get data resources of New Post from b2b
     * @param $url
     * @return false|mixed
     */
    public function sentRequest($url)
    {
        usleep(1000000);
        // $start = time();
        // $url = 'http://94.131.241.126/api/nova-poshta/cities';

        $curl = curl_init();
        curl_setopt_array($curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_CONNECTTIMEOUT => 20,
                CURLOPT_TIMEOUT => 1000,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                )
            )
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $info = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        //        var_dump('Время получения ответа: ' . (time() - $start));
        //        var_dump('Код ответа: ' . $info);
        //        var_dump('Ответ:');
        //        dd(json_decode($response, true));

        if($err || $info !== 200) {
            info("Ошибка! Не удалось получить ответ от сервера. Код ошибки: $info!");
            info("Ссылка: $url!");
            info($response);
            return false;
        }

        $result = json_decode($response, true);

        echo "Код ответа: $info" . PHP_EOL;
        echo "Страница " . $result['current_page'] . " из " . $result['last_page'] . PHP_EOL;

        //  dd($result);
        return $result;

    }
}
