<?php

namespace App\Rules;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class CheckExistedCategoryName implements ValidationRule
{
    public function __construct(private ?int $categoryId = null, private ?int $categoryType = null)
    {
        $this->categoryId = $categoryId;
        $this->categoryType = $categoryType;
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
        if ($this->categoryId) {
            return Category::find($this->categoryId)
                ?->children()
                ->where('type', $this->categoryType)
                ->where('name', $value)
                ->exists() ?? false;
        }

        return Category::where('type', $this->categoryType)
            ->whereNotExists(fn (Builder $query) => $query->select(DB::raw(1))
                ->from('categories as tmp')
                ->whereColumn('tmp.parent_id', 'categories.id'))
            ->where('name', $value)
            ->exists();
    }
}
