<?php

use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\TwitterCard;
use Carbon\Carbon;

if (!function_exists('currentUserLogin')) {

    /**
     * Get current user login
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    function currentUserLogin()
    {
        return \Illuminate\Support\Facades\Auth::user();
    }
}

if (!function_exists('trim_without_array')) {

    /**
     * Trim without value is array
     *
     * @param array $values  Array will be trim
     * @param array $excepts Array except
     *
     * @return array
     */
    function trim_without_array($values, $excepts = [])
    {
        array_walk($values, function (&$value, $key) use ($excepts) {
            if (!is_array($value) && !in_array($key, $excepts)) {
                $value = trim($value);
            }
        });

        return $values;
    }
}

if (!function_exists('getSortConditions')) {

    /**
     * Get sort condition
     *
     * @param array  $data              Data
     * @param array  $sortColumns       Sort Columns
     * @param string $sortColumnDefault Sort column Default
     *
     * @return array
     */
    function getSortConditions(array $data = [], array $sortColumns = [], string $sortColumnDefault = 'id')
    {
        $sortDirections = ['desc', 'asc'];
        if (!isset($data['sort_column']) || !in_array($data['sort_column'], $sortColumns)) {
            $data['sort_column'] = isset($sortColumns[$data['sort_column']]) ? $sortColumns[$data['sort_column']]
                : $sortColumnDefault;
        }

        if (!in_array($data['sort_direction'], $sortDirections)) {
            $data['sort_direction'] = 'desc';
        }

        return $data;
    }
}

if (!function_exists('getSql')) {

    /**
     * Convert encoding from array
     *
     * @param \Illuminate\Database\Query\Builder $builder Query builder
     *
     * @return array
     */
    function getSql($builder)
    {
        $sql = $builder->toSql();
        foreach ($builder->getBindings() as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }

        return $sql;
    }
}

if (!function_exists('toPgArray')) {

    /**
     * Convert to array postgres
     *
     * @param array $data Data
     *
     * @return bool
     */
    function toPgArray(array $data)
    {
        $result = [];
        foreach ($data as $value) {
            if (is_array($value)) {
                $result[] = toPgArray($value);
            } else {
                $value = str_replace('"', '\\"', $value);
                if (!is_numeric($value)) {
                    $value = '"' . $value . '"';
                }
                $result[] = $value;
            }
        }

        return '{' . implode(",", $result) . '}';
    }
}

if (!function_exists('getTimeAgo')) {

    /**
     * Get time ago
     *
     * @param mixed $time
     *
     * @return bool
     */
    function getTimeAgo($time)
    {
        return Carbon::parse($time)->diffForHumans();
    }
}

if (!function_exists('filterEmptyData')) {

    /**
     * Get time ago
     *
     * @param array $data
     *
     * @return array
     */
    function filterEmptyData(array $data)
    {
        return array_filter($data, function ($value) {
            return !(is_null($value) || $value === '');
        });
    }
}

if (!function_exists('convertEmptyData')) {

    /**
     * Get time ago
     *
     * @param array $data
     *
     * @return array
     */
    function convertEmptyData(array $data)
    {
        return array_map(function ($item) {
            if (is_string($item)) {
                return (trim($item) !== '') ? $item : null;
            }
            return $item;
        }, $data);
    }
}

if (!function_exists('transArr')) {

    /**
     * Translate with array
     *
     * @param array $data   Data format
     * @param array $locale Locale
     *
     * @return array
     */
    function transArr(array $data, $locale = null)
    {
        $arr = [];
        foreach ($data as $key => $value) {
            $arr[$key] = trans($value, [], $locale);
        }

        return $arr;
    }
}

if (!function_exists('arrayEncoding')) {

    /**
     * Convert encoding from array
     *
     * @param array  $data Data
     * @param string $to   To encoding
     * @param string $from From encoding
     *
     * @return array
     */
    function arrayEncoding(array $data, string $to = 'UTF-8', string $from = 'UTF-8')
    {
        array_walk_recursive($data, function (&$value, $key) use ($from, $to) {
            if (is_string($value)) {
                $value = mb_convert_encoding($value, $to, $from);
            }
        });

        return $data;
    }
}

