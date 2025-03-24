<?php

namespace App\Rules;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class CheckExistedCategoryName implements ValidationRule
{
    public function __construct(private ?int $parentId = null, private ?int $categoryType = null, private ?int $ignoreId = null)
    {
        $this->parentId = $parentId;
        $this->categoryType = $categoryType;
        $this->ignoreId = $ignoreId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->categoryExists($value)) {
            $fail(':attribute đã được đăng ký.');
        }
    }

    private function categoryExists(mixed $value): bool
    {
        if ($this->parentId) {
            $model = Category::find($this->parentId)->children();

            if($this->ignoreId) {
                $model->where('id', '!=', $this->ignoreId);
            }

            return $model->where('type', $this->categoryType)
                ->where('name', $value)
                ->exists() ?? false;
        }

        $model = Category::query();

        if($this->ignoreId) {
            $model->where('id', '!=', $this->ignoreId);
        }
        return $model->where('type', $this->categoryType)
            ->whereNull('parent_id')
            ->where('name', $value)
            ->exists();
    }
}
