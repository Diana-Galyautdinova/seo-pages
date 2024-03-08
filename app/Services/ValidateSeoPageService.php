<?php

namespace App\Services;

use App\Dto\SeoPageRequest;
use App\Entity\SeoPage;
use App\Entity\SeoPageGroup;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

final class ValidateSeoPageService
{
    /**
     * @throws ValidationException
     */
    public static function validate(SeoPageRequest $request, ?int $id = null): void
    {
        Validator::make($request->toArray(), [
            'active' => ['boolean', 'nullable'],
            'slug' => [
                'required',
                'string',
                'max:100',
                Rule::unique(SeoPage::class)
                    ->where('slug', $request->getSlug())
                    ->ignore($id)
            ],
            'name' => ['nullable', 'string', 'max:250'],
            'groupId' => ['nullable', 'numeric', 'exists:' . SeoPageGroup::class . ',id'],
            'seoTitle' => ['required', 'string', 'max:250'],
            'seoH1' => ['required', 'string', 'max:250'],
            'seoKeywords' => ['nullable', 'string', 'max:250'],
            'seoDescription' => ['nullable', 'string', 'max:250'],
            'seoText' => ['nullable', 'string', 'max:10000'],
            'sort' => ['nullable', 'integer'],
            'fillManually' => ['nullable', 'boolean'],
            'filters' => ['nullable', 'array'],
        ])->validate();
    }
}
