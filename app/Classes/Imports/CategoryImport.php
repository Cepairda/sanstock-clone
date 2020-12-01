<?php

namespace App\Classes\Imports;

use App\Alias;
use App\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoryImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $rows = $rows->keyBy('id')->toArray();

        $this->storeOrUpdate($rows);
        $this->fixParent($rows);
    }

    public function storeOrUpdate($data)
    {
        foreach ($data as $id => $row) {
            if (empty($id))
                break;

            $category = Category::where('virtual_id', $id)->first();

            if (!isset($category)) {
                $category = new Category();
                $requestData['virtual_id'] = $id;
                $url = str_replace('/', '-', $row['name']);
                $requestData['slug'] = $row['alias'] ?? Str::slug($url);
            } else {
                $requestData['virtual_id'] = $category->virtual_id;
                $requestData['slug'] = $category->slug;
            }

            $requestData['details']['published'] = isset($row['published']) ? (int)$row['published'] : 0;
            $requestData['details']['sort'] = isset($row['sort']) ? (int)$row['sort'] : 0;
            $requestData['details']['is_menu_item'] = isset($row['is_menu_item']) ? (int)$row['is_menu_item'] : 0;

            $category->setRequest($requestData);
            $category->storeOrUpdate();
        }
    }

    public function fixParent($data)
    {
        foreach ($data as $id => $row) {
            $parentId = $row['parent_id'];

            if (!empty($parentId)) {
                $parentCategory = Category::where('virtual_id', $parentId)->first();
                Category::where('virtual_id', $id)->update(['parent_id' => $parentCategory->id]);
            }
        }

        Category::fixTree();
    }
}
