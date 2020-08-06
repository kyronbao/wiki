

laravel中可以自定义一个验证，例如
```
class ShrinkageRequest extends Request
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
     * @param Request $request
     * @return array
     */
    public function rules(Request $request)
    {
        $id = $request->get('id', 0);

        return [
            'name' => ['required',Rule::unique('db_database.bd_shrinkage')->where(function ($query) use ($id)
            {
                return $query->where('id', '<>', $id)->whereNull('deleted_at');
            }),],
            'name_en' => ['required',Rule::unique('db_database.bd_shrinkage')->where(function ($query) use ($id)
            {
                return $query->where('id', '<>', $id)->whereNull('deleted_at');
            }),],
        ];

    }

    function attributes()
    {
        return [
            'name'    => '名称',
            'name_en'    => '名称(英文)',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute必填',
            'unique'    => ':attribute不允许重复',
        ];
    }
}
```
