<?php

namespace Core\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Product\ProductAttribute;
use Illuminate\Database\QueryException;

class ProductAttributes extends Controller
{
    public function index()
    {
        $attributes = ProductAttribute::orderBy('id', 'DESC')->get();
        return view('panel::products.attributes.index', ['attributes' => $attributes]);
    }

    public function edit($id)
    {
        $attribute = ProductAttribute::where("id", "=", $id)->first();

        if (!$attribute) {
            return redirect()
                ->route("panel.products.attributes.index")
                ->with(
                    "message_error",
                    trans("general.not_found", [
                        "type" => trans_choice("general.categories", 1),
                    ])
                );
        }

        return view('panel::products.attributes.edit', ['attribute' => $attribute]);
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');

        $attribute = ProductAttribute::where('id', '=', $id)->first();
        $attribute->name = $name;

        $attribute->save();

        return redirect()
            ->route("panel.products.attributes.edit", [
                "id" => $id,
            ])
            ->with(
                "message_success",
                trans("general.successfully_updated", [
                    "type" => trans_choice("general.categories", 1),
                ])
            );
    }

    public function editTerms($id)
    {
        $attribute = ProductAttribute::where("id", "=", $id)->first();

        if (!$attribute) {
            return redirect()
                ->route("panel.products.attributes.index")
                ->with(
                    "message_error",
                    trans("general.not_found", [
                        "type" => trans_choice("general.categories", 1),
                    ])
                );
        }

        return view('panel::products.attributes.edit-terms', ['attribute' => $attribute]);
    }

    public function create(Request $request)
    {
        try {
            $name = $request->input('name');

            $attribute = new ProductAttribute;

            $attribute->name = $name;

            $attribute->save();
        } catch (QueryException $e) {
            return response()
                ->json([
                    'success' => false
                ], 400);
        }

        return response()
            ->json([
                'success' => true
            ], 200);
    }

    public function delete($id)
    {
        $attribute = ProductAttribute::where("id", "=", $id)->first();

        if (!$attribute) {
            return redirect()
                ->route("panel.products.attributes.index")
                ->with(
                    "message_error",
                    trans("general.not_found", [
                        "type" => trans_choice("general.categories", 1),
                    ])
                );
        }

        $attribute->delete();

        return redirect()
            ->route("panel.products.attributes.index")
            ->with(
                "message_success",
                trans("general.successfully_deleted", [
                    "type" => trans_choice("general.categories", 1),
                ])
            );
    }
    
    public function deleteTerm($id, $id2)
    {
        $attribute = ProductAttribute::where("id", "=", $id)->first();

        if (!$attribute) {
            return redirect()
                ->route("panel.404");
        }

        if ($attribute->terms == null) {
            return redirect()
                ->route("panel.404");
        }

        $terms = json_decode($attribute->terms);

        foreach ($terms as $key => $term) {
            if ($term->uid == $id2) {
                array_splice($terms, $key, 1);
                break;
            }
        }

        $attribute->terms = json_encode($terms);
        $attribute->save();

        return redirect()
            ->route("panel.products.attributes.edit-terms", ['id' => $id])
            ->with(
                "message_success",
                trans("general.successfully_deleted", [
                    "type" => trans_choice("general.categories", 1),
                ])
            );
    }

    public function createTerm(Request $request)
    {
        try {
            $id = $request->input('id');
            $name = $request->input('name');
            $price = $request->input('price');

            $uid = $id . '-' . md5($name . date('h:i:s-d.m.Y'));

            $attribute = ProductAttribute::where('id', '=', $id)->first();

            if ($attribute->terms == null) {
                $terms = [];
            } else {
                $terms = json_decode($attribute->terms);
            }

            $term = [
                'uid' => $uid,
                'name' => $name,
                'price' => $price != null ? $price : 0
            ];

            array_push($terms, $term);

            $attribute->terms = json_encode($terms);

            $attribute->save();
        } catch (QueryException $e) {
            return response()
                ->json([
                    'success' => false
                ], 400);
        }

        return response()
            ->json([
                'success' => true
            ], 200);
    }

}