if (!function_exists('parseNumber')) {

    /**
     * Parse number
     *
     * @param mixed  $number   Number
     * @param string $decPoint Decimal point
     *
     * @return mixed
     */
    function parseNumber($number, string $decPoint = null) {
        if (empty($decPoint)) {
            $locale = localeconv();
            $decPoint = $locale['decimal_point'];
        }

        return floatval(str_replace($decPoint, '.', preg_replace('/[^\d'.preg_quote($decPoint).']/', '', $number)));
    }
}

if (!function_exists('randUniqueNumber')) {

    /**
     * Generate a random and unique number string
     *
     * @param string $appendString
     * @return void
     */
    function randUniqueNumber(string $appendString = null) {
        return date('Ymd').($appendString ?? '');
    }
}

if (!function_exists('formatResponseArray')) {

    /**
     * Format response array
     *
     * @param array $data        Data format
     * @param bool  $isTranslate Check is translate
     *
     * @return array
     */
    function formatResponseArray($data, $isTranslate = false)
    {
        if (empty($data)) {
            return null;
        }
        array_walk($data, function (&$item, $key) use ($isTranslate) {
            $item = [
                'id' => $key,
                'name' => $isTranslate ? trans($item) : $item,
            ];
        });

        return array_values($data);
    }
}

if (!function_exists('getParentCategories')) {

    /**
     * getParentCategories
     *
     * @return array
     */
    function getParentCategories($object)
    {
        $data = $object ? $object->toArray() : [];

        $array = [];

        array_walk_recursive($data, function ($item, $key) use (&$array) {
            if ($key == 'title') {
                $array[] = $item;
            }
        });

        return $array;
    }
}

if (! function_exists('booleanVal')) {

    /**
     * Retrieve input as a boolean value.
     *
     * @param  string|null $value Value
     *
     * @return bool
     */
    function booleanVal($value = null)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
}

if (! function_exists('hasPermission')) {

    /**
     * Check has permission
     *
     * @param  string $method Method
     *
     * @return bool
     */
    function hasPermission($method)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $methods = config('permission.admin')[$user->role]['method'];

        return in_array($method, $methods);
    }
}

if (! function_exists('getFileContainFolder')) {

    /**
     * Get file save folder
     *
     * @return string
     */
    function getFileContainFolder()
    {
        return config('filesystems.file_contain_folder');
    }
}

if (! function_exists('getPublicFile')) {

    /**
     * Get public file
     *
     * @param  string $filename Filename
     *
     * @return string
     */
    function getPublicFile($filename)
    {
        $path = config('filesystems.file_get_folder');

        return "/{$path}/$filename";
    }
}

if (! function_exists('customAsset')) {

    /**
     * Get public file
     *
     * @param  string $pathname Filename
     *
     * @return string
     */
    function customAsset($pathname)
    {
        return asset($pathname, config('define.secure'));
    }
}

if (! function_exists('getWebsiteTitle')) {

    /**
     * Get website title
     *
     * @return string
     */
    function getWebsiteTitle()
    {
        $names = [
            'admin/categories*' => 'Danh mục baì viết',
            'admin/website-setting*' => 'Cài đặt',
            'admin/pages*' => 'Trang',
        ];

        $name = null;

        foreach ($names as $key => $value) {
            if (request()->is($key)) {
                $name = $value;
                break;
            }
        }
        return "DPT Management" . ($name ? " | $name" : '');
    }
}


if (! function_exists('getUserWebsiteTitle')) {

    /**
     * Get user website title
     *
     * @return string
     */
    function getUserWebsiteTitle($title)
    {

        $appDomain = config('app.url');
        $title = substr($title, 0, 100);

        return "$title - $appDomain";
    }
}

if (! function_exists('getWebsiteSetting')) {

    /**
     * Get user website title
     *
     * @return string
     */
    function getWebsiteSetting($column = null)
    {
        $column = $column ?: '*';
        return \App\Models\WebsiteSetting::first([$column]);
    }
}

