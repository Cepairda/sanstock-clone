<?php

namespace App\Imports;

use App\Alias;
use App\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoryImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $rows = $rows->keyBy('id')->toArray();
        $tree = [];
        foreach ($rows as $id => &$row) {
            $parent_id = isset($row['parent_id']) ? (int)$row['parent_id'] : false;
            if (!$parent_id) {
                $tree[$id] = &$row;
            } else {
                $rows[$parent_id]['childs'][$id] = &$row;
            }
        }

        $this->storeOrUpdate($tree);
    }

    public function storeOrUpdate($data)
    {
        foreach ($data as $id => $row) {
            $category = Category::find($id);
            if (!isset($category)) {
                $category = new Category();
                $requestData['details']['category_id'] = $id;

                $aliasId = null;
                $url = str_replace('/', '-', $row['name']);
                /*if (isset($row['alias'])) {
                    $alias = Alias::whereUrl($row['alias'])->first();
                    $aliasId = isset($alias) ? $alias->id : null;
                    $url = $row['alias'];
                }

                $category->alias_id = Alias::storeOrUpdate($url, 'category', $aliasId);*/
                $requestData['slug'] = $row['alias'] ?? $row['name'];
            }

            /*$category->published = isset($row['published']) ? (int)$row['published'] : 0;
            $category->sort = isset($row['sort']) ? (int)$row['sort'] : 0;
            $category->is_menu_item = isset($row['is_menu_item']) ? (int)$row['is_menu_item'] : 0;
            $category->parent_id = isset($row['parent_id']) ? (int)$row['parent_id'] : null;*/

            $requestData['details']['published'] = isset($row['published']) ? (int)$row['published'] : 0;
            $requestData['details']['sort'] = isset($row['sort']) ? (int)$row['sort'] : 0;
            $requestData['details']['is_menu_item'] = isset($row['is_menu_item']) ? (int)$row['is_menu_item'] : 0;
            $requestData['details']['parent_id'] = isset($row['parent_id']) ? (int)$row['parent_id'] : null;

            $category->setRequest($requestData);

            LaravelLocalization::setLocale('ru');
            $category->storeOrUpdate();

            if (isset($row['childs'])) {
                $this->storeOrUpdate($row['childs']);
            }
        }
    }
}
