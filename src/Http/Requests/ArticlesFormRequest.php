<?php

namespace Yajra\CMS\Http\Requests;

class ArticlesFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'          => 'required|max:255',
            'alias'          => 'max:255|alpha_dash',
            'order'          => 'required|numeric|max:100',
            'blade_template' => 'view_exists',
            'body'           => 'required_without:blade_template',
            'category_id'    => 'required',
        ];
    }
}