if (! function_exists('makeSEO')) {

    /**
     * Make SEO
     *
     * @param array $data Data
     *
     * @return void
     */
    function makeSEO(array $data)
    {
        SEOMeta::setCanonical(request()->url());
        if (!empty($data['title'])) {
            SEOMeta::setTitle($data['title']);
            OpenGraph::setTitle($data['title']);
            JsonLd::setTitle($data['title']);
            TwitterCard::setTitle($data['title']);
            JsonLd::setTitle($data['title']);
        }

        if (!empty($data['description'])) {
            SEOMeta::setDescription($data['description']);
            OpenGraph::setDescription($data['description']);
            JsonLd::setDescription($data['description']);
            TwitterCard::setDescription($data['description']);
            JsonLd::setDescription($data['description']);
        }

        OpenGraph::addProperty('type', 'article');

        if (!empty($data['image'])) {
            OpenGraph::addProperty('image', $data['image']['url']);
            OpenGraph::addProperty('image:width', $data['image']['origin_width']);
            OpenGraph::addProperty('image:height', $data['image']['origin_height']);
            JsonLd::addImage($data['image']['url']);
        }
        JsonLd::addValue('datePublished', Carbon::now());
        JsonLd::setType('NewsArticle');

        if (!empty($data['created_at'])) {
            $dataArticle['published_time'] = $data['created_at']->toIso8601String();
        }

        if (!empty($data['updated_at'])) {
            $dataArticle['modified_time'] = $data['updated_at']->toIso8601String();
        }

//        OpenGraph::setType('article')
//            ->setArticle($dataArticle);

//        OpenGraph::setType('article')
//            ->setArticle([
//                'publisher' => app('web_setting')->link_fan_page_facebook ?? null,
//                'published_time' => 'datetime',
//                'modified_time' => 'datetime',
//                'expiration_time' => 'datetime',
//                'author' => 'profile / array',
//                'section' => 'string',
//                'tag' => 'string / array'
//            ]);
    }
}



if (! function_exists('buildTree')) {
    function buildTree(array $items, $parentId = null) {
        $tree = [];

        foreach ($items as $item) {
            $item['text'] = $item['name'];
            $item['children'] = [];
            if ($item['parent_id'] === $parentId) {
                $children = buildTree($items, $item['id']);
                if (!empty($children)) {
                    $item['children'] = $children;
                }
                $tree[] = $item;
            }
        }

        return $tree;
    }
}

if (! function_exists('buildSelectOptions')) {
    function buildSelectOptions($categories, $selectedId = null, $ignoreIds = null, $prefix = '')
    {
        $html = '';
        foreach ($categories as $category) {
            if (!$ignoreIds || !in_array($category['id'], $ignoreIds)) {
                $html .= '<option value="' . $category['id'] . '" ' . ($selectedId == $category['id'] ? 'selected="selected"' : '') . '>' . $prefix . $category['name'] . '</option>';
            }
            if (!empty($category['children'])) {
                $html .= buildSelectOptions($category['children'], $selectedId, $ignoreIds, $prefix . '------ ');
            }
        }
        return $html;
    }
}

if (! function_exists('findCategoryById')) {
    function findCategoryById(array $categories, int $id) {
        foreach ($categories as $category) {
            if ($category['id'] === $id) {
                return $category;
            }

            // Kiểm tra nếu có key 'children' và tiếp tục tìm kiếm trong mảng con
            if (isset($category['children']) && is_array($category['children'])) {
                $result = findCategoryById($category['children'], $id);
                if ($result !== null) {
                    return $result;
                }
            }
        }
        return null;
    }
}


if (! function_exists('getAllIds')) {
    function getAllIds(array $category, array &$ids = []) {
        $ids[] = $category['id'];
        if (isset($category['children']) && is_array($category['children'])) {
            foreach ($category['children'] as $child) {
                getAllIds($child, $ids);
            }
        }

        return $ids;
    }
}
