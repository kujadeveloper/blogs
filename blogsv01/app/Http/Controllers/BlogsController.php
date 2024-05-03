<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Blogs;


class BlogsController extends Controller
{
    public function index()
    {
        return Blogs::all();
    }

    public function show($id)
    {
        return Blogs::findOrFail($id);
    }

    public function userPosts($id)
    {
        return Blogs::where('author_id', $id)->get();
    }

    public function store(Request $request)
    {
        try {
            $author = Auth::user();

            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'description' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            

            return Blogs::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'author_id' => $author->id,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Beklenmedik bir hata oluştu'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $blog = Blogs::where('id', $id)
                         ->where('author_id', Auth::id())
                         ->first();

            if (!$blog) {
                return response()->json(['error' => 'Blog post not found or unauthorized'], 404);
            }

            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
            ]);

            $blog->update($validatedData);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Beklenmedik bir hata oluştu'], 500);
        }
        return $blog;
    }

    public function destroy($id)
    {

        try {
            $blog = Blogs::where('id', $id)
                         ->where('author_id', Auth::id())
                         ->first();

            if (!$blog) {
                return response()->json(['error' => 'Blog post not found or unauthorized'], 404);
            }

            $blog->delete();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Beklenmedik bir hata oluştu'], 500);
        }
        return response()->json(['message' => 'Blog deleted successfully']);
    }
}
